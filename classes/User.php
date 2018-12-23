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
        if (isset($_SESSION['loginUser'])) {
            return $_SESSION['loginUser'];
        } else
            return null;
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
        
        $_SESSION['R_nick'] = $nick;
        $_SESSION['R_password'] = $password;
    
        $query = "INSERT INTO users VALUES (NULL, '$nick', '$password_hash')";

        if ($result = $this->dbo->query($query)) {
        
            $result = $this->dbo->query("SELECT * FROM users WHERE username = '$nick'");
                        
            $row = $result->fetch_assoc();
                        
            $user_id = $row['id'];
            $query = "INSERT INTO incomes_category_assigned_to_users"
                   . " (user_id, name) SELECT '$user_id', name FROM "
                   . " incomes_category_default";        
            $this->dbo->query($query); 

            $query = "INSERT INTO expenses_category_assigned_to_users"
                   . " (user_id, name) SELECT  '$user_id', name FROM "
                   . "expenses_category_default";
            $this->dbo->query($query);
            
            $query = "INSERT INTO payment_methods_assigned_to_users "
                   . "(user_id, name) SELECT '$user_id', name FROM "
                   . "payment_methods_default";
            $this->dbo->query($query);
                        
            return ACTION_OK;               
        }
    }

    function addIncome() 
    {
        $income = new Budget($this->dbo);
        return $income->addIncome();
    }

    function addExpense() 
    {
        $expense = new Budget($this->dbo);
        return $expense->addExpense();
    }

    function showBalance($peroid)
    {
        $balance = new Budget($this->dbo);
        $balance->showBalance($peroid);
    }

}