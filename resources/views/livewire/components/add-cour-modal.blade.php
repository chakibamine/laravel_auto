<div>
    <div class="modal @if($showModal) show @endif" tabindex="-1" role="dialog" style="display: @if($showModal) block @else none @endif;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter des Cours</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date_cours">Date</label>
                                <input type="date" class="form-control @error('date_cours') is-invalid @enderror" 
                                    wire:model="date_cours" id="date_cours">
                                @error('date_cours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control @error('type') is-invalid @enderror" 
                                    wire:model="type" id="type">
                                    <option value="">Sélectionner un type</option>
                                    <option value="Theorique">Théorique</option>
                                    <option value="Pratique">Pratique</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Sélectionner les dossiers</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Rechercher un dossier..." 
                                wire:model.debounce.300ms="searchTerm">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </div>

                    @error('selectedDossiers')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                                wire:click="$set('selectedDossiers', @if(count($selectedDossiers) === $dossiers->count()) [] @else {{ $dossiers->pluck('id') }} @endif)">
                                        </div>
                                    </th>
                                    <th>Réf</th>
                                    <th>CIN</th>
                                    <th>Nom</th>
                                    <th>Théorique</th>
                                    <th>Pratique</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dossiers as $dossier)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" 
                                                    wire:model="selectedDossiers" 
                                                    value="{{ $dossier->id }}">
                                            </div>
                                        </td>
                                        <td>{{ $dossier->ref }}</td>
                                        <td>{{ $dossier->student->cin }}</td>
                                        <td>{{ $dossier->student->firstname }} {{ $dossier->student->lastname }}</td>
                                        <td @if($dossier->courses->where('type_cours', 'Theorique')->count() >= 20) class="text-danger fw-bold" @endif>
                                            {{ $dossier->courses->where('type_cours', 'Theorique')->count() }}/20
                                        </td>
                                        <td @if($dossier->courses->where('type_cours', 'Pratique')->count() >= 20) class="text-danger fw-bold" @endif>
                                            {{ $dossier->courses->where('type_cours', 'Pratique')->count() }}/20
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aucun dossier trouvé</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                    <button type="button" class="btn btn-primary" wire:click="saveCours">
                        <span wire:loading.remove wire:target="saveCours">Enregistrer</span>
                        <span wire:loading wire:target="saveCours">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Enregistrement...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show" style="display: @if($showModal) block @else none @endif;"></div>
</div> 