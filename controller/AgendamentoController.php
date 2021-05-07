<?php

session_start();
include("../utils/autoload.php");
include("../utils/mascaraCpf.php");


class AgendamentoController {

    public function __construct() {
        $this->agendamentoDeConsulta();
    }

    public function agendamentoDeConsulta() {
        try {
            $conexao = new Conexao();

            date_default_timezone_set('America/Fortaleza');
            $now = date('Y/m/d');
            $now_array = explode("/", $now);
            $now_formatada = implode("-", $now_array);
            $horario = date('H:i');
            $sql_sexo_paciente = "SELECT ID,SEXO FROM PACIENTE WHERE CPF = '" . desformatCpf($_REQUEST["cpf_paciente"]) . "'";
            $resultado_paciente = $conexao->query($sql_sexo_paciente)->fetch(PDO::FETCH_ASSOC);
            if (empty($resultado_paciente)) {
                $_SESSION["erro_cadastro"] = true;
                header("location: ../view/agendamento_view.php");
                exit();
            }
            $sexo_paciente = $resultado_paciente["sexo"];
            $id_paciente = $resultado_paciente["id"];

            $sql_sexo_medico = "SELECT ID FROM MEDICO WHERE CPF = '" . desformatCpf($_REQUEST["cpf_medico"]) . "'";
            $resultado_medico = $conexao->query($sql_sexo_medico)->fetch(PDO::FETCH_ASSOC);
            $id_medico = $resultado_medico["id"];

            $sql_procedimento = "SELECT ID, SEXO FROM PROCEDIMENTO WHERE NOME = '{$_REQUEST["procedimento_nome"]}'";
            $resultado_procedimento = $conexao->query($sql_procedimento)->fetch(PDO::FETCH_ASSOC);
            $sexo_procedimento = $resultado_procedimento["sexo"];
            $id_procedimento = $resultado_procedimento["id"];

            if (($_REQUEST["data_de_agendamento"] < $now_formatada) || ( ($_REQUEST["data_de_agendamento"] == $now_formatada) && $_REQUEST["horario_de_agendamento"] < $horario)) {
                $_SESSION["erro_data_agendamento"] = true;
                header("location: ../view/agendamento_view.php");
                exit();
            }
            if (strtolower($sexo_procedimento) == "ambos" || (strtolower($sexo_paciente) == strtolower($sexo_procedimento))) {
                $consulta = new Consulta($id_paciente, $id_medico, $id_procedimento, $_REQUEST["data_de_agendamento"], $_REQUEST["horario_de_agendamento"]);
                $consulta->adiciona();
                header("location: ../view/consultas_pendentes_view.php");
                exit();
            } elseif (strtolower($sexo_paciente) != strtolower($sexo_procedimento)) {
                $_SESSION["erro_cadastro"] = true;
                header("location: ../view/agendamento_view.php");
                exit();
            }

            exit();
        } catch (Exception $e) {
            header("location: ../view/agendamento_view.php");
        }
    }

}

new AgendamentoController();

