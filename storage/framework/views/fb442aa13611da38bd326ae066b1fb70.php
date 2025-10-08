


<?php $__env->startSection('title'); ?> <?php echo app('translator')->get('workers.edit_title'); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> <?php echo app('translator')->get('workers.breadcrumb'); ?> <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo app('translator')->get('workers.edit_title'); ?> <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light border-bottom">
                    <h4 class="card-title mb-0 text-primary"><?php echo app('translator')->get('workers.edit_title'); ?></h4>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('workers.update', $worker)); ?>" method="POST" class="row g-3">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Nombre -->
                        <div class="col-md-6">
                            <label for="name" class="form-label"><?php echo app('translator')->get('workers.name_label'); ?></label>
                            <input type="text" id="name" name="name"
                                   class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('name', $worker->name)); ?>"
                                   placeholder="<?php echo app('translator')->get('workers.name_placeholder'); ?>">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Apellidos -->
                        <div class="col-md-6">
                            <label for="surname" class="form-label"><?php echo app('translator')->get('workers.surname_label'); ?></label>
                            <input type="text" id="surname" name="surname"
                                   class="form-control <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('surname', $worker->surname)); ?>"
                                   placeholder="<?php echo app('translator')->get('workers.surname_placeholder'); ?>">
                            <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- DNI -->
                        <div class="col-md-4">
                            <label for="dni" class="form-label"><?php echo app('translator')->get('workers.dni_label'); ?></label>
                            <input type="text" id="dni" name="dni"
                                   class="form-control <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('dni', $worker->dni)); ?>"
                                   placeholder="<?php echo app('translator')->get('workers.dni_placeholder'); ?>">
                            <?php $__errorArgs = ['dni'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-md-4">
                            <label for="telefono" class="form-label"><?php echo app('translator')->get('workers.phone_label'); ?></label>
                            <input type="text" id="telefono" name="telefono"
                                   class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('telefono', $worker->telefono)); ?>"
                                   placeholder="<?php echo app('translator')->get('workers.phone_placeholder'); ?>">
                            <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4">
                            <label for="email" class="form-label"><?php echo app('translator')->get('workers.email_label'); ?></label>
                            <input type="email" id="email" name="email"
                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('email', $worker->email)); ?>"
                                   placeholder="<?php echo app('translator')->get('workers.email_placeholder'); ?>">
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Seguridad Social -->
                        <div class="col-md-6">
                            <label for="seguridad_social" class="form-label"><?php echo app('translator')->get('workers.seguridad_social_label'); ?></label>
                            <input type="text" id="seguridad_social" name="seguridad_social"
                                   class="form-control <?php $__errorArgs = ['seguridad_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('seguridad_social', $worker->seguridad_social)); ?>"
                                   placeholder="<?php echo app('translator')->get('workers.seguridad_social_placeholder'); ?>">
                            <?php $__errorArgs = ['seguridad_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Cuenta Bancaria (IBAN) -->
                        <div class="col-md-6">
                            <label for="cuenta_bancaria" class="form-label"><?php echo app('translator')->get('workers.cuenta_bancaria_label'); ?></label>
                            <input type="text" id="cuenta_bancaria" name="cuenta_bancaria"
                                   class="form-control <?php $__errorArgs = ['cuenta_bancaria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   value="<?php echo e(old('cuenta_bancaria', $worker->cuenta_bancaria)); ?>"
                                   placeholder="<?php echo app('translator')->get('workers.cuenta_bancaria_placeholder'); ?>">
                            <?php $__errorArgs = ['cuenta_bancaria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-12">
                            <label for="observaciones" class="form-label"><?php echo app('translator')->get('workers.observaciones_label'); ?></label>
                            <textarea id="observaciones" name="observaciones" rows="3"
                                      class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      placeholder="<?php echo app('translator')->get('workers.observaciones_placeholder'); ?>"><?php echo e(old('observaciones', $worker->observaciones)); ?></textarea>
                            <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Botones -->
                        <div class="col-12 text-end">
                            <a href="<?php echo e(route('workers.index')); ?>" class="btn btn-secondary me-2"><?php echo app('translator')->get('workers.back'); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('workers.save'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\daivatrans-software\resources\views/workers/edit.blade.php ENDPATH**/ ?>