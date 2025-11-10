<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

// OUTPUT BUFFERING - PRIMERO
ob_start();
session_start();

// Verificar autenticación
if (!isset($_SESSION['usuario_id'])) {
    ob_end_clean();
    header('Location: login.php');
    exit;
}

// Obtener datos del usuario logueado
$usuario_nombre = $_SESSION['usuario_nombre'] ?? 'Usuario';
$usuario_rol = $_SESSION['usuario_rol_nombre'] ?? 'Sin Rol';

require_once __DIR__ . '/config/Database.php';

// RUTAS CORREGIDAS - Los archivos PHP están un nivel arriba
require_once __DIR__ . '/../php/evento.php';
require_once __DIR__ . '/../php/educacion.php';
require_once __DIR__ . '/../php/noticia.php';

// Crear conexión MySQLi para los modelos
$db = new Database();
$mysqli = $db->getMysqli();

$eventoModel = new EventoModel_mysqli();
$educacionModel = new EducacionModel_mysqli();
$noticiaModel = new NoticiaModel_mysqli();

// Variables para mensajes
$mensaje = '';
$tipo_mensaje = '';


// FUNCIÓN PARA SUBIR IMÁGENES
function subirImagen($archivo)
{
    if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $extensiones_permitidas)) {
        return null;
    }

    // RUTA CORREGIDA: uploads está en la raíz del proyecto
    $carpeta_destino = __DIR__ . '/../uploads/';

    if (!file_exists($carpeta_destino)) {
        mkdir($carpeta_destino, 0755, true);
    }

    $nombre_archivo = uniqid() . '.' . $extension;
    $ruta_completa = $carpeta_destino . $nombre_archivo;

    if (move_uploaded_file($archivo['tmp_name'], $ruta_completa)) {
        return 'uploads/' . $nombre_archivo;
    }

    return null;
}

// Procesar formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    // ========== EVENTOS ==========
    if ($_POST['accion'] == 'agregar_evento') {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $comunidad = $_POST['comunidad'];
        $fecha = $_POST['fecha'];
        $modalidad = $_POST['modalidad'];
        $categoria = $_POST['categoria'];
        $lugar = $_POST['lugar'];
        $link = $_POST['link'] ?? '';

        $imagen = '';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = subirImagen($_FILES['imagen']);
        }

        if ($eventoModel->create($nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $imagen, $link)) {
            $mensaje = 'Evento agregado exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al agregar el evento';
            $tipo_mensaje = 'error';
        }
    }

    if ($_POST['accion'] == 'editar_evento') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $comunidad = $_POST['comunidad'];
        $fecha = $_POST['fecha'];
        $modalidad = $_POST['modalidad'];
        $categoria = $_POST['categoria'];
        $lugar = $_POST['lugar'];
        $link = $_POST['link'] ?? '';

        $evento_actual = $eventoModel->getById($id);
        $imagen = $evento_actual['imagen'] ?? null;

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $nueva_imagen = subirImagen($_FILES['imagen']);
            if ($nueva_imagen !== null) {
                $imagen = $nueva_imagen;
                if (!empty($evento_actual['imagen']) && file_exists(__DIR__ . '/../' . $evento_actual['imagen'])) {
                    unlink(__DIR__ . '/../' . $evento_actual['imagen']);
                }
            }
        }

        if ($eventoModel->update($id, $nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $imagen, $link)) {
            $mensaje = 'Evento actualizado exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al actualizar el evento';
            $tipo_mensaje = 'error';
        }
    }

    if ($accion === 'eliminar_evento') {
        $id = $_POST['id'] ?? 0;
        if ($eventoModel->delete($id)) {
            $mensaje = 'Evento eliminado exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al eliminar el evento';
            $tipo_mensaje = 'error';
        }
    }

    // ========== EDUCACIÓN ==========
    if ($accion === 'agregar_educacion') {
        $curso = $_POST['curso'] ?? '';
        $modalidad = $_POST['modalidad'] ?? '';
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        $instructor = $_POST['instructor'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        if ($educacionModel->create($curso, $modalidad, $fecha, $instructor, $descripcion)) {
            $mensaje = 'Curso agregado exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al agregar el curso';
            $tipo_mensaje = 'error';
        }
    }

    if ($accion === 'editar_educacion') {
        $id = $_POST['id'] ?? 0;
        $curso = $_POST['curso'] ?? '';
        $modalidad = $_POST['modalidad'] ?? '';
        $fecha = $_POST['fecha'] ?? date('Y-m-d');
        $instructor = $_POST['instructor'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        if ($educacionModel->update($id, $curso, $modalidad, $fecha, $instructor, $descripcion)) {
            $mensaje = 'Curso actualizado exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al actualizar el curso';
            $tipo_mensaje = 'error';
        }
    }

    if ($accion === 'eliminar_educacion') {
        $id = $_POST['id'] ?? 0;
        if ($educacionModel->delete($id)) {
            $mensaje = 'Curso eliminado exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al eliminar el curso';
            $tipo_mensaje = 'error';
        }
    }

    // ========== NOTICIAS ==========
    if ($accion === 'agregar_noticia') {
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        $imagen = '';
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = subirImagen($_FILES['imagen']);
        }

        if ($noticiaModel->create($titulo, $descripcion, $imagen)) {
            $mensaje = 'Noticia agregada exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al agregar la noticia';
            $tipo_mensaje = 'error';
        }
    }

    if ($accion === 'editar_noticia') {
        $id = $_POST['id'] ?? 0;
        $titulo = $_POST['titulo'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';

        $imagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $imagen = subirImagen($_FILES['imagen']);
        }

        if ($noticiaModel->update($id, $titulo, $descripcion, $imagen)) {
            $mensaje = 'Noticia actualizada exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al actualizar la noticia';
            $tipo_mensaje = 'error';
        }
    }

    if ($accion === 'eliminar_noticia') {
        $id = $_POST['id'] ?? 0;
        if ($noticiaModel->delete($id)) {
            $mensaje = 'Noticia eliminada exitosamente';
            $tipo_mensaje = 'success';
        } else {
            $mensaje = 'Error al eliminar la noticia';
            $tipo_mensaje = 'error';
        }
    }
}

