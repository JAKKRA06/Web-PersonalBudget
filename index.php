<?php
include 'constatns.php';
spl_autoload_register('classLoader');
session_start();

try{
  $PB = new User('localhost', 'root', '', 'personal_budget');

  $action = 'showStart';
  if(isset($_GET['action'])) {
    $action = $_GET['action'];
  }

  switch($action){
    case 'login' :
      switch ($PB->logIn()) {
        case ACTION_OK :
          header('Location: index.php?action=showMain');
          return;
        case ACTION_FAILED :
        case FORM_DATA_MISSING :
          $PB->setMessage('Błędna nazwa lub hasło użytkownika !');
          break;
        case SERVER_ERROR :
        default:
          $PB->setMessage('Błąd serwera. Prosimy o logowanie w innym terminie.');
      }
      header ('Location: index.php?action=showLoginForm');
      break;
    case 'logout' :
      $PB->logOut();
      header('Location: index.php?action=showStart');
      break;
    case 'register' :
      switch ($PB->registration()) {
        case ACTION_OK :
          header('Location: index.php?action=showRegistrationSuccess');
          return;
        case LOGIN_FAILED :
        case FORM_DATA_MISSING :
          $PB->setMessage('Login musi posiadać od 3 do 20 znaków ! Login musi składać się tylko z liter i cyfr (bez polskich znaków) !');
          break;
        case LOGIN_ALREADY_EXIST :
          $PB->setMessage('Podany login został przypisany do innego konta użytkownika !');
          break;
        case PASSWORD_DO_NOT_MATCH :
          $PB->setMessage('Hasło musi posiadać od 6 do 20 znaków !');
          break;
        default :
          $PB->setMessage('Błąd serwera.');
          break;
      }
      header ('Location: index.php?action=showRegistrationForm');
      break;
    case 'addIncome' :
      switch ($PB->addIncome()) {
        case ACTION_OK :
          $PB->setMessage('Dodano przychód !');
          break;
        case FORM_DATA_MISSING :
          $PB->setMessage('Uzupełnij wszystkie pola !');
          break;
        case INVALID_FORMAT :
          $PB->setMessage('Niepoprawny format !');
          break;
        case COMMENT_TO_LONG :
          $PB->setMessage('Komentarz jest zbyt długi ! Max długość komentarza to 100 znaków !');
          break;
        case SERVER_ERROR : 
        default:
          $PB->setMessage('Bład serwera.');
          break;
      }
      header('Location: index.php?action=showIncomeForm');
      break;
    case 'addExpense' :
      switch ($PB->addExpense()) {
        case ACTION_OK :
          $PB->setMessage('Dodano wydatek !');
          break;
        case FORM_DATA_MISSING :
          $PB->setMessage('Uzupełnij wszystkie pola !');
          break;
        case INVALID_FORMAT :
          $PB->setMessage('Niepoprawny format !');
          break;
        case COMMENT_TO_LONG :
          $PB->setMessage('Komentarz jest zbyt długi ! Max długość komentarza to 100 znaków !');
          break;
        case SERVER_ERROR : 
        default:
          $PB->setMessage('Bład serwera.');
          break;
      }
      header('Location: index.php?action=showExpenseForm');
      break;
    default:
      include 'templates/mainTemplate.php';
  }
}
catch(Excepiton $e){
  echo 'Bład: '.$e->getMessage();
  exit("Strona chwilowo niedostępna");
}

function classLoader($nazwa){
  if(file_exists("classes/$nazwa.php")){
    require_once("classes/$nazwa.php");
  } else {
    throw new Exception("Brak pliku z definicją klasy.");
  }
}

