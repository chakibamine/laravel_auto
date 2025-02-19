<div>
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
        <div>
            <h2 class="h4">Student Management</h2>
        </div>
        <div>
            <button wire:click="create" class="btn btn-sm btn-gray-800 d-inline-flex align-items-center">
                <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Student
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
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
                        <input wire:model.debounce.300ms="searchTerm" class="form-control" type="text" placeholder="Search students...">
                            </div>
                        </div>
                <div class="col-md-3 mb-3">
                    <select wire:model="filters.gender" class="form-select">
                        <option value="">All Genders</option>
                        <option value="Masculin">Masculin</option>
                        <option value="Féminin">Féminin</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select wire:model="filters.city" class="form-select">
                        <option value="">All Cities</option>
                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($city); ?>"><?php echo e($city); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <button wire:click="resetFilters" class="btn btn-sm btn-secondary d-inline-flex align-items-center">
                        <svg class="icon icon-xs me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </button>
                </div>
                            </div>
                        </div>
                    </div>

    <!-- Students Table -->
    <div class="card border-0 shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-centered table-nowrap mb-0 rounded">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0 rounded-start">
                                <a wire:click="sortBy('id')" role="button" class="text-decoration-none">
                                    #
                                    <?php if($sortField === 'id'): ?>
                                        <i class="fas fa-sort-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="border-0">
                                <a wire:click="sortBy('firstname')" role="button" class="text-decoration-none">
                                    Name
                                    <?php if($sortField === 'firstname'): ?>
                                        <i class="fas fa-sort-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="border-0">CIN</th>
                            <th class="border-0">
                                <a wire:click="sortBy('gender')" role="button" class="text-decoration-none">
                                    Gender
                                    <?php if($sortField === 'gender'): ?>
                                        <i class="fas fa-sort-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="border-0">Phone</th>
                            <th class="border-0">
                                <a wire:click="sortBy('city')" role="button" class="text-decoration-none">
                                    City
                                    <?php if($sortField === 'city'): ?>
                                        <i class="fas fa-sort-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="border-0">
                                <a wire:click="sortBy('date_birth')" role="button" class="text-decoration-none">
                                    Date de naissance
                                    <?php if($sortField === 'date_birth'): ?>
                                        <i class="fas fa-sort-<?php echo e($sortDirection === 'asc' ? 'up' : 'down'); ?>"></i>
                                    <?php endif; ?>
                                </a>
                            </th>
                            <th class="border-0 rounded-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($student->id); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if($student->image_url && Storage::disk('public')->exists($student->image_url)): ?>
                                        <img src="<?php echo e(Storage::url($student->image_url)); ?>" class="rounded-circle me-3" width="32" height="32" alt="<?php echo e($student->firstname); ?>">
                                    <?php else: ?>
                                        <div class="avatar rounded-circle me-3 bg-gray-600">
                                            <span class="text-white"><?php echo e(substr($student->firstname, 0, 1)); ?></span>
                            </div>
                                    <?php endif; ?>
                                    <?php echo e($student->firstname); ?> <?php echo e($student->lastname); ?>

                        </div>
                            </td>
                            <td><?php echo e($student->cin); ?></td>
                            <td><?php echo e($student->gender); ?></td>
                            <td><?php echo e($student->phone); ?></td>
                            <td><?php echo e($student->city); ?></td>
                            <td><?php echo e($student->date_birth ? $student->date_birth->format('d/m/Y') : '-'); ?></td>
                            <td>
                                <div class="btn-group">
                                    <button wire:click="edit(<?php echo e($student->id); ?>)" class="btn btn-link text-dark p-0 mx-2">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete(<?php echo e($student->id); ?>)" class="btn btn-link text-danger p-0 mx-2">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <?php if(!$student->dossiers()->where('status', 0)->exists()): ?>
                                    <button wire:click="addDossier(<?php echo e($student->id); ?>)" class="btn btn-link text-primary p-0 mx-2" title="Add Dossier">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center">No students found.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                    </div>
            <div class="mt-3">
                <?php echo e($students->links()); ?>

                            </div>
                        </div>
                    </div>

    <!-- Create/Edit Modal -->
    <?php if($showModal): ?>
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e($editMode ? 'Edit Student' : 'Add New Student'); ?></h5>
                    <button wire:click="closeModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="save">
                        <div class="container">
                            <!-- Gender Selection -->
                    <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="form-label mb-3">Gender:</label>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check me-4">
                                                <input class="form-check-input" type="radio" wire:model="student.gender" value="Masculin" id="gender-male">
                                                <label class="form-check-label" for="gender-male">
                                                    <i class="fas fa-male me-1"></i> Masculin
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" wire:model="student.gender" value="Féminin" id="gender-female">
                                                <label class="form-check-label" for="gender-female">
                                                    <i class="fas fa-female me-1"></i> Féminin
                                                </label>
                            </div>
                        </div>
                                        <?php $__errorArgs = ['student.gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                            <div class="text-danger mt-2 small">
                                                <i class="fas fa-exclamation-circle me-1"></i>
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label">C.I.N :</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.cin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.cin">
                                    <?php $__errorArgs = ['student.cin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                                <div class="col"></div>
                                <div class="col"></div>
                            </div>

                            <!-- Name Fields -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Prenom :</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.firstname">
                                    <?php $__errorArgs = ['student.firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label float-end">: الإسم الشخصي</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.a_firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.a_firstname">
                                    <?php $__errorArgs = ['student.a_firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Nom :</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.lastname">
                                    <?php $__errorArgs = ['student.lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label float-end">: الإسم العائلي</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.a_lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.a_lastname">
                                <?php $__errorArgs = ['student.a_lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Birth Information -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Date de naissance :</label>
                                    <input type="date" 
                                        class="form-control h-50 <?php $__errorArgs = ['student.date_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        wire:model="date_birth">
                                    <?php $__errorArgs = ['student.date_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col"></div>
                                <div class="col">
                                    <label class="form-label">Lieu de naissance :</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.place_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.place_birth">
                                    <?php $__errorArgs = ['student.place_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col">
                                    <label class="form-label float-end">: مكان الإزدياد</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.a_place_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.a_place_birth">
                                    <?php $__errorArgs = ['student.a_place_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                            <!-- Address -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Adresse :</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.address">
                                    <?php $__errorArgs = ['student.address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col">
                                    <label class="form-label float-end">: العنوان</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.a_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.a_address">
                                    <?php $__errorArgs = ['student.a_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- City, Phone and Photo -->
                            <div class="row mt-3">
                                <div class="col">
                                    <label class="form-label">Ville :</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.city">
                                    <?php $__errorArgs = ['student.city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col">
                                    <label class="form-label">Telephone GSM :</label>
                                    <input type="text" class="form-control h-50 <?php $__errorArgs = ['student.phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model="student.phone">
                                    <?php $__errorArgs = ['student.phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col">
                                    <label class="form-label">Photo :</label>
                                    <input type="file" 
                                        class="form-control <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        wire:model="photo" 
                                        accept="image/*">
                                    <?php $__errorArgs = ['photo'];
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
                    </form>
                    </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-outline-primary">Cancel</button>
                    <button wire:click="save" type="button" class="btn btn-primary"><?php echo e($editMode ? 'Update' : 'Inserer'); ?></button>
                </div>
            </div>
        </div>
    </div>
                            <?php endif; ?>

    <!-- Delete Confirmation Modal -->
    <?php if($showDeleteModal): ?>
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student</h5>
                    <button wire:click="$set('showDeleteModal', false)" type="button" class="btn-close" aria-label="Close"></button>
                        </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this student? This action cannot be undone.</p>
                    </div>
                <div class="modal-footer">
                    <button wire:click="$set('showDeleteModal', false)" type="button" class="btn btn-link text-gray ms-auto">Cancel</button>
                    <button wire:click="deleteStudent" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Dossier Creation Modal -->
    <?php if($showDossierModal): ?>
    <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Dossier</h5>
                    <button wire:click="closeDossierModal" type="button" class="btn-close" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveDossier">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select wire:model="dossier.category" class="form-select <?php $__errorArgs = ['dossier.category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <option value="">Select Category</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="EC">EC</option>
                            </select>
                            <?php $__errorArgs = ['dossier.category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Price</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['dossier.price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model="dossier.price">
                            <?php $__errorArgs = ['dossier.price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reference Number</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['dossier.ref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                wire:model="dossier.ref">
                            <?php $__errorArgs = ['dossier.ref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button wire:click="closeDossierModal" type="button" class="btn btn-link text-gray ms-auto">Cancel</button>
                    <button wire:click="saveDossier" type="button" class="btn btn-primary">Create Dossier</button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Notifications -->
    <?php if($showSavedAlert): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed bottom-0 end-0 mb-4 me-4" role="alert">
        <?php echo e($editMode ? 'Student updated successfully!' : 'Student created successfully!'); ?>

        <button wire:click="$set('showSavedAlert', false)" type="button" class="btn-close" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if($showDemoNotification): ?>
    <div class="alert alert-info alert-dismissible fade show position-fixed bottom-0 end-0 mb-4 me-4" role="alert">
        You cannot do that in the demo version.
        <button wire:click="$set('showDemoNotification', false)" type="button" class="btn-close" aria-label="Close"></button>
    </div>
    <?php endif; ?>
</div> <?php /**PATH D:\laravel\volt-laravel-dashboard - Copy - Copy\resources\views/livewire/student.blade.php ENDPATH**/ ?>