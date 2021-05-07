<?php

include("../utils/autoload.php");

$conexao = new Conexao();
$sql = "SELECT * FROM CONSULTA WHERE ID = {$_GET["cod"]}";

$resultado_consulta = $conexao->query($sql)->fetch(PDO::FETCH_ASSOC);

$consulta = new Consulta($resultado_consulta["paciente_id"], $resultado_consulta["procedimento_id"], $resultado_consulta["medico_id"], $resultado_consulta["data_agendamento"], $resultado_consulta["horario"]);

$sql_registro = "DELETE FROM REGISTRO_ATENDIMENTO WHERE CONSULTA_ID = {$_GET["cod"]}";
$conexao->query($sql_registro)->fetch(PDO::FETCH_ASSOC);

$resultado = $consulta->delete(intval($_GET["cod"]));
print($resultado);

if ($resultado){
    header("location: consultas_realizadas_view.php");
}else{
    header("location: consultas_realizadas_view.php");
}



