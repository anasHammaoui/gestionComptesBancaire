<?php
    include_once "../../controller/adminController.php";
    session_start();
    if (isset($_SESSION["admin"]) && $_SESSION["admin"] = "admin"){
        // session variables
        $adminSession =  $_SESSION["admin"];
        $adminName =  $_SESSION["admin_name"];
        $adminId =  $_SESSION["admin_id"] ;
        $adminImg =  $_SESSION["admin_img"] ;
        $admin = new adminControllern();
    // total balance
    $totalBal = $admin -> showBalance();
    $totalWith = $admin -> showTotalWithd();
    $totalDp = $admin -> showTotalDepot();

    } else {
        echo "Please log in admin:)";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport Bank</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chartCont{
            width: 70%;
            margin: 10px auto;
        }
    </style>
</head>
<body>
    <div class="chartCont">
    <canvas id="bankRapport"></canvas>
    </div>
    <script>
  const ctx = document.getElementById('bankRapport');

 let chart =  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Total Balance', 'Total Withdraw', 'Total Deposits'],
      datasets: [{
        label: 'Financial Repport in $ ',
        data: [<?= $totalBal?>, <?= $totalWith?>, <?= $totalDp?>],
        backgroundColor: ["#42a5f5","#ef5350","#7cb342"],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
</body>
</html>