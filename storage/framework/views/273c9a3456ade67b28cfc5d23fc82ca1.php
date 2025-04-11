<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Auto Ecole')); ?></title>

    <!-- Favicon -->
    <link rel="icon" href="<?php echo e(asset('logo/car.png')); ?>" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/volt.css')); ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <?php echo \Livewire\Livewire::styles(); ?>


    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
</head>

<body>
    <?php echo e($slot); ?>


    <?php echo \Livewire\Livewire::scripts(); ?>

    <script src="<?php echo e(asset('vendor/livewire/livewire.js')); ?>"></script>
    <script src="<?php echo e(asset('js/volt.js')); ?>"></script>

    <script>
        // Close any open alerts after 3 seconds
        window.addEventListener('load', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.display = 'none';
                });
            }, 3000);
        });
    </script>
</body>

</html> <?php /**PATH D:\laravel\volt-laravel-dashboard\resources\views/layouts/auth.blade.php ENDPATH**/ ?>