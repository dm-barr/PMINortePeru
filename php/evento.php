<?php
class EventoModel_mysqli {
    private $mysqli;
    private $table = 'Evento';
    private $host = 'localhost';
    private $dbname = 'pminorte_paginaweb';
    private $username = 'pminorte_admin';
    private $password = 'm$GYzHub$}Ov';

    public function __construct() {
        $this->mysqli = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        if ($this->mysqli->connect_error) {
            die('Error de conexión (' . $this->mysqli->connect_errno . ') ' . $this->mysqli->connect_error);
        }

        $this->mysqli->set_charset("utf8mb4");
    }    

    public function __destruct() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    // Obtener todos los eventos
    public function getAll() {
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
    // Crear evento
    public function create($nombre, $descripcion, $comunidad, $modalidad, $categoria, $lugar, $imagen) {
        $fecha = date('Y-m-d');
        $sql = "INSERT INTO {$this->table} (nombre, descripcion, comunidad, fecha, modalidad, categoria, lugar, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;
        $stmt->bind_param('ssssssss', $nombre, $descripcion, $comunidad, $fecha, $modalidad, $categoria, $lugar, $imagen);
        return $stmt->execute();
    }

    // Actualizar por ID
    public function update($id, $nombre, $descripcion, $comunidad, $modalidad, $categoria, $lugar, $imagen = null) {
      if($imagen !== null) {
        $sql = "UPDATE {$this->table} SET nombre = ?, descripcion = ?, comunidad = ?, modalidad = ?, categoria = ?, lugar = ?, imagen = ? WHERE id_Evento = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;
        $stmt->bind_param('sssssssi', $nombre, $descripcion, $comunidad, $modalidad, $categoria, $lugar, $imagen, $id);
      }else {
        $sql = "UPDATE {$this->table} SET nombre = ?, descripcion = ?, comunidad = ?, modalidad = ?, categoria = ?, lugar = ? WHERE id_Evento = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;
        $stmt->bind_param('ssssssi', $nombre, $descripcion, $comunidad, $modalidad, $categoria, $lugar, $id);
      }
      return $stmt->execute();
    }
    // Eliminar por ID
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id_Evento = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
    // Obtener evento por ID
    public function getById($id) {
        $sql =  "SELECT * FROM {$this->table} WHERE id_Evento = ?";
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