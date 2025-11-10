<?php
ob_start();
require_once __DIR__ . '/config/Database.php';

$correo = 'diana.barrantes@pminorteperu.org';
$password_test = 'Dimibaga_1510'; // ← Pon la contraseña que quieres probar

$db = new Database();
$conn = $db->getConnection();

$stmt = $conn->prepare("SELECT * FROM Usuario WHERE correo = ?");
$stmt->execute([$correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h2>Test de Login</h2>";
echo "<strong>Usuario encontrado:</strong> " . ($usuario ? '✅ SÍ' : '❌ NO') . "<br>";

if ($usuario) {
    echo "<strong>Nombre:</strong> {$usuario['nombre']}<br>";
    echo "<strong>Contraseña en DB (primeros 30 chars):</strong> " . substr($usuario['contrasena'], 0, 30) . "...<br>";
    echo "<strong>Password_verify resultado:</strong> " . (password_verify($password_test, $usuario['contrasena']) ? '✅ CORRECTO' : '❌ INCORRECTO') . "<br>";
}

ob_end_flush();
?>
