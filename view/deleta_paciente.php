<?php

session_start();
include("../utils/autoload.php");

$conexao = new Conexao();
$sql_paciente = "DELETE FROM PACIENTE WHERE ID = {$_GET["cod"]}";
$result_paciente = $conexao->query($sql_paciente);
if ($result_paciente) {
    //$_SESSION["erro_delete"] = true;
    header("location: paciente_view.php");
} else {
    $_SESSION["erro_delete"] = true;
    header("location: paciente_view.php");
}

