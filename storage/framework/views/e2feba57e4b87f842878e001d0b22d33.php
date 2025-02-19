<div>
    <?php if($showModal): ?>
    <div class="modal fade show" style="display: block" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un examen</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <?php if($selectedDossier && $this->canAddExam()): ?>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">C.I.N :</label>
                                    <input type="text" class="form-control" value="<?php echo e($selectedDossier->cin); ?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">Examen pour :</label>
                                    <input type="text" class="form-control" value="<?php echo e($selectedDossier->student->lastname); ?> <?php echo e($selectedDossier->student->firstname); ?>" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">Dossier :</label>
                                    <input type="text" class="form-control" value="<?php echo e($selectedDossier->ref); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">Date d'examen :</label>
                                    <input type="date" class="form-control" wire:model="exam.date_exam" required>
                                    <?php $__errorArgs = ['exam.date_exam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="col-form-label">Type :</label>
                                    <input type="text" class="form-control" wire:model="exam.type_exam" value="<?php echo e($examType); ?>" readonly>
                                    <?php $__errorArgs = ['exam.type_exam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col">
                                <?php if($showNSerie): ?>
                                <div class="mb-3">
                                    <label class="col-form-label">N'serie :</label>
                                    <input type="text" class="form-control" wire:model="exam.n_serie" required>
                                    <?php $__errorArgs = ['exam.n_serie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

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
                                    <?php if($exam->resultat == '1'): ?>
                                        Inapte
                                    <?php elseif($exam->resultat == '2'): ?>
                                        Apte
                                    <?php else: ?>
                                        En cours ...
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($exam->date_exam <= now()->format('Y-m-d') && $exam->resultat == '0'): ?>
                                        <button class="btn btn-outline-success btn-sm" wire:click="updateExamResult(<?php echo e($exam->id); ?>, '2')">APTE</button>
                                        <button class="btn btn-outline-warning btn-sm mx-2" wire:click="updateExamResult(<?php echo e($exam->id); ?>, '1')">INAPTE</button>
                                    <?php endif; ?>
                                    
                                    <?php if($exam->resultat == '0' && auth()->user()->role == 'admin'): ?>
                                        <button class="btn btn-outline-danger btn-sm" wire:click="deleteExam(<?php echo e($exam->id); ?>)">delete</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>

                    <div class="d-flex flex-row-reverse">
                        <?php if($examCount > 0): ?>
                            <a href="<?php echo e(route('exam.pdf', ['id' => $selectedDossier->id])); ?>" class="btn btn-outline-primary btn-sm p-2">
                                <i class="bi bi-printer"></i> fiche
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <?php if($this->canAddExam()): ?>
                        <button type="button" class="btn btn-outline-primary" wire:click="saveExam">Ajouter</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>
</div> <?php /**PATH D:\laravel\volt-laravel-dashboard - Copy - Copy\resources\views/livewire/exam-modal.blade.php ENDPATH**/ ?>