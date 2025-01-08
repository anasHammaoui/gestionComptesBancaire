<?php
require_once __DIR__ . "/../model/client.php";
session_start();

class ClientController
{
    protected $clientModel;
    function __construct()
    {
        $this->clientModel = new Client();
    }
    

    //login
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function login($email, $password)
    {
        $email = $this->validate($email);
        $password = $this->validate($password);
        if (empty($email) || empty($password)) {
            return "tous les champs sont necissaire";
        }
        $user = $this->clientModel->loginData($email, $password);
        if ($user) {
            // if (password_verify($password,$user["client_password"])) {
                if ($password===$user["client_password"]) {

                $_SESSION["user_Role"] = "user";
                $_SESSION["userId"] = $user["id"];
                $_SESSION["userName"] = $user["name"];
                if ($user["user_role"] === "user") {
                    header("location:../client/profeil.php");

                    // $_SESSION["user_Role"] = "user";
                    // $_SESSION["userId"] = $user["id"];
                    // $_SESSION["userName"] = $user["name"];
                } elseif ($user["user_role"] === "admin") {
                    header("location:signup.php");
                    // session_start();

                    // $_SESSION["user_Role"] = "admin";
                    // $_SESSION["userId"] = $user["id"];
                    // $_SESSION["userName"] = $user["name"];
                }
            } else {
                echo "password incorrect";
            }
        } else {
            echo "invalid email";
        }

        if ($user === true) {
            return "Connexion réussie.";
        } else {
            return $user;
        }
    }
public function Updateinfo($name,$email){
try {
    $client = new Client();
    if(empty($name) || empty($email)){
        return "tous les champs sont necissaire";
    }
    $id= $_SESSION["userId"] ;
     $client->Update($name,$email,$id);
     return "les modifications mese a jour avec succes";
  
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
    return false;
}
      
    
    
    }

