<?php

class DB {
    private static $_instance = null;
    private $_pdo; 

    private function __construct() {
        try {
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            $this->_pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->_pdo->setAttribute( \PDO::ATTR_EMULATE_PREPARES, false );

        } catch(PDOException $e) {
            echo "Database error: " . $e->getMessage();
            exit();
        }
        DB::$_instance = $this->_pdo;
    }

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            new DB(); 
        }
        return self::$_instance;
    }
}