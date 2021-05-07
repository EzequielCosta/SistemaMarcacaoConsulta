<?php

include("../utils/autoload.php");

$medico = new Medico( $_REQUEST["nome_medico"],
 $_REQUEST["cpf_medico"],
 $_REQUEST["idade_medico"],
 $_REQUEST["sexo_medico"],
 $_REQUEST["telefone_medico"],
 $_REQUEST["email_medico"],
 $_REQUEST["logradouro_medico"],
 $_REQUEST["numero_medico"],
 $_REQUEST["bairro_medico"]);

$medico->update($_REQUEST["codigo_medico"], $medico->getTelefone()
, $medico->getEmail()
, $medico->getLogradouro(), $medico->getNumero(), $medico->getBairro());

header("location: medico_view.php");

