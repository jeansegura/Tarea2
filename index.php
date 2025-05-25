<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Bienvenido al sistema</h1>
  <p>Hola, <strong><?= htmlspecialchars($_SESSION['nombre']) ?></strong>. Has iniciado sesión correctamente.</p>
  <p><a href="logout.php">Cerrar sesión</a></p>
</body>
</html>
