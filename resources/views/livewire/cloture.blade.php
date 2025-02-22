<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Gestion des Clôtures</h2>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-calendar"></i>
                        </span>
                        <input type="month" wire:model="selectedMonth" class="form-control" id="monthPicker">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cloture Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">N° Série</th>
                            <th class="border-0">C.I.N</th>
                            <th class="border-0">Nom et Prénom</th>
                            <th class="border-0">Catégorie</th>
                            <th class="border-0">Date d'Inscription</th>
                            <th class="border-0">Date de Clôture</th>
                            <th class="border-0">Date d'Examen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dossiers as $dossier)
                            <tr>
                                <td>{{ $dossier->n_serie }}</td>
                                <td>{{ $dossier->student->cin }}</td>
                                <td>{{ $dossier->student->lastname }} {{ $dossier->student->firstname }}</td>
                                <td>{{ $dossier->category }}</td>
                                <td>{{ $dossier->date_inscription ? Carbon\Carbon::parse($dossier->date_inscription)->format('d/m/Y H:i') : '-' }}</td>
                                <td>{{ $dossier->date_cloture ? Carbon\Carbon::parse($dossier->date_cloture)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $dossier->exams->first() ? Carbon\Carbon::parse($dossier->exams->first()->date_exam)->format('d/m/Y H:i') : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun dossier trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Total Section -->
            <div class="d-flex justify-content-end mt-3">
                <div class="me-3">
                    <strong>Total des Dossiers : </strong>{{ $dossiers->count() }}
                </div>
                <button onclick="printPage()" class="btn btn-primary btn-sm">
                    <i class="fas fa-print me-2"></i> Imprimer
                </button>
            </div>
        </div>
    </div>

    <script>
        function printPage() {
            window.print();
        }

        // Print styles
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                body * {
                    visibility: hidden;
                }
                .card-body, .card-body * {
                    visibility: visible;
                }
                .card-body {
                    position: absolute;
                    left: 0;
                    top: 0;
                }
                button {
                    display: none !important;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</div> 