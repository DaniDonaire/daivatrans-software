<?php
    // Obtener las preferencias del usuario autenticado
    $prefs = auth()->check() ? auth()->user()->preference : null;
    $darkMode = $prefs && $prefs->dark_mode ? 'dark' : 'light';
    $sidebarSize = $prefs && $prefs->sidebar_pinned ? 'sm-hover-active' : 'sm-hover';
?>
<!doctype html >
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" id="html-tag-master" data-sidebar-size="<?php echo e($sidebarSize); ?>" data-layout="vertical" data-topbar="light" data-sidebar="dark"  data-sidebar-image="none" data-preloader="disable" data-bs-theme="<?php echo e($darkMode); ?>">
 
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('settings.app_name') ?? 'Web Coding'); ?> - Software Premium Desarrollado por Webcoding</title>    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Software Premium Personalizado | Desarrollado por WebCoding" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <!-- <link rel="shortcut icon" href="<?php echo e(isset($settings['favicon']) && !empty($settings['favicon']->value) ? asset('storage/' . $settings['favicon']->value) : URL::asset('build/icons/favicon.ico')); ?>"> -->
    <link rel="shortcut icon" href="<?php echo e(config('settings.favicon') ? asset('storage/' . config('settings.favicon')) : asset('build/icons/favicon.ico')); ?>">

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS de Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- JS de Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <?php echo $__env->make('layouts.head-css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<?php $__env->startSection('body'); ?>
    <?php echo $__env->make('layouts.body', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->yieldSection(); ?>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php echo $__env->make('layouts.topbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php echo $__env->make('layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <?php echo $__env->make('layouts.customizer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- JAVASCRIPT -->
    <?php echo $__env->make('layouts.vendor-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\daivatrans-software\resources\views/layouts/master.blade.php ENDPATH**/ ?>