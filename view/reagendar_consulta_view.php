<!DOCTYPE html>
<?php
session_start();
include("../utils/autoload.php");
$conexao = new Conexao();

if (isset($_POST["submit"])) {
    $sql = "SELECT PROCEDIMENTO_ID,DATA_AGENDAMENTO FROM CONSULTA WHERE ID = {$_REQUEST["cod_consulta"]}";
    $resultado = $conexao->query($sql)->fetch(PDO::FETCH_ASSOC);

    date_default_timezone_set('America/Fortaleza');
    $now = date('Y/m/d');
    $now_array = explode("/", $now);
    $now_formatada = implode("-", $now_array);
    $horario = date("H:m");
    if ($resultado["data_agendamento"] < $now_formatada){
        $_SESSION["erro_data_reagendar"] = true;
        header("location: consultas_pendentes_view.php");
        exit();
    }
    elseif ($_REQUEST["data_de_consulta"] < $now_formatada || ($_REQUEST["data_de_consulta"] == $now_formatada && $_REQUEST["horario_de_consulta"] < $horario )) {
        $_SESSION["erro_data"] = true;
        header("location: consultas_pendentes_view.php");
        exit();
    }
    
    $consulta = new Consulta($_REQUEST["cod_paciente"], $resultado["procedimento_id"], $_REQUEST["cod_medico"], $_REQUEST["data_de_consulta"], $_REQUEST["horario_de_consulta"]);
    $consulta->update($_REQUEST["cod_consulta"]);
    header("location: consultas_pendentes_view.php");
    exit();
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sistemas de Gerenciamentos de Consultas</title>
        <link rel="stylesheet" href="../utils/css/bootstrap.min.css">
        <link rel="stylesheet" href="../utils/css/bootstrap.min.css.map">
        <script src="../utils/js/jquery.js"></script>
        <script src="../utils/js/popper.min.js"></script>
        <script src="../utils/js/bootstrap.min.js"></script>
        <script src="../utils/mascaraCpf.js"></script>


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

            <div style="margin-top: 70px;" class="container">
                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Agendamento de Consulta</h3>
                
                <form  method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>"  class="needs-validation" novalidate>

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cpf_paciente">CPF do Paciente </label>
                                <?php
                                $sql = "SELECT PAC.ID AS COD_PAC, MED.ID AS COD_MEDIC, PAC.CPF AS PACIENTE_CPF, MED.CPF AS MEDICO_CPF, PAC.NOME AS PACIENTE_NOME, MED.NOME AS MEDICO_NOME, PRO.NOME AS PROCED_NOME, DATA_AGENDAMENTO,HORARIO FROM (CONSULTA AS CON JOIN PACIENTE AS PAC ON CON.PACIENTE_ID = PAC.ID)  JOIN MEDICO AS MED ON CON.MEDICO_ID = MED.ID JOIN PROCEDIMENTO AS PRO ON CON.PROCEDIMENTO_ID = PRO.ID WHERE CON.ID = {$_REQUEST["cod"]};";
                                $result = $conexao->query($sql)->fetch(PDO::FETCH_ASSOC);
                                
                                echo '<input type = "text" class = "form-control" list = "lista_cpf_paciente" id = "cpf_paciente" onkeypress = "this.value = marcaraCpf(event);" name = "cpf_paciente" value= "' . $result["paciente_cpf"] . '" readonly required>';
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cod_paciente">Código do Paciente </label>

                            <?php
                            echo '<input type="text" class="form-control"  id="cod_paciente" name="cod_paciente" value="' . $result["cod_pac"] . '" readonly required>';
                            ?>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cpf_medico">CPF do Médico </label>

                                <?php
                                echo '<input type="text" class="form-control" list="lista_cpf_medico" id="cpf_medico" name="cpf_medico" value="' . $result["medico_cpf"] . '" readonly required>';
                                ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cod_medico">Código do Médico </label>

                            <?php
                            echo '<input type="text" class="form-control"  id="cod_medico" name="cod_medico" value="' . $result["cod_medic"] . '" readonly required>';
                            ?>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cod_consulta">Código da Consulta </label>
                                <?php
                                echo '<input type = "text" class="form-control" id="cod_consulta" name="cod_consulta"  value=" ' . $_GET["cod"] . ' " readonly="">';
                                ?>
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="nome_paciente">Nome do Paciente </label>
                                <?php
                                echo '<input type = "text" class = "form-control"  id = "nome_paciente" name = "nome_paciente" value= "' . $result["paciente_nome"] . '" readonly required>';
                                ?>

                            </div>

                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="nome_medico">Nome do Médico </label>

                                <?php
                                echo '<input type="text" class="form-control"  id="nome_medico" name="nome_medico" value="' . $result["medico_nome"] . '" readonly required>';
                                ?>
                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="procedimento">Procedimento </label>
                                <?php
                                echo '<input type = "text" class="form-control" list="lista_procedimento" id="procedimento" name="procedimento" value="' . $result["proced_nome"] . '" readonly required>';
                                ?>
                            </div>
                        </div>



                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="data_de_consulta">Data da Consulta: </label>
                                <?php
                                //print_r($result);
                                echo '<input type = "date" class = "form-control" value="' . $result["data_agendamento"] . '" id = "data_de_consulta" name = "data_de_consulta" required>';
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="hora_de_consulta">Horário da Consulta: </label>
                                <?php
                                echo '<input type = "time" class = "form-control" value = "' . $result["horario"] . '" id = "horario_de_consulta" name = "horario_de_consulta" required>';
                                ?>
                            </div>
                        </div>


                    </div>



                    <div class="row">

                        <div class="col-sm"></div>

                        <div style="text-align: center; margin-top: 5%;" class="col-sm">
                            <button type="submit" name="submit" class = "btn btn-primary" value="reagendar">Reagendar</button>
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
                    window.onload = function () {
                        mascara("cpf_paciente");
                    };
                </script>

            </div>
        </div>

    </body>
</html>
