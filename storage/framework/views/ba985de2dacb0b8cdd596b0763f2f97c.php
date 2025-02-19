<div class="modal <?php if($showModal): ?> show <?php endif; ?>" tabindex="-1" role="dialog" style="display: <?php if($showModal): ?> block <?php else: ?> none <?php endif; ?>;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau Paiement</h5>
                <button type="button" class="btn-close" wire:click="closeModal"></button>
            </div>
            <div class="modal-body">
                <?php if($dossier && $student): ?>
                <form wire:submit.prevent="saveReg">
                    <!-- First Row -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">C.I.N</label>
                            <input type="text" class="form-control" value="<?php echo e($student->cin); ?>" disabled>
                        </div>
                        <div class="col">
                            <label class="form-label">Reglement pour</label>
                            <input type="text" class="form-control" value="<?php echo e($student->lastname); ?> <?php echo e($student->firstname); ?>" disabled>
                        </div>
                        <div class="col">
                            <label class="form-label">Dossier</label>
                            <input type="text" class="form-control" value="<?php echo e($dossier->ref); ?>" disabled>
                        </div>
                    </div>

                    <!-- Second Row -->
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label">Prix</label>
                            <input type="text" class="form-control" value="<?php echo e($dossier->price); ?>" disabled>
                        </div>
                        <div class="col">
                            <label class="form-label">Avances</label>
                            <input type="text" class="form-control" value="<?php echo e($totalPaid); ?>" disabled>
                        </div>
                        <div class="col">
                            <label class="form-label">Reste</label>
                            <input type="text" class="form-control" value="<?php echo e($remaining); ?>" disabled>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="modal-footer">
                        <?php if($remaining > 0): ?>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        <?php endif; ?>
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Annuler</button>
                    </div>
                </form>
                <?php else: ?>
                <div class="text-center">
                    <p>Chargement...</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\laravel\volt-laravel-dashboard - Copy - Copy\resources\views/livewire/reg-controller.blade.php ENDPATH**/ ?>