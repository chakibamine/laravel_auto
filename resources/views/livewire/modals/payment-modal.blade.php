{{-- Debug info --}}
@if($showPaymentModal)
    <div style="display:none">
        Debug: Modal should be visible
        ShowPaymentModal: {{ var_export($showPaymentModal, true) }}
        SelectedDossier exists: {{ isset($selectedDossier) ? 'Yes' : 'No' }}
        @if(isset($selectedDossier))
            Dossier ID: {{ $selectedDossier->id }}
            Price: {{ $selectedDossier->price }}
            Remaining: {{ $remaining }}
        @endif
    </div>
@endif

@if($showPaymentModal && $selectedDossier)
<div class="modal show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $remaining > 0 ? 'Nouveau Paiement' : 'Détails des Paiements' }}</h5>
                <button type="button" class="btn-close" wire:click="closePaymentModal"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!-- First Row -->
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">C.I.N :</label>
                                <input type="text" class="form-control" value="{{ $selectedDossier->student->cin }}" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">Reglement pour :</label>
                                <input type="text" class="form-control" id="copy_lui_m" 
                                    value="{{ $selectedDossier->student->lastname }} {{ $selectedDossier->student->firstname }}" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">Dossier :</label>
                                <input type="text" class="form-control" value="{{ $selectedDossier->ref }}" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">Prix :</label>
                                <input type="text" class="form-control" value="{{ $selectedDossier->price }}" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">Avances :</label>
                                <input type="text" class="form-control" value="{{ $totalPaid }}" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">Reste :</label>
                                <input type="text" class="form-control" value="{{ $remaining }}" disabled>
                            </div>
                        </div>
                    </div>

                    @if($remaining > 0)
                        <form wire:submit.prevent="saveReg">
                            <!-- Hidden dossier_id -->
                            <input type="hidden" wire:model.defer="reg.dossier_id" value="{{ $selectedDossier->id }}">

                            <!-- Payment Form Fields -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Date de reglement :</label>
                                        <input type="date" class="form-control @error('reg.date_reg') is-invalid @enderror" 
                                            wire:model.defer="reg.date_reg">
                                        @error('reg.date_reg') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Montant :</label>
                                        <input type="number" step="0.01" class="form-control @error('reg.prix') is-invalid @enderror" 
                                            wire:model.defer="reg.prix">
                                        @error('reg.prix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Motif :</label>
                                        <select class="form-select @error('reg.motif') is-invalid @enderror" 
                                            wire:model.defer="reg.motif">
                                            <option value="">Sélectionner un motif</option>
                                            <option value="Free inscription">Frais inscription</option>
                                            <option value="Free dossier">Frais dossier</option>
                                            <option value="Free ecole">Frais ecole</option>
                                        </select>
                                        @error('reg.motif') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Nom du payeur :</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label>
                                                    lui meme <input wire:model="isLuiMeme" class="form-check-input mt-0" type="checkbox">
                                                </label>
                                            </div>
                                            <input type="text" class="form-control @error('reg.nom_du_payeur') is-invalid @enderror" 
                                                wire:model.defer="reg.nom_du_payeur" id="text_lui_m">
                                            @error('reg.nom_du_payeur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Show any validation errors -->
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

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

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary">Ajouter</button>
                                <button type="button" class="btn btn-outline-secondary" wire:click="closePaymentModal">Annuler</button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-success mt-3">
                            Le dossier est entièrement payé.
                        </div>
                    @endif

                    <!-- Registrations Table -->
                    @if($registrations && $registrations->count() > 0)
                    <div class="table-responsive" wire:poll.visible>
                        <table class="table" id="table_reg">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Motif</th>
                                    <th scope="col">Montant</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Nom du payeur</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $index => $reg)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $reg->motif }}</td>
                                    <td>{{ $reg->prix }}</td>
                                    <td>{{ $reg->date_reg->format('d/m/Y') }}</td>
                                    <td>{{ $reg->nom_du_payeur }}</td>
                                    <td>
                                        @if($selectedDossier->status == '1' && auth()->user()->role == 'admin')
                                            <button type="button" 
                                                class="btn btn-outline-danger btn-sm"
                                                wire:click="deleteReg({{ $reg->id }})">
                                                delete
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex flex-row-reverse">
                        <div>
                            <a href="#" class="btn btn-outline-primary btn-sm p-2">
                                <i class="bi bi-printer"></i> Facture
                            </a>
                            <a href="#" class="btn btn-outline-primary btn-sm p-2 m-2">
                                <i class="bi bi-printer"></i> Reglement Exterieur
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif 