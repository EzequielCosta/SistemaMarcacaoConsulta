<?php

include("../utils/autoload.php");

class MedicoController {

    public function __construct() {
        $this->cadastroDeMedico();
    }

    public function cadastroDeMedico() {
        try {
            $medico = new Medico($_REQUEST["nome_medico"], desformatCpf($_REQUEST["cpf_medico"]), $_REQUEST["idade_medico"], $_REQUEST["sexo_medico"], $_REQUEST["telefone_medico"], $_REQUEST["email_medico"], $_REQUEST["logradouro_medico"], $_REQUEST["numero_medico"], $_REQUEST["bairro_medico"]);
            if ($medico->adiciona()) {
                header("location: ../view/medico_view.php");
                exit();
            } else {
                $_SESSION["erro_cadastro"] = true;
                header("location: ../view/cadastro_medico_view.php");
                exit();
            }
        } catch (Exception $e) {
            header("location: ../view/cadastro_medico_view.php");
        }
    }

}

new MedicoController();
