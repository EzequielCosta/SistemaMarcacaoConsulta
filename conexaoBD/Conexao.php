<?php

class Conexao extends PDO {

    private $tipo;
    private $host;
    private $database;
    private $user;
    private $pass;

    function __construct() {
        $this->tipo = 'pgsql';
        $this->host = 'localhost';
        //SISTEMADEGERENCIAMENTODECONSULTAS
        $this->database = "SISTEMADEGERENCIAMENTODECONSULTAS";        
        $this->user = 'postgres';
        $this->pass = 'postgres';
        $dns = $this->tipo . ':dbname=' . $this->database . ";host=" . $this->host;
        parent::__construct($dns, $this->user, $this->pass, null);
    }

}

//$conexao = new Conexao();
//$codigo = strval(rand(1000000000, 9999999999));
//$sql = "SELECT * FROM PROCEDIMENTO P JOIN COD_PROCEDIMENTO CP ON P.ID = CP.PROCEDIMENTO_ID WHERE CODIGO = '{$codigo}'";
//$result = $conexao->query($sql)->fetchAll(PDO::FETCH_ASSOC);
//while ($result) {
//    $codigo = strval(rand(100000000000000, 999999999999999));
//}
//print($codigo);
//$default = "DEFAULT";
//$sql = "INSERT INTO PROCEDIMENTO VALUES ({$default},?,?,?,?)";
//$stmt = $conexao->prepare($sql);
//$bind = array(
//    "Dermatologista",
//    "0",
//    "100",
//    "AMBAS"
//);
//$stmt->execute($bind);
//
//$sql_ultimo_id = "SELECT MAX(ID) FROM PROCEDIMENTO";
//$ultimo_id = $conexao->query($sql_ultimo_id)->fetch(PDO::FETCH_ASSOC);
//
//$sqli = "INSERT INTO COD_PROCEDIMENTO VALUES ({$default},?,?)";
//$stmti = $conexao->prepare($sqli);
//$bindi = array(
//    $ultimo_id["max"],
//    "9898292827",
//);
//$stmti->execute($bindi);
