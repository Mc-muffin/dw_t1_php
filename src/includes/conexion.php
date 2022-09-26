<?php
    const URL = "localhost";
    const DB = "taller_php_1";

    // Dafault user fight me >:)
    const USER = "root";
    const PASS = "";

    try {
        return new PDO('mysql:host='.URL.';dbname='.DB, USER, PASS);
    } catch (PDOException $e) {
        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
            'error' => [
                'codigo' =>$e->getCode() ,
                'mensaje' => $e->getMessage()
            ]
        ]);
        die();
    }
?>