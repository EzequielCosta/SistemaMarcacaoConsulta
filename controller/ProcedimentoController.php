<?php
session_start();
include("../utils/autoload.php");

class ProcedimentoController {

    public function __construct() {
        $this->cadastroDeProcedimento();
    }

    public function cadastroDeProcedimento() {
       
        try {
            $procedimento = new Procedimento($_REQUEST["nome_procedimento"], $_REQUEST["idade_minima"], $_REQUEST["idade_maxima"], $_REQUEST["sexo"]);
            
            if ($procedimento->adiciona()) {
                header("location: ../view/procedimento_view.php");
                exit();
            } else {
                $_SESSION["erro_dados"] = true;
                header("location: ../view/cadastro_procedimento_view.php");
            }
        } catch (Exception $e) {
            $_SESSION["erro_dados"] = true;
            header("location: ../view/cadastro_procedimento_view.php");
        }
    }

}

new ProcedimentoController();

