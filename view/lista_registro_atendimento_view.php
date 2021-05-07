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
            </div

            <div id="consultas">

                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Histórico de registro de atendimento</h3>;
                <?php
                try {

                    if (isset($_SESSION["erro_data"]) && $_SESSION["erro_data"]) {
                        echo '<div class="alert alert-danger" style="margin: 10px auto 20px auto; width: 50%;">';
                        echo '<strong>Data de agendamento é menor que a data de hoje! </strong>';
                        echo '</div>';
                        $_SESSION["erro_data"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_data"] = false;
                }
                ?>
                <input style="width: 95%; margin-left: auto; margin-right: auto;" class="form-control" id="filtro" type="text" placeholder="Busca">
                <?php
                echo "<table style='width: 95%; margin-top: 10px;' class = 'table'>";
                echo "<thead class = 'thead-light'>";
                echo "<tr>";
                echo "<th scope = 'col'>Cód. Registro Atendimento</th>";
                echo "<th scope = 'col'>Cód. Consulta</th>";
                echo "<th scope = 'col'>Nome do Paciente</th>";
                echo "<th scope = 'col'>CPF do Paciente</th>";
                echo "<th scope = 'col'>Nome do Médico</th>";
                echo "<th scope = 'col'>CPF do Médico</th>";
                echo "<th scope = 'col'>Data Efetiva</th>";
                echo "<th scope = 'col'>Horário Efetivo</th>";

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
                $sql_procedimento = "SELECT RA.ID AS RA_ID,CON.ID AS CON_ID, P.NOME AS P_NOME,M.NOME AS M_NOME,P.CPF AS P_CPF,M.CPF AS M_CPF,DATA_AGENDAMENTO,DATA_EFETIVA,OBS,SITUACAO,CARTAO_SUS,HORARIO_EFETIVO,HORARIO FROM CONSULTA CON JOIN REGISTRO_ATENDIMENTO RA ON CON.ID = RA.CONSULTA_ID JOIN PACIENTE P ON CON.PACIENTE_ID = P.ID JOIN MEDICO M ON M.ID = CON.MEDICO_ID";

                $result_procedimento = $conexao->query($sql_procedimento)->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result_procedimento as $elemento) {

                    echo "<tr>";
                    echo "<th style='text-align: center' scope = 'row'><a href='ver_tudo_registro_atendimento_view.php?cod=" . $elemento['ra_id'] . "' >" . $elemento["ra_id"] . "</a></th>";
                    echo "<td style='text-align: center' >" . $elemento["con_id"] . "</td>";
                    echo "<td>" . $elemento["p_nome"] . "</td>";
                    echo "<td class ='cpf_paciente' >  " . $elemento["p_cpf"] . "</td>";

                    echo "<td>" . $elemento["m_nome"] . "</td>";
                    echo "<td class = 'cpf_medico' >" . $elemento["m_cpf"] . "</td>";

                    echo "<td>" . $elemento["data_efetiva"] . "</td>";
                    echo "<td style='text-align: center'>" . $elemento["horario_efetivo"] . "</td>";

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

                        var tags = document.getElementsByClassName("cpf_medico");
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
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                            });
                        });
                    });


                </script>
            </div>
        </div>
    </body>
</html>
