<?php
    // include_once "../config/db.php";
require_once __DIR__."../../config/db.php";


class adminModel extends database {
    // create client user and bank account
    function createAccount($name, $email,$pass,$accType,$balance){
        // check if the user is already exists
        $checkUser = $this -> connection -> prepare("SELECT COUNT(email) as count_email from users WHERE email = ?");
        $checkUser -> execute([$email]);
        $getResult = $checkUser  -> fetch(PDO::FETCH_ASSOC);
        // create user account 
        if ($getResult["count_email"] === 0){
            try {
                $createUser = $this -> connection -> prepare("INSERT INTO users(client_name, email, client_password) values (?,?,?)");
            $createUser -> execute([$name,$email,$pass]);
            } catch (PDOException $e){
                return "failed to insert users" . $e;
            }
        }
        // get created user Id 
        try {
            $getUserId = $this -> connection -> prepare("SELECT id from users where email = ?");
        $getUserId -> execute([$email]);
        $getId = $getUserId -> fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            return "failed to get user id" . $e;
        }
        
    //    CHECK if user don't have this account type 
    $checkType = $this -> connection -> prepare("SELECT account_type from accounts where user_id = ?");
    $checkType -> execute([$getId["id"]]);
    $checkResult = $checkType -> fetchAll(PDO::FETCH_ASSOC);
    $isExist = false;
        foreach($checkResult as $check){
            if ($check["account_type"] === $accType){
                $isExist = true;
            }
        }
        if ($isExist === false){
             // create bank account for user
        try {
            $createBank = $this -> connection -> prepare("INSERT INTO accounts(user_id, account_type, balance) VALUES (?, ?, ?)");
         $createBank -> execute([$getId["id"],$accType,$balance]);
         } catch (PDOException $e){
             return "failed to insert account bank" . $e;
         }
        } else {
            echo "<script>alert('account already exists')</script>";
        }
    }
    function showAllUsers(){
        $getAll = $this -> connection -> prepare("SELECT client_name, user_id, email, 
    GROUP_CONCAT(accounts.account_type SEPARATOR ', ') AS acc_type, COUNT(accounts.id) as account_count, SUM(balance) as balance FROM users 
LEFT JOIN accounts ON users.id = accounts.user_id 
GROUP BY users.id");
        $getAll -> execute();
        $getItAsArr = $getAll -> fetchAll(PDO::FETCH_ASSOC);
        return $getItAsArr;
    }
    function editAcc($cName,$email,$pass,$userId){
        try {
            $this -> connection -> beginTransaction();
            $changeUser = $this -> connection -> prepare("UPDATE users set client_name = ?, email = ?, client_password = ? where id = ?");
            $changeUser -> execute([$cName,$email,$pass, $userId]);
            // $changeAcc = $this -> connection -> prepare("UPDATE accounts set account_type = ? where user_id = ?");
            // $changeAcc -> execute([$accType,$userId]);
            $this -> connection -> commit();
        } catch (Exception $e){
            $this -> connection -> rollBack();
            echo "failed  to edit " . $e;
            return false;
        }
        return true;
    }
    function showAccs($userId){
        $show = $this -> connection -> prepare("SELECT * from accounts where user_id = ?");
        $show -> execute([$userId]);
        $getIt = $show -> fetchAll(PDO::FETCH_ASSOC);
        return $getIt;
    }
    function closeAcc($accId){
        $close = $this -> connection -> prepare("UPDATE accounts SET acc_status = 'inactive' where id = ?");
        $close -> execute([$accId]);
    }
    function activeAcc($accId){
        $close = $this -> connection -> prepare("UPDATE accounts SET acc_status = 'active' where id = ?");
        $close -> execute([$accId]);
    }
    // show total ballance
    function showTotalBalance(){
        $total = $this -> connection -> prepare("SELECT SUM(balance) as total_bal from accounts");
        $total -> execute();
        $result = $total -> fetch(PDO::FETCH_ASSOC);
        if ($result["total_bal"]){
            return $result["total_bal"] ;
        } else {
            return 0;
        }
    }
    // show total withdraw
    function showTotalWithd(){
        $total = $this -> connection -> prepare("SELECT SUM(amount) as total_am from transactions where transaction_type = 'retrait'");
        $total -> execute();
        $result = $total -> fetch(PDO::FETCH_ASSOC);
        if ($result["total_am"]){
            return $result["total_am"] ;
        } else {
            return 0;
        }
    }
    // show total Deposits
    function showTotalDepot(){
        $total = $this -> connection -> prepare("SELECT SUM(amount) as total_dp from transactions where transaction_type = 'depot'");
        $total -> execute();
        $result = $total -> fetch(PDO::FETCH_ASSOC);
        if ($result["total_dp"]){
            return $result["total_dp"] ;
        } else {
            return 0;
        }
    }
    // register for admins
//     public function register($user) {
   
//         try {
//             // Prepare and execute the insertion query
//             $result = $this->conn->prepare("INSERT INTO users (client_name, email, client_password, role) VALUES (?, ?, ?, ?)");
//             $result->execute($user);
//             return $this->conn->lastInsertId();
            
           
//         } catch (PDOException $e) {
//             echo "Error: " . $e->getMessage();
//         }
//     }
    // remove accounts  
    function removeAccs($id){
        $removeAcc = $this -> connection -> prepare("DELETE FROM accounts WHERE user_id = ?");
        $removeAcc -> execute([$id]);
        $removeUser = $this -> connection -> prepare("DELETE FROM users WHERE id = ?");
        $removeUser -> execute([$id]);
        
        return true;
    }
}
?>