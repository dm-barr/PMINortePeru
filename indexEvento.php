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

    if ($model->update($id_Evento, $nombre, $descripcion, $comunidad, $modalidad, $categoria, $lugar, $imagen)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=2");
        exit;
    } else {
        $mensaje = "❌ Error al actualizar el evento.";
    }
}

// ----- ELIMINAR EVENTO -----
if (isset($_GET['delete'])) {
    $id_Evento = intval($_GET['delete']);
    if ($model->delete($id_Evento)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=3");
        exit;
    } else {
        $mensaje = "❌ Error al eliminar el evento.";
    }
}

// Mensajes de éxito
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 1:
            $mensaje = "✅ Evento creado correctamente.";
            break;
        case 2:
            $mensaje = "✅ Evento actualizado correctamente.";
            break;
        case 3:
            $mensaje = "✅ Evento eliminado correctamente.";
            break;
    }
}

// Obtener todos los eventos
$eventos = $model->getAll();

// Si se va a editar, obtener los datos del evento
$editEvento = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    $editEvento = $model->getById($editId);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Eventos - PMI Norte Perú</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <style>
        .img-preview {
            max-height: 200px;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4 text-center text-primary">📅 Eventos - PMI Norte Perú</h1>

    <!-- Mensaje -->
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- Formulario Crear / Editar -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= $editEvento ? 'Editar Evento' : 'Agregar Nuevo Evento' ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?= $editEvento ? 'update' : 'create' ?>">
                <?php if ($editEvento): ?>
                    <input type="hidden" name="id_Evento" value="<?= $editEvento['ID_Evento'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required
                           value="<?= $editEvento ? htmlspecialchars($editEvento['nombre']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4" required><?= $editEvento ? htmlspecialchars($editEvento['descripcion']) : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Comunidad</label>
                    <input type="text" name="comunidad" class="form-control"
                           value="<?= $editEvento ? htmlspecialchars($editEvento['comunidad']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Modalidad</label>
                    <input type="text" name="modalidad" class="form-control"
                           value="<?= $editEvento ? htmlspecialchars($editEvento['modalidad']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoría</label>
                    <input type="text" name="categoria" class="form-control"
                           value="<?= $editEvento ? htmlspecialchars($editEvento['categoria']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Lugar</label>
                    <input type="text" name="lugar" class="form-control"
                           value="<?= $editEvento ? htmlspecialchars($editEvento['lugar']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" id="imagenInput">
                    <?php if ($editEvento && $editEvento['imagen']): ?>
                        <img src="<?= htmlspecialchars($editEvento['imagen']) ?>" class="img-preview" id="imagenPreview">
                    <?php else: ?>
                        <img src="" class="img-preview" id="imagenPreview" style="display:none;">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-success"><?= $editEvento ? 'Actualizar Evento' : 'Publicar Evento' ?></button>
                <?php if ($editEvento): ?>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Listado de eventos -->
    <h2 class="mb-4 text-secondary">Próximos Eventos</h2>
    <div class="row">
        <?php if (empty($eventos)): ?>
            <p class="text-muted">No hay eventos aún.</p>
        <?php else: ?>
            <?php foreach ($eventos as $evento): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($evento['imagen'])): ?>
                            <img src="<?= htmlspecialchars($evento['imagen']) ?>" class="card-img-top" alt="Imagen del evento">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x250?text=Sin+Imagen" class="card-img-top" alt="Sin imagen">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($evento['nombre']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($evento['descripcion'])) ?></p>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted">
                                Fecha: <?= htmlspecialchars($evento['fecha']) ?> <br>
                                Comunidad: <?= htmlspecialchars($evento['comunidad']) ?>
                            </small>
                            <div class="mt-2">
                                <?php
                                $editUrl = $_SERVER['PHP_SELF'] . '?edit=' . intval($evento['ID_Evento']);
                                $deleteUrl = $_SERVER['PHP_SELF'] . '?delete=' . intval($evento['ID_Evento']);
                                ?>
                                <a href="<?= htmlspecialchars($editUrl) ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="<?= htmlspecialchars($deleteUrl) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este evento?');">Eliminar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
// Preview de imagen
const imagenInput = document.getElementById('imagenInput');
const imagenPreview = document.getElementById('imagenPreview');

imagenInput.addEventListener('change', function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagenPreview.src = e.target.result;
            imagenPreview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        imagenPreview.src = '';
        imagenPreview.style.display = 'none';
    }
});
</script>

</body>
</html>
