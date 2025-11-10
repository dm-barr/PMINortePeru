<?php
require_once __DIR__ . '/config/Database.php';

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->query("SELECT id_Usuario, nombre, correo, contrasena FROM Usuario LIMIT 5");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<h2>Usuarios en la base de datos:</h2>";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Contraseña (primeros 20 chars)</th><th>¿Hasheada?</th></tr>";

foreach ($usuarios as $usuario) {
    $es_hash = (substr($usuario['contrasena'], 0, 4) === '$2y$') ? '✅ SÍ' : '❌ NO';
    echo "<tr>";
    echo "<td>{$usuario['id_Usuario']}</td>";
    echo "<td>{$usuario['nombre']}</td>";
    echo "<td>{$usuario['correo']}</td>";
    echo "<td>" . substr($usuario['contrasena'], 0, 20) . "...</td>";
    echo "<td>{$es_hash}</td>";
    echo "</tr>";
}

echo "</table>";
?>
