<?php if (isset($component)) { $__componentOriginala7e3e3ab156e6fa1f86927d4765c5327 = $component; } ?>
<?php $component = App\View\Components\Layouts\Base::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('layouts.base'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Layouts\Base::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <?php echo $__env->make('layouts.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    
    <?php echo $__env->make('layouts.sidenav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <main class="content">
        
        <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <div class="py-4">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('comptabilite')->html();
} elseif ($_instance->childHasBeenRendered('D40mWqH')) {
    $componentId = $_instance->getRenderedChildComponentId('D40mWqH');
    $componentTag = $_instance->getRenderedChildComponentTagName('D40mWqH');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('D40mWqH');
} else {
    $response = \Livewire\Livewire::mount('comptabilite');
    $html = $response->html();
    $_instance->logRenderedChild('D40mWqH', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>

        
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </main>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala7e3e3ab156e6fa1f86927d4765c5327)): ?>
<?php $component = $__componentOriginala7e3e3ab156e6fa1f86927d4765c5327; ?>
<?php unset($__componentOriginala7e3e3ab156e6fa1f86927d4765c5327); ?>
<?php endif; ?> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/pages/comptabilite.blade.php ENDPATH**/ ?>