<?php

/**
 * Class DB
 *
 * Manages the database connection using PDO
 * Connects to a MySQL database using credentials from the server environment
 * Has a method to retrieve the PDO connection
 * Has a method to close the connection
 */
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

    public function getConnection(): PDO {
        return $this->db;
    }

    // closes the connection
    function close() {
        $db = null;
    }
}