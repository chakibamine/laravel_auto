<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Liste des Cours</h2>
        </div>
    </div>

    <!-- Search -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between gap-3">
                        <div class="input-group input-group-merge search-bar">
                            <span class="input-group-text border-0 ps-3 bg-white">
                                <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <input wire:model.debounce.300ms="searchTerm" 
                                class="form-control border-0 ps-1" 
                                type="text" 
                                placeholder="Rechercher un dossier..."
                                style="border-radius: 0 20px 20px 0;">
                        </div>
                        <button class="btn btn-primary d-inline-flex align-items-center rounded-pill px-4 py-2" 
                            wire:click="$emitTo('components.add-cour-modal', 'showAddCourModal')">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Ajouter des Cours
                        </button>
                        <a href="<?php echo e(route('fiche.conduit')); ?>" target="_blank" class="btn btn-secondary d-inline-flex align-items-center rounded-pill px-4 py-2">
                            <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Fiche Conduit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .search-bar {
            box-shadow: 0 2px 4px rgba(0,0,0,.04);
            border-radius: 20px;
            background: white;
            transition: all 0.3s ease;
        }
        .search-bar:focus-within {
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
        }
        .search-bar input:focus {
            box-shadow: none;
        }
        .btn-primary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,.1);
        }
    </style>

    <!-- Dossiers Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th>Photo</th>
                            <th>N'web</th>
                            <th>CIN</th>
                            <th>Nom et prénom</th>
                            <th>Permis</th>
                            <th>Date d'inscription</th>
                            <th>Théorique</th>
                            <th>Pratique</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dossiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dossier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php if($dossier->student->image_url): ?>
                                        <img style="width:70px;" src="<?php echo e(Storage::url($dossier->student->image_url)); ?>" alt="Student photo">
                                    <?php else: ?>
                                        <img style="width:70px;" src="<?php echo e(asset('images/default-avatar.png')); ?>" alt="Default photo">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($dossier->ref); ?></td>
                                <td><?php echo e($dossier->student->cin); ?></td>
                                <td><?php echo e(strtoupper($dossier->student->lastname)); ?> <?php echo e(ucfirst($dossier->student->firstname)); ?></td>
                                <td><?php echo e($dossier->category); ?></td>
                                <td><?php echo e($dossier->date_inscription ? $dossier->date_inscription->format('d/m/Y H:i:s') : '-'); ?></td>
                                <td <?php if($dossier->courses->where('type_cours', 'Theorique')->count() >= 20): ?> class="text-danger fw-bold" <?php endif; ?>>
                                    <?php echo e($dossier->courses->where('type_cours', 'Theorique')->count()); ?>/20
                                </td>
                                <td <?php if($dossier->courses->where('type_cours', 'Pratique')->count() >= 20): ?> class="text-danger fw-bold" <?php endif; ?>>
                                    <?php echo e($dossier->courses->where('type_cours', 'Pratique')->count()); ?>/20
                                </td>
                                <td>
                                    <a href="<?php echo e(route('dossier.courses.print', ['id' => $dossier->id])); ?>" class="btn btn-outline-primary btn-sm">
                                        Imprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center">Aucun dossier trouvé.</td>
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

    <!-- Course Modal -->
    <?php if($showModal && $selectedDossier): ?>
    <div class="modal fade show" style="display: block;" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Cours</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form wire:submit.prevent="saveCour">
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
                                        <label class="col-form-label">Cours pour :</label>
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

                            <!-- Course Form -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label class="col-form-label">Date du cours :</label>
                                        <input type="date" class="form-control <?php $__errorArgs = ['cour.date_cours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            wire:model.defer="cour.date_cours" required>
                                        <?php $__errorArgs = ['cour.date_cours'];
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
                                        <select class="form-select <?php $__errorArgs = ['cour.type_cours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            wire:model.defer="cour.type_cours" required>
                                            <option value="">Sélectionner un type</option>
                                            <option value="Theorique">Théorique</option>
                                            <option value="Pratique">Pratique</option>
                                        </select>
                                        <?php $__errorArgs = ['cour.type_cours'];
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
                                <button type="submit" class="btn btn-outline-primary">Ajouter</button>
                                <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>
</div> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/cour-list.blade.php ENDPATH**/ ?>