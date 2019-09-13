<?php 
require_once "Config/Autoload.php";
Config\Autoload::run();
session_start();
    $id = $_POST['id'];
    $estado = $_POST['estado'];
    $idusuario = $_SESSION['id'];
    if (isset($_POST['estadoActual'])) {
        $adeudo = new Models\Adeudo();
        if ($estado == "R" && $_POST['estadoActual'] == "C") {
            $adeudo->editarTotalEstadoC($id, $idusuario);
            echo $adeudo;
        } else if ($estado == "C" && $_POST['estadoActual'] == "R") {
            $adeudo->editarTotalEstadoR($id, $idusuario);
            echo $adeudo;
        }
    }
?>