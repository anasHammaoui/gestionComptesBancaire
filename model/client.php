<?php

require_once __DIR__ . "/../config/db.php";
class Client extends Database
{

    //login
    public function loginData($email, $password)
    {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            return "Erreur : " . $e->getMessage();
        }
    }
    public function showClient(){
        $userId= $_SESSION["userId"] ;
        $stmt = $this->connection ->prepare("SELECT client_name, email FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $clientData = $stmt->fetch();
        return $clientData;
   
    }
    public function Update($name,$email,$id){

        $stmt = $this->connection->prepare("UPDATE users SET client_name = ?, email = ? WHERE id = ?");
         $stmt->execute([$name,$email,$id]);
         return true;
        

    }
    public function Updatepassword($password,$id){

        $stmt = $this->connection->prepare("UPDATE users SET client_password= ? WHERE id = ?");
         $stmt->execute([$password,$id]);
         return true;
        

    }

    public function showSold(){
        $userId= $_SESSION["userId"] ;
        $stmt = $this->connection->prepare("SELECT balance , id FROM accounts WHERE user_id = ? && account_type='courant'");
        $stmt->execute([$userId]);
        $clientSold = $stmt->fetch(PDO::FETCH_ASSOC);
        return $clientSold;
    }
    public function showSoldepa(){
        $userId= $_SESSION["userId"] ;
        $stmt = $this->connection->prepare("SELECT balance , id FROM accounts WHERE user_id = ? && account_type='epargne'");
        $stmt->execute([$userId]);
        $clientSold = $stmt->fetch(PDO::FETCH_ASSOC);
        return $clientSold;
    }
    // public function deposeArgent(){
    //     $stmt = $this->connection->prepare("SELECT balance FROM transactions WHERE id = ? && transaction_type='depot'");

    // }
    public function retirerArgent($accountId, $amount){
        
            // Start transaction
            $this->connection->beginTransaction();

            // Get current balance
            $stmt = $this->connection->prepare("SELECT balance FROM accounts WHERE id = ? FOR UPDATE");
            $stmt->execute([$accountId]);
            $soldActuelle = $stmt->fetchColumn();

            // Check if sufficient balance
            if ($soldActuelle < $amount) {
                return "Solde insuffisant pour ce retrait.";
            }

            // Update account balance
            $stmt = $this->connection->prepare(
                "UPDATE accounts 
                SET balance = balance - :amount, 
                    updated_at = NOW() 
                WHERE id = :accountId"
            );

            $stmt->execute([
                ':amount' => $amount,
                ':accountId' => $accountId
            ]);

            // Record transaction
            $stmt = $this->connection->prepare(
                "INSERT INTO transactions 
                (account_id, transaction_type, amount, created_at) 
                VALUES (:accountId, 'retrait', :amount, NOW())"
            );

            $stmt->execute([
                ':accountId' => $accountId,
                ':amount' => $amount
            ]);

            // Commit transaction
            $this->connection->commit();
            return true;

     
    }
    //     $stmt = $this->connection->prepare("SELECT balance FROM accounts WHERE id = ? ");
    //     $stmt->execute([$accountId]);
    //     $soldActuelle = $stmt->fetch();

    //     if($amount< $soldActuelle){

    //     }
        
    // }
}
