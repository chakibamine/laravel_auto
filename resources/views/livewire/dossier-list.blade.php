

<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Liste des Dossiers</h2>
        </div>
    </div>

    <!-- Search -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <input wire:model.debounce.300ms="searchTerm" class="form-control" type="text" placeholder="Rechercher...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dossiers Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">N'web</th>
                            <th class="border-0">CIN</th>
                            <th class="border-0">Nom et prénom</th>
                            <th class="border-0">Phone</th>
                            <th class="border-0">Permis</th>
                            <th class="border-0">Date d'inscription</th>
                            <th class="border-0">Date de cloture</th>
                            <th class="border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dossiers as $dossier)
                        <tr>
                            <td>{{ str_pad($dossier->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $dossier->student->cin }}</td>
                            <td>{{ strtoupper($dossier->student->lastname) }} {{ ucfirst($dossier->student->firstname) }}</td>
                            <td>{{ $dossier->student->phone }}</td>
                            <td>{{ $dossier->category }}</td>
                            <td>{{ $dossier->date_inscription ? $dossier->date_inscription->format('d/m/Y H:i:s') : '-' }}</td>
                            <td>{{ $dossier->date_cloture ? $dossier->date_cloture->format('d/m/Y H:i:s') : '-' }}</td>
                            <td>
                                <a href="#" class="text-success me-2" wire:click.prevent="openPaymentModal({{ $dossier->id }})">
                                    <i class="fas fa-money-bill fa-sm"></i>
                                </a>
                                <a href="#" class="text-primary me-2" wire:click.prevent="$emit('showExamModal', {{ $dossier->id }})">
                                    <i class="fas fa-graduation-cap fa-sm"></i>
                                </a>
                                <a href="#" class="text-info me-2">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <a href="#" class="text-secondary me-2">
                                    <i class="fas fa-print fa-sm"></i>
                                </a>
                                @if(auth()->user()->role == 'admin')
                                    <a href="#" class="text-danger" wire:click.prevent="deleteDossier({{ $dossier->id }})">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun dossier trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $dossiers->links() }}
            </div>
        </div>
    </div>

    <!-- Include Payment Modal -->
    @include('livewire.modals.payment-modal')
    @include('livewire.modals.exam-modal')

    <!-- Include Confirm Modal -->
    <livewire:confirm-modal 
        title="Confirmation de suppression"
        message="Êtes-vous sûr de vouloir supprimer ce dossier ? Cette action est irréversible."
        confirm-button-text="Supprimer"
        cancel-button-text="Annuler"
        confirm-button-class="btn-danger"
    />

</div>


