<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
if (!isset($_SESSION['acceso'])) {
  header('location: index.php');
} else if ($_SESSION['acceso'] != "CEOAB") {
  header('location: index.php');
} else if ($_SESSION['estado'] == "I") {
  header('location: index.php');
} else if ($_SESSION['acceso'] == "CEOAB") {
  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $us = new Models\Usuarioab();
    $us->eliminar($id);
  }
  header("Location: Vusuarios_ab.php");
} 
 