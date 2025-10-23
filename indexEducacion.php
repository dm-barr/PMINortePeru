<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/php/educacion.php';
$model = new EducacionModel_mysqli();

$mensaje = '';

// ----- CREAR CURSO -----
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $curso = trim($_POST['curso'] ?? '');
    $modalidad = trim($_POST['modalidad'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');
    $instructor = trim($_POST['instructor'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($curso === '' || $modalidad === '' || $fecha === '' || $instructor === '' || $descripcion === '') {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        if ($model->create($curso, $modalidad, $fecha, $instructor, $descripcion)) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit;
        } else {
            $mensaje = "Error al registrar el curso.";
        }
    }
}

// ----- ACTUALIZAR CURSO -----
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id_Edu = intval($_POST['id_Edu']);
    $curso = trim($_POST['curso'] ?? '');
    $modalidad = trim($_POST['modalidad'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');
    $instructor = trim($_POST['instructor'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($model->update($id_Edu, $curso, $modalidad, $fecha, $instructor, $descripcion)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=2");
        exit;
    } else {
        $mensaje = "Error al actualizar el curso.";
    }
}

// ----- ELIMINAR CURSO -----
if (isset($_GET['delete'])) {
    $id_Edu = intval($_GET['delete']);
    if ($model->delete($id_Edu)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=3");
        exit;
    } else {
        $mensaje = "Error al eliminar el curso.";
    }
}

// ----- MENSAJES -----
if (isset($_GET['success'])) {
    switch ($_GET['success']) {
        case 1:
            $mensaje = "Curso registrado correctamente.";
            break;
        case 2:
            $mensaje = "Curso actualizado correctamente.";
            break;
        case 3:
            $mensaje = "Curso eliminado correctamente.";
            break;
    }
}

// Obtener todos los cursos
$cursos = $model->getAll();

// Si se va a editar, obtener datos del curso
$editCurso = null;
if (isset($_GET['edit'])) {
    $editId = intval($_GET['edit']);
    $editCurso = $model->getById($editId);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Cursos - PMI Norte Perú</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container py-5">
        <h1 class="mb-4 text-center text-primary">🎓 Educación - PMI Norte Perú</h1>

        <!-- Mensaje -->
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <!-- Formulario Crear / Editar -->
        <div class="card mb-5 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?= $editCurso ? 'Editar Curso' : 'Agregar Nuevo Curso' ?></h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="<?= $editCurso ? 'update' : 'create' ?>">
                    <?php if ($editCurso): ?>
                        <input type="hidden" name="id_Edu" value="<?= $editCurso['id_Edu'] ?>">
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Curso</label>
                            <input type="text" name="curso" class="form-control" required
                                value="<?= $editCurso ? htmlspecialchars($editCurso['curso']) : '' ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modalidad</label>
                            <input type="text" name="modalidad" class="form-control" required
                                value="<?= $editCurso ? htmlspecialchars($editCurso['modalidad']) : '' ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control" required
                                value="<?= $editCurso ? htmlspecialchars($editCurso['fecha']) : '' ?>">
                        </div>

                        <div class="col-md-8 mb-3">
                            <label class="form-label">Instructor</label>
                            <input type="text" name="instructor" class="form-control" required
                                value="<?= $editCurso ? htmlspecialchars($editCurso['instructor']) : '' ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" required><?= $editCurso ? htmlspecialchars($editCurso['descripcion']) : '' ?></textarea>
                    </div>

                    <button type="submit"
                        class="btn btn-success"><?= $editCurso ? 'Actualizar Curso' : 'Registrar Curso' ?></button>
                    <?php if ($editCurso): ?>
                        <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Listado de cursos -->
        <h2 class="mb-4 text-secondary">📚 Lista de Cursos</h2>
        <div class="row">
            <?php if (empty($cursos)): ?>
                <p class="text-muted">No hay cursos registrados aún.</p>
            <?php else: ?>
                <?php foreach ($cursos as $curso): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($curso['curso']) ?></h5>
                                <p class="card-text">
                                    <strong>Modalidad:</strong> <?= htmlspecialchars($curso['modalidad']) ?><br>
                                    <strong>Fecha:</strong> <?= htmlspecialchars($curso['fecha']) ?><br>
                                    <strong>Instructor:</strong> <?= htmlspecialchars($curso['instructor']) ?><br>
                                    <em><?= nl2br(htmlspecialchars($curso['descripcion'])) ?></em>
                                </p>
                            </div>
                            <div class="card-footer text-center">
                                <?php
                                $editUrl = $_SERVER['PHP_SELF'] . '?edit=' . intval($curso['id_Edu']);
                                $deleteUrl = $_SERVER['PHP_SELF'] . '?delete=' . intval($curso['id_Edu']);
                                ?>
                                <a href="<?= htmlspecialchars($editUrl) ?>" class="btn btn-sm btn-primary">Editar</a>
                                <a href="<?= htmlspecialchars($deleteUrl) ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Seguro que deseas eliminar este curso?');">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
