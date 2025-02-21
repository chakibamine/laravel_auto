<div>
    <div class="modal <?php if($showModal): ?> show <?php endif; ?>" tabindex="-1" role="dialog" style="display: <?php if($showModal): ?> block <?php else: ?> none <?php endif; ?>;">
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
                                <input type="date" class="form-control <?php $__errorArgs = ['date_cours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    wire:model="date_cours" id="date_cours">
                                <?php $__errorArgs = ['date_cours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    wire:model="type" id="type">
                                    <option value="">Sélectionner un type</option>
                                    <option value="Theorique">Théorique</option>
                                    <option value="Pratique">Pratique</option>
                                </select>
                                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

                    <?php $__errorArgs = ['selectedDossiers'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="alert alert-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" 
                                                wire:click="$set('selectedDossiers', <?php if(count($selectedDossiers) === $dossiers->count()): ?> [] <?php else: ?> <?php echo e($dossiers->pluck('id')); ?> <?php endif; ?>)">
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
                                <?php $__empty_1 = true; $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" 
                                                    wire:model="selectedDossiers" 
                                                    value="<?php echo e($dossier->id); ?>">
                                            </div>
                                        </td>
                                        <td><?php echo e($dossier->ref); ?></td>
                                        <td><?php echo e($dossier->student->cin); ?></td>
                                        <td><?php echo e($dossier->student->firstname); ?> <?php echo e($dossier->student->lastname); ?></td>
                                        <td <?php if($dossier->courses->where('type_cours', 'Theorique')->count() >= 20): ?> class="text-danger fw-bold" <?php endif; ?>>
                                            <?php echo e($dossier->courses->where('type_cours', 'Theorique')->count()); ?>/20
                                        </td>
                                        <td <?php if($dossier->courses->where('type_cours', 'Pratique')->count() >= 20): ?> class="text-danger fw-bold" <?php endif; ?>>
                                            <?php echo e($dossier->courses->where('type_cours', 'Pratique')->count()); ?>/20
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Aucun dossier trouvé</td>
                                    </tr>
                                <?php endif; ?>
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
    <div class="modal-backdrop fade show" style="display: <?php if($showModal): ?> block <?php else: ?> none <?php endif; ?>;"></div>
</div> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/components/add-cour-modal.blade.php ENDPATH**/ ?>