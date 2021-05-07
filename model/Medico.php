<?php

session_start();
include("../utils/mascaraCpf.php");


//include("../utils/autoload.php");

class Medico {

    private $nome;
    private $cpf;
    private $idade;
    private $sexo;
    private $telefone;
    private $email;
    private $logradouro;
    private $numero;
    private $bairro;
    private $conexao;

    function __construct($nome, $cpf, $idade, $sexo, $telefone, $email, $logradouro, $numero, $bairro) {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->idade = $idade;
        $this->sexo = $sexo;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->logradouro = $logradouro;
        $this->numero = $numero;
        $this->bairro = $bairro;
        $this->conexao = new Conexao();
    }

    public function adiciona() {
        if ($this->validaDados()) {
            $default = "DEFAULT";
            $sql = "INSERT INTO MEDICO VALUES ({$default},?,?,?,?,?,?,?,?,?)";
            $stmt = $this->conexao->prepare($sql);
            $bind = array(
                $this->nome,
                $this->cpf,
                $this->idade,
                $this->sexo,
                $this->telefone,
                $this->email,
                $this->logradouro,
                $this->numero,
                $this->bairro
            );

            $stmt->execute($bind);
            return true;
        }
        return false;
    }

    public function update($cod, $telefone, $email, $logradouro, $numero, $bairro) {


        $sql = "UPDATE MEDICO SET telefone = ?, email = ?, logradouro = ?, numero = ?, bairro = ? where id = ?";
        $stmt = $this->conexao->prepare($sql);
        $bind = array(
            $telefone,
            $email,
            $logradouro,
            $numero,
            $bairro,
            $cod
        );

        $stmt->execute($bind);
    }

    private function validaDados() {
        if ($this->uniqueCPF() && $this->validaCPF()) {
            return true;
        }
        return false;
    }

    private function uniqueCPF() {
        $sql = "SELECT CPF FROM MEDICO WHERE CPF = '".desformatCpf($this->cpf)."'";
        $result = $this->conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            return false;
        } else {
            return true;
        }
    }

    function getNome() {
        return $this->nome;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getEmail() {
        return $this->email;
    }

    function getLogradouro() {
        return $this->logradouro;
    }

    function getNumero() {
        return $this->numero;
    }

    function getBairro() {
        return $this->bairro;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    function setNumero($numero) {
        $this->numero = $numero;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    private function validaCPF() {

        // Extrai somente os números
        $this->cpf = preg_replace('/[^0-9]/is', '', $this->cpf);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($this->cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $this->cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->cpf{$c} * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($this->cpf{$c} != $d) {
                return false;
            }
        }
        return true;
    }

}
