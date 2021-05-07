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
                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Listas de Pacientes</h3>;

                <div>
                    <?php
                    try {

                        if (isset($_SESSION["erro_delete"]) && $_SESSION["erro_delete"]) {
                            echo '<div class="alert alert-danger" style="margin: 10px auto 10px auto; width: 50%;">';
                            echo '<strong style="text-align: center">Paciente está cadastrado em uma consulta! </strong>';
                            echo '</div>';
                            unset($_SESSION["erro_delete"]);
                        }
                    } catch (Exception $e) {
                        unset($_SESSION["erro_delete"]);
                    }
                    ?>   
                </div>

                <input style="width: 95%; margin-left: auto; margin-right: auto;" class="form-control" id="filtro" type="text" placeholder="Busca">
                <?php
                echo "<table class = 'table' style = 'width: 95%; margin-top: 20px;'>";
                echo "<thead class = 'thead-light'>";
                echo "<tr>";
                echo "<th scope = 'col'>Código do Paciente</th>";
                echo "<th scope = 'col'>Nome do Paciente</th>";
                echo "<th scope = 'col'>CPF do Paciente</th>";
                echo "<th scope = 'col'>Cartão do SUS</th>";
                echo "<th scope = 'col'>Data de Nasc.</th>";
                echo "<th scope = 'col'>Sexo</th>";
                echo "<th scope = 'col'></th>";
                echo "<th scope = 'col'></th>";
                echo "<th scope = 'col'></th>";
                echo "</tr>";
                echo "</thead>";

                echo "<tbody id = 'table'>";

                $conexao = new Conexao();
                $sql = "SELECT * FROM PACIENTE";
                $result = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);


                foreach ($result as $i) {


                    echo "<tr>";
                    echo "<th scope = 'row'>" . $i["id"] . "</th>";

                    echo "<td> <a href='ver_tudo_paciente_view.php?cod=" . $i['id'] . "' >" . $i["nome"] . "</a> </td>";
                    echo "<td class = 'cpf_paciente'>" . $i["cpf"] . "</td>";
                    echo "<td>" . $i["cartao_sus"] . "</td>";
                    echo "<td>" . $i["data_nascimento"] . "</td>";
                    echo "<td>" . $i["sexo"] . "</td>";
                    echo "<td><a href='atualizar_paciente_view.php?cod=" . $i['id'] . "' >Atualizar dados</a></td>";
                    echo "<td><a  href='deleta_paciente.php?cod=" . $i['id'] . "' value='deleta' >Deletelar dados</a></td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                //session_destroy();
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
                                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                            });
                        });
                    });

                </script>
            </div>
        </div>
    </body>
</html>

