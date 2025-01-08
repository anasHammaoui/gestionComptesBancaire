<?php
    include_once "../../controller/adminController.php";
    $admin = new adminControllern();
    // add account
    $admin -> ajouterCompte();
    // get all users
    $usersData = $admin -> showAllUsers();
    // edit users
    $admin -> modifierCompte();
    // :change status 
    $admin -> activeInactiveCompte();
    // total balance
    $total = $admin -> showBalance();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bank Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-gray-100">
    <!-- :side bar toggler button  -->
    <div class="sideBar-toggle text-3xl z-40 mx-auto mt-5 mr-7 w-10 cursor-pointer lg:hidden z-20">
        <i class="fa-solid fa-bars"></i>
    </div>
    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-blue-800 hidden lg:block">
        <div class="flex items-center justify-center h-16 bg-blue-900">
            <h1 class="text-white text-xl font-bold">Bank Admin</h1>
        </div>
        <nav class="mt-6">
            <div class="px-4 py-3">
                <div class="flex items-center space-x-3">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" 
                         alt="Admin" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="text-white font-medium">Admin User</p>
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <a href="#dashboard" class="flex items-center px-6 py-3 text-white bg-blue-900">
                    <span>Dashboard</span>
                </a>
                <a href="#accounts" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-900">
                    <span>Accounts</span>
                </a>
                <a href="#reports" class="flex items-center px-6 py-3 text-blue-100 hover:bg-blue-900">
                    <span>Reports</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-64 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center flex-col md:flex-row mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Dashboard Overview</h2>
            <div class="flex items-center space-x-4 flex-col  md:flex-row py-3 md:py-0">
                <button onclick="generateReport()" class="px-4 mb-4 md:mb-0 mx-auto py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Generate Report
                </button>
                <button onclick="openNewAccountModal()" class="px-4 py-2 bg-blue-600  text-white rounded-lg hover:bg-blue-700">
                    New Account
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-500 text-sm font-medium">Total Deposits</h3>
                <p class="text-3xl font-bold text-green-600 mt-2" id="totalDeposits">€0.00</p>
                <div class="mt-2 text-sm text-gray-600">
                    <span class="text-green-500">↑ 12%</span> from last month
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-500 text-sm font-medium">Total Withdrawals</h3>
                <p class="text-3xl font-bold text-red-600 mt-2" id="totalWithdrawals">€0.00</p>
                <div class="mt-2 text-sm text-gray-600">
                    <span class="text-red-500">↓ 5%</span> from last month
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-500 text-sm font-medium">Total Balance</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2" id="totalBalance">€<?=$total?></p>
                <div class="mt-2 text-sm text-gray-600">
                    <span class="text-blue-500">All accounts</span>
                </div>
            </div>
        </div>

        <!-- Search and Table -->
        <div class="bg-white rounded-xl shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-medium">Client Accounts</h3>
                    <div class="relative w-64">
                        <input type="text" id="searchInput" 
                               placeholder="Search clients..." 
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Account Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="accountsTable" class="bg-white divide-y divide-gray-200">
                        <?php
                            foreach ($usersData as $value){ ?>
                               <tr class="users">
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div>
                        <div class="text-sm font-medium text-gray-900 name" data-id="<?= $value["user_id"]?>"><?= $value["client_name"] ?></div>
                        <div class="text-sm text-gray-500 email"><?= $value["email"] ?></div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 acctype"><?= $value["account_type"] ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900 "><?= $value["balance"] ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                <?= $value["acc_status"] ?>
                </span>
            </td>
            <td class="px-6 py-6 whitespace-nowrap text-sm flex font-medium">
                
                    <?php
                        if ($value["acc_status"] === "active"){ ?>
                                <form action="adminDash.php" method="GET">
                                    <input type="text" name="statusId" class="hidden" value="<?= $value["user_id"]?>">
                                    <input type="submit" value="Close" name="closeAcc" class="text-blue-600 cursor-pointer hover:text-blue-900 mr-4">
                                </form>
                       <?php } else { ?>
                                <form action="adminDash.php" method="GET">
                                <input type="text" name="statusId" class="hidden" value="<?= $value["user_id"]?>">
                                    <input type="submit" value="Open" name="openAcc" class="text-blue-600 cursor-pointer hover:text-blue-900 mr-4">
                                </form>
                       <?php     }
                    ?>
               
                <button 
                        onclick="editAccountModal()"
                        class="text-green-600 hover:text-green-900 edit-user">
                    Edit
                </button>
            </td>
        </tr>
                          <?php  }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- New Account Modal -->
    <div id="newAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-8 w-full max-w-md">
            <h3 class="text-xl font-bold mb-6">Create New Account</h3>
            <form id="newAccountForm" action="adminDash.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Client Name</label>
                    <input type="text" name="name" required class="mt-1 block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="mt-1 block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required class="mt-1 block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Account Type</label>
                    <select name="accType" required class="mt-1 block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="epargne">Savings Account</option>
                        <option value="courant">Current Account</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Initial Balance ($)</label>
                    <input name="balance" type="number" min="0" step="0.1" required class="mt-1 p-1 border block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex space-x-4 pt-4">
                    <button type="submit" name="create" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Create</button>
                    <button type="button" onclick="closeNewAccountModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <!-- edit Account Modal -->
    <div id="editAccountModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-8 w-full max-w-md">
            <h3 class="text-xl font-bold mb-6">Edit Account</h3>
            <form id="editAccountForm" action="adminDash.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 ">Client Name</label>
                    <input type="text" name="editName" required class="mt-1 cname block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 ">Email</label>
                    <input type="email" name="editEmail" required class="mt-1 cemail block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 ">Password</label>
                    <input type="password" name="editPassword" required class="mt-1 cpass block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 ">Account Type</label>
                    <select name="editAccType" required class="mt-1 cacctype block w-full border p-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="epargne">Savings Account</option>
                        <option value="courant">Current Account</option>
                    </select>
                </div>
                <input type="text" name="userId" class="hidden input-id">
                <div class="flex space-x-4 pt-4">
                    <button type="submit" name="editAcc" class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Edit</button>
                    <button type="button" onclick="closeEditAccountModal()" class="flex-1 bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/script.js"> </script>
</body>
</html>