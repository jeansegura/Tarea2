<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Iniciar sesión</h2>
  <form action="procesar_login.php" method="post">
    <input type="text" name="usuario" placeholder="Nombre de usuario" required><br>
    <input type="password" name="clave" placeholder="Contraseña" required><br>
    <button type="submit">Entrar</button>
  </form>
  <p><a href="registro.php">¿No tienes cuenta? Regístrate</a></p>
</body>
</html>
