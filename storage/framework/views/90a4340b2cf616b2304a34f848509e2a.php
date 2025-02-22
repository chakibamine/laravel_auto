<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Gestion des Dossiers</h2>
        </div>
    </div>

    <!-- Search -->
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
                        <input wire:model.debounce.300ms="searchTerm" class="form-control" type="text" placeholder="Rechercher un dossier...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dossiers Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">N° Dossier</th>
                            <th class="border-0">CIN</th>
                            <th class="border-0">Nom et Prénom</th>
                            <th class="border-0">Téléphone</th>
                            <th class="border-0">Catégorie</th>
                            <th class="border-0">Date d'Inscription</th>
                            <th class="border-0">Date de Clôture</th>
                            <th class="border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($dossier->ref); ?></td>
                            <td><?php echo e($dossier->student->cin); ?></td>
                            <td><?php echo e(strtoupper($dossier->student->lastname)); ?> <?php echo e(ucfirst($dossier->student->firstname)); ?></td>
                            <td><?php echo e($dossier->student->phone); ?></td>
                            <td><?php echo e($dossier->category); ?></td>
                            <td><?php echo e($dossier->date_inscription ? $dossier->date_inscription->format('d/m/Y H:i:s') : '-'); ?></td>
                            <td><?php echo e($dossier->date_cloture ? $dossier->date_cloture->format('d/m/Y H:i:s') : '-'); ?></td>
                            <td>
                                <a href="#" class="text-success me-2" wire:click.prevent="openPaymentModal(<?php echo e($dossier->id); ?>)">
                                    <i class="fas fa-money-bill fa-sm"></i>
                                </a>
                                <a href="#" class="text-primary me-2" wire:click.prevent="openExamModal(<?php echo e($dossier->id); ?>)">
                                    <i class="fas fa-graduation-cap fa-sm"></i>
                                </a>
                                <a href="#" class="text-info me-2" wire:click.prevent="openEditModal(<?php echo e($dossier->id); ?>)">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <a href="<?php echo e(route('dossier.contract.pdf', ['id' => $dossier->id])); ?>" class="text-secondary me-2" target="_blank">
                                    <i class="fas fa-print fa-sm"></i>
                                </a>
                                <?php if(auth()->user()->role == 'admin'): ?>
                                    <a href="#" class="text-danger" wire:click.prevent="deleteDossier(<?php echo e($dossier->id); ?>)">
                                        <i class="fas fa-trash fa-sm"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">Aucun dossier trouvé.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php echo e($dossiers->links()); ?>

            </div>
        </div>
    </div>

    <!-- Include Payment Modal -->
    <?php echo $__env->make('livewire.modals.payment-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Include Edit Modal -->
    <?php if($showEditModal && $selectedDossier): ?>
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le Dossier</h5>
                    <button wire:click="closeEditModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="updateDossier">
                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select wire:model.defer="editDossier.category" class="form-select <?php $__errorArgs = ['editDossier.category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Sélectionner une catégorie</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="EC">EC</option>
                            </select>
                            <?php $__errorArgs = ['editDossier.category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['editDossier.price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="editDossier.price">
                            <?php $__errorArgs = ['editDossier.price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">N° Dossier</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['editDossier.ref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="editDossier.ref">
                            <?php $__errorArgs = ['editDossier.ref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

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
                    </form>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeEditModal" type="button" class="btn btn-link text-gray ms-auto">Annuler</button>
                    <button wire:click="updateDossier" type="button" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <!-- Include Confirm Modal -->
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('confirm-modal', ['title' => 'Confirmation de suppression','message' => 'Êtes-vous sûr de vouloir supprimer ce dossier ? Cette action est irréversible.','confirmButtonText' => 'Supprimer','cancelButtonText' => 'Annuler','confirmButtonClass' => 'btn-danger'])->html();
} elseif ($_instance->childHasBeenRendered('l1588430505-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1588430505-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1588430505-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1588430505-0');
} else {
    $response = \Livewire\Livewire::mount('confirm-modal', ['title' => 'Confirmation de suppression','message' => 'Êtes-vous sûr de vouloir supprimer ce dossier ? Cette action est irréversible.','confirmButtonText' => 'Supprimer','cancelButtonText' => 'Annuler','confirmButtonClass' => 'btn-danger']);
    $html = $response->html();
    $_instance->logRenderedChild('l1588430505-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    <!-- Include Exam Modal -->
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.exam-modal')->html();
} elseif ($_instance->childHasBeenRendered('l1588430505-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l1588430505-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1588430505-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1588430505-1');
} else {
    $response = \Livewire\Livewire::mount('components.exam-modal');
    $html = $response->html();
    $_instance->logRenderedChild('l1588430505-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

</div>


<?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/dossier-list.blade.php ENDPATH**/ ?>