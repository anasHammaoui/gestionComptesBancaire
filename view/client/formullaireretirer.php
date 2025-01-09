<?php 
 require_once "../../controller/clientController.php";
 require_once "../../model/client.php";

 
  $client=new ClientController();
  if ($_SERVER['REQUEST_METHOD']=='POST'&&  isset($_POST['retirersubmit'])) {
    $client->retirer();
  }
 $clientAccounts=$client->clientAccount();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire de Retrait</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Formulaire de Retrait</h2>
    <form method="POST">

      <!-- Montant -->
      <div class="mb-4">
        <label for="amount" class="block text-gray-700 font-medium mb-2">Montant à retirer</label>
        <input 
          type="number" 
          id="amount" 
          name="amount" 
          class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
          placeholder="Entrez le montant" 
          min="1" 
          required
        >
      </div>

      <!-- Type de compte -->
      <div class="mb-4">
        <label for="account-type" class="block text-gray-700 font-medium mb-2">Type de compte</label>
        <select 
          id="account-type" 
          name="account_id" 
          class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          required
        >
          <?php   foreach($clientAccounts as $clientAccount) :  ?>
          <option value="<?= htmlspecialchars($clientAccount['id']) ?>"><?= htmlspecialchars($clientAccount['account_type']) ?></option>
          <?php endforeach;?>
        </select>
      </div>

      <!-- Bouton de confirmation -->
      <div class="mt-6">
        <button 
        name="retirersubmit"
          type="submit" 
          class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50"
        >
          Confirmer le retrait
        </button>
      </div>
    </form>
  </div>
</body>
</html>
