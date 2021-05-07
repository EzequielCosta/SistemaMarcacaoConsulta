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

            <div style="margin-top: 70px; width: 40%;" class="container">
                <h3  style="color: #007bff; text-align: center; margin-top: 20px;" >Atualizar Procedimento</h3>
                <?php
                try {

                    if (isset($_SESSION["erro_dados"]) && $_SESSION["erro_dados"]) {
                        echo '<div class="alert alert-danger" style="margin: 50px auto 0px auto; width: 50%;">';
                        echo '<strong>Procedimento já cadastrado! </strong>';
                        echo '</div>';
                        $_SESSION["erro_dados"] = false;
                    }
                } catch (Exception $e) {
                    $_SESSION["erro_dados"] = false;
                }
                ?>     
                <form action="atualiza_procedimento.php" method="POST" class="needs-validation" novalidate>
                    <?php
                    $conexao = new Conexao();
                    $sql = "SELECT * FROM PROCEDIMENTO WHERE ID = {$_GET["cod"]}";
                    $resultado = $conexao->query($sql)->fetch(PDO::FETCH_ASSOC);
                    $_SESSION["cod_proced"] = $_GET["cod"];
                    
                    ?>
                    <div class="row">
                        <div class="col-sm">
                            <div class="form-group">
                                <label for="nome_procedimento">Nome </label>
                                <?php
                                echo '<input type = "text" autocomplete="off" class = "form-control" id = "nome_procedimento" oninput = "maiusculo(event)" name = "nome_procedimento" value="' . $resultado["nome"] . '" placeholder = "Nome Procedimento" required>';
                                ?>
                            </div>

                        </div>

                    </div>


                    <div class="row">

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="idade_minima">Idade mínima </label>
                                <?php
                                echo '<input type = "text" class = "form-control" autocomplete="off" id = "idade_minima" name = "idade_minima" value = ' . $resultado["idade_minima"] . ' placeholder = "Idade mínima" required>';
                                ?>
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="form-group">
                                <label for="idade_maxima">Idade máxima </label>
                                <?php
                                echo '<input type = "text" class = "form-control" autocomplete="off" id = "idade_maxima" value = ' . $resultado["idade_maxima"] . ' name = "idade_maxima" placeholder = "Idade máxima" required>';
                                ?>
                            </div>
                        </div>


                        <div class="col-sm">

                            <div class="form-group">
                                <label for="sexo">Sexo: </label>
                                <?php
                                echo '<select class="form-control custom-select" id="sexo" name="sexo">';
                                if (strtolower($resultado["sexo"]) === "masculino") {
                                    echo '<option value = "MASCULINO" selected >Masculino</option>';
                                    echo '<option value = "FEMININO" >Feminino</option>';
                                    echo '<option value = "AMBOS" >Ambos</option>';
                                    echo '</select>';
                                } elseif (strtolower($resultado["sexo"]) === "feminino") {
                                    echo '<option value = "MASCULINO"  >Masculino</option>';
                                    echo '<option value = "FEMININO" selected >Feminino</option>';
                                    echo '<option value = "AMBOS" >Ambos</option>';
                                    echo '</select>';
                                } else {
                                    echo '<option value = "MASCULINO"  >Masculino</option>';
                                    echo '<option value = "FEMININO"  >Feminino</option>';
                                    echo '<option value = "AMBOS" selected >Ambos</option>';
                                    echo '</select>';
                                }
                                ?>
                            </div>

                        </div>
                    </div>


                    <div class="row">

                        <div class="col-sm"></div>

                        <div style="text-align: center; margin-top: 5%;" class="col-sm">
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>

                        <div class="col-sm"></div>
                    </div>

                </form>

                <script>
                    
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
                    function maiusculo(e) {
                        var ss = e.target.selectionStart;
                        var se = e.target.selectionEnd;
                        e.target.value = e.target.value.toUpperCase();
                        e.target.selectionStart = ss;
                        e.target.selectionEnd = se;
                    }
                </script>

            </div>

        </div>
    </body>
</html>