// Cargar datos
$eventos = $eventoModel->getAll();
$educaciones = $educacionModel->getAll();
$noticias = $noticiaModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - PMI Norte Perú</title>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <div class="admin-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../img/logo/logo_PMI.png" alt="Logo PMI Norte Perú" class="sidebar-logo">
                <div class="user-info">
                    <p class="user-name"><?php echo htmlspecialchars($usuario_nombre); ?></p>
                    <p class="user-role"><?php echo htmlspecialchars($usuario_rol); ?></p>
                </div>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" class="nav-link active" data-target="eventos">Eventos</a></li>
                    <li><a href="#" class="nav-link" data-target="educacion">Educación</a></li>
                    <li><a href="#" class="nav-link" data-target="noticias">Noticias</a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <a href="logout.php" class="logout-link">Cerrar Sesión</a>
            </div>
        </aside>

        <main class="main-content">
            <!-- Mensaje de notificación -->
            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <!-- SECCIÓN EVENTOS -->
            <section id="eventos" class="view active">
                <header class="view-header">
                    <h1>Eventos</h1>
                    <div class="header-buttons">
                        <button class="btn btn-primary" id="btn-abrir-evento">+ Agregar</button>
                    </div>
                </header>

                <div class="search-box">
                    <input type="text" id="search-eventos" class="search-input" placeholder="🔍 Buscar eventos...">
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Comunidad</th>
                                <th>Modalidad</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th>Lugar</th>
                                <th>Link</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="eventos-tbody">
                            <?php if (!empty($eventos)): ?>
                                <?php foreach ($eventos as $evento): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($evento['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($evento['descripcion'], 0, 50)) . '...'; ?></td>
                                        <td><?php echo htmlspecialchars($evento['comunidad']); ?></td>
                                        <td><?php echo htmlspecialchars($evento['modalidad']); ?></td>
                                        <td><?php echo htmlspecialchars($evento['categoria']); ?></td>
                                        <td><?php echo htmlspecialchars($evento['fecha']); ?></td>
                                        <td><?php echo htmlspecialchars($evento['lugar']); ?></td>
                                        <td><?php echo !empty($evento['link']) ? '<a href="' . htmlspecialchars($evento['link']) . '" target="_blank">Ver</a>' : '-'; ?>
                                        </td>
                                        <td><?php echo !empty($evento['imagen']) ? htmlspecialchars($evento['imagen']) : '-'; ?>
                                        </td>
                                        <td class="action-icons">
                                            <a href="#" class="btn-editar-evento" data-id="<?= $evento['id_Evento'] ?>"
                                                data-nombre="<?= htmlspecialchars($evento['nombre']) ?>"
                                                data-descripcion="<?= htmlspecialchars($evento['descripcion']) ?>"
                                                data-comunidad="<?= htmlspecialchars($evento['comunidad']) ?>"
                                                data-fecha="<?= $evento['fecha'] ?>"
                                                data-modalidad="<?= htmlspecialchars($evento['modalidad']) ?>"
                                                data-categoria="<?= htmlspecialchars($evento['categoria']) ?>"
                                                data-lugar="<?= htmlspecialchars($evento['lugar']) ?>"
                                                data-link="<?= htmlspecialchars($evento['link']) ?>" title="Editar">
                                                <img src="../img/iconos/editar.png" alt="Editar">
                                            </a>
                                            <a href="#" class="btn-eliminar" data-tipo="evento"
                                                data-id="<?php echo htmlspecialchars($evento['id_Evento']); ?>"
                                                title="Eliminar">
                                                <img src="../img/iconos/eliminar.png" alt="Eliminar">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10">No hay eventos disponibles</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </section>

            <!-- SECCIÓN EDUCACIÓN -->
            <section id="educacion" class="view">
                <header class="view-header">
                    <h1 class="title-educacion">Educación</h1>
                    <div class="header-buttons">
                        <button class="btn btn-purple" id="btn-abrir-educacion">+ Agregar</button>
                    </div>
                </header>

                <div class="search-box">
                    <input type="text" id="search-educacion" class="search-input" placeholder="🔍 Buscar cursos...">
                </div>

                <div class="table-container-educacion">
                    <table>
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Modalidad</th>
                                <th>Fecha</th>
                                <th>Instructor</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="educacion-tbody">
                            <?php if (!empty($educaciones)): ?>
                                <?php foreach ($educaciones as $educacion): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($educacion['curso']); ?></td>
                                        <td><?php echo htmlspecialchars($educacion['modalidad']); ?></td>
                                        <td><?php echo htmlspecialchars($educacion['fecha']); ?></td>
                                        <td><?php echo htmlspecialchars($educacion['instructor']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($educacion['descripcion'], 0, 50)) . '...'; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($educacion['imagen']); ?></td>
                                        <td class="action-icons">
                                            <a href="#" class="btn-editar-educacion"
                                                data-id="<?php echo $educacion['id_Educacion']; ?>"
                                                data-curso="<?php echo htmlspecialchars($educacion['curso']); ?>"
                                                data-modalidad="<?php echo htmlspecialchars($educacion['modalidad']); ?>"
                                                data-fecha="<?php echo htmlspecialchars($educacion['fecha']); ?>"
                                                data-instructor="<?php echo htmlspecialchars($educacion['instructor']); ?>"
                                                data-descripcion="<?php echo htmlspecialchars($educacion['descripcion']); ?>"
                                                title="Editar">
                                                <img src="../img/iconos/editar.png" alt="Editar">
                                            </a>
                                            <a href="#" class="btn-eliminar" data-tipo="educacion"
                                                data-id="<?php echo $educacion['id_Educacion']; ?>" title="Eliminar">
                                                <img src="../img/iconos/eliminar.png" alt="Eliminar">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No hay cursos disponibles</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- SECCIÓN NOTICIAS -->
            <section id="noticias" class="view">
                <header class="view-header">
                    <h1>Noticias</h1>
                    <div class="header-buttons">
                        <button class="btn btn-primary" id="btn-abrir-noticia">+ Agregar</button>
                    </div>
                </header>

                <div class="search-box">
                    <input type="text" id="search-noticias" class="search-input" placeholder="🔍 Buscar noticias...">
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Imagen</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="noticias-tbody">
                            <?php if (!empty($noticias)): ?>
                                <?php foreach ($noticias as $noticia): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($noticia['titulo']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($noticia['descripcion'], 0, 50)) . '...'; ?></td>
                                        <td><?php echo htmlspecialchars($noticia['imagen']); ?></td>
                                        <td><?php echo htmlspecialchars($noticia['fecha']); ?></td>
                                        <td class="action-icons">
                                            <a href="#" class="btn-editar-noticia"
                                                data-id="<?php echo $noticia['id_Noticia']; ?>"
                                                data-titulo="<?php echo htmlspecialchars($noticia['titulo']); ?>"
                                                data-descripcion="<?php echo htmlspecialchars($noticia['descripcion']); ?>"
                                                data-imagen="<?php echo htmlspecialchars($noticia['imagen']); ?>"
                                                title="Editar">
                                                <img src="../img/iconos/editar.png" alt="Editar">
                                            </a>
                                            <a href="#" class="btn-eliminar" data-tipo="noticia"
                                                data-id="<?php echo $noticia['id_Noticia']; ?>" title="Eliminar">
                                                <img src="../img/iconos/eliminar.png" alt="Eliminar">
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">No hay noticias disponibles</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- MODAL EVENTO -->
    <div id="modal-evento" class="modal-overlay">
        <div class="modal-box">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h2 id="titulo-modal-evento">Agregar Evento</h2>
            </div>
            <form class="modal-form form-evento" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="accion" id="accion-evento" value="agregar_evento">
                <input type="hidden" name="id" id="evento-id" value="">

                <div class="form-group-full">
                    <label for="evento-nombre">Nombre</label>
                    <input type="text" name="nombre" id="evento-nombre" required>
                </div>

                <!-- ✅ VISTA PREVIA DE IMAGEN -->
                <div class="form-group">
                    <label for="evento-imagen">Imagen</label>
                    <label for="evento-imagen" class="file-upload-label">
                        <span>📁 Subir imagen</span>
                    </label>
                    <input type="file" name="imagen" id="evento-imagen" class="file-upload-input" accept="image/*">
                    <div class="image-preview" id="preview-evento" style="display: none;">
                        <img src="" alt="Preview"
                            style="max-width: 100%; max-height: 150px; border-radius: 8px; margin-top: 10px;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="evento-fecha">Fecha</label>
                    <input type="date" name="fecha" id="evento-fecha">
                </div>
                <div class="form-group">
                    <label for="evento-modalidad">Modalidad</label>
                    <select name="modalidad" id="evento-modalidad" required>
                        <option value="">Seleccionar</option>
                        <option value="Presencial">Presencial</option>
                        <option value="Online">Online</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="evento-comunidad">Comunidad</label>
                    <select name="comunidad" id="evento-comunidad" required>
                        <option value="">Seleccionar</option>
                        <option value="Cajamarca">Cajamarca</option>
                        <option value="Trujillo">Trujillo</option>
                        <option value="Piura">Piura</option>
                        <option value="Estudiantil">Estudiantil</option>
                        <option value="Estudiantil UNC">Estudiantil UNC</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="evento-lugar">Lugar</label>
                    <input type="text" name="lugar" id="evento-lugar" required>
                </div>
                <div class="form-group">
                    <label for="evento-categoria">Categoría</label>
                    <select name="categoria" id="evento-categoria" required>
                        <option value="">Seleccionar</option>
                        <option value="Capacitación">Capacitación</option>
                        <option value="Congreso">Congreso</option>
                        <option value="Conferencia">Conferencia</option>
                        <option value="Networking">Networking</option>
                        <option value="Taller">Taller</option>
                        <option value="Webinar">Webinar</option>
                    </select>
                </div>

                <!-- ✅ NUEVO CAMPO LINK -->
                <div class="form-group-full">
                    <label for="evento-link">Link del Evento</label>
                    <input type="url" name="link" id="evento-link" placeholder="https://ejemplo.com/evento">
                </div>

                <div class="form-group-full">
                    <label for="evento-descripcion">Descripción</label>
                    <textarea name="descripcion" id="evento-descripcion" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-guardar">Guardar</button>
            </form>
        </div>
    </div>

    <!-- MODAL EDUCACIÓN -->
    <div id="modal-educacion" class="modal-overlay">
        <div class="modal-box theme-educacion">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h2 id="titulo-modal-educacion">Agregar Curso</h2>
            </div>
            <form class="modal-form form-educacion" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="accion" id="accion-educacion" value="agregar_educacion">
                <input type="hidden" name="id" id="educacion-id" value="">

                <div class="form-group-full">
                    <label for="curso-nombre">Curso</label>
                    <input type="text" name="curso" id="curso-nombre" required>
                </div>

                <!-- ✅ VISTA PREVIA DE IMAGEN -->
                <div class="form-group">
                    <label for="curso-imagen">Imagen</label>
                    <label for="curso-imagen" class="file-upload-label">
                        <span>📁 Subir imagen</span>
                    </label>
                    <input type="file" name="imagen" id="curso-imagen" class="file-upload-input" accept="image/*">
                    <div class="image-preview" id="preview-educacion" style="display: none;">
                        <img src="" alt="Preview"
                            style="max-width: 100%; max-height: 150px; border-radius: 8px; margin-top: 10px;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="curso-modalidad">Modalidad</label>
                    <select name="modalidad" id="curso-modalidad" required>
                        <option value="">Seleccionar</option>
                        <option value="Online">Online</option>
                        <option value="Presencial">Presencial</option>
                    </select>
                </div>
                <div class="form-group-full">
                    <label for="curso-fecha">Fecha</label>
                    <input type="date" name="fecha" id="curso-fecha" required>
                </div>

                <div class="form-group-full">
                    <label for="curso-instructor">Instructor</label>
                    <input type="text" name="instructor" id="curso-instructor" required>
                </div>

                <div class="form-group-full">
                    <label for="curso-descripcion">Descripción</label>
                    <textarea name="descripcion" id="curso-descripcion" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-guardar">Guardar</button>
            </form>
        </div>
    </div>

    <!-- MODAL NOTICIA -->
    <div id="modal-noticia" class="modal-overlay">
        <div class="modal-box">
            <span class="close-modal">&times;</span>
            <div class="modal-header">
                <h2 id="titulo-modal-noticia">Agregar Noticia</h2>
            </div>
            <form class="modal-form form-noticia" method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="accion" id="accion-noticia" value="agregar_noticia">
                <input type="hidden" name="id" id="noticia-id" value="">

                <div class="form-group-full">
                    <label for="noticia-titulo">Título</label>
                    <input type="text" name="titulo" id="noticia-titulo" required>
                </div>

                <!-- ✅ VISTA PREVIA DE IMAGEN -->
                <div class="form-group-full">
                    <label for="noticia-imagen">Imagen</label>
                    <label for="noticia-imagen" class="file-upload-label">
                        <span>📁 Subir imagen</span>
                    </label>
                    <input type="file" name="imagen" id="noticia-imagen" class="file-upload-input" accept="image/*">
                    <div class="image-preview" id="preview-noticia" style="display: none;">
                        <img src="" alt="Preview"
                            style="max-width: 100%; max-height: 150px; border-radius: 8px; margin-top: 10px;">
                    </div>
                </div>

                <div class="form-group-full">
                    <label for="noticia-fecha">Fecha</label>
                    <input type="date" name="fecha" id="noticia-fecha">
                </div>
                <div class="form-group-full">
                    <label for="noticia-descripcion">Descripción</label>
                    <textarea name="descripcion" id="noticia-descripcion" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn-guardar">Guardar</button>
            </form>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
<?php ob_end_flush(); ?>

</html>
<?php
$mysqli->close();
?>