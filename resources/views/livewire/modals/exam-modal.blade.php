@if($showModal && $selectedDossier)
<div class="modal show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gestion des Examens</h5>
                <button type="button" class="btn-close" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="saveExam">
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
                                    <label class="col-form-label">Candidat :</label>
                                    <input type="text" class="form-control" 
                                        value="{{ $selectedDossier->student->lastname }} {{ $selectedDossier->student->firstname }}" disabled>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">N° Dossier :</label>
                                    <input type="text" class="form-control" value="{{ $selectedDossier->ref }}" disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row -->
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">Date d'Examen :</label>
                                    <input type="date" class="form-control @error('exam.date_exam') is-invalid @enderror" 
                                        wire:model.defer="exam.date_exam">
                                    @error('exam.date_exam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">Type d'Examen :</label>
                                    <select class="form-select @error('exam.type_exam') is-invalid @enderror" 
                                        wire:model.defer="exam.type_exam">
                                        <option value="">Sélectionner un type</option>
                                        <option value="Theorique">Théorique</option>
                                        <option value="Pratique">Pratique</option>
                                    </select>
                                    @error('exam.type_exam') <div class="invalid-feedback">{{ $message }}</div> @enderror
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

                        <!-- Footer -->
                        <div class="modal-footer">
                            @if(!$isMaxExamsReached)
                                <button type="submit" class="btn btn-outline-primary">
                                    Ajouter
                                </button>
                            @endif
                            <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Annuler</button>
                        </div>

                        <!-- Exams Table -->
                        @if($exams && $exams->count() > 0)
                        <div class="table-responsive" wire:poll.visible>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Type d'Examen</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Résultat</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exams as $exam)
                                    <tr style="background-color: {{ $exam->resultat == '1' ? '#F9EEEE' : ($exam->resultat == '2' ? '#EEF9F9' : '') }}">
                                        <td>{{ $exam->type_exam }}</td>
                                        <td>{{ $exam->date_exam->format('d/m/Y') }}</td>
                                        <td>
                                            @if($exam->resultat == '1')
                                                Inapte
                                            @elseif($exam->resultat == '2')
                                                Apte
                                            @else
                                                En cours
                                            @endif
                                        </td>
                                        <td>
                                            @if($exam->date_exam->lte(now()) && $exam->resultat == '0')
                                                <button type="button" class="btn btn-outline-success btn-sm"
                                                    wire:click="updateExamResult({{ $exam->id }}, '2')">
                                                    APTE
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-sm mx-2"
                                                    wire:click="updateExamResult({{ $exam->id }}, '1')">
                                                    INAPTE
                                                </button>
                                            @endif
                                            
                                            @if($exam->resultat == '0' && auth()->user()->role == 'admin')
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    wire:click="deleteExam({{ $exam->id }})"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet examen ?')">
                                                    Supprimer
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
@endif 