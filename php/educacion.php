<?php
class EducacionModel_mysqli
{
    private $mysqli;
    private $table = 'Educacion';
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

    //Obtener todos los cursos
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY fecha DESC";
        $result = $this->mysqli->query($sql);

        $cursos = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cursos[] = $row;
            }
            $result->free();
        }
        return $cursos;
    }

    //Crear un nuevo curso
    public function create($curso, $modalidad, $fecha, $instructor, $descripcion)
    {
        $sql = "INSERT INTO {$this->table} (curso, modalidad, fecha, instructor, descripcion)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;

        $stmt->bind_param('sssss', $curso, $modalidad, $fecha, $instructor, $descripcion);
        return $stmt->execute();
    }

    //Actualizar curso por ID
    public function update($id, $curso, $modalidad, $fecha, $instructor, $descripcion)
    {
        $sql = "UPDATE {$this->table} 
                SET curso = ?, modalidad = ?, fecha = ?, instructor = ?, descripcion = ?
                WHERE id_Educacion = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;

        $stmt->bind_param('sssssi', $curso, $modalidad, $fecha, $instructor, $descripcion, $id);
        return $stmt->execute();
    }

    //Eliminar curso por ID
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id_Educacion = ?";
        $stmt = $this->mysqli->prepare($sql);
        if (!$stmt)
            return false;

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    //Obtener curso por ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id_Educacion = ?";
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
