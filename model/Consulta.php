<?php

session_start();

class Consulta {

    private $paciente;
    private $procedimento;
    private $medico;
    private $data_agendamento;
    private $horario_agendamento;
    private $conexao;

    public function __construct($paciente, $procedimento, $medico, $data_agendamento,$horario_agendamento) {
        $this->paciente = $paciente;
        $this->procedimento = $procedimento;
        $this->medico = $medico;
        $this->data_agendamento = $data_agendamento;
        $this->horario_agendamento = $horario_agendamento;
        $this->conexao = new Conexao();
    }

    public function adiciona() {

        $default = "DEFAULT";
        $sql = "INSERT INTO CONSULTA VALUES ({$default},?,?,?,?,?)";
        $stmt = $this->conexao->prepare($sql);

        $bind = array(
            $this->paciente,
            $this->procedimento,
            $this->medico,
            $this->data_agendamento,
            $this->horario_agendamento
        );

        $stmt->execute($bind);
    }
    
    public function delete($cod) {
        $sql = "DELETE FROM CONSULTA WHERE ID = {$cod}";
        $resultado = $this->conexao->exec($sql);
//        $resultado =  $this->conexao->query($sql);
        return $resultado;
        
    }

    public function update($cod) {

        $sql = "UPDATE CONSULTA SET DATA_AGENDAMENTO = ?, HORARIO = ? WHERE ID = {$cod} ";
        $stmt = $this->conexao->prepare($sql);
        $bind = array(
        $this->data_agendamento,
        $this->horario_agendamento
        );

        $stmt->execute($bind);
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function getProcedimento() {
        return $this->procedimento;
    }

    public function getMedico() {
        return $this->medico;
    }

    public function getData_atendimento() {
        return $this->data_atendimento;
    }

    public function setPaciente($paciente) {
        $this->paciente = $paciente;
    }

    public function setProcedimento($procedimento) {
        $this->procedimento = $procedimento;
    }

    public function setMedico($medico) {
        $this->medico = $medico;
    }

    public function setData_atendimenot($data_atendimento) {
        $this->data_atendimento = $data_atendimento;
    }

}
