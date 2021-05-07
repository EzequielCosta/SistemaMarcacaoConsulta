<?php
session_start();
include("../utils/autoload.php");
include("../utils/mascaraCpf.php");

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
        $conexao = new Conexao();
        ?>

        <div style="margin-top: 70px;" class="container">
            <h3  style="color: #007bff; text-align: center; margin-top: 20px; margin-bottom: 20px" >Cadastro de Paciente</h3>

            <?php
            $sql_paciente = "SELECT * FROM PACIENTE WHERE ID = {$_GET["cod"]}";
            $result_paciente = $conexao->query($sql_paciente)->fetch(PDO::FETCH_ASSOC);
            echo '<form method="POST" action="atualiza_paciente.php" class = "needs-validation" novalidate >';

            echo '<div class = "row">';
            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "nome_paciente">Nome </label>';

            echo '<input type = "text" class = "form-control" id = "nome_paciente" name = "nome_paciente" value = " ' . $result_paciente["nome"] . ' " readonly >';
            echo '</div>';

            echo '</div>';

            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "cpf_paciente">CPF </label>';
            echo '<input type = "text" class = "form-control" id = "cpf_paciente" name = "cpf_paciente" value = "' . formatCpf($result_paciente["cpf"]) . '" readonly >';
            echo '</div>';
            echo '</div>';

            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "cartao_sus">Cartão SUS </label>';
            echo '<input type = "text" class = "form-control" id = "cartao_sus" name = "cartao_sus" value = "' . $result_paciente["cartao_sus"] . '" readonly >';
            echo '</div>';
            echo '</div>';

            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "codigo_paciente">Código Cliente </label>';
            echo '<input type = "text" class = "form-control" id = "codigo_paciente" name = "codigo_paciente" value = "' . $_GET["cod"] . '" readonly >';
            echo '</div>';
            echo '</div>';


            echo '</div>';


            echo '<div class = "row">';

            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "idade_paciente">Idade: </label>';
            echo '<input type = "date" class = "form-control" id = "idade_paciente" name = "idade_paciente" placeholder = "Idade" value = ' . $result_paciente["data_nascimento"] . ' readonly>';
            echo '</div>';
            echo '</div>';

            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "telefone_paciente">Telefone: </label>';
            echo '<input type = "text" class = "form-control" id = "telefone_paciente" name = "telefone_paciente" placeholder="Telefone" value = ' . $result_paciente["telefone"] . ' readonly>';
            echo '</div>';
            echo '</div>';


            echo '<div class = "col-sm">';

            echo '<div class = "form-group">';
            echo '<label for = "sexo_paciente">Sexo: </label>';
            echo '<select class = "form-control" id = "sexo_paciente" name = "sexo_paciente" value = ' . $result_paciente["sexo"] . ' readonly >';
            if (strtolower($result_paciente["sexo"]) === "masculino") {
                echo '<option value = "masculino" selected >Masculino</option>';
                echo '<option value = "feminino" >Feminino</option>';
                echo '</select>';
            } elseif (strtolower($result_paciente["sexo"]) === "feminino") {
                echo '<option value = "masculino"  >Masculino</option>';
                echo '<option value = "feminino" selected >Feminino</option>';
                echo '</select>';
            }
            echo '</div>';

            echo '</div>';
            echo '</div>';

            echo '<div class = "row">';
            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "email_paciente">Email </label>';
            echo '<input type = "email" class = "form-control" id = "nome_paciente" name = "email_paciente" placeholder ="Email" value = ' . $result_paciente["email"] . ' readonly>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            echo '<div class = "row">';

            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "logradouro_paciente">Logradouro: </label>';
            echo '<input type = "text" class = "form-control" id = "logradouro_paciente" name = "logradouro_paciente" placeholder = "Logradouro" value = "' . $result_paciente["logradouro"] . '" readonly >';
            echo '</div>';
            echo '</div>';

            echo '<div class = "col-sm">';
            echo '<div class = "form-group">';
            echo '<label for = "numero_paciente">Número: </label>';
            echo '<input type = "text" class = "form-control" id = "numero_paciente" name = "numero_paciente" placeholder = "Número" value = ' . $result_paciente["numero"] . ' readonly>';
            echo '</div>';
            echo '</div>';


            echo '<div class = "col-sm">';

            echo '<div class = "form-group">';
            echo '<label for = "bairro_paciente">Bairro: </label>';
            echo '<input type = "text" class = "form-control" id = "bairro_paciente" name = "bairro_paciente" placeholder = "Bairro" value = ' . $result_paciente["bairro"] . ' readonly>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
            ?>
            <div class="row">
                <div class="col-sm"></div>
                <div style="text-align: center; margin-top: 40px;" class="col-sm">
                    <button type="button" class = "btn btn-primary" onclick="document.location = 'paciente_view.php'" value="ok">Voltar</button>
                </div>
                <div class="col-sm"></div>

            </div>
        </form>'





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
