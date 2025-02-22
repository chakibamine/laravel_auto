<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\Dossier;
use App\Models\Exam;
use App\Models\Reg;
use App\Models\Entrer;
use App\Models\Sortie;
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
    
    // New accounting properties
    public $totalRevenue;
    public $totalExpenses;
    public $netIncome;
    public $dailyTransactions;
    public $monthlyExpenses;
    public $revenueByCategory;
    public $paymentMethods;
    public $unpaidDossiers;

    public function mount()
    {
        $this->calculateStatistics();
        if (auth()->user()->role === 'admin') {
            $this->calculateAccountingStats();
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
        $this->dailyTransactions = [
            'income' => Entrer::whereDate('date_entrer', Carbon::today())->sum('montant'),
            'expenses' => Sortie::whereDate('date_sortie', Carbon::today())->sum('montant')
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
        return view('livewire.dashboard');
    }
}
