<?php
session_start();
$mensaje = $_SESSION['mensaje_error'] ?? "";
$datos = $_SESSION['datos_ingresados'] ?? [
    "nombre" => "", "usuario" => "", "fecha" => "", "edad" => "", "correo" => ""
];
unset($_SESSION['mensaje_error'], $_SESSION['datos_ingresados']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Crear cuenta</h2>
  <?php if ($mensaje): ?>
    <p class="alert"><?= $mensaje ?></p>
  <?php endif; ?>
  <form action="procesar_registro.php" method="post">
    <input type="text" name="nombre" placeholder="Nombre completo" required value="<?= htmlspecialchars($datos['nombre']) ?>">
    <input type="text" name="usuario" placeholder="Nombre de usuario" required value="<?= htmlspecialchars($datos['usuario']) ?>">
    <input type="date" name="fecha" required value="<?= htmlspecialchars($datos['fecha']) ?>">
    <input type="number" name="edad" placeholder="Edad" required value="<?= htmlspecialchars($datos['edad']) ?>">
    <input type="email" name="correo" placeholder="Correo electrónico" required value="<?= htmlspecialchars($datos['correo']) ?>">
    <input type="password" name="clave" placeholder="Contraseña" required>
    <input type="password" name="clave2" placeholder="Repite la contraseña" required>
    <button type="submit">Registrarse</button>
  </form>
  <p><a href="login.php">¿Ya tienes cuenta? Inicia sesión</a></p>
</body>
</html>
