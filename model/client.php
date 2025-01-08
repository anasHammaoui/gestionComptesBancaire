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
}
