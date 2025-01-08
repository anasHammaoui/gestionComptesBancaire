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
    function editAcc($cName,$email,$pass,$accType,$userId){
        try {
            $this -> connection -> beginTransaction();
            $changeUser = $this -> connection -> prepare("UPDATE users set client_name = ?, email = ?, client_password = ? where id = ?");
            $changeUser -> execute([$cName,$email,$pass, $userId]);
            $changeAcc = $this -> connection -> prepare("UPDATE accounts set account_type = ? where user_id = ?");
            $changeAcc -> execute([$accType,$userId]);
            $this -> connection -> commit();
        } catch (Exception $e){
            $this -> connection -> rollBack();
            echo "failed  to edit " . $e;
            return false;
        }
        return true;
    }
    function closeAcc($userId){
        $close = $this -> connection -> prepare("UPDATE accounts SET acc_status = 'inactive' where id = ?");
        $close -> execute([$userId]);
    }
    function activeAcc($userId){
        $close = $this -> connection -> prepare("UPDATE accounts SET acc_status = 'active' where id = ?");
        $close -> execute([$userId]);
    }
    // show total ballance
    function showTotalBalance(){
        $total = $this -> connection -> prepare("SELECT SUM(balance) as total_bal from accounts");
        $total -> execute();
        $result = $total -> fetch(PDO::FETCH_ASSOC);
        return $result["total_bal"];
    }
}
?>