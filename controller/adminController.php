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
                    echo "alert('added successfully')";
                    header("location: adminDash.php");
                    exit();
                }
            }
        }
        function showAllUsers(){
           return $this -> userModel -> showAllUsers();
        }
        function modifierCompte(){
           if (isset($_POST["editAcc"])){
            $name = $this ->  validateInputs($_POST["editName"]);
                $email = $this ->  validateInputs($_POST["editEmail"]);
                $pass = password_hash( $this -> validateInputs($_POST["editPassword"]) , PASSWORD_DEFAULT);
                $accType = $_POST["editAccType"];
                $userId = $_POST["userId"];
                if ($this -> userModel -> editAcc($name,$email,$pass,$accType,(int)$userId)){
                    echo "<script>alert('edited succussfully')</script>";
                header("location: adminDash.php");
                exit();
                } else {
                    echo "<script>alert('failed succussfully')</script>";
                }
                
           }

        }
        function activeInactiveCompte(){

        }
    }
?>