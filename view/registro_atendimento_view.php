<?php
session_start();
include("../utils/autoload.php");

if (isset($_POST["submit"]) && $_POST["submit"] == "push") {

    $conexao = new Conexao();
    $default = "DEFAULT";

    $sql_verifica_consulta = "SELECT *,CON.ID AS ID FROM CONSULTA AS CON LEFT JOIN REGISTRO_ATENDIMENTO AS RA ON CON.ID = RA.CONSULTA_ID WHERE  CON.ID = {$_REQUEST["cod_consulta"]} AND CONSULTA_ID IS NULL";
    $existe_consulta = $conexao->query($sql_verifica_consulta)->fetch(PDO::FETCH_ASSOC);

    if ($existe_consulta == false) {

        $_SESSION["erro_cadastro"] = true;
        header("location: registro_atendimento_view.php");
        exit();
    }

    date_default_timezone_set('America/Fortaleza');
    $now = date('Y/m/d');
    $now_array = explode("/", $now);
    $now_formatada = implode("-", $now_array);
    $data_bd = $existe_consulta["data_agendamento"];
    $horario_bd = $existe_consulta["horario"];
    $hoje = new DateTime($now_formatada);
    $data_consulta = new DateTime($data_bd);
    $horario = date("H:i");
   

    if (($_REQUEST["data_definitiva"] > $now_formatada)) {
        $_SESSION["data_posterior"] = true;
        header("location: registro_atendimento_view.php");
        exit();
    
    } elseif (($_REQUEST["data_definitiva"] == $now_formatada) && ($_REQUEST["horario_definitivo"] > $horario)) {
        $_SESSION["data_posterior"] = true;
        header("location: registro_atendimento_view.php");
        exit();
    } elseif ($_REQUEST["data_definitiva"] < $now_formatada) {
        if (!(($data_bd < $now_formatada) && ($data_bd <= $_REQUEST["data_definitiva"]) && $_REQUEST["horario_definitivo"] >= $horario_bd)) {
            $_SESSION["erro_data_inferior"] = true;
            header("location: registro_atendimento_view.php");
            exit();
        }
    }elseif (($_REQUEST["data_definitiva"] == $now_formatada) && ($_REQUEST["horario_definitivo"] <= $horario) ) {
        if (($data_bd > $now_formatada) || (($data_bd == $now_formatada) && ($horario_bd > $horario))){
            $_SESSION["consulta_posterior"] = true;
            header("location: registro_atendimento_view.php");
            exit(); 
        }
        elseif( ($data_bd == $now_formatada) && $horario_bd > $_REQUEST["horario_definitivo"]){
            $_SESSION["horario_inferior"] = true;
            header("location: registro_atendimento_view.php");
            exit();
        }
    }
    if ( ($_REQUEST["data_definitiva"] != $data_bd) ){
        
        if (strlen($_REQUEST["observacoes"]) == 0 || $_REQUEST["situacao"] == "1") {
            $_SESSION["erro_observacao"] = true;
            header("location: registro_atendimento_view.php");
            exit();
        }
    }

    $sql = "INSERT INTO REGISTRO_ATENDIMENTO VALUES ({$default},?,?,?,?,?)";
    $sql_consulta = "SELECT DATA_AGENDAMENTO FROM CONSULTA WHERE ID = {$_REQUEST["cod_consulta"]}";

    if ($data_bd > $now_formatada) {

        $_SESSION["erro_dados"] = true;
        header("location: registro_atendimento_view.php");
        exit();
    }

    $stm_envia = $conexao->prepare($sql);
    $bind_envia = array(
        $_REQUEST["cod_consulta"],
        $_REQUEST["situacao"],
        $_REQUEST["data_definitiva"],
        $_REQUEST["horario_definitivo"],
        $_REQUEST["observacoes"]
    );
    $a = $stm_envia->execute($bind_envia);
    header("location: consultas_realizadas_view.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>

        <title>Sistema de Gerenciamento de Consulta</title>
        <meta charset="UTF-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../utils/css/bootstrap.min.css">
        <link rel="stylesheet" href="../utils/css/bootstrap.min.css.map">
        <script src="../utils/js/jquery.js"></script>
        <script src="../utils/js/popper.min.js"></script>
        <script src="../utils/js/bootstrap.min.js"></script>
    </head>
    <body>

        <div id="container">

            <div>
                <nav id="barra" class="navbar navbar-expand-lg navbar-dark bg-info">
                    <span class="navbar-brand">Sistemas de Gerenciamento de Consulta</span>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="paciente" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Consultas
                                </a>

                                <div class="dropdown-menu" aria-labelledby="paciente">
                                    <a class="dropdown-item" href="registro_atendimento_view.php">Registro de atendimento</a>
                                    <a class="dropdown-item" href="consultas_pendentes_view.php">Consultas pendentes</a>
                                    <a class="dropdown-item" href="consultas_realizadas_view.php">Consultas realizadas</a>
                                    <a class="dropdown-item" href="agendamento_view.php">Agendar consulta</a>
                                    <a class="dropdown-item" href="lista_registro_atendimento_view.php">Histórico de Registros de Atendimento</a>

                                </div>

                            </li>


                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="paciente" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Paciente
                                </a>

                                <div class="dropdown-menu" aria-labelledby="paciente">
                                    <a class="dropdown-item" href="paciente_view.php">Pacientes Cadastrados</a>
                                    <a class="dropdown-item" href="cadastro_paciente_view.php">Cadastrar Pacientes</a>

                                </div>

                            </li>


                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="medico" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Médico
                                </a>

                                <div class="dropdown-menu" aria-labelledby="medico">
                                    <a class="dropdown-item" href="medico_view.php">Médicos Cadastrados</a>
                                    <a class="dropdown-item" href="cadastro_medico_view.php">Cadastrar Médicos</a>

                                </div>

                            </li>

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="medico" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Procedimento
                                </a>

                                <div class="dropdown-menu" aria-labelledby="medico">
                                    <a class="dropdown-item" href="procedimento_view.php">Lista de Procedimentos</a>
                                    <a class="dropdown-item" href="cadastro_procedimento_view.php">Cadastrar Procedimentos</a>

                                </div>

                            </li>



                            <li>
                                <div style="width: 100px;"> </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>

            <div style="margin-top: 70px; width: 40%;" class="container">
                <h3  style="color: #007bff; text-align: center; margin-top: 20px; margin-bottom: 20px;" >Registro de Atendimento</h3>
                <?php
                try {

                    if (isset($_SESSION["consulta_posterior"]) && $_SESSION["consulta_posterior"]) {
                        echo '<div class="alert alert-danger" style="margin: 30px auto 40px auto; width: 100%;">';
                        echo '<strong>Você está tentando registrar uma consulta posterior! </strong>';
                        echo '</div>';
                        unset($_SESSION["consulta_posterior"]);
                    }
                } catch (Exception $e) {
                    unset($_SESSION["consulta_posterior"]);
                }

                try {

                    if (isset($_SESSION["erro_cadastro"]) && $_SESSION["erro_cadastro"]) {
                        echo '<div class="alert alert-danger" style="margin: 30px auto 40px auto; width: 100%;">';
                        echo '<strong>Esta consulta não existe! </strong>';
                        echo '</div>';
                        $_SESSION["erro_cadastro"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_cadastro"] = false;
                }
                try {

                    if (isset($_SESSION["erro_observacao"]) && $_SESSION["erro_observacao"]) {
                        echo '<div class="alert alert-danger" style="margin: 30px auto 40px auto; width: 100%;">';
                        echo '<strong>Você deve selecionar o ausente e preencher o campo de obdervação ! </strong>';
                        echo '</div>';
                        $_SESSION["erro_observacao"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_observacao"] = false;
                }
                try {

                    if (isset($_SESSION["erro_data_inferior"]) && $_SESSION["erro_data_inferior"]) {
                        echo '<div class="alert alert-danger" style="margin: 30px auto 40px auto; width: 100%;">';
                        echo '<strong>Você digitou uma data/horário inválidos para este registro </strong>';
                        echo '</div>';
                        unset($_SESSION["erro_data_inferior"]);
                    }
                } catch (Exception $e) {
                    unset($_SESSION["erro_data_inferior"]);
                }
                
                try {

                    if (isset($_SESSION["data_posterior"]) && $_SESSION["data_posterior"]) {
                        echo '<div class="alert alert-danger" style="margin: 30px auto 40px auto; width: 100%;">';
                        echo '<strong>Sua data/horario é maior que o atual! </strong>';
                        echo '</div>';
                        unset($_SESSION["data_posterior"]);
                    }
                } catch (Exception $e) {
                    unset($_SESSION["data_posterior"]);
                }
                
                try {

                    if (isset($_SESSION["horario_inferior"]) && $_SESSION["horario_inferior"]) {
                        echo '<div class="alert alert-danger" style="margin: 30px auto 40px auto; width: 100%;">';
                        echo '<strong>Seu horário é menor que o horário da consulta! </strong>';
                        echo '</div>';
                        unset($_SESSION["horario_inferior"]);
                    }
                } catch (Exception $e) {
                    unset($_SESSION["horario_inferior"]);
                }
                ?>     
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="needs-validation" novalidate>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cod_consulta">Código da Consulta </label>
                                <input type="text" class="form-control" autocomplete="off" pattern="[0-9]+$" id="cod_consulta"  name="cod_consulta" placeholder="Código consulta" required>
                            </div>

                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="situacao">Situação </label>
                                <select class="form-control" name="situacao" >
                                    <option value="1" selected="selected" >Paciente Atendido</option>
                                    <option value="2">Paciente Faltou</option>
                                    <option value="3">Médico Faltou</option>
                                </select>
                            </div>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="data_definitiva">Data Definitiva: </label>
                                <input  type = "date" class="form-control habilita" id="data_definitiva"  name="data_definitiva"  required>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="horario_definitivo">Horário Definitivo: </label>
                                <input  type = "time" class="form-control habilita" id="horario_definitivo" value="" name="horario_definitivo"  required>
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <label for= "observacoes" >Observações </label>
                            <textarea class="form-control habilita"  pattern="[a-z\s]+$"  name="observacoes" value=""></textarea>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm"></div>

                        <div style="text-align: center; margin-top: 5%;" class="col-sm">
                            <button style="margin-bottom: 50px" type="submit" name="submit" class="btn btn-primary" value="push" >Cadastrar</button>
                        </div>

                        <div class="col-sm"></div>
                    </div>

                </form>

                <script>
                    // Exemplo de JavaScript inicial para desativar envios de formulário, se houver campos inválidos.
                    (function () {
                        'use strict';
                        window.addEventListener('load', function () {
                            // Pega todos os formulários que nós queremos aplicar estilos de validação Bootstrap personalizados.
                            var forms = document.getElementsByClassName('needs-validation');
                            // Faz um loop neles e evita o envio
                            var validation = Array.prototype.filter.call(forms, function (form) {
                                form.addEventListener('submit', function (event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                    function maiusculo(e) {
                        var ss = e.target.selectionStart;
                        var se = e.target.selectionEnd;
                        e.target.value = e.target.value.toUpperCase();
                        e.target.selectionStart = ss;
                        e.target.selectionEnd = se;
                    }
                </script>

            </div>

        </div>
    </body>
</html>
