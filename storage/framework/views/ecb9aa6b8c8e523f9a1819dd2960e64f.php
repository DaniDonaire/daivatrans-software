
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('settings.title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <form action="<?php echo e(route('settings.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#textSettings" role="tab">
                                    <i class="fas fa-file-alt"></i>
                                    <?php echo app('translator')->get('settings.text_settings'); ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#fileSettings" role="tab">
                                    <i class="fas fa-image"></i>
                                    <?php echo app('translator')->get('settings.image_settings'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <!-- Pestaña: Configuraciones de Texto -->
                            <div class="tab-pane active" id="textSettings" role="tabpanel">
                                <div class="row g-3">
                                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($setting->type === 'text'): ?>
                                            <div class="col-lg-6">
                                                <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(ucfirst(str_replace('_', ' ', $key))); ?></label>
                                                <input type="text" 
                                                    id="<?php echo e($key); ?>" 
                                                    name="<?php echo e($key); ?>" 
                                                    class="form-control" 
                                                    value="<?php echo e(old($key, $setting->value)); ?>" 
                                                    placeholder="Introduce <?php echo e(str_replace('_', ' ', $key)); ?>">
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>

                            <!-- Pestaña: Configuraciones de Imágenes -->
                            <div class="tab-pane" id="fileSettings" role="tabpanel">
                                <div class="row g-4 justify-content-center">
                                    <?php $__currentLoopData = ['favicon', 'logo_rectangular', 'logo_square']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($settings[$key]) && $settings[$key]->type === 'file'): ?>
                                            <div class="col-xxl-3 col-lg-4 col-md-6">
                                                <div class="card text-center">
                                                    <div class="card-body d-flex flex-column align-items-center">
                                                        <div class="profile-user position-relative mb-4">
                                                            <!-- Imagen actual o por defecto -->
                                                            <img id="preview-<?php echo e($key); ?>" 
                                                                src="
                                                                <?php if($key === 'favicon' && empty($settings[$key]->value)): ?>
                                                                    <?php echo e(URL::asset('build/images/favicon.ico')); ?>

                                                                <?php elseif($key === 'logo_rectangular' && empty($settings[$key]->value)): ?>
                                                                    <?php echo e(URL::asset('build/images/WCD_White.png')); ?>

                                                                <?php elseif($key === 'logo_square' && empty($settings[$key]->value)): ?>
                                                                    <?php echo e(URL::asset('build/images/WCD_TG_White.png')); ?>

                                                                <?php else: ?>
                                                                    <?php echo e(URL::asset('storage/' . $settings[$key]->value)); ?>

                                                                <?php endif; ?>" 
                                                                class="rounded-circle avatar-xl img-thumbnail user-profile-image" 
                                                                alt="<?php echo e(ucfirst(str_replace('_', ' ', $key))); ?> no disponible" 
                                                                style="width: 150px; height: 150px; object-fit: cover;">
                                                            <!-- Input de archivo -->
                                                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                                                <input id="file-input-<?php echo e($key); ?>" 
                                                                    type="file" 
                                                                    name="<?php echo e($key); ?>" 
                                                                    class="profile-img-file-input" 
                                                                    accept="image/*"
                                                                    onchange="previewImage(this, 'preview-<?php echo e($key); ?>')">
                                                                <label for="file-input-<?php echo e($key); ?>" 
                                                                    class="profile-photo-edit avatar-xs">
                                                                    <span class="avatar-title rounded-circle bg-light text-body">
                                                                        <i class="ri-camera-fill"></i>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <h5 class="fs-17 mb-1"><?php echo e(ucfirst(str_replace('_', ' ', $key))); ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('settings.save_changes'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script>
        <?php if(session('success')): ?>
            Swal.fire({
                title: '<?php echo app('translator')->get('settings.success'); ?>',
                text: '<?php echo app('translator')->get('settings.success_message'); ?>',
                icon: 'success',
                confirmButtonText: '<?php echo app('translator')->get('settings.accept'); ?>',
            });
        <?php elseif(session('error')): ?>
            Swal.fire({
                title: '<?php echo app('translator')->get('settings.error'); ?>',
                text: '<?php echo app('translator')->get('settings.error_message'); ?>',
                icon: 'error',
                confirmButtonText: '<?php echo app('translator')->get('settings.accept'); ?>',
            });
        <?php endif; ?>
    </script>
    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    preview.src = e.target.result; // Actualiza la imagen con la nueva URL
                };
                reader.readAsDataURL(input.files[0]); // Lee el archivo como una URL de datos
            }
        }
    </script>    
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PlantillaVelozon\resources\views/settings/index.blade.php ENDPATH**/ ?>