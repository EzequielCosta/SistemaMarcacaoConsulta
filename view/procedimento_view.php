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
                <h3 style="color: #007bff; text-align: center; margin-top: 20px;" >Listas de Procedimentos</h3>;
                <?php
                try {

                    if (isset($_SESSION["erro_delete"]) && $_SESSION["erro_delete"]) {
                        echo '<div class="alert alert-danger" style="margin: 10px auto 10px auto; width: 50%; text-aligh:center">';
                        echo '<strong style = "text-aligh: center;">O procedimento faz parte de uma consulta! </strong>';
                        echo '</div>';
                        echo '<script>alerta();</script>';
                        $_SESSION["erro_delete"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_delete"] = false;
                }
                ?> 
                <input style="width: 95%; margin-left: auto; margin-right: auto;" class="form-control" id="filtro" type="text" placeholder="Busca">
                <?php
                echo "<table class = 'table' style = 'width: 95%; margin-top: 20px;'>";
                echo "<thead class = 'thead-light'>";
                echo "<tr>";
                echo "<th scope = 'col'>Código do Procedimento</th>";
                echo "<th scope = 'col'>Nome do Procedimento</th>";
                echo "<th scope = 'col'>Idade mínima</th>";
                echo "<th scope = 'col'>Idade máxima</th>";
                echo "<th scope = 'col'>Sexo</th>";
                echo "<th scope = 'col'></th>";
                echo "<th scope = 'col'></th>";
                echo "</tr>";
                echo "</thead>";

                echo "<tbody id = 'table'>";

                $conexao = new Conexao();
                $sql = "SELECT *,P.ID AS P_ID FROM PROCEDIMENTO P JOIN COD_PROCEDIMENTO CP ON P.ID = CP.PROCEDIMENTO_ID ;";
                $result = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);


                foreach ($result as $i) {


                    echo "<tr>";
                    echo "<th scope = 'row'>" . $i["codigo"] . "</th>";

                    echo "<td>" . $i["nome"] . "</td>";
                    echo "<td style = 'text-align: center'>" . $i["idade_minima"] . "</td>";
                    echo "<td style = 'text-align: center'>" . $i["idade_maxima"] . "</td>";
                    echo "<td>" . $i["sexo"] . "</td>";
                    echo "<td><a href='atualizar_procedimento_view.php?cod=" . $i['p_id'] . "' >Atualizar dados</a></td>";
                    echo "<td><a  href='deletar_procedimento.php?cod=" . $i['p_id'] . "' value='deleta' >Deletelar dados</a></td>";
                    echo "</tr>";
                    $_SESSION["cod_proced"] = $i["p_id"];
                }
                echo "</tbody>";
                echo "</table>";
                //session_destroy();
                ?>
                <script>
                  
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

