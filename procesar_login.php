<?php
session_start();
require_once "conexion.php";

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$stmt = $conn->prepare("SELECT id, nombre, clave FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $nombre, $clave_hash);
    $stmt->fetch();

    if (password_verify($clave, $clave_hash)) {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['nombre'] = $nombre;
        header("Location: cursos.php");
        exit;
    } else {
        echo " Contraseña incorrecta. <a href='login.php'>Volver</a>";
    }
} else {
    echo " Usuario no encontrado. <a href='login.php'>Volver</a>";
}
