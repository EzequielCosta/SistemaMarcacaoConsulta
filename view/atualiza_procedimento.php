<?php
session_start();
include("../utils/autoload.php");

$procedimento = new Procedimento($_REQUEST["nome_procedimento"], $_REQUEST["idade_minima"], $_REQUEST["idade_maxima"], $_REQUEST["sexo"]);
$procedimento->update($_SESSION["cod_proced"],$procedimento->getNome(),$procedimento->getIdade_minima(),
        $procedimento->getIdade_maxima(),$procedimento->getSexo());
unset($_SESSION["cod_proced"]);
header("location: procedimento_view.php");

