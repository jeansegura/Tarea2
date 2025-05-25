<?php
session_start();
require_once "conexion.php";

$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$id_curso = $_POST['id_curso'];

$verifica = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? AND correo = ?");
$verifica->bind_param("ss", $usuario, $correo);
$verifica->execute();
$verifica->store_result();

$titulo = "";
$mensaje = "";
$tipo = ""; // success | warning | error

if ($verifica->num_rows === 1) {
    $verifica->bind_result($id_usuario);
    $verifica->fetch();

    $check = $conn->prepare("SELECT id FROM inscripciones WHERE id_usuario = ? AND id_curso = ?");
    $check->bind_param("ii", $id_usuario, $id_curso);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $titulo = "Ya estás inscrito";
        $mensaje = "Ya estás inscrito en este curso.";
        $tipo = "warning";
    } else {
        $fecha = date("Y-m-d");
        $insert = $conn->prepare("INSERT INTO inscripciones (id_usuario, id_curso, fecha_inscripcion) VALUES (?, ?, ?)");
        $insert->bind_param("iis", $id_usuario, $id_curso, $fecha);
        $insert->execute();

        $titulo = "¡Inscripción exitosa!";
        $mensaje = "Te has inscrito correctamente al curso.";
        $tipo = "success";
    }

} else {
    $titulo = "Error de autenticación";
    $mensaje = "Usuario o correo incorrecto.";
    $tipo = "error";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado de inscripción</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .resultado {
      max-width: 500px;
      margin: 80px auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    .resultado.success { border-left: 5px solid #4CAF50; }
    .resultado.warning { border-left: 5px solid #FFC107; }
    .resultado.error { border-left: 5px solid #F44336; }
    .resultado h2 {
      margin-top: 0;
    }
    .resultado p {
      font-size: 1.1em;
      margin-bottom: 20px;
    }
    .resultado a {
      padding: 10px 20px;
      background: #1e88e5;
      color: white;
      text-decoration: none;
      border-radius: 5px;
    }
    .resultado a:hover {
      background: #0d47a1;
    }
  </style>
</head>
<body>

<div class="resultado <?= $tipo ?>">
  <h2><?= $titulo ?></h2>
  <p><?= $mensaje ?></p>
  <a href="cursos.php">Volver a los cursos</a>
</div>

</body>
</html>
