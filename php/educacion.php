<?php
    //configuracion de conexion
    $host = 'localhost'; 
    $dbname = 'pminorte_paginaweb';
    $username = 'pminorte_admin'; 
    $password = 'm$GYzHub$}Ov';

    // Conexion para la base de datos
    $conexion = new mysqli($host, $username, $password, $dbname);
    if($conexion->connect_error) {
        die("Error de conexión: " .$conexion->connet_error);
    }

    //para el registro de uno nuevo
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $curso = $_POST["curso"];
        $modalidad = $_POST["modalidad"];
        $fecha = $_POST["fecha"];
        $instructor = $_POST["instructor"];
        $descripcion = $_POST["descripcion"];
    }

    //VALIDACION
    if (!empty($curso) && !empty($modalidad) && !empty($fecha) && !empty($instructor)) {
        $sql = "INSERT INTO Educacion (curso, modalidad, fecha, instructor, descripcion)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssss", $curso, $modalidad, $fecha, $instructor, $descripcion);

        if ($stmt->execute()) {
            echo "<script>alert('Curso registrado correctamente');</script>";
        } else {
            echo "<script>alert('Error al registrar el curso');</script>";
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('Por favor, completa todos los campos obligatorios');</script>";
    }
?>