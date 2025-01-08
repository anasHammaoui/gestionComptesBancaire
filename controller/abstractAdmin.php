<?php
require_once __DIR__."../../model/admin.php";
    // include_once "../model/admin.php";
    abstract class admin{
        protected $userModel;
        function __construct() {
            $this -> userModel = new adminModel();
        }
        abstract function ajouterCompte();
        abstract function modifierCompte();
        abstract function activeInactiveCompte();
        abstract function showAllUsers();
    }
?>