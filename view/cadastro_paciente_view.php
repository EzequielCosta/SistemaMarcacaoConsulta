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
            </div

            <div>
                <?php
                try {

                    if (isset($_SESSION["cpf_invalido_paciente"]) && $_SESSION["cpf_invalido_paciente"]) {
                        echo '<div class="alert alert-danger" style="margin: 50px auto 0px auto; width: 50%;">';
                        echo '<strong>O CPF digitado não é válido ou já foi cadastrado! </strong>';
                        echo '</div>';
                        $_SESSION["cpf_invalido_paciente"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["cpf_invalido_paciente"] = false;
                }
                ?>      
            </div>

            <div style="margin-top: 70px;" class="container">
                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Cadastro de Paciente</h3>
                <form action="../controller/PacienteController.php" method="POST" class="needs-validation" novalidate>

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="nome_paciente">Nome </label>
                                <input type="text" class="form-control" autocomplete="off" minlength="10" maxlength="50" id="nome_paciente" name="nome_paciente" placeholder="Nome completo" required>
                            </div>

                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="cpf_paciente">CPF </label>
                                <input type="text" class="form-control" autocomplete="off" maxlenght="14" id="cpf_paciente" name="cpf_paciente" maxlength="14" placeholder="CPF" onkeypress="this.value = mascara(event);"  required>
                            </div>
                        </div>


                    </div>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="idade_paciente">Data de Nascimento: </label>
                                <input type="date" class="form-control" autocomplete="off" id="idade_paciente" name="idade_paciente" placeholder="Idade" required>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="telefone_paciente">Telefone: </label>
                                <input type = "text" class="form-control" autocomplete="off"  maxlenght="20" id="telefone_paciente" name="telefone_paciente" placeholder="Telefone" required>
                            </div>
                        </div>

                        <div class="col-sm">

                            <div class="form-group">
                                <label for="sexo_paciente">Sexo: </label>
                                <select class="form-control custom-select" id="sexo_paciente" name="sexo_paciente" required>
                                    <option value="masculino" >Masculino</option>
                                    <option value="feminino" >Feminino</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="email_paciente">Email </label>
                                <input type="email" class="form-control" autocomplete="off"  maxlength="150"  id="nome_paciente" name="email_paciente" placeholder="Email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="logradouro_paciente">Logradouro: </label>
                                <input type="text" class="form-control" autocomplete="off" maxlength="45" id="logradouro_paciente" name="logradouro_paciente" placeholder="Logradouro" required>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="numero_paciente">Número: </label>
                                <input type = "text" class="form-control" autocomplete="off" maxlength="10" id="numero_paciente" name="numero_paciente" placeholder="Numero" required>
                            </div>
                        </div>


                        <div class="col-sm">

                            <div class="form-group">
                                <label for="bairro_paciente">Bairro: </label>
                                <input type = "text" class="form-control" autocomplete="off" maxlength="50" id="bairro_paciente" name="bairro_paciente" placeholder="Bairro" required>
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

                    function mascara(evt)
                    {
                        value = (navigator.appName === "Netscape") ? evt.target.value : evt.srcElement.value;
                        const cnpjCpf = value.replace(/\D/g, '');
                        return cnpjCpf.replace(/(\d{3})(\d{3})(\d{3})(\d{1})/g, "\$1.\$2.\$3-\$4");
                    }

                </script>

            </div>

        </div>
    </body>
</html>
