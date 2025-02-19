<?php if($showPaymentModal && $selectedDossier): ?>
<div class="modal show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e($remaining > 0 ? 'Nouveau Paiement' : 'Détails des Paiements'); ?></h5>
                <button type="button" class="btn-close" wire:click="closePaymentModal"></button>
            </div>
            <div class="modal-body">
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
                                <label class="col-form-label">Reglement pour :</label>
                                <input type="text" class="form-control" id="copy_lui_m" 
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
                                <label class="col-form-label">Prix :</label>
                                <input type="text" class="form-control" value="<?php echo e($selectedDossier->price); ?>" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">Avances :</label>
                                <input type="text" class="form-control" value="<?php echo e($totalPaid); ?>" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="col-form-label">Reste :</label>
                                <input type="text" class="form-control" value="<?php echo e($remaining); ?>" disabled>
                            </div>
                        </div>
                    </div>

                    <?php if($remaining > 0): ?>
                        <form wire:submit.prevent="saveReg">
                            <!-- Hidden dossier_id -->
                            <input type="hidden" wire:model.defer="reg.dossier_id" value="<?php echo e($selectedDossier->id); ?>">

                            <!-- Payment Form Fields -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Date de reglement :</label>
                                        <input type="date" class="form-control <?php $__errorArgs = ['reg.date_reg'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            wire:model.defer="reg.date_reg">
                                        <?php $__errorArgs = ['reg.date_reg'];
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
                                        <label class="col-form-label">Montant :</label>
                                        <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['reg.prix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            wire:model.defer="reg.prix">
                                        <?php $__errorArgs = ['reg.prix'];
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

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Motif :</label>
                                        <select class="form-select <?php $__errorArgs = ['reg.motif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            wire:model.defer="reg.motif">
                                            <option value="">Sélectionner un motif</option>
                                            <option value="Free inscription">Frais inscription</option>
                                            <option value="Free dossier">Frais dossier</option>
                                            <option value="Free ecole">Frais ecole</option>
                                        </select>
                                        <?php $__errorArgs = ['reg.motif'];
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
                                        <label class="col-form-label">Nom du payeur :</label>
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                <label>
                                                    lui meme <input wire:model="isLuiMeme" class="form-check-input mt-0" type="checkbox">
                                                </label>
                                            </div>
                                            <input type="text" class="form-control <?php $__errorArgs = ['reg.nom_du_payeur'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                wire:model.defer="reg.nom_du_payeur" id="text_lui_m">
                                            <?php $__errorArgs = ['reg.nom_du_payeur'];
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

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-outline-primary">Ajouter</button>
                                <button type="button" class="btn btn-outline-secondary" wire:click="closePaymentModal">Annuler</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-success mt-3">
                            Le dossier est entièrement payé.
                        </div>
                    <?php endif; ?>

                    <!-- Registrations Table -->
                    <?php if($registrations && $registrations->count() > 0): ?>
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
                                <?php $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $reg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($index + 1); ?></td>
                                    <td><?php echo e($reg->motif); ?></td>
                                    <td><?php echo e($reg->prix); ?></td>
                                    <td><?php echo e($reg->date_reg->format('d/m/Y')); ?></td>
                                    <td><?php echo e($reg->nom_du_payeur); ?></td>
                                    <td>
                                        <?php if($selectedDossier->status == '0' && auth()->user()->role == 'admin'): ?>
                                            <button type="button" 
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Etes-vous sur???')"
                                                wire:click="deleteReg(<?php echo e($reg->id); ?>)">
                                                delete
                                            </button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show"></div>
<?php endif; ?> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/modals/payment-modal.blade.php ENDPATH**/ ?>