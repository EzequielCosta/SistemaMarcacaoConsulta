<?php

session_start();
include("../utils/autoload.php");

$conexao = new Conexao();
$sql_medico = "DELETE FROM MEDICO WHERE ID = {$_GET["cod"]}";
$result_medico = $conexao->query($sql_medico);
if ($result_medico) {
    //$_SESSION["erro_delete"] = true;
    header("location: medico_view.php");
} else {
    $_SESSION["erro_delete"] = true;
    header("location: medico_view.php");
}

header("location: medico_view.php");