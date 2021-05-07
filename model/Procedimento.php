<?php

class Procedimento {

    private $nome;
    private $idade_minima;
    private $idade_maxima;
    private $sexo;
    private $conexao;

    function __construct($nome, $idade_minima, $idade_maxima, $sexo) {
        $this->nome = $nome;
        $this->idade_minima = intval($idade_minima);
        $this->idade_maxima = intval($idade_maxima);
        $this->sexo = $sexo;
        $this->conexao = new Conexao();
    }

    public function adiciona() {
        if ($this->uniqueProcedimento()) {
            $default = "DEFAULT";
            $sql = "INSERT INTO PROCEDIMENTO VALUES ({$default},?,?,?,?)";
            $stmt = $this->conexao->prepare($sql);
            $bind = array(
                strtoupper($this->nome),
                $this->idade_minima,
                $this->idade_maxima,
                strtoupper($this->sexo)
            );
            $stmt->execute($bind);
            
            $sql_ultimo_id = "SELECT MAX(ID) FROM PROCEDIMENTO";
            $ultimo_id = $this->conexao->query($sql_ultimo_id)->fetch(PDO::FETCH_ASSOC);

            $sqli = "INSERT INTO COD_PROCEDIMENTO VALUES ({$default},?,?)";
            $stmti = $this->conexao->prepare($sqli);
            $bindi = array(
                $ultimo_id["max"],
                $this->geraCodigo(),
            );
            $stmti->execute($bindi);

            return true;
        }
        return false;
    }

    public function update($cod, $nome, $idade_minima, $idade_maxima, $sexo) {

        $sql = "UPDATE PROCEDIMENTO SET nome = ?, idade_minima = ?, idade_maxima = ?, sexo = ? WHERE id = {$cod}";
        $stmt = $this->conexao->prepare($sql);
        $bind = array(
            $this->nome,
            $this->idade_minima,
            $this->idade_maxima,
            $this->sexo
        );
        $stmt->execute($bind);
    }

    private function uniqueProcedimento() {
        $sql = "SELECT NOME FROM PROCEDIMENTO WHERE NOME = '{$this->nome}'";
        $result = $this->conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        if ($result) {
            return false;
        } else {
            return true;
        }
    }

    private function geraCodigo() {
        $codigo = strval(rand(1000000000, 9999999999));
        $sql = "SELECT * FROM PROCEDIMENTO P JOIN COD_PROCEDIMENTO CP ON P.ID = CP.PROCEDIMENTO_ID WHERE CODIGO = '{$codigo}'";
        $result = $this->conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        while ($result) {
            $codigo = strval(rand(1000000000, 9999999999));
        }
        return $codigo;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getIdade_minima() {
        return $this->idade_minima;
    }

    public function getIdade_maxima() {
        return $this->idade_maxima;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setIdade_minima($idade_minima) {
        $this->idade_minima = $idade_minima;
    }

    public function setIdade_maxima($idade_maxima) {
        $this->idade_maxima = $idade_maxima;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }

}
