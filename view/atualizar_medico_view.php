<?php
session_start();
include("../utils/autoload.php");
$_POST["update"] = 0;
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


            <?php
            $conexao = new Conexao();
            ?>

            <div style="margin-top: 70px;" class="container">
                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Atualizar dados do médico</h3>

                <?php
                $sql_medico = "SELECT * FROM MEDICO WHERE ID = {$_GET["cod"]}";
                $result_medico = $conexao->query($sql_medico)->fetch(PDO::FETCH_ASSOC);
                echo '<form method="POST" action="atualiza_medico.php" class = "needs-validation" novalidate >';

                echo '<div class = "row">';
                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "nome_medico">Nome </label>';

                echo '<input type = "text" class = "form-control" id = "nome_medico" name = "nome_medico" value = " ' . $result_medico["nome"] . ' " readonly >';
                echo '</div>';

                echo '</div>';

                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "cpf_medico">CPF </label>';
                echo '<input type = "text" class = "form-control" id = "cpf_medico" name = "cpf_medico" value = "' . $result_medico["cpf"] . '" readonly >';
                echo '</div>';
                echo '</div>';

                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "codigo_medico">Código Médico </label>';
                echo '<input type = "text" class = "form-control" id = "codigo_medico" name = "codigo_medico" value = "' . $_GET["cod"] . '" readonly >';
                echo '</div>';
                echo '</div>';


                echo '</div>';


                echo '<div class = "row">';

                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "idade_medico">Data de Nascimento: </label>';
                echo '<input type = "text" class = "form-control" id = "idade_medico" name = "idade_medico" placeholder = "Idade" value = ' . $result_medico["data_nascimento"] . ' readonly>';
                echo '</div>';
                echo '</div>';

                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "telefone_medico">Telefone: </label>';
                echo '<input type = "text" class = "form-control" autocomplete="off" id = "telefone_medico" name = "telefone_medico" placeholder="Telefone" value = "' . $result_medico["telefone"] . '" >';
                echo '</div>';
                echo '</div>';


                echo '<div class = "col-sm">';

                echo '<div class = "form-group">';
                
                echo '<label for = "sexo_medico">Sexo: </label>';
                
                echo '<select class="form-control custom-select" id="sexo" name="sexo" readonly>';
                if (strtolower($result_medico["sexo"]) === "masculino") {
                echo '<option value = "masculino" selected >Masculino</option>';
                echo '<option value = "feminino" >Feminino</option>';
                echo '</select>';
                } elseif (strtolower($result_medico["sexo"]) === "feminino") {
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
                echo '<label for = "email_medico">Email </label>';
                echo '<input type = "email" class = "form-control" autocomplete="off" id = "nome_medico" name = "email_medico" placeholder ="Email" value = ' . $result_medico["email"] . '>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                echo '<div class = "row">';

                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "logradouro_medico">Logradouro: </label>';
                echo '<input type = "text" class = "form-control" autocomplete="off" id = "logradouro_medico" name = "logradouro_medico" placeholder = "Logradouro" value = "' . $result_medico["logradouro"] . '" >';
                echo '</div>';
                echo '</div>';
                
                

                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "numero_medico">Número: </label>';
                echo '<input type = "text" class = "form-control" autocomplete="off" id = "numero_medico" name = "numero_medico" placeholder = "Número" value = ' . $result_medico["numero"] . '>';
                echo '</div>';
                echo '</div>';


                echo '<div class = "col-sm">';

                echo '<div class = "form-group">';
                echo '<label for = "bairro_medico">Bairro: </label>';
                echo '<input type = "text" class = "form-control" autocomplete="off" id = "bairro_medico" name = "bairro_medico" placeholder = "Bairro" value = "' . $result_medico["bairro"] . '">';
                echo '</div>';

                echo '</div>';
                echo '</div>';

                echo '<div class = "row">';

                echo '<div class = "col-sm"></div>';

                echo '<div style = "text-align: center; margin-top: 5%;" class = "col-sm">';
                echo '<input type = "submit" class = "btn btn-primary" value = "Atualizar">';
                echo '</div>';

                echo '<div class = "col-sm"></div>';
                echo '</div>';

                echo '</form>';
                ?>



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
                        mascara("cpf_medico");
                    }

                </script>

            </div>

        </div>
    </body>
</html>
