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
          $PB->setMessage('Błąd serwera.');
          break;
      }
      header('Location: index.php?action=showIncomeForm');
      break;
    case 'modifyIncome' :
      $idRecordToModify = $_GET['idRecordToModify'];
      $peroid           = $_GET['peroid'];
      $startDate        = $_GET['startDate'];
      $lastDate         = $_GET['lastDate'];
      switch ($PB->modifyIncome($idRecordToModify)) {
        case ACTION_OK :
          $PB->setMessage('Wprowadzono zmiany !');
          break;
        case INVALID_FORMAT :
          $PB->setMessage('Niepoprawny format !');
          break;
        case COMMENT_TO_LONG :
          $PB->setMessage('Komentarz jest zbyt długi ! Max długość komentarza to 100 znaków !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się wprowadzić zmian !');
          break;
        case SERVER_ERROR : 
        default:
          $PB->setMessage('Błąd serwera.');
          break;
      }
      header('Location: index.php?action=showBalance&peroid='.$peroid.'&startDate='.$startDate.'&lastDate='.$lastDate.'');
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
          $PB->setMessage('Błąd serwera.');
          break;
      }
      header('Location: index.php?action=showExpenseForm');
      break;
    case 'modifyExpense' :
      $idRecordToModify = $_GET['idRecordToModify'];
      $peroid           = $_GET['peroid'];
      $startDate        = $_GET['startDate'];
      $lastDate         = $_GET['lastDate'];
      switch ($PB->modifyExpense($idRecordToModify)) {
        case ACTION_OK :
          $PB->setMessage('Wprowadzono zmiany !');
          break;
        case INVALID_FORMAT :
          $PB->setMessage('Niepoprawny format !');
          break;
        case COMMENT_TO_LONG :
          $PB->setMessage('Komentarz jest zbyt długi ! Max długość komentarza to 100 znaków !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się wprowadzić zmian !');
          break;
        case SERVER_ERROR : 
        default:
          $PB->setMessage('Błąd serwera.');
          break;
      }
      header('Location: index.php?action=showBalance&peroid='.$peroid.'&startDate='.$startDate.'&lastDate='.$lastDate.'');
      break;
    case 'dropIncomeCategory' :
      $dropIncomeCategory = $_POST['dropIncomeCategory'];
      switch ($PB->dropIncomeCategory($dropIncomeCategory)) {
        case ACTION_OK :
          $PB->setMessage('Usunięto wybraną kategorię !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się usunąć wybranej kategorii !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'dropExpenseCategory' :
      $dropExpenseCategory = $_POST['dropExpenseCategory'];
      switch ($PB->dropExpenseCategory($dropExpenseCategory)) {
        case ACTION_OK :
          $PB->setMessage('Usunięto wybraną kategorię !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się usunąć wybranej kategorii !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'dropPaymentMethod' :
      $dropPaymentMethod = $_POST['dropPaymentMethod'];
      switch ($PB->dropPaymentMethod($dropPaymentMethod)) {
        case ACTION_OK :
          $PB->setMessage("Usunięto wybraną kategorię !");
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się usunąć wybranej kategorii !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'dropSingleRecordOfIncome' :
      $singleRecordId = $_GET['incomeId'];
      $peroid         = $_GET['peroid'];
      $startDate      = $_GET['startDate'];
      $lastDate       = $_GET['lastDate'];     
      switch ($PB->dropSingleRecordOfIncome($singleRecordId)) {
        case ACTION_OK :
          $PB->setMessage("Usunięto wybrany rekord !");
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się usunąć wybranego rekordu !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showBalance&peroid='.$peroid.'&startDate='.$startDate.'&lastDate='.$lastDate.'');
      break;
    case 'dropSingleRecordOfExpense' :
      $singleRecordId = $_GET['expenseId'];
      $peroid         = $_GET['peroid'];
      $startDate      = $_GET['startDate'];
      $lastDate       = $_GET['lastDate'];   
      switch ($PB->dropSingleRecordOfExpense($singleRecordId)) {
        case ACTION_OK :
          $PB->setMessage("Usunięto wybrany rekord !");
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się usunąć wybranego rekordu !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showBalance&peroid='.$peroid.'&startDate='.$startDate.'&lastDate='.$lastDate.'');
      break;
    case 'addIncomeCategoryName' :
      $categoryName = $_POST['incomeCategoryName'];
      switch ($PB->addIncomeCategoryName($categoryName)) {
        case ACTION_OK :
          $PB->setMessage('Dodano nową kategorię !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się dodać nowej kategorii !');
          break;
        case CATEGORY_ALREADY_EXIST :
          $PB->setMessage('Znaleziono w bazie kategorię o takiej samej nazwie !'.'</br>'.'Prawidłowy format to: Nowa Kategoria Przychodu (bez polskich znaków). ');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'addExpenseCategoryName' :
      $categoryName = $_POST['expenseCategoryName'];
      switch ($PB->addExpenseCategoryName($categoryName)) {
        case ACTION_OK :
          $PB->setMessage('Dodano nową kategorię !');
          break;
        case CATEGORY_ALREADY_EXIST :
          $PB->setMessage('Znaleziono w bazie kategorię o takiej samej nazwie !'.'</br>'.'Prawidłowy format to: Nowa Kategoria Wydatku (bez polskich znaków). ');
          break;        
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się dodać nowej kategorii !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'addPaymentMethod' :
      $paymentMethodName = $_POST['paymentMethod'];
      switch ($PB->addPaymentMethod($paymentMethodName)) {
        case ACTION_OK :
          $PB->setMessage('Dodano nową metodę płatności !');
          break;
        case CATEGORY_ALREADY_EXIST :
          $PB->setMessage('Znaleziono w bazie metodę płatności o takiej samej nazwie !'.'</br>'.'Prawidłowy format to: Nowa Metoda Płatności (bez polskich znaków). ');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się dodać nowej metody płatności !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'changeExpenseCategory' :
      $categoryNameToModify   = $_POST['categoryNameToModify'];
      $newExpenseCategoryName = $_POST['newExpenseCategoryName'];
      $amountLimit = $_POST['inputLimit'];
      switch ($PB->changeExpenseCategory($categoryNameToModify, $newExpenseCategoryName, $amountLimit)) {
        case ACTION_OK :
          $PB->setMessage('Zmodyfikowano nazwę kategorii wydatku !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się zmodyfikować nazwy kategorii wydatku !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;  
    case 'changePaymentMethod' :
      $categoryNameToModify = $_POST['categoryNameToModify'];
      $newPaymentMethod     = $_POST['newPaymentMethod'];
      switch ($PB->changePaymentMethod($categoryNameToModify, $newPaymentMethod)) {
        case ACTION_OK :
          $PB->setMessage('Zmodyfikowano nazwę metody płatności !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się zmodyfikować nazwy metody płatności !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;  
    case 'changeIncomeCategory' :
      $categoryNameToModify  = $_POST['categoryNameToModify'];
      $newIncomeCategoryName = $_POST['newIncomeCategoryName'];
      switch ($PB->changeIncomeCategory($categoryNameToModify, $newIncomeCategoryName)) {
        case ACTION_OK :
          $PB->setMessage('Zmodyfikowano nazwę kategorii przychodu !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się zmodyfikować nazwy kategorii przychodu !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'editUserLogin' :
      switch ($PB->editUserLogin()) {
        case ACTION_OK :
          $PB->setMessage('Zmodyfikowano dane uzytkownika !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się zmodyfikować danych uzytkownika !');
          break;
        case LOGIN_ALREADY_EXIST :
          $PB->setMessage('Podany login występuje w bazie !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    case 'editUserPassword' :
      switch ($PB->editUserPassword()) {
        case ACTION_OK :
          $PB->setMessage('Zmieniono hasło !');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się zmienić hasła !');
          break;
        case PASSWORD_DO_NOT_MATCH :
          $PB->setMessage('Hasło musi posiadać od 6 do 20 znaków !');
          break;
        case SERVER_ERROR :
          $PB->setMessage('Błąd serwera !');
          break;
        }
      header('Location: index.php?action=showSettings');
      break;
    /*case 'deleteProfile' :
      if(isset($_GET['id'])) {
        $id = $_GET['id'];
      }
      switch ($PB->deleteProfile()) {
        case ACTION_OK :
          $PB->setMessage('Konto zostało usunięte ! Następuje wylogowanie... ');
          $PB->logOut();
          header('Location: index.php?action=showStart');
          break;
        case ACTION_FAILED :
          $PB->setMessage('Nie udało się usunąć konta. Skontaktuj się z administratorem strony !');
          break; 
        case SERVER_ERROR :
        default :
          $PB->setMessage('Bład serwera !');
      }
      header('Location: index.php?action=showSettings');
      break;*/
      default :
      include 'templates/mainTemplate.php';
  }
}

catch(Excepiton $e) {
  echo 'Bład: '.$e->getMessage();
  exit("Strona chwilowo niedostępna");
}

function classLoader($nazwa) {
  if(file_exists("classes/$nazwa.php")) {
    require_once("classes/$nazwa.php");
  } else {
    throw new Exception("Brak pliku z definicją klasy.");
  }
}

