<?php
ob_start();
session_start();

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la sesión
session_destroy();

// Limpiar buffer y redirigir
ob_end_clean();
header('Location: login.php');
exit;
?>
