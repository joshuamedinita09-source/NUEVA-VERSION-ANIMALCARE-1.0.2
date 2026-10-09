<?php
session_start();
// Destruir todas las variables de sesión
$_SESSION = array();
session_destroy();

// Redirigir al login principal
header("Location: index.php"); // O a tu archivo de acceso
exit;
?>