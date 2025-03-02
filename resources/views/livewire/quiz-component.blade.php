<div>
    {{-- Success Message --}}
    @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <h2 class="h4">Gestion des Quiz</h2>
        <button wire:click="create" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajouter un Quiz
        </button>
    </div>
    
    {{-- Search and Filters --}}
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
                        <input wire:model.debounce.300ms="searchTerm" class="form-control" type="text" placeholder="Rechercher des quiz...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @if($showModal)
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $editMode ? 'Modifier le Quiz' : 'Ajouter un Nouveau Quiz' }}</h5>
                    <button wire:click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label">Image :</label>
                                    <input type="file" class="form-control @error('image_url') is-invalid @enderror" wire:model="image_url" accept="image/*">
                                    @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col">
                                    <label class="form-label">Audio :</label>
                                    <input type="file" class="form-control @error('audio') is-invalid @enderror" wire:model="audio" accept="audio/*">
                                    @error('audio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Résultat :</label>
                                    <input type="text" class="form-control @error('result') is-invalid @enderror" wire:model="result">
                                    @error('result') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Description :</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" wire:model="description"></textarea>
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-outline-primary">Annuler</button>
                    <button type="submit" class="btn btn-primary" wire:click="save">{{ $editMode ? 'Mettre à jour' : 'Insérer' }}</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Quizzes Table --}}
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <table class="table table-centered table-nowrap mb-0 rounded">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Audio</th>
                        <th>Résultat</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->id }}</td>
                        <td><img src="{{ Storage::url($quiz->image_url) }}" class="img-fluid" width="50" alt="Quiz Image"></td>
                        <td><audio controls><source src="{{ Storage::url($quiz->audio) }}" type="audio/mpeg">Your browser does not support the audio element.</audio></td>
                        <td>{{ $quiz->result }}</td>
                        <td>{{ $quiz->description }}</td>
                        <td>
                            <button wire:click="edit({{ $quiz->id }})" class="btn btn-link text-dark p-0 mx-2">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </button>
                            <button wire:click="delete({{ $quiz->id }})" class="btn btn-link text-danger p-0 mx-2">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucun quiz trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $quizzes->links() }}
        </div>
    </div>
</div>