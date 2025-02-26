<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Gestion des Étudiants</h2>
        </div>
        <div>
            <button wire:click="create" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Ajouter un Étudiant
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
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
                        <input wire:model.debounce.300ms="searchTerm" class="form-control" type="text" placeholder="Rechercher des étudiants...">
                            </div>
                        </div>
                <div class="col-md-3 mb-3">
                    <select wire:model="filters.gender" class="form-select">
                        <option value="">Tous les Genres</option>
                        <option value="Masculin">Masculin</option>
                        <option value="Féminin">Féminin</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select wire:model="filters.city" class="form-select">
                        <option value="">Toutes les Villes</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button wire:click="resetFilters" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                        <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Réinitialiser
                    </button>
                </div>
                            </div>
                        </div>
                    </div>

    <!-- Students Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">
                                <a wire:click="sortBy('id')" role="button" class="text-decoration-none">
                                    #
                                    @if($sortField === 'id')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="border-0">
                                <a wire:click="sortBy('firstname')" role="button" class="text-decoration-none">
                                    Nom
                                    @if($sortField === 'firstname')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="border-0">CIN</th>
                            <th class="border-0">
                                <a wire:click="sortBy('gender')" role="button" class="text-decoration-none">
                                    Genre
                                    @if($sortField === 'gender')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="border-0">Téléphone</th>
                            <th class="border-0">
                                <a wire:click="sortBy('city')" role="button" class="text-decoration-none">
                                    Ville
                                    @if($sortField === 'city')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="border-0">
                                <a wire:click="sortBy('date_birth')" role="button" class="text-decoration-none">
                                    Date de naissance
                                    @if($sortField === 'date_birth')
                                        <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                                    @endif
                                </a>
                            </th>
                            <th class="border-0 rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td>{{ $student->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($student->image_url && Storage::disk('public')->exists($student->image_url))
                                        <img src="{{ Storage::url($student->image_url) }}" class="rounded-circle me-3" width="32" height="32" alt="{{ $student->firstname }}">
                                    @else
                                        <div class="avatar rounded-circle me-3 bg-gray-600" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                            <span class="text-white" style="font-size: 14px;">{{ substr(strtoupper($student->firstname), 0, 1) }}</span>
                                        </div>
                                    @endif
                                    {{ $student->firstname }} {{ $student->lastname }}
                                </div>
                            </td>
                            <td>{{ $student->cin }}</td>
                            <td>{{ $student->gender }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->city }}</td>
                            <td>{{ $student->date_birth ? $student->date_birth->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button wire:click="edit({{ $student->id }})" class="btn btn-link text-dark p-0 mx-2">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $student->id }})" class="btn btn-link text-danger p-0 mx-2">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    @if(!$student->dossiers()->where('status', 1)->exists())
                                    <button wire:click="addDossier({{ $student->id }})" class="btn btn-link text-primary p-0 mx-2" title="Add Dossier">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucun étudiant trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                    </div>
            <div class="mt-3">
                {{ $students->links() }}
                            </div>
                        </div>
                    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editMode ? 'Modifier l\'Étudiant' : 'Ajouter un Nouvel Étudiant' }}</h5>
                    <button wire:click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="container">
                            <!-- Gender Selection -->
                    <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label mb-3">Genre :</label>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-4">
                                                <input class="form-check-input" type="radio" wire:model="student.gender" value="Masculin" id="gender-male">
                                                <label class="form-check-label" for="gender-male">
                                                    <i class="fas fa-male me-1"></i> Masculin
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" wire:model="student.gender" value="Féminin" id="gender-female">
                                                <label class="form-check-label" for="gender-female">
                                                    <i class="fas fa-female me-1"></i> Féminin
                                                </label>
                            </div>
                        </div>
                                        @error('student.gender') 
                                            <div class="text-danger mt-2 small">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                            </div>
                        </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label">C.I.N :</label>
                                    <input type="text" class="form-control h-50 @error('student.cin') is-invalid @enderror" wire:model="student.cin">
                                    @error('student.cin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>

                            <!-- Name Fields -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Prénom :</label>
                                    <input type="text" class="form-control h-50 @error('student.firstname') is-invalid @enderror" wire:model="student.firstname">
                                    @error('student.firstname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label float-end">: الإسم الشخصي</label>
                                    <input type="text" class="form-control h-50 @error('student.firstname_ar') is-invalid @enderror" wire:model="student.firstname_ar">
                                    @error('student.firstname_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Nom :</label>
                                    <input type="text" class="form-control h-50 @error('student.lastname') is-invalid @enderror" wire:model="student.lastname">
                                    @error('student.lastname') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label float-end">: الإسم العائلي</label>
                                    <input type="text" class="form-control h-50 @error('student.lastname_ar') is-invalid @enderror" wire:model="student.lastname_ar">
                                    @error('student.lastname_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Birth Information -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Date de naissance :</label>
                                    <input type="date" 
                                        class="form-control h-50 @error('student.date_birth') is-invalid @enderror" 
                                        wire:model="date_birth">
                                    @error('student.date_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label">Lieu de naissance :</label>
                                    <input type="text" class="form-control h-50 @error('student.place_birth') is-invalid @enderror" wire:model="student.place_birth">
                                    @error('student.place_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label float-end">: مكان الإزدياد</label>
                                    <input type="text" class="form-control h-50 @error('student.place_birth_ar') is-invalid @enderror" wire:model="student.place_birth_ar">
                                    @error('student.place_birth_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Adresse :</label>
                                    <input type="text" class="form-control h-50 @error('student.address') is-invalid @enderror" wire:model="student.address">
                                    @error('student.address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label float-end">: العنوان</label>
                                    <input type="text" class="form-control h-50 @error('student.address_ar') is-invalid @enderror" wire:model="student.address_ar">
                                    @error('student.address_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- City, Phone and Photo -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Ville :</label>
                                    <input type="text" class="form-control h-50 @error('student.city') is-invalid @enderror" wire:model="student.city">
                                    @error('student.city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label">Téléphone GSM :</label>
                                    <input type="text" class="form-control h-50 @error('student.phone') is-invalid @enderror" wire:model="student.phone">
                                    @error('student.phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label">Photo :</label>
                                    <input type="file" 
                                        class="form-control @error('photo') is-invalid @enderror" 
                                        wire:model="photo" 
                                        accept="image/*">
                                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-outline-primary">Annuler</button>
                    <button wire:click="save" type="button" class="btn btn-primary">{{ $editMode ? 'Mettre à jour' : 'Insérer' }}</button>
                </div>
            </div>
        </div>
    </div>
                            @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Supprimer l'Étudiant</h5>
                    <button wire:click="$set('showDeleteModal', false)" type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet étudiant ? Cette action ne peut pas être annulée.</p>
                    </div>
                <div class="modal-footer">
                    <button wire:click="$set('showDeleteModal', false)" type="button" class="btn btn-link text-gray ms-auto">Annuler</button>
                    <button wire:click="deleteStudent" type="button" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Dossier Creation Modal -->
    @if($showDossierModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Nouveau Dossier</h5>
                    <button wire:click="closeDossierModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveDossier">
                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select wire:model="dossier.category" class="form-select @error('dossier.category') is-invalid @enderror">
                                <option value="">Sélectionner une Catégorie</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="EC">EC</option>
                            </select>
                            @error('dossier.category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" class="form-control @error('dossier.price') is-invalid @enderror" 
                                wire:model="dossier.price">
                            @error('dossier.price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Numéro de Référence</label>
                            <input type="text" class="form-control @error('dossier.ref') is-invalid @enderror" 
                                wire:model="dossier.ref">
                            @error('dossier.ref') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeDossierModal" type="button" class="btn btn-link text-gray ms-auto">Annuler</button>
                    <button wire:click="saveDossier" type="button" class="btn btn-primary">Créer le Dossier</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Notifications -->
    @if($showSavedAlert)
    <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 mb-4 me-4" role="alert">
        {{ $editMode ? 'Étudiant mis à jour avec succès !' : 'Étudiant créé avec succès !' }}
        <button wire:click="$set('showSavedAlert', false)" type="button" class="btn-close" aria-label="Close"></button>
    </div>
    @endif

    @if($showDemoNotification)
    <div class="alert alert-info alert-dismissible fade show position-fixed bottom-0 end-0 mb-4 me-4" role="alert">
        Vous ne pouvez pas faire cela dans la version de démonstration.
        <button wire:click="$set('showDemoNotification', false)" type="button" class="btn-close" aria-label="Close"></button>
    </div>
    @endif
</div> 