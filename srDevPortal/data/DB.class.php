<?php

class DB {
    protected $db;

    function __construct() {

        try {
            $this->db = new PDO("mysql:host={$_SERVER['DB_SERVER']};dbname={$_SERVER['DB']}", 
                    $_SERVER['DB_USER'], $_SERVER['DB_PASSWORD'] );

            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $pe) {
            error_log($pe->getMessage());
            die("Bad Database Connection");
        }

    }//constructor

    // closes the connection
    function close() {
        $db = null;
    }
}