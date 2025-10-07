
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('users.title'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            <?php echo app('translator')->get('users.breadcrumb'); ?>
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            <?php echo app('translator')->get('users.title'); ?>
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary"><?php echo app('translator')->get('users.title'); ?></h4>
                </div>

                <div class="card-body">
                    <div class="listjs-table" id="customerList">
                        <div class="row g-3 mb-4 align-items-center">
                            <!-- Botón Añadir Usuario -->
                            <div class="col-12 col-md-auto">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_create')): ?>
                                    <a href="<?php echo e(route('users.create')); ?>">
                                        <button type="button" class="btn btn-primary w-100 w-md-auto">
                                            <i class="ri-add-line align-bottom me-1"></i> <?php echo app('translator')->get('users.add_user'); ?>
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Formulario de Filtros -->
                            <div class="col-12 col-md d-flex justify-content-end">
                                <form method="GET" action="<?php echo e(route('users.index')); ?>" class="row g-2 align-items-center justify-content-end w-100">
                                    <!-- Selector de registros por página -->
                                    <div class="col-12 col-sm-auto">
                                        <select class="form-select bg-light border-primary" name="perPage" id="perPage">
                                            <option value="10" <?php echo e(request('perPage') == 10 ? 'selected' : ''); ?>>10 <?php echo app('translator')->get('users.records_per_page'); ?></option>
                                            <option value="20" <?php echo e(request('perPage') == 20 ? 'selected' : ''); ?>>20 <?php echo app('translator')->get('users.records_per_page'); ?></option>
                                            <option value="30" <?php echo e(request('perPage') == 30 ? 'selected' : ''); ?>>30 <?php echo app('translator')->get('users.records_per_page'); ?></option>
                                            <option value="50" <?php echo e(request('perPage') == 50 ? 'selected' : ''); ?>>50 <?php echo app('translator')->get('users.records_per_page'); ?></option>
                                        </select>
                                    </div>

                                    <!-- Campo de búsqueda -->
                                    <div class="col-12 col-sm" style="min-width: 200px; max-width: 350px;">
                                        <input 
                                            type="text" 
                                            id="search" 
                                            name="search" 
                                            class="form-control search bg-light border-primary" 
                                            placeholder="<?php echo app('translator')->get('users.search_placeholder'); ?>" 
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
                                        <a href="<?php echo e(route('users.index')); ?>" class="btn btn-secondary w-100 w-sm-auto">
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
                                        <th><?php echo app('translator')->get('users.id'); ?></th>
                                        <th><?php echo app('translator')->get('users.name'); ?></th>
                                        <th><?php echo app('translator')->get('users.email'); ?></th>
                                        <th><?php echo app('translator')->get('users.role'); ?></th>
                                        <th class="text-end pe-3"><?php echo app('translator')->get('users.actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="text-muted"><?php echo e($user->id); ?></td>
                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->email); ?></td>
                                            <td>
                                                <?php $__currentLoopData = $user->getRoleNames(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge bg-secondary"><?php echo e($role); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="d-inline-flex gap-2 justify-content-end">
                                                    <?php if(Auth::id() == $user->id && Auth::user()->can('users_edit_own')): ?>
                                                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm btn-warning"><?php echo app('translator')->get('users.edit_own_profile'); ?></a>
                                                    <?php elseif(Auth::user()->can('users_edit_all')): ?>
                                                        <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-sm btn-success"><?php echo app('translator')->get('users.edit'); ?></a>
                                                    <?php endif; ?>

                                                    <?php if(Auth::user()->can('users_delete') && Auth::id() !== $user->id): ?>
                                                        <form id="deleteForm<?php echo e($user->id); ?>" action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                        <button onclick="confirmDelete(<?php echo e($user->id); ?>)" class="btn btn-sm btn-danger"><?php echo app('translator')->get('users.delete'); ?></button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="noresult text-center py-4" style="display: none">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                            <h5 class="mt-3"><?php echo app('translator')->get('users.no_results'); ?></h5>
                            <p class="text-muted"><?php echo app('translator')->get('users.try_searching'); ?></p>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <nav aria-label="Pagination">
                                <?php echo e($users->appends(request()->query())->links()); ?>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Manejar el cambio en el selector de registros por página
            var perPageElement = document.getElementById('perPage');
            if (perPageElement) {
                perPageElement.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });

        function confirmDelete(activeId) {
            Swal.fire({
                title: '<?php echo app('translator')->get('users.confirm_delete_title'); ?>',
                text: '<?php echo app('translator')->get('users.confirm_delete_text'); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '<?php echo app('translator')->get('users.confirm_delete_yes'); ?>',
                cancelButtonText: '<?php echo app('translator')->get('users.confirm_delete_cancel'); ?>'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + activeId).submit();
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
                confirmButtonText: '<?php echo app('translator')->get('users.accept'); ?>',
            });
        <?php endif; ?>
    </script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PlantillaVelozon\resources\views/users/index.blade.php ENDPATH**/ ?>