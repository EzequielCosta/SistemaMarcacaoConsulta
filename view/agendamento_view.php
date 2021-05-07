<!DOCTYPE html>
<?php
session_start();
include("../utils/autoload.php");
include("../utils/mascaraCpf.php");
$conexao = new Conexao();
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
                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Agendamento de consulta</h3>
                <?php
                try {

                    if (isset($_SESSION["erro_cadastro_cpf"]) && $_SESSION["erro_cadastro_cpf"]) {
                        echo '<div class="alert alert-danger" style="margin: 10px auto 10px auto; width: 50%;">';
                        echo '<strong>Dados inválidos! </strong>';
                        echo '</div>';
                        $_SESSION["erro_cadastro_cpf"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_cadastro_cpf"] = false;
                }
                try {

                    if (isset($_SESSION["erro_data_agendamento"]) && $_SESSION["erro_data_agendamento"]) {
                        echo '<div class="alert alert-danger" style="margin: 10px auto 10px auto; width: 50%;">';
                        echo '<strong>Sua data de agendamento/horário é menor que a data de hoje</strong>';
                        echo '</div>';
                        $_SESSION["erro_data_agendamento"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_data_agendamento"] = false;
                }
                try {

                    if (isset($_SESSION["erro_cadastro"]) && $_SESSION["erro_cadastro"]) {
                        echo '<div class="alert alert-danger" style="margin: 10px auto 10px auto; width: 50%;">';
                        echo '<strong>Seu sexo não condiz com o procedimento</strong>';
                        echo '</div>';
                        $_SESSION["erro_cadastro"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_cadastro"] = false;
                }
                
                ?>
                <form action="confirmar_dados_agendamento.php" method="POST" class="needs-validation" novalidate>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cpf_paciente">CPF do Paciente </label>
                                <input type="text" class="form-control" autocomplete="off" list="lista_cpf_paciente" id="cpf_paciente" name="cpf_paciente" placeholder="CPF paciente" required>

                                <?php
                                $sql = "SELECT CPF,NOME FROM PACIENTE";
                                $resultado_paciente = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                                echo '<datalist  id="lista_cpf_paciente">';
                                foreach ($resultado_paciente as $elemento) {
                                    echo '<option value="' . formatCpf($elemento["cpf"]) . ' ' . $elemento["nome"] . '">';
                                }
                                echo '</datalist>';
                                ?>

                            </div>

                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cpf_medico">CPF do Médico </label>
                                <input type="text" class="form-control" autocomplete="off" list="lista_cpf_medico" id="cpf_medico" name="cpf_medico" placeholder="CPF médico" required>
                                <?php
                                $sql_medico = "SELECT CPF,NOME FROM MEDICO";
                                $resultado_medico = $conexao->query($sql_medico)->fetchAll(PDO::FETCH_ASSOC);
                                echo '<datalist  id="lista_cpf_medico">';
                                foreach ($resultado_medico as $elemento) {
                                    echo '<option value="' . formatCpf($elemento["cpf"]) . ' ' . $elemento["nome"] . '">';
                                }
                                echo '</datalist>';
                                ?>

                            </div>
                        </div>


                    </div>


                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="procedimento">Procedimento </label>
                                <input type = "text" class="form-control" autocomplete="off" list="lista_procedimento" id="procedimento" name="procedimento" placeholder="Procedimento" required>

                                <?php
                                $sql = "SELECT NOME FROM PROCEDIMENTO";
                                $resultado_procedimento = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                                echo '<datalist  id="lista_procedimento">';
                                foreach ($resultado_procedimento as $elemento) {
                                    echo '<option value="' . $elemento["nome"] . '">';
                                }
                                echo '</datalist>';
                                ?>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="data_de_agendamento">Data de Agendamento: </label>
                                <input type = "date" class="form-control" id="data_de_agendamento" name="data_de_agendamento"  required>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="horario_de_agendamento">Horario de Agendamento (FORMATO 24 HORAS) </label>
                                <input type = "time" class="form-control" id="horario_de_agendamento" name="horario_de_agendamento"  required>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-sm"></div>

                        <div style="text-align: center; margin-top: 5%;" class="col-sm">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
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
                </script>

            </div>
        </div>

    </body>
</html>
