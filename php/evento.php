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
        $sql = "SELECT * FROM {$this->table} ORDER BY fecha_inicio DESC";
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

    // Obtener solo eventos activos (estado = 1) para vista del usuario
    public function getAllActivos()
    {
        $sql = "SELECT * FROM {$this->table} WHERE estado = 1 ORDER BY fecha_inicio DESC";
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

    // Cambiar estado del evento (toggle: 0 ↔ 1)
    public function toggleEstado($id)
    {
        $evento = $this->getById($id);
        if (!$evento)
            return false;

        $nuevoEstado = ($evento['estado'] == 1) ? 0 : 1;

        $sql = "UPDATE {$this->table} SET estado = ? WHERE id_Evento = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;

        $stmt->bind_param('ii', $nuevoEstado, $id);
        return $stmt->execute();
    }

    // Crear evento con todos los campos actualizados
    public function create($nombre, $descripcion, $descripcion_corta, $comunidad, $modalidad, $categoria, $fecha_inicio, $fecha_fin, $lugar, $imagen, $link = '', $estado = 1)
    {
        $sql = "INSERT INTO {$this->table} 
                (nombre, descripcion, descripcion_corta, comunidad, modalidad, categoria, fecha_inicio, fecha_fin, lugar, imagen, link, estado) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;
        
        // 12 parámetros: 11 strings + 1 integer (estado)
        $stmt->bind_param('sssssssssssi', $nombre, $descripcion, $descripcion_corta, $comunidad, $modalidad, $categoria, $fecha_inicio, $fecha_fin, $lugar, $imagen, $link, $estado);
        return $stmt->execute();
    }

    // Actualizar evento con todos los campos actualizados
    public function update($id, $nombre, $descripcion, $descripcion_corta, $comunidad, $modalidad, $categoria, $fecha_inicio, $fecha_fin, $lugar, $imagen = null, $link = '', $estado = 1)
    {
        if ($imagen !== null) {
            $sql = "UPDATE {$this->table}
                    SET nombre = ?, descripcion = ?, descripcion_corta = ?, comunidad = ?, modalidad = ?, categoria = ?, 
                        fecha_inicio = ?, fecha_fin = ?, lugar = ?, imagen = ?, link = ?, estado = ?
                    WHERE id_Evento = ?";
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt)
                return false;
            
            // 13 parámetros: 11 strings + 2 integers (estado, id)
            $stmt->bind_param('sssssssssssii', $nombre, $descripcion, $descripcion_corta, $comunidad, $modalidad, $categoria, $fecha_inicio, $fecha_fin, $lugar, $imagen, $link, $estado, $id);
        } else {
            $sql = "UPDATE {$this->table}
                    SET nombre = ?, descripcion = ?, descripcion_corta = ?, comunidad = ?, modalidad = ?, categoria = ?, 
                        fecha_inicio = ?, fecha_fin = ?, lugar = ?, link = ?, estado = ?
                    WHERE id_Evento = ?";
            $stmt = $this->mysqli->prepare($sql);
            if (!$stmt)
                return false;
            
            // 12 parámetros: 10 strings + 2 integers (estado, id)
            $stmt->bind_param('ssssssssssii', $nombre, $descripcion, $descripcion_corta, $comunidad, $modalidad, $categoria, $fecha_inicio, $fecha_fin, $lugar, $link, $estado, $id);
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
