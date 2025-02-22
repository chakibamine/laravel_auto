<?php $__env->startSection('title', 'Gestion des Utilisateurs'); ?>

<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Gestion des Utilisateurs</h2>
            <p class="mb-0">Gérez les utilisateurs et leurs rôles.</p>
        </div>
        <div>
            <button wire:click="create" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-2"></i> Nouvel Utilisateur
            </button>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div class="input-group w-50">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input wire:model.debounce.300ms="searchTerm" type="text" class="form-control" placeholder="Rechercher un utilisateur">
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card border-0 shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>NOM</th>
                            <th>EMAIL</th>
                            <th>RÔLE</th>
                            <th>DATE DE CRÉATION</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td>
                                <?php if($user->role === 'admin'): ?>
                                    <span class="badge bg-dark">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">Utilisateur</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->created_at->format('d/m/Y')); ?></td>
                            <td>
                                <button wire:click="edit(<?php echo e($user->id); ?>)" class="btn btn-sm btn-dark">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <?php if(auth()->id() !== $user->id): ?>
                                <button wire:click="confirmDelete(<?php echo e($user->id); ?>)" class="btn btn-sm btn-danger ms-2">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center">Aucun utilisateur trouvé</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <?php echo e($users->links()); ?>

            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <?php if($showModal): ?>
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="createEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createEditModalLabel">
                        <?php echo e($editMode ? 'Modifier l\'utilisateur' : 'Nouvel utilisateur'); ?>

                    </h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <form wire:submit.prevent="save">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['user.name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="user.name">
                            <?php $__errorArgs = ['user.name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['user.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="user.email">
                            <?php $__errorArgs = ['user.email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-select <?php $__errorArgs = ['user.role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="user.role">
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin">Admin</option>
                                <option value="user">Utilisateur</option>
                            </select>
                            <?php $__errorArgs = ['user.role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                Mot de passe <?php echo e($editMode ? '(laisser vide pour ne pas modifier)' : ''); ?>

                            </label>
                            <input type="password" class="form-control <?php $__errorArgs = ['user.password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model.defer="user.password">
                            <?php $__errorArgs = ['user.password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" 
                                wire:model.defer="user.password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                        <button type="submit" class="btn btn-primary">
                            <?php echo e($editMode ? 'Mettre à jour' : 'Créer'); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <!-- Delete Confirmation Modal -->
    <?php if($showDeleteModal): ?>
    <div class="modal fade show d-block" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                    <button type="button" class="btn btn-danger" wire:click="deleteUser">Supprimer</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    <?php endif; ?>

    <!-- Flash Messages -->
    <?php if(session()->has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" wire:click="$set('showSuccessAlert', false)"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" wire:click="$set('showErrorAlert', false)"></button>
        </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    window.addEventListener('closeModal', event => {
        document.body.classList.remove('modal-open');
    });

    window.addEventListener('showModal', event => {
        document.body.classList.add('modal-open');
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/livewire/users.blade.php ENDPATH**/ ?>