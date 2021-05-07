<?php
session_start();
include("../utils/autoload.php");
include("../utils/mascaraCpf.php");

$conexao = new Conexao();

$sql_medico = "SELECT * FROM MEDICO WHERE CPF = '" . desformatCpf(explode(" ", $_REQUEST["cpf_medico"])[0]) . "'";

$resultado_medico = $conexao->query($sql_medico)->fetch(PDO::FETCH_ASSOC);

if (empty($resultado_medico)) {
    $_SESSION["erro_cadastro_cpf"] = true;
    header("location: agendamento_view.php");
    exit();
}

$sql_paciente = "SELECT * FROM PACIENTE WHERE CPF = '" . desformatCpf(explode(" ", $_REQUEST["cpf_paciente"])[0]) . "'";

$resultado_paciente = $conexao->query($sql_paciente)->fetch(PDO::FETCH_ASSOC);
if (empty($resultado_paciente)) {
    $_SESSION["erro_cadastro_cpf"] = true;
    header("location: agendamento_view.php");
    exit();
}

$sql_procedimento_id = "SELECT CD.CODIGO FROM PROCEDIMENTO PRO JOIN COD_PROCEDIMENTO CD  ON (PRO.ID = CD.PROCEDIMENTO_ID) WHERE PRO.NOME = '{$_REQUEST['procedimento']}'";
$result_procedimento_id = $conexao->query($sql_procedimento_id)->fetch(PDO::FETCH_ASSOC);
if (empty($result_procedimento_id)) {
    $_SESSION["erro_cadastro_cpf"] = true;
    header("location: agendamento_view.php");
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

            <?php
            $medico_id = $resultado_medico["id"];
            $paciente_id = $resultado_paciente["id"];
            ?>

            <div style="margin-top: 70px;" class="container">
                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Confirmar dados</h3>
                <?php
                echo '<form action = "../controller/AgendamentoController.php?" method = "POST" class = "needs-validation" novalidate>';
                ?>
                <fieldset>

                    <legend style="color: #0062cc">Informações do Médico</legend>


                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="nome_medico">Nome do Médico </label>
                                <?php
                                echo '<input type="text" class="form-control" id="nome_medico" name="nome_medico" value="' . $resultado_medico["nome"] . '"  readonly> '
                                ?>
                            </div>

                        </div>

                        <div class="col-sm">
                            <label for="cpf_medico">CPF do Médico </label>
                            <div class="form-group">
                                <?php
                                echo '<input type="text" class="form-control" id="cpf_medico" value="' . formatCpf($resultado_medico["cpf"]) . '" name="cpf_medico"  readonly>'
                                ?>
                            </div>
                        </div>
                    </div>


                </fieldset>

                <fieldset>

                    <legend style="color: #0062cc">Informações do Pacientes</legend>

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="nome_paciente">Nome do Paciente </label>
                                <?php
                                echo '<input type="text" class="form-control" id="nome_paciente" name="nome_paciente" value="' . $resultado_paciente["nome"] . '"  readonly> ';
                                ?>
                            </div>

                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cpf_paciente">CPF do Paciente </label>
                                <?php
                                echo '<input type="text" class="form-control" id="cpf_paciente" value="' . formatCpf($resultado_paciente["cpf"]) . '" name="cpf_paciente" readonly>'
                                ?>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cartao_sus">Cartão SUS </label>
                                <?php
                                echo '<input type="text" class="form-control" id="cartao_sus" value="' . $resultado_paciente["cartao_sus"] . '" name="cartao_sus" readonly>';
                                ?>

                            </div>
                        </div>
                    </div>


                    <div class="row">

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="idade_paciente">Data de Nascimento: </label>
                                <?php
                                echo '<input type = "text" class = "form-control" id = "idade_paciente" value="' . $resultado_paciente["data_nascimento"] . '" name = "idade_paciente"  readonly>';
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="telefone_paciente">Telefone: </label>
                                <?php
                                echo '<input type = "text" class = "form-control" id = "telefone_paciente" name = "telefone_paciente" value="' . $resultado_paciente["telefone"] . '" readonly>';
                                ?>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="email_paciente">Email </label>
                                <?php
                                echo '<input type = "email" class = "form-control" id = "nome_paciente" name = "email_paciente" value="' . $resultado_paciente["email"] . '" readonly>';
                                ?>
                            </div>
                        </div>

                        <div class="col-sm">

                            <div class="form-group">
                                <label for="sexo_paciente">Sexo: </label>
                                <?php
                                echo '<select class="form-control custom-select" id="sexo_paciente"  name="sexo_paciente" readonly>';
                                if (strtolower($resultado_paciente["sexo"]) === "masculino") {
                                    echo '<option value = "masculino" selected readonly >Masculino</option>';
                                    echo '<option value = "feminino" readonly >Feminino</option>';
                                    echo '</select>';
                                } elseif (strtolower($resultado_paciente["sexo"]) === "feminino") {
                                    echo '<option value = "masculino" readonly >Masculino</option>';
                                    echo '<option value = "feminino" selected readonly>Feminino</option>';
                                    echo '</select>';
                                }
                                ?>
                            </div>

                        </div>
                    </div>


                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="logradouro_paciente">Logradouro: </label>
                                <?php
                                echo '<input type = "text" class = "form-control" id = "logradouro_paciente" name = "logradouro_paciente" value="' . $resultado_paciente["logradouro"] . '" readonly >';
                                ?>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="numero_paciente">Número: </label>
                                <?php
                                echo '<input type = "text" class = "form-control" id = "numero_paciente" name = "numero_paciente" value="' . $resultado_paciente["numero"] . '" readonly>';
                                ?>
                            </div>
                        </div>


                        <div class="col-sm">

                            <div class="form-group">
                                <label for="bairro_paciente">Bairro: </label>
                                <?php
                                echo '<input type = "text" class = "form-control" id = "bairro_paciente" readonly name = "bairro_paciente" value="'.$resultado_paciente["bairro"].'">';
                                ?>
                            </div>

                        </div>
                    </div>
                </fieldset>

                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="procedimento">Código do Procedimento </label>
                            <?php
                            $procedimento_id = $result_procedimento_id["codigo"];
                            echo '<input type = "text" class = "form-control" id = "procedimento_id" name = "procedimento_id" value="' . $procedimento_id . '" readonly>'
                            ?>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="procedimento_nome">Procedimento </label>
                            <?php
                            echo '<input type = "text" class = "form-control" id = "procedimento_nome" name = "procedimento_nome" value="' . $_REQUEST["procedimento"] . '" readonly>';
                            ?>
                        </div>
                    </div>



                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="data_de_agendamento">Data da Consulta: </label>
                            <?php
                            echo '<input type = "date" class = "form-control" id = "data_de_agendamento" name = "data_de_agendamento" value =  "' . $_REQUEST
                            ["data_de_agendamento"] . '" readonly required>';
                            ?>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="horario_de_agendamento">Horario da Consulta: </label>
                            <?php
                            echo '<input type = "text" class = "form-control" id = "horario_de_agendamento" name = "horario_de_agendamento" value =  "' . $_REQUEST
                            ["horario_de_agendamento"] . '" readonly required>';
                            ?>
                        </div>
                    </div>
                </div>

                <div class-="row">
                    <div class="col-sm">
                        <span class="alert-danger">Caso haja informações incorretas, atualize os dados nas seções de edição de dados </span>
                    </div>

                </div>



                <div class="row">

                    <div class="col-sm"></div>

                    <div style="text-align: center; margin-top: 5%; margin-bottom: 30px;" class="col-sm">
                        <button type="submit" class="btn btn-primary">Confirmar Agendamento</button>
                    </div>

                    <div class="col-sm"></div>
                </div>

                </form>

            </div>

        </div>
    </body>
</html>
