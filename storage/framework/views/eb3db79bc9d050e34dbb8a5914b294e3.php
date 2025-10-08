


<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('workers.title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <?php echo app('translator')->get('workers.breadcrumb'); ?>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('workers.list'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary"><?php echo app('translator')->get('workers.title'); ?></h4>
                </div>

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-4 align-items-center">
                            <!-- Botón Añadir Trabajador -->
                            <div class="col-12 col-md-auto">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('workers_create')): ?>
                                    <a href="<?php echo e(route('workers.create')); ?>">
                                        <button type="button" class="btn btn-primary w-100 w-md-auto">
                                            <i class="ri-add-line align-bottom me-1"></i> <?php echo app('translator')->get('workers.add_worker'); ?>
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Formulario de Filtros -->
                            <div class="col-12 col-md d-flex justify-content-end">
                                <form method="GET" action="<?php echo e(route('workers.index')); ?>" class="row g-2 align-items-center justify-content-end w-100">
                                    <!-- Selector de registros por página -->
                                    <div class="col-12 col-sm-auto">
                                        <select class="form-select bg-light border-primary" name="perPage" id="perPage">
                                            <option value="10" <?php echo e(request('perPage') == 10 ? 'selected' : ''); ?>>10 <?php echo app('translator')->get('workers.records_per_page'); ?></option>
                                            <option value="20" <?php echo e(request('perPage') == 20 ? 'selected' : ''); ?>>20 <?php echo app('translator')->get('workers.records_per_page'); ?></option>
                                            <option value="30" <?php echo e(request('perPage') == 30 ? 'selected' : ''); ?>>30 <?php echo app('translator')->get('workers.records_per_page'); ?></option>
                                            <option value="50" <?php echo e(request('perPage') == 50 ? 'selected' : ''); ?>>50 <?php echo app('translator')->get('workers.records_per_page'); ?></option>
                                        </select>
                                    </div>

                                    <!-- Campo de búsqueda -->
                                    <div class="col-12 col-sm" style="min-width: 200px; max-width: 350px;">
                                        <input 
                                            type="text" 
                                            id="search" 
                                            name="search" 
                                            class="form-control search bg-light border-primary" 
                                            placeholder="<?php echo app('translator')->get('workers.search_placeholder'); ?>" 
                                            value="<?php echo e(request('search')); ?>"
                                            style="font-size: 0.9rem;"
                                        >
                                    </div>

                                    <!-- Botón Buscar -->
                                    <div class="col-12 col-sm-auto">
                                        <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>

                                    <!-- Botón Limpiar -->
                                    <div class="col-12 col-sm-auto">
                                        <a href="<?php echo e(route('workers.index')); ?>" class="btn btn-secondary w-100 w-sm-auto">
                                            <i class="ri-delete-back-2-fill"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle table-borderless">
                                <thead class="table-primary">
                                    <tr>
                                        <th><?php echo app('translator')->get('workers.surname'); ?></th>
                                        <th><?php echo app('translator')->get('workers.name'); ?></th>
                                        <th><?php echo app('translator')->get('workers.dni'); ?></th>
                                        <th><?php echo app('translator')->get('workers.phone'); ?></th>
                                        <th><?php echo app('translator')->get('workers.email'); ?></th>
                                        <th class="text-end pe-3"><?php echo app('translator')->get('workers.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $trabajadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trabajador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($trabajador->surname); ?></td>
                                            <td><?php echo e($trabajador->name); ?></td>
                                            <td><?php echo e($trabajador->dni); ?></td>
                                            <td><?php echo e($trabajador->telefono ?? '—'); ?></td>
                                            <td><?php echo e($trabajador->email ?? '—'); ?></td>
                                            <td class="text-end pe-3">
                                                <div class="d-inline-flex gap-2 justify-content-end">
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('workers_edit')): ?>
                                                        <a href="<?php echo e(route('workers.edit', $trabajador->id)); ?>" class="btn btn-sm btn-success"><?php echo app('translator')->get('workers.edit'); ?></a>
                                                    <?php endif; ?>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('workers_destroy')): ?>
                                                        <form id="deleteForm<?php echo e($trabajador->id); ?>" action="<?php echo e(route('workers.destroy', $trabajador->id)); ?>" method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                        <button onclick="confirmDelete(<?php echo e($trabajador->id); ?>)" class="btn btn-sm btn-danger"><?php echo app('translator')->get('workers.delete'); ?></button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="noresult text-center py-4" style="display: none">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-3"><?php echo app('translator')->get('workers.no_results'); ?></h5>
                            <p class="text-muted"><?php echo app('translator')->get('workers.try_searching'); ?></p>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <nav aria-label="Pagination">
                                <?php echo e($trabajadores->appends(request()->query())->links('pagination::bootstrap-4')); ?>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchElement = document.getElementById('search');
            
            if (searchElement) {
                searchElement.addEventListener('input', function () {
                    var form = this.form;
                    clearTimeout(this.searchTimeout);
                    this.searchTimeout = setTimeout(function () {
                        form.submit();
                    }, 1000);
                });
            }

            var perPageElement = document.getElementById('perPage');
            if (perPageElement) {
                perPageElement.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });
    </script>

    <script>
        function confirmDelete(workerId) {
            Swal.fire({
                title: '<?php echo app('translator')->get('workers.confirm_delete_title'); ?>',
                text: '<?php echo app('translator')->get('workers.confirm_delete_text'); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<?php echo app('translator')->get('workers.confirm_delete_yes'); ?>',
                cancelButtonText: '<?php echo app('translator')->get('workers.confirm_delete_cancel'); ?>'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + workerId).submit();
                }
            });
        }
    </script>

    <script>
        <?php if(session('sweetalert')): ?>
            Swal.fire({
                title: "<?php echo e(session('sweetalert.title')); ?>",
                text: "<?php echo e(session('sweetalert.text')); ?>",
                icon: "<?php echo e(session('sweetalert.type')); ?>",
                confirmButtonText: '<?php echo app('translator')->get('workers.accept'); ?>',
            });
        <?php endif; ?>
    </script>

    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\daivatrans-software\resources\views/workers/index.blade.php ENDPATH**/ ?>