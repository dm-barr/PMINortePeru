<?php
class EventoModel_mysqli
{
    private $mysqli;
    private $table = 'Evento';
    private $host = 'localhost';
    private $dbname = 'pminorte_paginaweb';
    private $username = 'pminorte_admin';
    private $password = 'm$GYzHub$}Ov';

    public function __construct()
    {
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->mysqli->connect_error) {
            die('Error de conexión (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }

        $this->mysqli->set_charset("utf8mb4");
    }

    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    // Obtener todos los eventos (para admin)
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY fecha DESC";
        $result = $this->mysqli->query($sql);

        $eventos = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $eventos[] = $row;
            }
            $result->free();
        }
        return $eventos;
    }

    // ✅ NUEVO: Obtener solo eventos activos (para vista del usuario)
    public function getAllActivos()
    {
        $sql = "SELECT * FROM {$this->table} WHERE estado = 'activo' ORDER BY fecha DESC";
        $result = $this->mysqli->query($sql);

        $eventos = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $eventos[] = $row;
            }
            $result->free();
        }
        return $eventos;
    }

    // ✅ NUEVO: Cambiar estado del evento (toggle)
    public function toggleEstado($id)
    {
        // Primero obtenemos el estado actual
        $evento = $this->getById($id);
        if (!$evento) return false;

        // Invertimos el estado
        $nuevoEstado = ($evento['estado'] === 'activo') ? 'inactivo' : 'activo';

        // Actualizamos en la BD
        $sql = "UPDATE {$this->table} SET estado = ? WHERE id_Evento = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt) return false;
        
        $stmt->bind_param('si', $nuevoEstado, $id);
        return $stmt->execute();
    }

    // Crear evento con estado
    public function create($nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $imagen, $link = '', $estado = 'activo')
    {
        $sql = "INSERT INTO {$this->table} (nombre, descripcion, comunidad, fecha, modalidad, categoria, lugar, imagen, link, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;
        $stmt->bind_param('ssssssssss', $nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $imagen, $link, $estado);
        return $stmt->execute();
    }

    // Actualizar evento con estado
    public function update($id, $nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $imagen = null, $link = '', $estado = 'activo')
    {
        if ($imagen !== null) {
            $sql = "UPDATE {$this->table}
                SET nombre = ?, descripcion = ?, comunidad = ?, fecha = ?, modalidad = ?, categoria = ?, lugar = ?, imagen = ?, link = ?, estado = ?
                WHERE id_Evento = ?";
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt)
                return false;
            $stmt->bind_param('ssssssssssi', $nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $imagen, $link, $estado, $id);
        } else {
            $sql = "UPDATE {$this->table}
                SET nombre = ?, descripcion = ?, comunidad = ?, fecha = ?, modalidad = ?, categoria = ?, lugar = ?, link = ?, estado = ?
                WHERE id_Evento = ?";
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt)
                return false;
            $stmt->bind_param('sssssssssi', $nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $link, $estado, $id);
        }

        return $stmt->execute();
    }

    // Eliminar por ID
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id_Evento = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    // Obtener evento por ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_Evento = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
