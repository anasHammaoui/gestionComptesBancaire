<?php
    include_once "abstractAdmin.php";
    class adminControllern extends admin{
        function validateInputs($data){
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = stripslashes($data);
            return $data;
        }
        function ajouterCompte(){
            if (isset($_POST["create"])){
                $name = $this ->  validateInputs($_POST["name"]);
                $email = $this ->  validateInputs($_POST["email"]);
                $pass = password_hash( $this -> validateInputs($_POST["password"]) , PASSWORD_DEFAULT);
                $accType = $_POST["accType"];
                $balance = $_POST["balance"];
                if ($this -> userModel -> isExists($email)){
                    echo "user is already exists";
                } else {
                    $this -> userModel -> createAccount($name,$email,$pass,$accType,$balance);
                    header("location: adminDash.php");
                    exit();
                }
            }
        }
        function showAllUsers(){
           return $this -> userModel -> showAllUsers();
        }
        function modifierCompte(){

        }
        function activeInactiveCompte(){

        }
    }
?>