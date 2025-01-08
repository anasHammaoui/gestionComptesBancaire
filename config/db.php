<?php
    class Database {
        protected $connection;
        function __construct()
        {
            try {
                $this -> connection = new PDO("mysql:host=localhost;dbname=GBancaire","root","");
            } catch (PDOException $e){
                echo "failed to connect " . $e;
            };
        }
    }
?>