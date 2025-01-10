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
                $userId = $_POST["userId"];
                if ($this -> userModel -> editAcc($name,$email,$pass,(int)$userId)){
                header("location: adminDash.php");
                exit();
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
        
          // delete users clients
    function removeUsersAccs(){
        if (isset($_GET["deleteAcc"])){
            $user_id = $_GET["deleteUserId"];
            if ($this -> userModel -> removeAccs((int)$user_id)){
                header("location: adminDash.php");
            } else {
                echo "failed to delete";
            }
        }
    }
    
    }
?>