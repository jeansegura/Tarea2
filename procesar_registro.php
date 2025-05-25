<?php
session_start();
require_once "conexion.php";

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$fecha = $_POST['fecha'];
$edad = (int)$_POST['edad'];
$correo = $_POST['correo'];
$clave = $_POST['clave'];
$clave2 = $_POST['clave2'];

$_SESSION['datos_ingresados'] = [
    "nombre" => $nombre,
    "usuario" => $usuario,
    "fecha" => $fecha,
    "edad" => $edad,
    "correo" => $correo
];

function es_clave_segura($clave) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $clave);
}

if ($clave !== $clave2) {
    $_SESSION['mensaje_error'] = "⚠️ Las contraseñas no coinciden.";
    header("Location: registro.php");
    exit;
}
if (!es_clave_segura($clave)) {
    $_SESSION['mensaje_error'] = "⚠️ Contraseña insegura.";
    header("Location: registro.php");
    exit;
}
if ($edad < 18) {
    $_SESSION['mensaje_error'] = "⚠️ Debes ser mayor de edad.";
    header("Location: registro.php");
    exit;
}

$res = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? OR usuario = ?");
$res->bind_param("ss", $correo, $usuario);
$res->execute();
$res->store_result();
if ($res->num_rows > 0) {
    $_SESSION['mensaje_error'] = "⚠️ Correo o usuario ya registrado.";
    header("Location: registro.php");
    exit;
}

$clave_hash = password_hash($clave, PASSWORD_BCRYPT);
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, fecha_nacimiento, edad, correo, clave) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss", $nombre, $usuario, $fecha, $edad, $correo, $clave_hash);
$stmt->execute();

unset($_SESSION['datos_ingresados']);
echo " Registro exitoso. <a href='login.php'>Inicia sesión</a>";
