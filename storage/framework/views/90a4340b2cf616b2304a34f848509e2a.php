

<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Liste des Dossiers</h2>
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
                        <input wire:model.debounce.300ms="searchTerm" class="form-control" type="text" placeholder="Rechercher...">
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
                            <th class="border-0">N'web</th>
                            <th class="border-0">CIN</th>
                            <th class="border-0">Nom et prénom</th>
                            <th class="border-0">Phone</th>
                            <th class="border-0">Permis</th>
                            <th class="border-0">Date d'inscription</th>
                            <th class="border-0">Date de cloture</th>
                            <th class="border-0">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e(str_pad($dossier->id, 4, '0', STR_PAD_LEFT)); ?></td>
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
                                <a href="#" class="text-primary me-2" wire:click.prevent="$emit('showExamModal', <?php echo e($dossier->id); ?>)">
                                    <i class="fas fa-graduation-cap fa-sm"></i>
                                </a>
                                <a href="#" class="text-info me-2">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <a href="#" class="text-secondary me-2">
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
    <?php echo $__env->make('livewire.modals.exam-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

</div>


<?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/dossier-list.blade.php ENDPATH**/ ?>