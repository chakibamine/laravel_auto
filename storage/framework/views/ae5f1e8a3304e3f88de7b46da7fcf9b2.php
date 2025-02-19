<?php if($showModal && $selectedDossier): ?>
<div class="modal show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau Examen</h5>
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

                        <!-- Second Row -->
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
                                        wire:model.defer="exam.date_exam">
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
                                        wire:model.defer="exam.type_exam">
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

                        <!-- Show any validation errors -->
                        <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <!-- Success/Error Messages -->
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
                            <?php if(!$isMaxExamsReached): ?>
                                <button type="submit" class="btn btn-outline-primary">
                                    Ajouter
                                </button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Annuler</button>
                        </div>

                        <!-- Exams Table -->
                        <?php if($exams && $exams->count() > 0): ?>
                        <div class="table-responsive" wire:poll.visible>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Examen</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Resultat</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="background-color: <?php echo e($exam->resultat == '1' ? '#F9EEEE' : ($exam->resultat == '2' ? '#EEF9F9' : '')); ?>">
                                        <td><?php echo e($exam->type_exam); ?></td>
                                        <td><?php echo e($exam->date_exam->format('d/m/Y')); ?></td>
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
                                            <?php if($exam->date_exam->lte(now()) && $exam->resultat == '0'): ?>
                                                <button type="button" class="btn btn-outline-success btn-sm"
                                                    wire:click="updateExamResult(<?php echo e($exam->id); ?>, '2')">
                                                    APTE
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-sm mx-2"
                                                    wire:click="updateExamResult(<?php echo e($exam->id); ?>, '1')">
                                                    INAPTE
                                                </button>
                                            <?php endif; ?>
                                            
                                            <?php if($exam->resultat == '0' && auth()->user()->role == 'admin'): ?>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    wire:click="deleteExam(<?php echo e($exam->id); ?>)"
                                                    delete
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
<?php endif; ?> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/modals/exam-modal.blade.php ENDPATH**/ ?>