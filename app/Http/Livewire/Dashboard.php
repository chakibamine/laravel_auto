<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Dossier;
use App\Models\Exam;
use App\Models\Reg;
use App\Models\Entrer;
use App\Models\Sortie;
use App\Models\Remainder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalStudents;
    public $totalActiveDossiers;
    public $monthlyRevenue;
    public $examSuccessRate;
    public $recentPayments;
    public $upcomingExams;
    public $monthlyStats;
    public $categoryDistribution;
    
    // New statistics properties
    public $examSuccessByCategory;
    public $paymentStatusStats;
    public $studentProgressStats;
    public $revenueByPaymentMethod;
    public $averageTrainingDuration;
    public $studentAgeDistribution;
    
    // Accounting properties
    public $totalRevenue;
    public $totalExpenses;
    public $netIncome;
    public $dailyTransactions;
    public $monthlyExpenses;
    public $revenueByCategory;
    public $paymentMethods;
    public $unpaidDossiers;

    public $upcomingReminders;

    public function mount()
    {
        $this->calculateStatistics();
        if (auth()->user()->role === 'admin') {
            $this->calculateAccountingStats();
            // Query for reminders within the next 7 days
            $this->upcomingReminders = Remainder::whereDate('date', '>=', Carbon::today())
                ->whereDate('date', '<=', Carbon::today()->addDays(7))
                ->orderBy('date')
                ->get();
        } else {
            $this->upcomingReminders = collect();
        }
    }

    private function calculateStatistics()
    {
        // Total active students
        $this->totalStudents = Student::count();

        // Total active dossiers
        $this->totalActiveDossiers = Dossier::where('status', 1)->count();

        // Monthly revenue (admin only)
        if (auth()->user()->role === 'admin') {
            $this->monthlyRevenue = Reg::whereMonth('date_reg', Carbon::now()->month)
                ->whereYear('date_reg', Carbon::now()->year)
                ->sum('price');
        }

        // Exam success rate
        $totalExams = Exam::count();
        $successfulExams = Exam::where('resultat', '2')->count();
        $this->examSuccessRate = $totalExams > 0 ? round(($successfulExams / $totalExams) * 100, 1) : 0;

        // Recent payments (last 5)
        $this->recentPayments = Reg::with(['dossier.student'])
            ->orderBy('date_reg', 'desc')
            ->limit(5)
            ->get();

        // All upcoming exams for the count
        $this->upcomingExams = Exam::with(['dossier.student'])
            ->where('date_exam', '>=', Carbon::today())
            ->orderBy('date_exam', 'asc')
            ->get();

        // Monthly statistics for the last 6 months
        $this->monthlyStats = Dossier::select(
            DB::raw('MONTH(date_inscription) as month'),
            DB::raw('YEAR(date_inscription) as year'),
            DB::raw('COUNT(*) as total_inscriptions')
        )
            ->where('date_inscription', '>=', Carbon::now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Category distribution
        $this->categoryDistribution = Dossier::select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->get()
            ->pluck('total', 'category')
            ->toArray();

        // New statistics calculations
        $this->calculateNewStatistics();
    }

    private function calculateNewStatistics()
    {
        // Exam success rate by category
        $this->examSuccessByCategory = Exam::select('type_exam', DB::raw('COUNT(*) as total'))
            ->selectRaw('SUM(CASE WHEN resultat = 2 THEN 1 ELSE 0 END) as successful')
            ->groupBy('type_exam')
            ->get()
            ->map(function ($item) {
                $item->success_rate = $item->total > 0 ? round(($item->successful / $item->total) * 100, 1) : 0;
                return $item;
            });

        // Payment status statistics
        $this->paymentStatusStats = Dossier::select(
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active'),
            DB::raw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as completed')
        )->first();

        // Student progress statistics
        $this->studentProgressStats = [
            'total' => Student::count(),
            'active' => Student::whereHas('dossiers', function($query) {
                $query->where('status', 1);
            })->count(),
            'completed' => Student::whereHas('dossiers', function($query) {
                $query->where('status', 0);
            })->count()
        ];

        // Revenue by payment method (using motif instead of mode_paiement)
        $this->revenueByPaymentMethod = Reg::select('motif', DB::raw('SUM(price) as total'))
            ->whereMonth('date_reg', Carbon::now()->month)
            ->whereYear('date_reg', Carbon::now()->year)
            ->groupBy('motif')
            ->get();

        // Average training duration
        $completedDossiers = Dossier::whereNotNull('date_cloture')
            ->whereNotNull('date_inscription')
            ->get();
        
        $totalDays = 0;
        $count = 0;
        foreach ($completedDossiers as $dossier) {
            if ($dossier->date_cloture && $dossier->date_inscription) {
                $totalDays += $dossier->date_cloture->diffInDays($dossier->date_inscription);
                $count++;
            }
        }
        $this->averageTrainingDuration = $count > 0 ? round($totalDays / $count) : 0;

        // Student age distribution (using category instead of age)
        $this->studentAgeDistribution = Dossier::select('category', DB::raw('COUNT(*) as total'))
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                $item->age_group = "Catégorie " . $item->category;
                return $item;
            });
    }

    private function calculateAccountingStats()
    {
        // Calculate total revenue (all time)
        $this->totalRevenue = Entrer::sum('montant');

        // Calculate total expenses
        $this->totalExpenses = Sortie::sum('montant');

        // Calculate net income
        $this->netIncome = $this->totalRevenue - $this->totalExpenses;

        // Get today's transactions
        $today = Carbon::today();
        $this->dailyTransactions = [
            'income' => Entrer::whereDate('date_entrer', $today)->sum('montant'),
            'expenses' => Sortie::whereDate('date_sortie', $today)->sum('montant')
        ];

        // Calculate monthly expenses by category
        $this->monthlyExpenses = Sortie::select('motif', DB::raw('SUM(montant) as total'))
            ->whereMonth('date_sortie', Carbon::now()->month)
            ->whereYear('date_sortie', Carbon::now()->year)
            ->groupBy('motif')
            ->get();

        // Calculate revenue by payment category
        $this->revenueByCategory = Reg::select('motif', DB::raw('SUM(price) as total'))
            ->whereMonth('date_reg', Carbon::now()->month)
            ->whereYear('date_reg', Carbon::now()->year)
            ->groupBy('motif')
            ->get();

        // Get unpaid or partially paid dossiers
        $this->unpaidDossiers = Dossier::where('status', 1)
            ->whereHas('student')
            ->select('dossier.*', DB::raw('(SELECT COALESCE(SUM(price), 0) FROM reg WHERE dossier.id = reg.dossier_id) as total_paid'))
            ->whereRaw('(SELECT COALESCE(SUM(price), 0) FROM reg WHERE dossier.id = reg.dossier_id) < dossier.price')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'upcomingReminders' => $this->upcomingReminders,
        ]);
    }
}
