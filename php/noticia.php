<?php
class NoticiaModel_mysqli
{
    private $mysqli;
    private $table = 'Noticia';
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

    // Obtener todas las noticias
    public function getAll(){
        $sql = "SELECT * FROM {$this->table} ORDER BY fecha_publicacion DESC";
        $result = $this->mysqli->query($sql);

        $noticias = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $noticias[] = $row;
            }
            $result->free();
        }
        return $noticias;
    }

    // Crear noticia
    public function create($titulo, $descripcion, $imagen) {
        $fecha_publicacion = date('Y-m-d');
        $sql = "INSERT INTO {$this->table} (titulo, descripcion, imagen, fecha_publicacion) VALUES (?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        if(!$stmt) return false;
        $stmt->bind_param('ssss', $titulo, $descripcion, $imagen, $fecha_publicacion);
        return $stmt->execute();
    }

    // Actualizar noticia por ID
    public function update($id, $titulo, $descripcion, $imagen = null) {
        if ($imagen !== null) {
            // Si se proporciona imagen, se actualiza también
            $sql = "UPDATE {$this->table} SET titulo = ?, descripcion = ?, imagen = ? WHERE id = ?";
            $stmt = $this->mysqli->prepare($sql);
            if(!$stmt) return false;
            $stmt->bind_param('sssi', $titulo, $descripcion, $imagen, $id);
        } else {
            // Solo actualizar título y descripción
            $sql = "UPDATE {$this->table} SET titulo = ?, descripcion = ? WHERE id = ?";
            $stmt = $this->mysqli->prepare($sql);
            if(!$stmt) return false;
            $stmt->bind_param('ssi', $titulo, $descripcion, $id);
        }
        return $stmt->execute();
    }

    // Eliminar noticia por ID
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        if(!$stmt) return false;
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    // Obtener noticia por ID (opcional para edición)
    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->mysqli->prepare($sql);
        if(!$stmt) return null;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>
