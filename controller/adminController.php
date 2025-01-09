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
                    $this -> userModel -> createAccount($name,$email,$pass,$accType,$balance);
                    echo "alert('added successfully')";
                    header("location: adminDash.php");
                    exit();
              
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
                    echo "<script>alert('Faild to edit')</script>";
                }
           }

        }
        function activeInactiveCompte(){
            if (isset($_GET["changeStatus"])){
                list($status, $userId) = explode("|",$_GET["changeStatus"]);
                    if ($status === "active"){
                        $this -> userModel -> closeAcc((int)$userId);
                        header("location: adminDash.php");
                    } else {
                        $this -> userModel -> activeAcc((int)$userId);
                        header("location: adminDash.php");
                    }
            }
        }
        // show balance
        function showBalance(){
            return   $this -> userModel -> showTotalBalance();
        }
        // show withdraw
        function showTotalWithd(){
            return   $this -> userModel -> showTotalWithd();
        }
        // show deposits
        function showTotalDepot(){
            return   $this -> userModel -> showTotalDepot();
        }
        // show accounts inn dropdown
        function showAccDrop($id){
           return $this -> userModel -> showAccs($id);
        }
    }
?>