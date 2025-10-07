<?php

return [
    // Títulos y encabezados
    'title' => 'Trabajadores',
    'list' => 'Lista de Trabajadores',
    'breadcrumb' => 'Trabajadores',

    // Columnas de la tabla
    'id' => 'ID',
    'name' => 'Nombre',
    'surname' => 'Apellidos',
    'dni' => 'DNI',
    'phone' => 'Teléfono',
    'email' => 'Correo',
    'actions' => 'Acciones',

    // Botones y acciones
    'add_worker' => 'Añadir Trabajador',
    'edit' => 'Editar',
    'delete' => 'Eliminar',
    'accept' => 'Aceptar',

    // Mensajes de confirmación
    'confirm_delete_title' => '¿Estás seguro?',
    'confirm_delete_text' => 'Esta acción no se puede deshacer',
    'confirm_delete_yes' => 'Sí, eliminar',
    'confirm_delete_cancel' => 'Cancelar',

    // Paginación y búsqueda
    'records_per_page' => 'registros',
    'search_placeholder' => 'Buscar trabajador...',
    'no_results' => 'No se encontraron resultados',
    'try_searching' => 'Intenta con otros términos de búsqueda',

    // Mensajes de éxito/error
    'created' => 'Trabajador creado exitosamente',
    'updated' => 'Trabajador actualizado exitosamente',
    'deleted' => 'Trabajador eliminado exitosamente',
    'error' => 'Ha ocurrido un error',

    // Formularios
    'create_title' => 'Crear Nuevo Trabajador',
    'edit_title' => 'Editar Trabajador',
    'save' => 'Guardar',
    'cancel' => 'Cancelar',
    'back' => 'Volver',

    // Campos del formulario
    'name_label' => 'Nombre',
    'name_placeholder' => 'Ingrese el nombre',
    'surname_label' => 'Apellidos',
    'surname_placeholder' => 'Ingrese los apellidos',
    'dni_label' => 'DNI',
    'dni_placeholder' => 'Ingrese el DNI',
    'phone_label' => 'Teléfono',
    'phone_placeholder' => 'Ingrese el teléfono',
    'email_label' => 'Correo electrónico',
    'email_placeholder' => 'Ingrese el correo electrónico',

    // Validaciones
    'required' => 'El campo :attribute es obligatorio',
    'min' => 'El campo :attribute debe tener al menos :min caracteres',
    'max' => 'El campo :attribute no puede tener más de :max caracteres',
    'unique' => 'El :attribute ya existe en el sistema',
    'email_format' => 'El campo :attribute debe ser una dirección de correo válida',


        // Nuevos campos del formulario
    'seguridad_social_label' => 'Número de Seguridad Social',
    'seguridad_social_placeholder' => 'Introduce el número de la Seguridad Social',
    'cuenta_bancaria_label' => 'Cuenta Bancaria (IBAN)',
    'cuenta_bancaria_placeholder' => 'Ej: ES91 2100 0418 4502 0005 1332',
    'observaciones_label' => 'Observaciones',
    'observaciones_placeholder' => 'Añade cualquier observación relevante sobre el trabajador',

    // Nuevos mensajes de validación
    'seguridad_social_required' => 'El número de Seguridad Social es obligatorio',
    'seguridad_social_unique' => 'Este número de Seguridad Social ya está registrado',
    'cuenta_bancaria_format' => 'El formato de la cuenta bancaria no es válido',
    
];