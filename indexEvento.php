<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/php/EventoModel_mysqli.php';  // Ajusta el path si es necesario
$model = new EventoModel_mysqli();

$mensaje = '';

// ----- CREAR EVENTO -----
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $comunidad = trim($_POST['comunidad'] ?? '');
    $modalidad = trim($_POST['modalidad'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $lugar = trim($_POST['lugar'] ?? '');
    $imagen = '';

    if ($nombre === '' || $descripcion === '') {
        $mensaje = "❌ Nombre y descripción son obligatorios.";
    } else {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['imagen']['type'], $tiposPermitidos)) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $nombreArchivo = uniqid('img_') . '.' . $ext;
                $rutaDestino = __DIR__ . '/uploads/' . $nombreArchivo;
                if (!is_dir(__DIR__ . '/uploads'))
                    mkdir(__DIR__ . '/uploads', 0755, true);
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = 'uploads/' . $nombreArchivo;
                } else {
                    $mensaje = "❌ Error al subir la imagen.";
                }
            } else {
                $mensaje = "❌ Tipo de imagen no permitido.";
            }
        }

        if ($mensaje === '' && $model->create($nombre, $descripcion, $comunidad, $modalidad, $categoria, $lugar, $imagen)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit;
        }
    }
}

// ----- ACTUALIZAR EVENTO -----
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_Evento = intval($_POST['id_Evento']);
    $nombre = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $comunidad = trim($_POST['comunidad'] ?? '');
    $modalidad = trim($_POST['modalidad'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $lugar = trim($_POST['lugar'] ?? '');
    $imagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['imagen']['type'], $tiposPermitidos)) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('img_') . '.' . $ext;
            $rutaDestino = __DIR__ . '/uploads/' . $nombreArchivo;
            if (!is_dir(__DIR__ . '/uploads'))
                mkdir(__DIR__ . '/uploads', 0755, true);
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                $imagen = 'uploads/' . $nombreArchivo;
            }
        }
    }

    if ($model->update($id_Evento, $nombre, $descripcion, $comunidad,
