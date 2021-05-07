<?php
session_start();
include("../utils/autoload.php");
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

            <div id="consultas">

                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Consultas Pendentes</h3>;
                <?php
                try {

                    if (isset($_SESSION["erro_data"]) && $_SESSION["erro_data"]) {
                        echo '<div class="alert alert-danger" style="margin: 10px auto 20px auto; width: 50%;">';
                        echo '<strong>Data/Horário de agendamento é menor que a data de hoje! </strong>';
                        echo '</div>';
                        unset($_SESSION["erro_data"]);
                    }
                } catch (Exception $e) {
                    unset($_SESSION["erro_data"]);
                }

                try {

                    if (isset($_SESSION["erro_data_reagendar"]) && $_SESSION["erro_data_reagendar"]) {
                        echo '<div class="alert alert-danger" style="margin: 10px auto 20px auto; width: 50%;">';
                        echo '<strong>Esta consulta já aconteceu, dirija-se ao <a style = "color : #1769B3;" href=registro_atendimento_view.php#">Registro de Atendimento</a>! </strong>';
                        echo '</div>';
                        unset($_SESSION["erro_data_reagendar"]);
                    }
                } catch (Exception $e) {
                    unset($_SESSION["erro_data_reagendar"]);
                }
                ?>
                
                <input style="width: 95%; margin-left: auto; margin-right: auto;" class="form-control" id="filtro" type="text" placeholder="Busca">
                <?php
                echo "<table  style='width: 95%; margin-top: 10px;' class = 'table'>";
                echo "<thead class = 'thead-light'>";
                echo "<tr>";
                echo "<th scope = 'col'>Código da Consulta</th>";
                echo "<th scope = 'col'>Nome do Paciente</th>";
                echo "<th scope = 'col'>CPF do Paciente</th>";
                echo "<th scope = 'col'>Procedimento</th>";
                echo "<th scope = 'col'>Data de Atendimento</th>";
                echo "<th scope = 'col'>Horário de Atendimento</th>";
                echo "<th scope = 'col'>Nome do médico</th>";
                echo "<th scope = 'col'></th>";
                echo "<th scope = 'col'></th>";
                echo "</tr>";
                echo "</thead>";

                echo "<tbody id = 'table'>";

                date_default_timezone_set('America/Fortaleza');
                $now = date('Y/m/d');
                $now_array = explode("/", $now);
                $now_formatada = implode("-", $now_array);
                $horario = date('H:i:s');

                $agora = new DateTime($now_formatada);
                $conexao = new Conexao();
                $sql_consulta = "SELECT *,CON.ID AS ID FROM CONSULTA AS CON LEFT JOIN REGISTRO_ATENDIMENTO AS RA ON CON.ID = RA.CONSULTA_ID WHERE CONSULTA_ID IS NULL";

                $result_consulta = $conexao->query($sql_consulta)->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result_consulta as $elemento) {

                    $data = new DateTime($elemento["data_agendamento"]);



                    echo "<tr>";
                    echo "<th style = 'text-align: center' scope = 'row'>" . $elemento["id"] . "</th>";

                    $sql_paciente = "SELECT NOME,CPF FROM PACIENTE WHERE ID={$elemento["paciente_id"]}";
                    $result_paciente = $conexao->query($sql_paciente)->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result_paciente as $paciente) {
                        echo "<td>" . $paciente["nome"] . "</td>";
                        echo "<td class ='cpf_paciente' >  " . $paciente["cpf"] . "</td>";
                    }

                    $sql_procedimento = "SELECT NOME FROM PROCEDIMENTO WHERE ID={$elemento["procedimento_id"]}";
                    $result_procedimento = $conexao->query($sql_procedimento)->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result_procedimento as $procedimento) {
                        echo "<td>" . $procedimento["nome"] . "</td>";
                    }

                    echo "<td style = 'text-align: center'>" . $elemento["data_agendamento"] . "</td>";
                    echo "<td style = 'text-align: center'>" . $elemento["horario"] . "</td>";

                    $sql_medico = "SELECT NOME FROM MEDICO WHERE ID={$elemento["medico_id"]}";
                    $result_medico = $conexao->query($sql_medico)->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result_medico as $medico) {
                        echo "<td>" . $medico["nome"] . "</td>";
                    }

                    echo "<td><a href='reagendar_consulta_view.php?cod=" . $elemento['id'] . "' >Reagendar</a></td>";
                    echo "<td><a href='deletar_consulta_pendentes.php?cod=" . $elemento['id'] . "' >Deletar</a></td>";

                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
                ?>
                <script>
                    window.onload = function () {
                        var tags = document.getElementsByClassName("cpf_paciente");
                        for (i = 0; i < tags.length; i++) {
                            var content = tags[i].innerHTML;
                            const cnpjCpf = content.replace(/\D/g, '');

                            tags[i].innerHTML = cnpjCpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3-\$4");
                            ;
                        }
                    }

                    $(document).ready(function () {
                        $("#filtro").on("keyup", function () {
                            var value = $(this).val().toLowerCase();
                            $("#table tr").filter(function () {
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                            });
                        });
                    });

                </script>
            </div>
        </div>
    </body>
</html>
