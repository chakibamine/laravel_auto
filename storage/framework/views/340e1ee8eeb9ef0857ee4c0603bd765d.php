<div>
    <?php if($showModal && $selectedDossier): ?>
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
                                        <input type="text" class="form-control" value="<?php echo e($selectedDossier->student->cin); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Examen pour :</label>
                                        <input type="text" class="form-control" 
                                            value="<?php echo e($selectedDossier->student->lastname); ?> <?php echo e($selectedDossier->student->firstname); ?>" disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Dossier :</label>
                                        <input type="text" class="form-control" value="<?php echo e($selectedDossier->ref); ?>" disabled>
                                    </div>
                                </div>
                            </div>

                            <!-- Exam Form -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Date d'examen :</label>
                                        <input type="date" class="form-control <?php $__errorArgs = ['exam.date_exam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            wire:model.defer="exam.date_exam" required>
                                        <?php $__errorArgs = ['exam.date_exam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Type :</label>
                                        <select class="form-select <?php $__errorArgs = ['exam.type_exam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            wire:model.defer="exam.type_exam" required>
                                            <option value="">Sélectionner un type</option>
                                            <option value="Theorique">Theorique</option>
                                            <option value="Pratique">Pratique</option>
                                        </select>
                                        <?php $__errorArgs = ['exam.type_exam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages -->
                            <?php if(session()->has('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo e(session('success')); ?>

                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <?php if(session()->has('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo e(session('error')); ?>

                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>

                            <!-- Footer -->
                            <div class="modal-footer">
                                <?php
                                    $examCount = count($exams);
                                    $canAddMore = true;
                                    
                                    if ($examCount >= 3) {
                                        $canAddMore = false;
                                    } elseif ($examCount == 2) {
                                        $results = collect($exams)->pluck('resultat')->toArray();
                                        if ((in_array('1', $results) && in_array('1', $results)) || 
                                            (in_array('2', $results) && in_array('2', $results))) {
                                            $canAddMore = false;
                                        }
                                    }
                                ?>

                                <?php if($canAddMore): ?>
                                    <button type="submit" class="btn btn-outline-primary">Ajouter</button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Annuler</button>
                            </div>
                        </form>

                        <!-- Exams List -->
                        <?php if($exams->count() > 0): ?>
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
                                <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="background-color: <?php echo e($exam->resultat == '1' ? '#F9EEEE' : ($exam->resultat == '2' ? '#EEF9F9' : '')); ?>">
                                    <td><?php echo e($exam->type_exam); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($exam->date_exam)->format('d/m/Y')); ?></td>
                                    <td>
                                        <?php if($exam->resultat == '0'): ?>
                                            En cours...
                                        <?php elseif($exam->resultat == '1'): ?>
                                            Inapte
                                        <?php elseif($exam->resultat == '2'): ?>
                                            Apte
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($exam->resultat == '0' && $exam->date_exam->isToday()): ?>
                                            <button class="btn btn-outline-success btn-sm" 
                                                wire:click="updateExamResult(<?php echo e($exam->id); ?>, '2')">APTE</button>
                                            <button class="btn btn-outline-warning btn-sm mx-2" 
                                                wire:click="updateExamResult(<?php echo e($exam->id); ?>, '1')">INAPTE</button>
                                        <?php endif; ?>
                                        <?php if(auth()->user()->role == "admin"): ?>
                                            <button class="btn btn-outline-danger btn-sm" 
                                                wire:click="confirmDelete(<?php echo e($exam->id); ?>)">
                                                <i class="fas fa-trash"></i> delete
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <!-- Print Button -->
                        <div class="d-flex flex-row-reverse">
                            <a href="#" class="btn btn-outline-primary btn-sm p-2">
                                <i class="bi bi-printer"></i> fiche
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Confirm Delete Modal -->
    <?php if($showConfirmModal): ?>
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
    <?php endif; ?>

    <!-- Single Backdrop for both modals -->
    <?php if($showModal || $showConfirmModal): ?>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>
</div> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/components/exam-modal.blade.php ENDPATH**/ ?>