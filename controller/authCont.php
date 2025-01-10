<?php
require_once __DIR__. "/../model/adminAuth.php";
class Auth {
    private $adminModel;
    function __construct(){
        $this -> adminModel = new Adminauth();
    }
    // VALIDATION
    function validateInputs($data){
        $data = trim($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        return $data;
    }
    // sign up for admin
public function handleRegister(){

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signupAdmin"])){
      $adminName = $this -> validateInputs($_POST["adminName"]);
      $adminEmail = $this -> validateInputs($_POST["adminEmail"]) ;
      $adminPassword = password_hash($_POST["adminPassword"],PASSWORD_DEFAULT);
      $adminPicName =  $_FILES["adminPic"]["name"];
      $adminPicTmp = $_FILES["adminPic"]["tmp_name"];
    //   var_dump($_FILES["adminPic"]);
    //   var_dump($adminPicTmp);
    // check if signed up successfully 
      if (move_uploaded_file($adminPicTmp, "../adminImg/".$adminPicName) && $this -> adminModel -> register($adminName,$adminEmail,$adminPassword,$adminPicName)){
        return true;
      } else {
        return false;
      }

   }
 }
//  login to admin acc
public function handleLogin(){


    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['adminLogin'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $result = $this->adminModel->login($email);

            if ($result) {
                if (password_verify($password, $result["admin_password"])){
                    session_start();
                    $_SESSION["admin"] = "admin";
                    $_SESSION["admin_name"] = $result["admin_name"];
                    $_SESSION["admin_id"] = $result["admin_id"];
                    $_SESSION["admin_img"] = $result["profile_pic"];
                    header("location: ../admin/adminDash.php");
                } else {
                    echo "password incorrect";
                }
            } else {
                echo "invalid email";
            }
           
        }
    }


 }
}

?>