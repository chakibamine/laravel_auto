

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
                            <td>{{ $dossier->ref }}</td>
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
                                <a href="#" class="text-primary me-2" wire:click.prevent="openExamModal({{ $dossier->id }})">
                                    <i class="fas fa-graduation-cap fa-sm"></i>
                                </a>
                                <a href="#" class="text-info me-2" wire:click.prevent="openEditModal({{ $dossier->id }})">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <a href="{{ route('dossier.contract.pdf', ['id' => $dossier->id]) }}" class="text-secondary me-2" target="_blank">
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

    <!-- Include Edit Modal -->
    @if($showEditModal && $selectedDossier)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le Dossier</h5>
                    <button wire:click="closeEditModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateDossier">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select wire:model.defer="editDossier.category" class="form-select @error('editDossier.category') is-invalid @enderror">
                                <option value="">Select Category</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="EC">EC</option>
                            </select>
                            @error('editDossier.category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" class="form-control @error('editDossier.price') is-invalid @enderror" 
                                wire:model.defer="editDossier.price">
                            @error('editDossier.price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Référence</label>
                            <input type="text" class="form-control @error('editDossier.ref') is-invalid @enderror" 
                                wire:model.defer="editDossier.ref">
                            @error('editDossier.ref') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Success/Error Messages -->
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeEditModal" type="button" class="btn btn-link text-gray ms-auto">Annuler</button>
                    <button wire:click="updateDossier" type="button" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Include Confirm Modal -->
    <livewire:confirm-modal 
        title="Confirmation de suppression"
        message="Êtes-vous sûr de vouloir supprimer ce dossier ? Cette action est irréversible."
        confirm-button-text="Supprimer"
        cancel-button-text="Annuler"
        confirm-button-class="btn-danger"
    />

    <!-- Include Exam Modal -->
    @livewire('components.exam-modal')

</div>


