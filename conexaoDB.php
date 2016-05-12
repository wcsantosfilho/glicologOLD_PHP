<?php

function conexaoDB () {
    try{
        $config = include "config.php";
        if (! isset($config['db'])) {
            throw new \InvalidArgumentException("Configuração do Banco de Dados inválida");
        }

        $host = (isset($config['db']['host'])) ? $config['db']['host'] : null;
        $dbname = (isset($config['db']['dbname'])) ? $config['db']['dbname'] : null;
        $user = (isset($config['db']['user'])) ? $config['db']['user'] : null;
        $passwd = (isset($config['db']['passwd'])) ? $config['db']['passwd'] : null;

        return new \PDO("mysql:host={$host};dbname={$dbname}", $user, $passwd);

    } catch (\PDOException $e) {
        echo $e->getMessage()."\n";
        echo $e->getTraceAsString()."\n";
    }
}

?>