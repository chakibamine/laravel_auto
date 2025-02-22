<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div class="d-block mb-4 mb-md-0">
            <h2 class="h4">Comptabilité - <?php echo e($this->currentMonthName); ?></h2>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            
            <div class="d-flex gap-2">
                
                <button class="btn btn-sm btn-primary" wire:click="openMonthlyReport">
                    <i class="fas fa-print me-2"></i> Imprimer Bilan
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-shape-success rounded me-4 m-4">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small text-gray-400 mb-0">Total Entrées</div>
                            <div class="fs-5 fw-extrabold text-nowrap"><?php echo e(number_format($this->totalEntrees, 2, '.', ',')); ?> DH</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-shape-danger rounded me-4 m-4">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small text-gray-400 mb-0">Total Sorties</div>
                            <div class="fs-5 fw-extrabold text-nowrap"><?php echo e(number_format($this->totalSorties, 2, '.', ',')); ?> DH</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-shape-tertiary rounded me-4 m-4">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="small text-gray-400 mb-0">Balance</div>
                            <div class="fs-5 fw-extrabold text-nowrap"><?php echo e(number_format($this->balance, 2, '.', ',')); ?> DH</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text border-0">
                            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        <input wire:model.debounce.300ms="searchTerm" class="form-control border-0" type="text" placeholder="Rechercher...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="month" class="form-control" 
                            wire:model="selectedMonth" 
                            value="<?php echo e($currentYear); ?>-<?php echo e(str_pad($currentMonth, 2, '0', STR_PAD_LEFT)); ?>">
                        <button class="btn btn-outline-primary" wire:click="resetToCurrentMonth">
                            <i class="fas fa-calendar-day"></i> Mois Actuel
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <input wire:model="dateFilter" type="date" class="form-control" placeholder="Filtrer par date">
                </div>
                <div class="col-md-2 text-md-end">
                    <?php if($selectedType === 'entrees'): ?>
                        <button class="btn btn-primary" wire:click="showEntrerForm">
                            <i class="fas fa-plus"></i> Nouvelle Entrée
                        </button>
                    <?php else: ?>
                        <button class="btn btn-primary" wire:click="showSortieForm">
                            <i class="fas fa-plus"></i> Nouvelle Sortie
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="card border-0 shadow">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link <?php echo e($selectedType === 'entrees' ? 'active' : ''); ?>" 
                        wire:click="toggleType('entrees')" 
                        href="#">Entrées</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e($selectedType === 'sorties' ? 'active' : ''); ?>" 
                        wire:click="toggleType('sorties')" 
                        href="#">Sorties</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <?php if($selectedType === 'entrees'): ?>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">Motif</th>
                                        <th class="border-0">Montant</th>
                                        <th class="border-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $entrees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entree): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(\Carbon\Carbon::parse($entree->date_entrer)->format('d/m/Y')); ?></td>
                                            <td><?php echo e($entree->motif); ?></td>
                                            <td><?php echo e(number_format($entree->montant, 2)); ?> DH</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" wire:click="confirmDelete(<?php echo e($entree->id); ?>, 'entree')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Aucune entrée trouvée</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0 rounded">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">Motif</th>
                                        <th class="border-0">Montant</th>
                                        <th class="border-0">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $sorties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sortie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e(\Carbon\Carbon::parse($sortie->date_sortie)->format('d/m/Y')); ?></td>
                                            <td><?php echo e($sortie->motif); ?></td>
                                            <td><?php echo e(number_format($sortie->montant, 2)); ?> DH</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" wire:click="confirmDelete(<?php echo e($sortie->id); ?>, 'sortie')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">Aucune sortie trouvée</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Entrer Modal -->
    <div class="modal fade <?php if($showEntrerModal): ?> show <?php endif; ?>" 
        style="display: <?php if($showEntrerModal): ?> block <?php else: ?> none <?php endif; ?>;" 
        tabindex="-1" 
        role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle Entrée</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveEntrer">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['entrer.date_entrer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="entrer.date_entrer">
                            <?php $__errorArgs = ['entrer.date_entrer'];
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
                        <div class="mb-3">
                            <label class="form-label">Motif</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['entrer.motif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="entrer.motif">
                            <?php $__errorArgs = ['entrer.motif'];
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
                        <div class="mb-3">
                            <label class="form-label">Montant</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['entrer.montant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    wire:model.defer="entrer.montant">
                                <span class="input-group-text">DH</span>
                                <?php $__errorArgs = ['entrer.montant'];
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sortie Modal -->
    <div class="modal fade <?php if($showSortieModal): ?> show <?php endif; ?>" 
        style="display: <?php if($showSortieModal): ?> block <?php else: ?> none <?php endif; ?>;" 
        tabindex="-1" 
        role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle Sortie</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveSortie">
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control <?php $__errorArgs = ['sortie.date_sortie'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="sortie.date_sortie">
                            <?php $__errorArgs = ['sortie.date_sortie'];
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
                        <div class="mb-3">
                            <label class="form-label">Motif</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['sortie.motif'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="sortie.motif">
                            <?php $__errorArgs = ['sortie.motif'];
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
                        <div class="mb-3">
                            <label class="form-label">Montant</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['sortie.montant'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    wire:model.defer="sortie.montant">
                                <span class="input-group-text">DH</span>
                                <?php $__errorArgs = ['sortie.montant'];
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Backdrop -->
    <?php if($showEntrerModal || $showSortieModal): ?>
        <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <!-- Confirmation Modal -->
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('confirm-modal', [
        'title' => 'Confirmation de suppression',
        'message' => 'Êtes-vous sûr de vouloir supprimer cet élément ?',
        'confirmButtonText' => 'Supprimer',
        'cancelButtonText' => 'Annuler',
        'confirmButtonClass' => 'btn-danger'
    ])->html();
} elseif ($_instance->childHasBeenRendered('l1918679098-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l1918679098-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l1918679098-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l1918679098-0');
} else {
    $response = \Livewire\Livewire::mount('confirm-modal', [
        'title' => 'Confirmation de suppression',
        'message' => 'Êtes-vous sûr de vouloir supprimer cet élément ?',
        'confirmButtonText' => 'Supprimer',
        'cancelButtonText' => 'Annuler',
        'confirmButtonClass' => 'btn-danger'
    ]);
    $html = $response->html();
    $_instance->logRenderedChild('l1918679098-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

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

    <style>
        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-shape-success {
            background: #31A24C;
            color: white;
        }
        .icon-shape-danger {
            background: #E11D48;
            color: white;
        }
        .icon-shape-tertiary {
            background: #2361CE;
            color: white;
        }
        .nav-tabs .nav-link {
            cursor: pointer;
        }
        .table td {
            vertical-align: middle;
        }
        .text-nowrap {
            white-space: nowrap !important;
        }
        .small {
            font-size: 0.875rem;
        }
    </style>

    <script>
        window.addEventListener('open-report', event => {
            window.open(event.detail.url, '_blank');
        });
    </script>
</div> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/comptabilite.blade.php ENDPATH**/ ?>