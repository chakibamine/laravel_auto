<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Dashboard</h2>
            <p class="mb-0">Your auto school management statistics and overview.</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-primary rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Total Students</h2>
                                <h3 class="fw-extrabold mb-2">{{ $totalStudents }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-secondary rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Active Dossiers</h2>
                                <h3 class="fw-extrabold mb-2">{{ $totalActiveDossiers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-tertiary rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Success Rate</h2>
                                <h3 class="fw-extrabold mb-2">{{ $examSuccessRate }}%</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <div class="row d-block d-xl-flex align-items-center">
                        <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                            <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-12 col-xl-7 px-xl-0">
                            <div class="d-none d-sm-block">
                                <h2 class="h6 text-gray-400 mb-0">Monthly Revenue</h2>
                                <h3 class="fw-extrabold mb-2">{{ number_format($monthlyRevenue, 2) }} DH</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Payments Table -->
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Recent Payments</h2>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th class="border-bottom" scope="col">Student</th>
                                <th class="border-bottom" scope="col">Amount</th>
                                <th class="border-bottom" scope="col">Date</th>
                                <th class="border-bottom" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPayments as $payment)
                            <tr>
                                <td>
                                    {{ $payment->dossier->student->firstname }} {{ $payment->dossier->student->lastname }}
                                </td>
                                <td>
                                    {{ number_format($payment->price, 2) }} DH
                                </td>
                                <td>
                                    {{ $payment->date_reg->format('d M Y') }}
                                </td>
                                <td>
                                    <span class="badge bg-success">Completed</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Upcoming Exams -->
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Upcoming Exams</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($upcomingExams as $exam)
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div>
                            <div class="h6 mb-0 d-flex align-items-center">
                                {{ $exam->dossier->student->firstname }} {{ $exam->dossier->student->lastname }}
                            </div>
                            <div class="small text-gray">{{ $exam->type_exam }}</div>
                        </div>
                        <div>
                            <span class="badge bg-info">{{ $exam->date_exam->format('d M') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Monthly Statistics -->
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Monthly Inscriptions</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Month</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Total Inscriptions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyStats as $stat)
                                <tr>
                                    <td>{{ Carbon\Carbon::create()->month($stat->month)->format('F') }}</td>
                                    <td>{{ $stat->year }}</td>
                                    <td>{{ $stat->total_inscriptions }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">License Categories</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($categoryDistribution as $category => $total)
                    <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                        <div>
                            <div class="h6 mb-0 d-flex align-items-center">
                                Category {{ $category }}
                            </div>
                        </div>
                        <div>
                            <span class="badge bg-primary">{{ $total }} Students</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Only Financial Statistics -->
    @if(auth()->user()->role === 'admin')
    <div class="row">
        <!-- Financial Overview -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h2 class="fs-5 fw-bold mb-0">Financial Overview</h2>
                        </div>
                        <div class="col text-end">
                            <a href="{{ route('comptabilite') }}" class="btn btn-sm btn-primary">View Full Report</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Total Revenue -->
                        <div class="col-12 col-sm-6 col-xl-4 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Total Revenue</span>
                                            <span class="h3 font-bold mb-0">{{ number_format($totalRevenue, 2) }} DH</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-success text-white text-lg rounded-circle">
                                                <i class="bi bi-cash"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Total Expenses -->
                        <div class="col-12 col-sm-6 col-xl-4 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Total Expenses</span>
                                            <span class="h3 font-bold mb-0">{{ number_format($totalExpenses, 2) }} DH</span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-danger text-white text-lg rounded-circle">
                                                <i class="bi bi-credit-card"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Net Income -->
                        <div class="col-12 col-sm-6 col-xl-4 mb-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <span class="h6 font-semibold text-muted text-sm d-block mb-2">Net Income</span>
                                            <span class="h3 font-bold mb-0 {{ $netIncome >= 0 ? 'text-success' : 'text-danger' }}">
                                                {{ number_format($netIncome, 2) }} DH
                                            </span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape {{ $netIncome >= 0 ? 'bg-success' : 'bg-danger' }} text-white text-lg rounded-circle">
                                                <i class="bi bi-graph-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Transactions -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-4">Today's Transactions</h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-muted">Income</span>
                                                <h4 class="mb-0 text-success">{{ number_format($dailyTransactions['income'], 2) }} DH</h4>
                                            </div>
                                            <div class="icon-shape bg-success text-white rounded-circle">
                                                <i class="bi bi-arrow-up"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 border rounded bg-light">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="text-muted">Expenses</span>
                                                <h4 class="mb-0 text-danger">{{ number_format($dailyTransactions['expenses'], 2) }} DH</h4>
                                            </div>
                                            <div class="icon-shape bg-danger text-white rounded-circle">
                                                <i class="bi bi-arrow-down"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Expenses -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h5 class="mb-0">Monthly Expenses</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyExpenses as $expense)
                                <tr>
                                    <td>{{ $expense->motif }}</td>
                                    <td>{{ number_format($expense->total, 2) }} DH</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue by Category -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h5 class="mb-0">Revenue by Category</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($revenueByCategory as $revenue)
                                <tr>
                                    <td>{{ $revenue->motif }}</td>
                                    <td>{{ number_format($revenue->total, 2) }} DH</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unpaid Dossiers -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h5 class="mb-0">Unpaid Dossiers</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Dossier Ref</th>
                                    <th>Total Price</th>
                                    <th>Paid Amount</th>
                                    <th>Remaining</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($unpaidDossiers as $dossier)
                                <tr>
                                    <td>{{ $dossier->student->firstname }} {{ $dossier->student->lastname }}</td>
                                    <td>{{ $dossier->ref }}</td>
                                    <td>{{ number_format($dossier->price, 2) }} DH</td>
                                    <td>{{ number_format($dossier->total_paid ?? 0, 2) }} DH</td>
                                    <td>{{ number_format($dossier->price - ($dossier->total_paid ?? 0), 2) }} DH</td>
                                    <td>
                                        <span class="badge bg-warning">Pending Payment</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div> 