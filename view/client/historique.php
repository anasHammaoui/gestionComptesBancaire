<?php  
 require_once "../../controller/clientController.php";
 require_once "../../model/client.php";
 $user=new ClientController();
//  $entrer=$user-> deposer();
//  $sortie=$user->retirer();
 $histo=$user->historique();
//  echo "<pre>";
//  var_dump($histo);
//  die();
  ?>
 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Historique des transactions</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg md:block hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">Ma Banque</h1>
            </div>
            <nav class="mt-6">
                <a href="index.php" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="wallet"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="compte.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="credit-card"></i>
                    <span>Mes comptes</span>
                </a>
                
               
                <a href="historique.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="history"></i>
                    <span>Historique</span>
                </a>
                <a href="profeil.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="user"></i>
                    <span>Profil</span>
                </a>
            </nav>
        </div>
       
        <!-- Button to toggle sidebar on mobile -->
        <button class="md:hidden p-4 text-gray-600" id="toggleSidebar">
            <i data-lucide="menu"></i>
        </button>
     
        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8">
      <form class="max-w-md  mt-10" action="historique.php" method="post">
  <label for="transaction-search" class="sr-only">Search Transactions</label>
  <div class="relative">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
      <!-- Search Icon -->
      <svg class="w-5 h-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 0 0-15 7.5 7.5 0 0 0 0 15z"/>
      </svg>
    </div>
    <input type="search" id="transaction-search" name="transactions" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search transactions..." required>
    <button type="submit" name="recherchetransactions" class="absolute right-2.5 bottom-2.5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Search</button>
  </div>
</form>
            <h2 class="text-2xl font-bold text-gray-800">Historique des transactions</h2>

    

            <!-- Résumé -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total des entrées</h3>
                    <p class="text-2xl font-bold text-green-600 mt-2">+<?=$histo['depot']?></p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total des sorties</h3>
                    <p class="text-2xl font-bold text-red-600 mt-2">-<?=$histo['retrait']?></p>
                </div>
               
            </div>

            <!-- Liste des transactions -->
          <!-- Liste des transactions -->
<div class="bg-white rounded-lg shadow mt-6">
    <div class="p-4 md:p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Transactions</h3>
           
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Compte
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                      
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Transaction 1 -->
                    <?php foreach($histo["historiquetransactions"] as $transaction) : ?>
                        <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?= $transaction['created_at'] ?>
                        </td>
                        
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                            <?= $transaction['transaction_type'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <?= $transaction['account_type'] ?>              
                              </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-red-600">
                        <?= $transaction['amount'] ?>         
                                   </td>
                        
                    </tr>
                    <?php endforeach ?>

                    <!-- Plus de transactions... -->
                </tbody>
            </table>
        </div>

       
    </div>
</div>
    <script>
        // Toggle sidebar visibility on mobile
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.w-64');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        lucide.createIcons();
    </script>
</body>
</html>