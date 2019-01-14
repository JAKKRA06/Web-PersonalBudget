<?php
class User extends MyDB
{
    public  $loginUser = null;
  
    function __construct($host, $user, $pass, $db)
    {
        $this->dbo = $this->startConnection($host, $user, $pass, $db);
        $this->loginUser = $this->getActualUser();
    }

    function getActualUser()
    {
        if(isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $query  = "SELECT username FROM users"
                    . " WHERE id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();

                $_SESSION['loginUser'] = $row['username'];
                return $_SESSION['loginUser'];
            } 
        } else {
            return null;
        }
    }
    
    function setMessage($text) 
    {
        $_SESSION['statement'] = $text;
    }

    function getMessage()
    {
        if (isset($_SESSION['statement'])) {
        	$statement = $_SESSION['statement'];
        	unset($_SESSION['statement']);
        	return $statement;
        } else {
        	return null;
        }
    }

    function logIn()
    {
        if (!$this->dbo) return SERVER_ERROR;

        if (!isset($_POST['login'])) {
            return FORM_DATA_MISSING;
           }

        $name     = $_POST['login'];
        $password = $_POST['password'];

        $name = htmlentities($name, ENT_QUOTES, 'UTF-8');

        $name     = $this->dbo->real_escape_string($name);
        $password = $this->dbo->real_escape_string($password);

        $query    = "SELECT * FROM users WHERE username= '$name'";
        if (!$result = $this->dbo->query($query)) {
            return SERVER_ERROR;
        }

        if ($result->num_rows <> 1) {
            return ACTION_FAILED; // zbyt wielu uzytkowników
        } else {
            $row = $result->fetch_assoc();

            if (!password_verify($password, $row['password'])) {
                return ACTION_FAILED;
            } else {
                $_SESSION['loginUser'] = $row['username'];
                $_SESSION['userId']    = $row['id'];

                return ACTION_OK;
            }
        }
    }

    function logOut()
    {
        $this->loginUser = null;
        if (isset($_SESSION['loginUser'])) {
        	unset($_SESSION['loginUser']);
        }
    }

    function registration()
    {
        if (!isset($_POST['nick'])) {
           return FORM_DATA_MISSING;
        }

        $nick = $_POST['nick'];
        
        if ((strlen($nick) < 3 ) || (strlen($nick) > 20)) {
           return LOGIN_FAILED;
        }
        
        if (ctype_alnum($nick) == false) {
            return LOGIN_FAILED;
        } 

        $query = "SELECT COUNT(*) FROM users WHERE username = '$nick'";
        if ($this->getQuerySingleResult($query) > 0) {
            return LOGIN_ALREADY_EXIST;
        }

        $password = $_POST['password'];
        
        if ((strlen ($password) < 6) || (strlen ($password) > 20)) {
            return PASSWORD_DO_NOT_MATCH;
        }
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // tworzenie zmiennych sesyjnych, ktore beda zapamietane przez formularv przy blednej rejestracji
        
        $_SESSION['R_nick']     = $nick;
        $_SESSION['R_password'] = $password;
    
        $query = "INSERT INTO users VALUES (NULL, '$nick', '$password_hash')";

        if ($result = $this->dbo->query($query)) {
        
            $result = $this->dbo->query("SELECT * FROM users WHERE username = '$nick'");
                        
            $row = $result->fetch_assoc();
                        
            $userId = $row['id'];
            $query = "INSERT INTO incomes_category_assigned_to_users"
                   . " (user_id, name) SELECT '$userId', name FROM "
                   . " incomes_category_default";        
            $this->dbo->query($query); 

            $query = "INSERT INTO expenses_category_assigned_to_users"
                   . " (user_id, name) SELECT  '$userId', name FROM "
                   . "expenses_category_default";
            $this->dbo->query($query);
            
            $query = "INSERT INTO payment_methods_assigned_to_users "
                   . "(user_id, name) SELECT '$userId', name FROM "
                   . "payment_methods_default";
            $this->dbo->query($query);
                        
            return ACTION_OK;               
        }
    }

    function editUserLogin()
    {
        $newLogin = new Budget($this->dbo);
        return $newLogin->editUserLogin();
    }

    function editUserPassword()
    {
        $newPassword = new Budget($this->dbo);
        return $newPassword->editUserPassword();
    }



    function addIncome() 
    {
        $income = new Budget($this->dbo);
        return $income->addIncome();
    }

    function modifyIncome($idRecordToModify)
    {
        $modifyIncome = new Budget($this->dbo);
        return $modifyIncome->modifyIncome($idRecordToModify);
    }

    function addExpense() 
    {
        $expense = new Budget($this->dbo);
        return $expense->addExpense();
    }
    
    function modifyExpense($idRecordToModify)
    {
        $modifyExpense = new Budget($this->dbo);
        return $modifyExpense->modifyExpense($idRecordToModify);  
    }

    function addIncomeCategoryName($categoryName)
    {
        $addIncomeCategoryName = new Budget($this->dbo);
        return $addIncomeCategoryName->addIncomeCategoryName($categoryName);
    }

    function addExpenseCategoryName($categoryName)
    {
        $addExpenseCategoryName = new Budget($this->dbo);
        return $addExpenseCategoryName->addExpenseCategoryName($categoryName);
    }

    function addPaymentMethod($paymentMethodName)
    {
        $paymentMethod = new Budget($this->dbo);
        return $paymentMethod->addPaymentMethod($paymentMethodName);
    }



    function showBalance($peroid, $startDate, $lastDate)
    {
        $balance = new Budget($this->dbo);
        $balance->showBalance($peroid, $startDate, $lastDate);
    }



    function selectAllIncomes()
    {
        $allIncomes = new Budget($this->dbo);
        return $allIncomes->selectAllIncomes();  
    }

    function selectAllExpenses()
    {
        $allExpenses = new Budget($this->dbo);
        return $allExpenses->selectAllExpenses();  
    }

    function selectAllPaymentMethods()
    {
        $allPaymentMethods = new Budget($this->dbo);
        return $allPaymentMethods->selectAllPaymentMethods();
    }

    function selectSingleRowOfIncome($idRecordToModify)
    {
        $singleRow = new Budget($this->dbo);
        return $singleRow->selectSingleRowOfIncome($idRecordToModify);  
    }

    function selectSingleRowOfExpense($idRecordToModify)
    {
        $singleRow = new Budget($this->dbo);
        return $singleRow->selectSingleRowOfExpense($idRecordToModify);  
    }



    function selectSinglePaymentMethod($idCategoryToModify)
    {
        $singleRow = new Budget($this->dbo);
        return $singleRow->selectSinglePaymentMethod($idCategoryToModify);       
    }

    function selectSingleIncomeCategoryName($idCategoryToModify)
    {
        $singleNameOfIncome = new Budget($this->dbo);
        return $singleNameOfIncome->selectSingleIncomeCategoryName($idCategoryToModify);
    }

    function selectSingleExpenseCategoryName($idCategoryToModify)
    {
        $singleNameOfExpense = new Budget($this->dbo);
        return $singleNameOfExpense->selectSingleExpenseCategoryName($idCategoryToModify);
    }



    function dropExpenseCategory($dropExpenseCategory)
    {
        $balance = new Budget($this->dbo);
        return $balance->dropExpenseCategory($dropExpenseCategory);
    }

    function dropIncomeCategory($dropIncomeCategory)
    {
        $balance = new Budget($this->dbo);
        return $balance->dropIncomeCategory($dropIncomeCategory);
    }

    function dropPaymentMethod($dropPaymentMethod)
    {
        $paymentMethod = new Budget($this->dbo);
        return $paymentMethod->dropPaymentMethod($dropPaymentMethod);
    }

    function dropSingleRecordOfIncome($singleRecordId)
    {
        $singleRecord = new Budget($this->dbo);
        return $singleRecord->dropSingleRecordOfIncome($singleRecordId);
    }

    function dropSingleRecordOfExpense($singleRecordId)
    {
        $singleRecord = new Budget($this->dbo);
        return $singleRecord->dropSingleRecordOfExpense($singleRecordId);
    }



    function changeExpenseCategory($categoryNameToModify, $newExpenseCategoryName)
    {
         $change = new Budget($this->dbo);
         return $change->changeExpenseCategory($categoryNameToModify, $newExpenseCategoryName);
    }

    function changeIncomeCategory($categoryNameToModify, $newIncomeCategoryName)
    {
         $change = new Budget($this->dbo);
         return $change->changeIncomeCategory($categoryNameToModify, $newIncomeCategoryName);
    }

    function changePaymentMethod($categoryNameToModify, $newPaymentMethod)
    {
         $change = new Budget($this->dbo);
         return $change->changePaymentMethod($categoryNameToModify, $newPaymentMethod);
    }
}