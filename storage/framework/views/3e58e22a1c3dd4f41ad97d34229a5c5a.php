

<?php $__env->startSection('title', 'Métodos de Contacto'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4 mb-4">
    <div class="flex-grow-1">
        <a href="<?php echo e(route('contact-methods.create')); ?>" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i> Crear Método de Contacto</a>        
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Métodos de Contacto</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('contact-methods.index')); ?>">
                    <div class="row g-3">
                        <!-- <div class="col-xxl-12 col-sm-12">
                            <div class="search-box">
                                <input type="text" name="search" class="form-control search bg-light border-light" placeholder="Buscar por nombre" value="<?php echo e(request('search')); ?>">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div> -->
                        <div class="col-xxl-2 col-sm-4">
                            <div class="input-light">

                                <select class="form-control" data-choices data-choices-search-false name="perPage" id="perPage" onchange="this.form.submit()">
                                    <option value="10" <?php echo e(request('perPage') == 10 ? 'selected' : ''); ?>>10 registros</option>
                                    <option value="20" <?php echo e(request('perPage') == 20 ? 'selected' : ''); ?>>20 registros</option>
                                    <option value="30" <?php echo e(request('perPage') == 30 ? 'selected' : ''); ?>>30 registros</option>
                                    <option value="50" <?php echo e(request('perPage') == 50 ? 'selected' : ''); ?>>50 registros</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                
                <div class="table-responsive mt-4">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Nombre</th>
                                <th>Fecha de Creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $contactMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contactMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td  class="text-nowrap">
                                        <a href="<?php echo e(route('contact-methods.edit', $contactMethod->id)); ?>" class="btn btn-primary btn-sm">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="<?php echo e(route('contact-methods.destroy', $contactMethod->id)); ?>" method="POST" style="display:inline-block;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td><?php echo e($contactMethod->name); ?></td>
                                    <td><?php echo e($contactMethod->created_at->format('d/m/Y')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <?php echo $contactMethods->links('vendor.pagination.bootstrap-4'); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PlantillaVelozon\resources\views/contact_methods/index.blade.php ENDPATH**/ ?>