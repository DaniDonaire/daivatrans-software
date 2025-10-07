

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('auditoria.title'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <!-- Cargar Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Ajustar la apariencia del Select2 con icono */
        .select2-with-icon + .select2-container .select2-selection {
            background: url('https://cdn.jsdelivr.net/npm/remixicon@latest/icons/User/user-line.svg') no-repeat 10px center;
            background-size: 15px;
            padding-left: 35px !important;
            border: 1px solid #5EA3CB !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('auditoria.breadcrumb'); ?> <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo app('translator')->get('auditoria.audit_list'); ?> <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary"><?php echo app('translator')->get('auditoria.audit_list'); ?></h4>
                </div>

                <div class="card-body">
                    <div class="listjs-table" id="auditList">
                        <div class="row g-3 mb-4 align-items-center">
                            <!-- Formulario de Filtros -->
                            <div class="col-12 d-flex justify-content-end">
                                <form method="GET" action="<?php echo e(route('audit.index')); ?>" class="row g-2 align-items-center justify-content-end w-100">
                                    <!-- Selector de registros por página -->
                                    <div class="col-12 col-sm-auto">
                                        <select class="form-select bg-light border-primary" name="perPage" id="perPage">
                                            <option value="10" <?php echo e(request('perPage') == 10 ? 'selected' : ''); ?>>10 <?php echo app('translator')->get('auditoria.records_per_page'); ?></option>
                                            <option value="20" <?php echo e(request('perPage') == 20 ? 'selected' : ''); ?>>20 <?php echo app('translator')->get('auditoria.records_per_page'); ?></option>
                                            <option value="30" <?php echo e(request('perPage') == 30 ? 'selected' : ''); ?>>30 <?php echo app('translator')->get('auditoria.records_per_page'); ?></option>
                                            <option value="50" <?php echo e(request('perPage') == 50 ? 'selected' : ''); ?>>50 <?php echo app('translator')->get('auditoria.records_per_page'); ?></option>
                                        </select>
                                    </div>

                                    <!-- Filtro por Usuario (Select2 con Búsqueda) -->
                                    <div class="col-12 col-sm-auto">
                                        <select name="user" id="user" class="form-select border-primary select2">
                                            <option value="" disabled selected>Selecciona un usuario</option>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($user->id); ?>" <?php echo e(request('user') == $user->id ? 'selected' : ''); ?>>
                                                    <?php echo e($user->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <!-- Filtro por Acción -->
                                    <div class="col-12 col-sm-auto">
                                        <select name="action" id="action" class="form-select bg-light border-primary">
                                            <option value=""><?php echo app('translator')->get('auditoria.all'); ?></option>
                                            <option value="created" <?php echo e(request('action') == 'created' ? 'selected' : ''); ?>><?php echo app('translator')->get('auditoria.created'); ?></option>
                                            <option value="updated" <?php echo e(request('action') == 'updated' ? 'selected' : ''); ?>><?php echo app('translator')->get('auditoria.updated'); ?></option>
                                            <option value="deleted" <?php echo e(request('action') == 'deleted' ? 'selected' : ''); ?>><?php echo app('translator')->get('auditoria.deleted'); ?></option>
                                        </select>
                                    </div>

                                    <!-- Filtro por Fecha -->
                                    <div class="col-12 col-sm-auto">
                                        <input type="date" name="date" class="form-control bg-light border-primary" value="<?php echo e(request('date')); ?>">
                                    </div>

                                    <!-- Botón Buscar -->
                                    <div class="col-12 col-sm-auto">
                                        <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                                            <i class="ri-search-line"></i>
                                        </button>
                                    </div>

                                    <!-- Botón Limpiar -->
                                    <div class="col-12 col-sm-auto">
                                        <a href="<?php echo e(route('audit.index')); ?>" class="btn btn-secondary w-100 w-sm-auto">
                                            <i class="ri-delete-back-2-fill"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Auditorías -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle table-borderless">
                            <thead class="table-primary">
                                <tr>
                                    <th><?php echo app('translator')->get('auditoria.user'); ?></th>
                                    <th><?php echo app('translator')->get('auditoria.model'); ?></th>
                                    <th><?php echo app('translator')->get('auditoria.action'); ?></th>
                                    <th><?php echo app('translator')->get('auditoria.old_values'); ?></th>
                                    <th><?php echo app('translator')->get('auditoria.new_values'); ?></th>
                                    <th><?php echo app('translator')->get('auditoria.date'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $audits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(optional($audit->user)->name ?? 'Sistema'); ?></td>
                                        <td><?php echo e(class_basename($audit->auditable_type)); ?> #<?php echo e($audit->auditable_id); ?></td>
                                        <td><?php echo e(ucfirst($audit->event)); ?></td>
                                        <td><?php echo e(json_encode($audit->old_values)); ?></td>
                                        <td><?php echo e(json_encode($audit->new_values)); ?></td>
                                        <td><?php echo e($audit->created_at->format('d-m-Y H:i')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <!-- Cargar Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializar Select2 en Usuario
            $('#user').select2({
                placeholder: "Selecciona un usuario",
                allowClear: true,
                minimumResultsForSearch: 1,
                width: '100%',
                dropdownParent: $('#user').parent()
            });

            // Aplicar borde azul cuando Select2 está activo
            $('#user').on("select2:open", function () {
                $(".select2-selection").addClass("border-primary");
            }).on("select2:close", function () {
                $(".select2-selection").removeClass("border-primary");
            });
        });
    </script>

    <!-- Cargar SweetAlert -->
    <script src="<?php echo e(URL::asset('build/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Manejar mensajes de validación con SweetAlert
            <?php if(session('sweetalert')): ?>
                Swal.fire({
                    title: "<?php echo e(session('sweetalert.title')); ?>",
                    text: "<?php echo e(session('sweetalert.text')); ?>",
                    icon: "<?php echo e(session('sweetalert.type')); ?>",
                    confirmButtonText: '<?php echo app('translator')->get('auditoria.accept'); ?>',
                });
            <?php endif; ?>

            <?php if($errors->any()): ?>
                Swal.fire({
                    title: 'Error de Validación',
                    html: `<ul style="text-align: left;">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>`,
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                });
            <?php endif; ?>

            // Búsqueda en vivo en el select de usuario (evita múltiples submits)
            let userSelectElement = document.getElementById('user');
            if (userSelectElement) {
                let searchTimeout;
                userSelectElement.addEventListener('change', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(function () {
                        userSelectElement.form.submit();
                    }, 1000);
                });
            }

            // Manejar el cambio en el selector de registros por página
            let perPageElement = document.getElementById('perPage');
            if (perPageElement) {
                perPageElement.addEventListener('change', function () {
                    this.form.submit();
                });
            }
        });
    </script>

    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\PlantillaVelozon\resources\views/audit/index.blade.php ENDPATH**/ ?>