<?php
  require_once "../../controller/authCont.php";


    $admin = new Auth();
    if ($admin -> handleRegister()){
        header('Location: loginAdmin.php?message=' . urlencode("Signed up successfully") . '&type=success');
       echo "<script> alert('Sign Up successfully')</script>";

    } else if ($admin -> handleRegister() === false){
        header('Location: signupadmin.php?message=' . urlencode("Failed to sign up") . '&type=failed');
       
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="font-[sans-serif] bg-white max-w-4xl flex items-center mx-auto md:h-screen p-4">
        <div class="grid md:grid-cols-3 items-center shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-xl overflow-hidden">
            <div class="max-md:order-1 flex flex-col justify-center space-y-16 max-md:mt-16 min-h-full bg-gradient-to-r from-gray-900 to-gray-700 lg:px-8 px-4 py-4">
                <div>
                    <h4 class="text-white text-lg">Welcome Admin</h4>
                    <p class="text-[13px] text-gray-300 mt-3 leading-relaxed">Sign Up now to access to your admin dashboard.</p>
                </div>
                <div>
                    <h4 class="text-white text-lg">Secure Login</h4>    
                    <p class="text-[13px] text-gray-300 mt-3 leading-relaxed">We prioritize your data security. Please enter your credentials carefully.</p>
                </div>
            </div>

            <form action="signUpAdmin.php" method="POST" class="md:col-span-2 w-full py-6 px-6 sm:px-16 max-md:max-w-xl mx-auto" enctype="multipart/form-data">
                <div class="mb-6">
                    <h3 class="text-gray-800 text-xl font-bold">Sign Up Admin</h3>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="text-gray-600 text-sm mb-2 block">Full Name</label>
                        <div class="relative flex items-center">
                            <input name="adminName" type="text" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm pl-4 pr-8 py-2.5 rounded-md outline-blue-500" placeholder="Enter Full Name" />
                            
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm mb-2 block">Email</label>
                        <div class="relative flex items-center">
                            <input name="adminEmail" type="email" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm pl-4 pr-8 py-2.5 rounded-md outline-blue-500" placeholder="Enter email" />
                            
                        </div>
                    </div>
            

                    <div>
                        <label class="text-gray-600 text-sm mb-2 block">Password</label>
                        <div class="relative flex items-center">
                            <input name="adminPassword" type="password" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm pl-4 pr-8 py-2.5 rounded-md outline-blue-500" placeholder="Enter password" />
                            
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-600 text-sm mb-2 block">Profile Picture</label>
                        <div class="relative flex items-center">
                            <input name="adminPic" type="file" required class="text-gray-800 bg-white border border-gray-300 w-full text-sm pl-4 pr-8 py-2.5 rounded-md outline-blue-500" placeholder="Upload Picture" />
                            
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button name="signupAdmin" type="submit" class="w-full py-2.5 px-4 tracking-wider text-sm rounded-md text-white bg-gray-700 hover:bg-gray-800 focus:outline-none">
                        Sign Up
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>