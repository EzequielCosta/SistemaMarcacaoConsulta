<?php

include("../utils/autoload.php");

class PacienteController {

    public function __construct() {
        $this->cadastroDePaciente();
    }

    public function cadastroDePaciente() {
        try {
            $paciente = new Paciente($_REQUEST["nome_paciente"], desformatCpf($_REQUEST["cpf_paciente"]), $_REQUEST["idade_paciente"], $_REQUEST["sexo_paciente"], $_REQUEST["telefone_paciente"], $_REQUEST["email_paciente"], $_REQUEST["logradouro_paciente"], $_REQUEST["numero_paciente"], $_REQUEST["bairro_paciente"]);
            
            if ($paciente->adiciona()) {
                header("location: ../view/paciente_view.php");
                exit();
            } else {
                $_SESSION["cpf_invalido_paciente"] = true;
                header("location: ../view/cadastro_paciente_view.php");
            }
            //print($paciente->getCpf());
            //print($paciente->uniqueCPF());
            //print($paciente->validaDados());
        } catch (Exception $e) {
            $_SESSION["cpf_invalido_paciente"] = true;
            header("location: ../view/cadastro_paciente_view.php");
        }
    }

}

new PacienteController();

