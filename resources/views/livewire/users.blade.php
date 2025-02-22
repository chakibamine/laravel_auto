@section('title', 'Gestion des Utilisateurs')

<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Gestion des Utilisateurs</h2>
            <p class="mb-0">Gérez les utilisateurs et leurs rôles.</p>
        </div>
        <div>
            <button wire:click="create" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-2"></i> Nouvel Utilisateur
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="input-group w-50">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input wire:model.debounce.300ms="searchTerm" type="text" class="form-control" placeholder="Rechercher un utilisateur">
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>NOM</th>
                            <th>EMAIL</th>
                            <th>RÔLE</th>
                            <th>DATE DE CRÉATION</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-dark">Admin</span>
                                @else
                                    <span class="badge bg-primary">Utilisateur</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button wire:click="edit({{ $user->id }})" class="btn btn-sm btn-dark">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                @if(auth()->id() !== $user->id)
                                <button wire:click="confirmDelete({{ $user->id }})" class="btn btn-sm btn-danger ms-2">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun utilisateur trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="createEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEditModalLabel">
                        {{ $editMode ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur' }}
                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control @error('user.name') is-invalid @enderror" 
                                wire:model.defer="user.name">
                            @error('user.name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('user.email') is-invalid @enderror" 
                                wire:model.defer="user.email">
                            @error('user.email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-select @error('user.role') is-invalid @enderror" 
                                wire:model.defer="user.role">
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin">Admin</option>
                                <option value="user">Utilisateur</option>
                            </select>
                            @error('user.role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Mot de passe {{ $editMode ? '(laisser vide pour ne pas modifier)' : '' }}
                            </label>
                            <input type="password" class="form-control @error('user.password') is-invalid @enderror" 
                                wire:model.defer="user.password">
                            @error('user.password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" 
                                wire:model.defer="user.password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            {{ $editMode ? 'Mettre à jour' : 'Créer' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteUser">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" wire:click="$set('showSuccessAlert', false)"></button>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" wire:click="$set('showErrorAlert', false)"></button>
        </div>
    @endif
</div>

@push('scripts')
<script>
    window.addEventListener('closeModal', event => {
        document.body.classList.remove('modal-open');
    });

    window.addEventListener('showModal', event => {
        document.body.classList.add('modal-open');
    });
</script>
@endpush