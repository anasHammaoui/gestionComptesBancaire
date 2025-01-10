<?php
    include_once __DIR__."/../config/db.php";
    class Adminauth extends database {
         // register for admins
    public function register($adminName,$adminEmail,$adminPassword,$adminPicName) {
   
        $checkExist = $this -> connection -> prepare("SELECT count(email) as count from admins where email = ?");
        $checkExist -> execute([$adminEmail]);
        $countEmails = $checkExist -> fetch(PDO::FETCH_ASSOC);
        if ($countEmails["count"] === 0){
            try {
                // Prepare and execute the insertion query
                $result = $this->connection->prepare("INSERT INTO admins (admin_name, email, admin_password, profile_pic) VALUES (?, ?, ?, ?)");
                $result->execute([$adminName,$adminEmail,$adminPassword,$adminPicName]);     
               
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        return true;
        } else {
            return false;
        }
    }
    // admin login
    public function login($email){
        $checkEmail = $this -> connection -> prepare("SELECT count(email) as count_mail from admins where email =?");
        $checkEmail -> execute([$email]);
        $checkResult = $checkEmail -> fetch(PDO::FETCH_ASSOC);
        // CHECK IF EMAIL EXISTT
        if ($checkResult["count_mail"]){
            // get user result 
            $getRes = $this -> connection -> prepare("SELECT * from admins where email =?");
        $getRes -> execute([$email]);
        $result = $getRes -> fetch(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return false;
        }
    }
    }
?>