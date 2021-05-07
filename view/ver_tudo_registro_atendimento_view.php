<?php
session_start();
include("../utils/autoload.php");
include("../utils/mascaraCpf.php");

$conexao = new Conexao();
if (isset($_REQUEST["submit"]) && $_REQUEST["submit"] == "deletar") {
    $sql = "SELECT CONSULTA_ID FROM REGISTRO_ATENDIMENTO WHERE ID = {$_REQUEST["ra_id"]}";
    $cod_consulta = $conexao->query($sql)->fetch(PDO::FETCH_ASSOC);
    
    $sql_registro = "DELETE FROM REGISTRO_ATENDIMENTO WHERE ID = {$_REQUEST["ra_id"]}";
    $conexao->query($sql_registro)->fetch(PDO::FETCH_ASSOC);
    
    $sql_consulta = "DELETE FROM CONSULTA WHERE ID = {$cod_consulta['consulta_id']}";
    $conexao->query($sql_consulta)->fetch(PDO::FETCH_ASSOC);
    header("location: lista_registro_atendimento_view.php");
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
        $sql_procedimento = "SELECT PC.NOME AS PC_NOME ,RA.ID AS RA_ID,P.NOME AS P_NOME,M.NOME AS M_NOME,P.CPF AS P_CPF,M.CPF AS M_CPF,DATA_AGENDAMENTO,HORARIO,DATA_EFETIVA,HORARIO_EFETIVO,OBS,SITUACAO,CARTAO_SUS FROM CONSULTA CON JOIN REGISTRO_ATENDIMENTO RA ON CON.ID = RA.CONSULTA_ID JOIN PACIENTE P ON CON.PACIENTE_ID = P.ID JOIN MEDICO M ON M.ID = CON.MEDICO_ID JOIN PROCEDIMENTO PC ON PC.ID = CON.PROCEDIMENTO_ID  WHERE RA.ID = {$_GET["cod"]}";
        $resultado = $conexao->query($sql_procedimento)->fetch(PDO::FETCH_ASSOC);
        ?>

        <div style="margin-top: 70px;" class="container">
            <h3  style="color: #007bff; text-align: center; margin-top: 20px; margin-bottom: 20px" >Histórico de registro de atendimento</h3>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>" class = "needs-validation" novalidate >

                <?php
                echo '<div class = "row">';

                echo '<div class = "col-sm-3">';

                echo '<div class = "form-group">';
                echo '<label for = "ra_id">Cod. Registro de Atendimento </label>';
                echo '<input type = "text" class = "form-control" id = "ra_id" name = "ra_id" value = " ' . $resultado["ra_id"] . ' " readonly >';

                echo '</div>';

                echo '</div>';


                echo '<div class = "col-sm">';

                echo '<div class = "form-group">';
                echo '<label for = "nome_paciente">Nome </label>';
                echo '<input type = "text" class = "form-control" id = "nome_paciente" name = "nome_paciente" value = " ' . $resultado["p_nome"] . ' " readonly >';

                echo '</div>';

                echo '</div>';

                echo '<div class = "col-sm-2">';
                echo '<div class = "form-group">';
                echo '<label for = "cpf_paciente">CPF do paciente </label>';
                echo '<input type = "text" class = "form-control" id = "cpf_paciente" name = "cpf_paciente" value = "' . formatCpf($resultado["p_cpf"]) . '" readonly >';
                echo '</div>';
                echo '</div>';

                echo '<div class = "col-sm-2">';

                echo '<div class = "form-group">';
                echo '<label for = "cartao_sus">Cartão SUS </label>';
                echo '<input type = "text" class = "form-control" id = "cartao_sus" name = "cartao_sus" value = "' . $resultado["cartao_sus"] . '" readonly >';
                echo '</div>';
                echo '</div>';

                echo '</div>';


                echo '<div class = "row">';

                echo '<div class = "col-sm-4">';
                echo '<div class = "form-group">';
                echo '<label for = "nome_medico">Nome médico: </label>';
                echo '<input type = "text" class = "form-control" id = "nome_medico" name= "nome_medico"  value = "' . $resultado["m_nome"] . '" readonly>';
                echo '</div>';
                echo '</div>';

                echo '<div class = "col-sm-2">';
                echo '<div class = "form-group">';
                echo '<label for = "cpf_medico">CPF do médico: </label>';
                echo '<input type = "text" class = "form-control" id = "cpf_medico" name = "cpf_medico"  value = ' . formatCpf($resultado["m_cpf"]) . ' readonly>';
                echo '</div>';
                echo '</div>';


                echo '<div class = "col-sm-3">';

                echo '<div class = "form-group">';
                echo '<label for = "data_agendamento">Data de agendamento: </label>';
                echo '<input class = "form-control" id = "data_agendamento" name = "data_agendamento" value = ' . $resultado["data_agendamento"] . ' readonly >';
                echo '</div>';

                echo '</div>';

                echo '<div class = "col-sm-3">';

                echo '<div class = "form-group">';
                echo '<label for = "horario_agendamento">Horário de agendamento: </label>';
                echo '<input class = "form-control" id = "horario_agendamento" name = "horario_agendamento" value = ' . $resultado["horario"] . ' readonly >';
                echo '</div>';

                echo '</div>';

                echo '</div>';

                echo '<div class = "row">';

                echo '<div class = "col-sm">';

                echo '<div class = "form-group">';
                echo '<label for = "data_agendamento">Data efetiva: </label>';
                echo '<input class = "form-control" id = "data_agendamento" name = "data_agendamento" value = ' . $resultado["data_efetiva"] . ' readonly >';
                echo '</div>';

                echo '</div>';

                echo '<div class = "col-sm">';

                echo '<div class = "form-group">';
                echo '<label for = "horario_agendamento">Horário efetivo: </label>';
                echo '<input class = "form-control" id = "horario_agendamento" name = "horario_agendamento" value = ' . $resultado["horario_efetivo"] . ' readonly >';
                echo '</div>';

                echo '</div>';


                echo '<div class = "col-sm">';
                echo '<div class = "form-group">';
                echo '<label for = "situacao">Situação </label>';
                
                if ($resultado["situacao"] == "1") {
                    echo '<input type = "email" class = "form-control" id = "situacao" name = "situacao"  value = "Atendido" readonly>';
                } elseif ($resultado["situacao"] == "2") {
                    echo '<input type = "email" class = "form-control" id = "situacao" name = "situacao"   value = "Paciente Faltou" readonly>';
                } else {
                    echo '<input type = "email" class = "form-control" id = "situacao" name = "situacao"  value = "Médico faltou" readonly>';
                }

                echo '</div>';
                echo '</div>';
                echo '</div>';
                
                echo '<div class = "row">';

                echo '<div class = "col-sm">';

                echo '<div class = "form-group">';
                echo '<label for = "logradouro_paciente">Procedimento: </label>';

                echo '<input class = "form-control" value = "'.$resultado["pc_nome"].'" readonly>';
                echo '</div>';

                echo '</div>';

                echo '</div>';


                echo '<div class = "row">';

                echo '<div class = "col-sm">';

                echo '<div class = "form-group">';
                echo '<label for = "logradouro_paciente">Observações: </label>';

                echo '<textarea class = "form-control" readonly>' . $resultado["obs"] . '</textarea>';
                echo '</div>';

                echo '</div>';

                echo '</div>';
                
                

                echo '<div class = "row">';

                echo '<div class = "col-sm-4"></div>';

                echo '<div style="text-align: center;" class = "col-sm-2">';

                echo '<div class = "form-group">';
                ?>
                <button type="button" class = "btn btn-primary" onclick="document.location = 'lista_registro_atendimento_view.php'" value="ok">Voltar</button>
                <?php
                echo '</div>';

                echo '</div>';

                echo '<div  class = "col-sm-2">';

                echo '<div class = "form-group">';


                echo '<button type="submit" name="submit" class = "btn btn-primary" value="deletar">Deletar</button>';

                echo '</div>';

                echo '</div>';

                echo '<div class = "col-sm-4"></div>';

                echo '</div>';
                ?>
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
