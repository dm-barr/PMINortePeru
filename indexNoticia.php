<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/noticia.php';
$model = new NoticiaModel_mysqli();

$mensaje = '';

// ----- CREAR NOTICIA -----
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $imagen = '';

    if ($titulo === '' || $descripcion === '') {
        $mensaje = "❌ Título y descripción son obligatorios.";
    } else {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $tiposPermitidos = ['image/jpeg','image/png','image/gif'];
            if (in_array($_FILES['imagen']['type'], $tiposPermitidos)) {
                $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $nombreArchivo = uniqid('img_') . '.' . $ext;
                $rutaDestino = __DIR__ . '/uploads/' . $nombreArchivo;
                if (!is_dir(__DIR__.'/uploads')) mkdir(__DIR__.'/uploads', 0755, true);
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    $imagen = 'uploads/' . $nombreArchivo;
                } else {
                    $mensaje = "❌ Error al subir la imagen.";
                }
            } else {
                $mensaje = "❌ Tipo de imagen no permitido.";
            }
        }

        if ($mensaje === '' && $model->create($titulo, $descripcion, $imagen)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit;
        }
    }
}

// ----- ACTUALIZAR NOTICIA -----
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id_Noticia']);
    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $imagen = null;

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tiposPermitidos = ['image/jpeg','image/png','image/gif'];
        if (in_array($_FILES['imagen']['type'], $tiposPermitidos)) {
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('img_') . '.' . $ext;
            $rutaDestino = __DIR__ . '/uploads/' . $nombreArchivo;
            if (!is_dir(__DIR__.'/uploads')) mkdir(__DIR__.'/uploads', 0755, true);
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                $imagen = 'uploads/' . $nombreArchivo;
            }
        }
    }

    if ($model->update($id, $titulo, $descripcion, $imagen)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=2");
        exit;
    } else {
        $mensaje = "❌ Error al actualizar la noticia.";
    }
}

// ----- ELIMINAR NOTICIA -----
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    if ($model->delete($id)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=3");
        exit;
    } else {
        $mensaje = "❌ Error al eliminar la noticia.";
    }
}

// Mensajes de éxito
if (isset($_GET['success'])) {
    switch($_GET['success']) {
        case 1: $mensaje = "✅ Noticia creada correctamente."; break;
        case 2: $mensaje = "✅ Noticia actualizada correctamente."; break;
        case 3: $mensaje = "✅ Noticia eliminada correctamente."; break;
    }
}

// Obtener todas las noticias
$noticias = $model->getAll();

// Si se va a editar, obtener los datos de la noticia
$editNoticia = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    $editNoticia = $model->getById($editId);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Noticias - PMI Norte Perú</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .img-preview { max-height: 200px; margin-top: 10px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="mb-4 text-center text-primary">📰 Noticias - PMI Norte Perú</h1>

    <!-- Mensaje -->
    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- Formulario Crear / Editar -->
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><?= $editNoticia ? 'Editar Noticia' : 'Agregar Nueva Noticia' ?></h5>
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?= $editNoticia ? 'update' : 'create' ?>">
                <?php if ($editNoticia): ?>
                    <input type="hidden" name="id" value="<?= $editNoticia['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Título</label>
                    <input type="text" name="titulo" class="form-control" required
                        value="<?= $editNoticia ? htmlspecialchars($editNoticia['titulo']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="4" required><?= $editNoticia ? htmlspecialchars($editNoticia['descripcion']) : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="imagen" class="form-control" accept="image/*" id="imagenInput">
                    <?php if ($editNoticia && $editNoticia['imagen']): ?>
                        <img src="<?= htmlspecialchars($editNoticia['imagen']) ?>" class="img-preview" id="imagenPreview">
                    <?php else: ?>
                        <img src="" class="img-preview" id="imagenPreview" style="display:none;">
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-success"><?= $editNoticia ? 'Actualizar Noticia' : 'Publicar Noticia' ?></button>
                <?php if ($editNoticia): ?>
                    <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Listado de noticias -->
    <h2 class="mb-4 text-secondary">Últimas Noticias</h2>
    <div class="row">
        <?php if (empty($noticias)): ?>
            <p class="text-muted">No hay noticias publicadas aún.</p>
        <?php else: ?>
            <?php foreach ($noticias as $noticia): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($noticia['imagen'])): ?>
                            <img src="<?= htmlspecialchars($noticia['imagen']) ?>" class="card-img-top" alt="Imagen de la noticia">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x250?text=Sin+Imagen" class="card-img-top" alt="Sin imagen">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($noticia['titulo']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($noticia['descripcion'])) ?></p>
                        </div>
                        <div class="card-footer text-center">
                            <small class="text-muted">Publicado el <?= htmlspecialchars($noticia['fecha_publicacion']) ?></small>
                            <div class="mt-2">
                                <a href="<?= $_SERVER['PHP_SELF'] ?>?edit=<?= $noticia['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="<?= $_SERVER['PHP_SELF'] ?>?delete=<?= $noticia['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('¿Seguro que deseas eliminar esta noticia?')">Eliminar</a>
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

    imagenInput.addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
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
