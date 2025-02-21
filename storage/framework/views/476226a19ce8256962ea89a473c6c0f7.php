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
        
        
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('cour-list', [])->html();
} elseif ($_instance->childHasBeenRendered('nhJSyPs')) {
    $componentId = $_instance->getRenderedChildComponentId('nhJSyPs');
    $componentTag = $_instance->getRenderedChildComponentTagName('nhJSyPs');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('nhJSyPs');
} else {
    $response = \Livewire\Livewire::mount('cour-list', []);
    $html = $response->html();
    $_instance->logRenderedChild('nhJSyPs', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

        
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </main>

    
    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('components.add-cour-modal', [])->html();
} elseif ($_instance->childHasBeenRendered('henA0DH')) {
    $componentId = $_instance->getRenderedChildComponentId('henA0DH');
    $componentTag = $_instance->getRenderedChildComponentTagName('henA0DH');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('henA0DH');
} else {
    $response = \Livewire\Livewire::mount('components.add-cour-modal', []);
    $html = $response->html();
    $_instance->logRenderedChild('henA0DH', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala7e3e3ab156e6fa1f86927d4765c5327)): ?>
<?php $component = $__componentOriginala7e3e3ab156e6fa1f86927d4765c5327; ?>
<?php unset($__componentOriginala7e3e3ab156e6fa1f86927d4765c5327); ?>
<?php endif; ?>

<?php $__env->startPush('scripts'); ?>
<script>
    window.addEventListener('closeModal', event => {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
    });
</script>
<?php $__env->stopPush(); ?> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/pages/courses.blade.php ENDPATH**/ ?>