<?php
session_start();
include("../utils/autoload.php");

$conexao = new Conexao();
$sql_delete_consulta = "SELECT * FROM CONSULTA WHERE PROCEDIMENTO_ID = {$_GET["cod"]}";
$delete_consulta = $conexao->query($sql_delete_consulta)->fetch(PDO::FETCH_ASSOC);
if ($delete_consulta){
    $_SESSION["erro_delete"] = true;
    header("location: procedimento_view.php");
    exit();
}

$sql_delete_cod_procedimento = "DELETE FROM COD_PROCEDIMENTO WHERE PROCEDIMENTO_ID = {$_GET["cod"]}";
$delete_resultado_cod = $conexao->query($sql_delete_cod_procedimento)->fetch(PDO::FETCH_ASSOC);

$sql_procedimento = "DELETE FROM PROCEDIMENTO WHERE ID = {$_GET["cod"]}";
$resultado = $conexao->query($sql_procedimento);
if ($resultado) {
    header("location: procedimento_view.php");
} else {
    $_SESSION["erro_delete"] = true;
    header("location: procedimento_view.php");
}


