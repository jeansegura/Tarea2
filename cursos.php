<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$cursos = $conn->query("SELECT * FROM cursos");
$cursos_array = [];
while ($row = $cursos->fetch_assoc()) {
    $cursos_array[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cursos</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .navbar {
      background-color: #1e88e5;
      color: white;
      padding: 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: bold;
    }
    .container {
      padding: 30px;
    }
    .card-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }
    .curso-card {
      background-color: white;
      border-radius: 8px;
      padding: 20px;
      width: 300px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      cursor: pointer;
      transition: transform 0.3s;
      text-align: center;
    }
    .curso-card:hover {
      transform: scale(1.03);
    }
    .curso-card img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 6px;
      margin-bottom: 15px;
    }
    .curso-card h3 {
      margin: 0 0 10px;
      color: #1e88e5;
    }
    .modal {
      display: none;
      position: fixed;
      top: 10%;
      left: 50%;
      transform: translateX(-50%);
      background: white;
      padding: 30px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      border-radius: 10px;
      z-index: 1000;
      width: 90%;
      max-width: 600px;
    }
    .modal h2 {
      margin-top: 0;
    }
    .modal button {
      margin-top: 15px;
    }
    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      z-index: 999;
    }
  </style>
</head>
<body>

<div class="navbar">
  <div><strong>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?></strong></div>
  <div>
    <a href="cursos.php">Cursos</a>
    <a href="logout.php">Cerrar sesión</a>
  </div>
</div>

<div class="container">
  <h2>Explora los cursos disponibles</h2>
<div class="card-grid">
  <?php foreach ($cursos_array as $curso): ?>
    <?php
      $nombreCurso = strtolower($curso['nombre']);
      $imagenRuta = "img/default.jpg"; // Imagen genérica

      if ($nombreCurso === "python") {
          $imagenRuta = "img/python.jpg";
      } elseif ($nombreCurso === "html") {
          $imagenRuta = "img/html.jpg";
      } elseif ($nombreCurso === "c#") {
          $imagenRuta = "img/csharp.jpg";
      }
    ?>
    <div class="curso-card" onclick='mostrarCurso(<?= json_encode($curso, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>
      <img src="<?= $imagenRuta ?>" alt="Imagen del curso <?= htmlspecialchars($curso['nombre']) ?>">
      <h3><?= htmlspecialchars($curso['nombre']) ?></h3>
      <p><?= substr(htmlspecialchars($curso['descripcion']), 0, 60) ?>...</p>
    </div>
  <?php endforeach; ?>
</div>


<div class="overlay" onclick="cerrarModal()"></div>
<div class="modal" id="modalCurso">
  <h2 id="modalTitulo"></h2>
  <p id="modalDescripcion"></p>
  <p><strong>Fecha de inicio:</strong> <span id="modalFecha"></span></p>
  <p><strong>Duración:</strong> <span id="modalDuracion"></span> semanas</p>
  <form action="procesar_inscripcion.php" method="post">
    <input type="hidden" name="id_curso" id="inputCursoId">
    <input type="text" name="usuario" placeholder="Tu nombre de usuario" required><br>
    <input type="email" name="correo" placeholder="Tu correo" required><br>
    <button type="submit">Inscribirme</button>
  </form>
</div>

<script>
function mostrarCurso(curso) {
  document.querySelector("#modalTitulo").innerText = curso.nombre;
  document.querySelector("#modalDescripcion").innerText = curso.descripcion;
  document.querySelector("#modalFecha").innerText = curso.fecha_inicio;
  document.querySelector("#modalDuracion").innerText = curso.duracion_semanas;
  document.querySelector("#inputCursoId").value = curso.id;
  document.querySelector(".overlay").style.display = "block";
  document.querySelector(".modal").style.display = "block";
}

function cerrarModal() {
  document.querySelector(".overlay").style.display = "none";
  document.querySelector(".modal").style.display = "none";
}
</script>

</body>
</html>
