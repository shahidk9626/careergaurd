<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('assets/img/apple-icon.png')); ?>" />
  <link rel="icon" type="image/png" href="<?php echo e(asset('assets/img/favicon.png')); ?>" />
  <title><?php echo e(config('app.name', 'Soft UI Dashboard Tailwind')); ?></title>
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Nucleo Icons -->
  <link href="<?php echo e(asset('assets/css/nucleo-icons.css')); ?>" rel="stylesheet" />
  <link href="<?php echo e(asset('assets/css/nucleo-svg.css')); ?>" rel="stylesheet" />
  <!-- Main Styling -->
  <link href="<?php echo e(asset('assets/css/soft-ui-dashboard-tailwind.css?v=1.0.5')); ?>" rel="stylesheet" />
</head>

<body class="m-0 font-sans antialiased font-normal bg-white text-start text-base leading-default text-slate-500">

  <?php echo $__env->yieldContent('content'); ?>

  <!-- plugin for scrollbar  -->
  <script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>" async></script>
  <!-- main script file  -->
  <script src="<?php echo e(asset('assets/js/soft-ui-dashboard-tailwind.js?v=1.0.5')); ?>" async></script>
</body>

</html><?php /**PATH /Users/Raif/Documents/GitHub/careergaurd/resources/views/layouts/auth.blade.php ENDPATH**/ ?>