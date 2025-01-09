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
    public function showClient()
    {
        $userId = $_SESSION["userId"];
        $stmt = $this->connection->prepare("SELECT client_name, email FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $clientData = $stmt->fetch();
        return $clientData;
    }
    public function Update($name, $email, $id)
    {

        $stmt = $this->connection->prepare("UPDATE users SET client_name = ?, email = ? WHERE id = ?");
        $stmt->execute([$name, $email, $id]);
        return true;
    }
    public function Updatepassword($password, $id)
    {

        $stmt = $this->connection->prepare("UPDATE users SET client_password= ? WHERE id = ?");
        $stmt->execute([$password, $id]);
        return true;
    }

    public function showSold()
    {
        $userId = $_SESSION["userId"];
        $stmt = $this->connection->prepare("SELECT balance , id FROM accounts WHERE user_id = ? && account_type='courant'");
        $stmt->execute([$userId]);
        $clientSold = $stmt->fetch(PDO::FETCH_ASSOC);
        return $clientSold;
    }
    public function showSoldepa()
    {
        $userId = $_SESSION["userId"];
        $stmt = $this->connection->prepare("SELECT balance , id FROM accounts WHERE user_id = ? && account_type='epargne'");
        $stmt->execute([$userId]);
        $clientSold = $stmt->fetch(PDO::FETCH_ASSOC);
        return $clientSold;
    }
    public function clientcompte($user_id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM accounts WHERE user_id=?");
        $stmt->execute([$user_id]);
        $clientaccounts = $stmt->fetchAll();
        return $clientaccounts;
    }
    public function retirerArgent($transactionInfo)
    {
        try {
            // Start transaction
            $this->connection->beginTransaction();

            // Get current balance
            $stmt = $this->connection->prepare("SELECT balance FROM accounts WHERE id = ? ");
            $stmt->execute([$transactionInfo["account_id"]]);
            $currentBalance = $stmt->fetchColumn();
            

            // Check if sufficient balance
            if ((int)$currentBalance <  $transactionInfo["amount"]) {
                return false;
            }

            // Update account balance
            $stmt = $this->connection->prepare("UPDATE accounts  SET balance = balance - :amount,  updated_at = NOW()   WHERE id = :accountId && acc_status='active'" );

            $stmt->execute([
                ':amount' => $transactionInfo["amount"],
                ':accountId' => $transactionInfo["account_id"]
            ]);
            if(!$stmt){
                return false;
            }
        $stmt = $this->connection->prepare("INSERT INTO transactions (account_id,amount,transaction_type)  VALUES (?,?,?)");
        $stmt->execute([$transactionInfo["account_id"], $transactionInfo["amount"], "retrait"]);

          $this->connection->commit();
          return true;

      } catch (Exception $e) {
          $this->connection->rollBack();
          throw $e;
      }
    }
    public function deposerArgent($transactionInfo)
    {
        try {
            // Start transaction
            $this->connection->beginTransaction();

            // Get current balance
            $stmt = $this->connection->prepare("SELECT balance FROM accounts WHERE id = ? ");
            $stmt->execute([$transactionInfo["account_id"]]);
            $currentBalance = $stmt->fetchColumn();
            

            if ($transactionInfo['amount']<0.01 ) {
                return false;
            }

            // Update account balance
            $stmt = $this->connection->prepare("UPDATE accounts  SET balance = balance + :amount,  updated_at = NOW()   WHERE id = :accountId && acc_status='active'" );

            $stmt->execute([
                ':amount' => $transactionInfo["amount"],
                ':accountId' => $transactionInfo["account_id"]
            ]);
            if(!$stmt){
                return false;
            }
            $stmt = $this->connection->prepare("INSERT INTO transactions (account_id,amount,transaction_type)  VALUES (?,?,?)");
            $stmt->execute([$transactionInfo["account_id"], $transactionInfo["amount"], "depot"]);
            $this->connection->commit();
            return true;
  
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }    }
    public function transfererArgent($transactionInfo)
    {
        try {
            // Start transaction
            $this->connection->beginTransaction();

            // Get current balance
            $stmt = $this->connection->prepare("SELECT balance FROM accounts WHERE id = ? ");
            $stmt->execute([$transactionInfo["account_id"]]);
            $currentBalance = $stmt->fetchColumn();
            

          

            // Update account balance
            $stmt = $this->connection->prepare("UPDATE accounts  SET balance = balance + :amount,  updated_at = NOW()   WHERE id = :accountId && acc_status='active'" );
            $stmt = $this->connection->prepare("UPDATE accounts  SET balance = balance - :amount,  updated_at = NOW()   WHERE id = : && acc_status='active'" );

            $stmt->execute([
                ':amount' => $transactionInfo["amount"],
                ':accountId' => $transactionInfo["account_id"]
            ]);
            if(!$stmt){
                return false;
            }
            $stmt = $this->connection->prepare("INSERT INTO transactions (account_id,amount,transaction_type)  VALUES (?,?,?)");
            $stmt->execute([$transactionInfo["account_id"], $transactionInfo["amount"], "transfert"]);
            $this->connection->commit();
            return true;
  
        } catch (Exception $e) {
            $this->connection->rollBack();
            throw $e;
        }      }
}
