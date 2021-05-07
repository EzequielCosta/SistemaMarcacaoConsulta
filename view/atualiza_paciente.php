<?php

include("../utils/autoload.php");



$paciente = new Paciente($_REQUEST["nome_paciente"], $_REQUEST["cpf_paciente"], $_REQUEST["idade_paciente"], $_REQUEST["sexo_paciente"], $_REQUEST["telefone_paciente"], $_REQUEST["email_paciente"], $_REQUEST["logradouro_paciente"], $_REQUEST["numero_paciente"], $_REQUEST["bairro_paciente"]);

$paciente->update($_POST["codigo_paciente"], $paciente->getTelefone(), $paciente->getEmail()
        , $paciente->getLogradouro(), $paciente->getNumero(), $paciente->getBairro());



header("location: paciente_view.php");
