<?php
    // include_once "../config/db.php";
require_once __DIR__."../../config/db.php";


class adminModel extends database {
    // check if the client already exists
    function isExists($email){
        $isExist = $this -> connection -> prepare("SELECT email from users where email = ?");
        $isExist -> execute([$email]);
        $check = $isExist -> fetch(PDO::FETCH_ASSOC);
        if ($check){
            return true;
        } else{
            return false;
        }
    }
    // create client user and bank account
    function createAccount($name, $email,$pass,$accType,$balance){
        // create user account 
        try {
            $createUser = $this -> connection -> prepare("INSERT INTO users(client_name, email, client_password) values (?,?,?)");
        $createUser -> execute([$name,$email,$pass]);
        } catch (PDOException $e){
            return "failed to insert users" . $e;
        }
        // get created user Id 
        try {
            $getUserId = $this -> connection -> prepare("SELECT id from users where client_name = ?");
        $getUserId -> execute([$name]);
        $getId = $getUserId -> fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return "failed to get user id" . $e;
        }
        
        // create bank account for user
        try {
           $createBank = $this -> connection -> prepare("INSERT INTO accounts(user_id, account_type, balance) VALUES (?, ?, ?)");
        $createBank -> execute([$getId["id"],$accType,$balance]);
        } catch (PDOException $e){
            return "failed to insert account bank" . $e;
        }
    }
    function showAllUsers(){
        $getAll = $this -> connection -> prepare("SELECT client_name, email, user_id, account_type, acc_status, balance from users JOIN accounts ON users.id = accounts.user_id");
        $getAll -> execute();
        $getItAsArr = $getAll -> fetchAll(PDO::FETCH_ASSOC);
        return $getItAsArr;
    }
}
?>