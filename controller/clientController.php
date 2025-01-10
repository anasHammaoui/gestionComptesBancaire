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
            // {
            if (password_verify($password, $user["client_password"])) {

                $_SESSION["user_Role"] = "user";
                $_SESSION["userId"] = $user["id"];
                $_SESSION["userName"] = $user["name"];
                if ($user["user_role"] === "user") {
                    header("location:../client/index.php");
                } elseif ($user["user_role"] === "admin") {
                    header("location:adminDash");
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
    public function Updateinfo($name, $email)
    {
        try {
            $client = new Client();
            if (empty($name) || empty($email)) {
                return "tous les champs sont necissaire";
            }
            $id = $_SESSION["userId"];
            $client->Update($name, $email, $id);
            return "les modifications mese a jour avec succes";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return false;
    }
    public function Updatpass($password)
    {
        $newpassword = $_POST['newpassword'];
        $confirmnewpassword = $_POST['confirmnewpassword'];
        try {
            $client = new Client();
            if (empty($password) || empty($newpassword) || empty($confirmnewpassword)) {
                return "tous les champs sont necissaire";
            } elseif ($newpassword !== $confirmnewpassword) {
                return "la confirmation de mot de passe est incorrecte";
            }

            $id = $_SESSION["userId"];
            $client->Updatepassword($password, $id);
            return "les modifications mese a jour avec succes";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return false;
    }
public function clientAccount(){
   $client = new Client();
   return  $client->clientcompte($_SESSION["userId"]);
}
    public function retirer()
    {
        $amount = (float)$_POST['amount'];
        $account_id = (int)$_POST['account_id'];
        $transactionInfo = ["account_id" => $account_id, "amount" => $amount];

        $client = new Client();
        $client->retirerArgent($transactionInfo);
        header("Location: index.php");
    }
    public function deposer(){
        $amount = $_POST['amount'];
        $account_id = $_POST['account_id'];
        $transactionInfo = ["account_id" => $account_id, "amount" => $amount];

        $client = new Client();
        $client->deposerArgent($transactionInfo);
        header("Location: index.php");
    }
   
    public function transferer(){

        $amount = (float)$_POST['amount'];
        $account_id_source = (int)$_POST['account_id_source'];
        $account_id_cible = (int)$_POST['account_id_cible'];
        // $beneficiary_account_id=(int)$_POST['beneficiary_account_id'];
        $transactionInfo = ["account_id_source" => $account_id_source,"account_id_cible"=>$account_id_cible, "amount" => $amount];

        $client = new Client();
        $client->transfererArgent($transactionInfo);
        header("Location: index.php");
    }
    public function historique(){
      $historiquetransactions=  $this->clientModel->history();
      $depots=0;
      $retraits=0;
      foreach($historiquetransactions as $historiquetransaction){
            //   echo "<pre>";
            //     var_dump($historiquetransaction);
        if($historiquetransaction["transaction_type"] === 'depot'){
            $depots +=(float)$historiquetransaction["amount"] ;
        }elseif($historiquetransaction["transaction_type"] === 'retrait'){
            $retraits +=(float)$historiquetransaction["amount"] ;
        }
    }
    return  ["historiquetransactions"=>$historiquetransactions,"depot"=>$depots,"retrait"=>$retraits];

    }
}
