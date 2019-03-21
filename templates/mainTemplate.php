<?php if (!isset($PB)) exit(); ?>
<!DOCTYPE html>
<html lang="PL">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Personal Budget</title>

  <meta name="description" content="Aplikacja do prowadzenia ewidencji własnych wydatków">
  <meta name="keywords" content="finanse, prowadzenie, budzet, osobisty, bilans, wydatki, przychody, budget, domowy">
  <meta name="author" content="Jakub Krajniewski">
  <meta http-equiv="X-Ua-Compatible" content="IE=edge">



  <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="font\fontello-47199828\css/fontello.css">

  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="apple-touch-icon" sizes="57x57" href="favico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="favico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favico/favicon-16x16.png">
    <link rel="manifest" href="favico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

</head>
<body>
    <main>
        <div class="container">
            <?php
              switch($action):
                case 'showLoginForm' :
                  include 'templates/loginForm.php';
                  break;
                case 'showRegistrationForm' :
                  include 'templates/registrationForm.php';
                break;
                case 'showMain' :
                  include 'templates/mainPage.php';
                  break;
                case 'showIncomeForm' :
                  include 'templates/incomeForm.php';
                  break;
                case 'showExpenseForm' :
                  include 'templates/expenseForm.php';
                  break;
                case 'showBalance' :
                  $peroid    = 'currentMonth';
                  if(isset($_GET['peroid'])) {
                     $peroid = $_GET['peroid'];
                  }
                  if(isset($_POST['startDate'])) {
                     $startDate = $_POST['startDate'];
                  } else if(isset($_GET['startDate'])) {
                     $startDate = $_GET['startDate'];
                  } else {
                     $startDate = '';
                    }
                  if(isset($_POST['lastDate'])) {
                     $lastDate = $_POST['lastDate'];
                  } else if(isset($_GET['lastDate'])) {
                     $lastDate  = $_GET['lastDate'];
                  } else {
                    $lastDate = '';
                  }
                  switch ($peroid) {
                    case 'currentMonth' :
                      $PB->showBalance($peroid, $startDate, $lastDate);
                      break;
                    case 'previousMonth' :
                      $PB->showBalance($peroid, $startDate, $lastDate);
                      break;
                    case 'currentYear' :
                      $PB->showBalance($peroid, $startDate, $lastDate);
                      break;
                    case 'nonStandard' :
                      $PB->showBalance($peroid, $startDate, $lastDate);
                      break;
                    }
                  break;
                case 'showSettings' :
                  $allIncomes        = $PB->selectAllIncomes();
                  $allExpenses       = $PB->selectAllExpenses();
                  $allPaymentMethods = $PB->selectAllPaymentMethods();
                  include 'templates/settingsForm.php';
                  break;
                case 'showRegistrationSuccess' :
                  include 'templates/welcome.php';
                  break;
                case 'showModifyIncomeForm' :
                  include 'templates/modifyIncomeForm.php';
                  break;
                case 'showModifyExpenseForm' :
                  include 'templates/modifyExpenseForm.php';
                  break;                
                case 'showStart' :
                default :
                      include 'templates/startTemplate.php';
              endswitch;
            ?>

        </div>
    </main>
<script src="js/jquery-3.3.1.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script src="js/jquery.js"></script>
<script src="js/menuResponsywne.js"></script>



</body>
</html>