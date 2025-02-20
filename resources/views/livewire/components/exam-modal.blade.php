<div>
    @if($showModal && $selectedDossier)
    <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Examen</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form wire:submit.prevent="saveExam">
                            <!-- Student Info -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">C.I.N :</label>
                                        <input type="text" class="form-control" value="{{ $selectedDossier->student->cin }}" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Examen pour :</label>
                                        <input type="text" class="form-control" 
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

                            <!-- Exam Form -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Date d'examen :</label>
                                        <input type="date" class="form-control @error('exam.date_exam') is-invalid @enderror" 
                                            wire:model.defer="exam.date_exam" required>
                                        @error('exam.date_exam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                               
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Type :</label>
                                        @if(count($exams) === 0)
                                            <input type="text" class="form-control" wire:model.defer="exam.type_exam" value="Theorique" readonly>
                                            <input type="hidden" wire:model.defer="exam.type_exam" value="Theorique">
                                        @else
                                            <input type="text" class="form-control" wire:model.defer="exam.type_exam" value="{{ $exam['type_exam'] }}" readonly>
                                            <input type="hidden" wire:model.defer="exam.type_exam" value="{{ $exam['type_exam'] }}">
                                        @endif
                                        @error('exam.type_exam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    @if(count($exams) === 0)
                                    <div class="mb-3">
                                        <label class="col-form-label">N'serie :</label>
                                        <input type="text" class="form-control @error('exam.n_serie') is-invalid @enderror" 
                                            wire:model.defer="exam.n_serie" required>
                                        @error('exam.n_serie') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Messages -->
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
                                @php
                                    $examCount = count($exams);
                                    $canAddMore = true;
                                    
                                    switch ($examCount) {
                                        case 2:
                                            if (($exams[0]->resultat == '1' && $exams[1]->resultat == '1') || 
                                                ($exams[0]->resultat == '2' && $exams[1]->resultat == '2')) {
                                                $canAddMore = false;
                                            }
                                            break;
                                        case 3:
                                            $canAddMore = false;
                                            break;
                                    }
                                @endphp

                                @if($canAddMore)
                                    <button type="submit" class="btn btn-outline-primary">Ajouter</button>
                                @endif
                                <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Annuler</button>
                            </div>
                        </form>

                        <!-- Exams List -->
                        @if($exams->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Examen</th>
                                    <th>Date</th>
                                    <th>Resultat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                <tr style="background-color: {{ $exam->resultat == '1' ? '#F9EEEE' : ($exam->resultat == '2' ? '#EEF9F9' : '') }}">
                                    <td>{{ $exam->type_exam }}</td>
                                    <td>{{ \Carbon\Carbon::parse($exam->date_exam)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($exam->resultat == '0')
                                            En cours...
                                        @elseif($exam->resultat == '1')
                                            Inapte
                                        @elseif($exam->resultat == '2')
                                            Apte
                                        @endif
                                    </td>
                                    <td>
                                        @if($exam->resultat == '0' &&  $exam->date_exam->isPast())
                                            <button class="btn btn-outline-success btn-sm" 
                                                wire:click="updateExamResult({{ $exam->id }}, '2')">APTE</button>
                                            <button class="btn btn-outline-warning btn-sm mx-2" 
                                                wire:click="updateExamResult({{ $exam->id }}, '1')">INAPTE</button>
                                        @endif
                                        @if(auth()->user()->role == "admin")
                                            <button class="btn btn-outline-danger btn-sm" 
                                                wire:click="confirmDelete({{ $exam->id }})">
                                                <i class="fas fa-trash"></i> delete
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Print Button -->
                        <div class="d-flex flex-row-reverse">
                            <a href="#" class="btn btn-outline-primary btn-sm p-2">
                                <i class="bi bi-printer"></i> fiche
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Confirm Delete Modal -->
    @if($showConfirmModal)
    <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation de suppression</h5>
                    <button wire:click="cancelDelete" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet examen ?</p>
                </div>
                <div class="modal-footer">
                    <button wire:click="cancelDelete" type="button" class="btn btn-link text-gray ms-auto">Annuler</button>
                    <button wire:click="deleteExam" type="button" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Single Backdrop for both modals -->
    @if($showModal || $showConfirmModal)
    <div class="modal-backdrop fade show"></div>
    @endif
</div> 