<?php
class Budget
{
	private $dbo = null;

	function __construct($dbo)
	{
		$this->dbo = $dbo;
	}

    function editUserPassword()
    {
    	if(isset($_POST['newPassword'])) {

           $newPassword = $_POST['newPassword'];

           $newPassword = $this->dbo->real_escape_string($newPassword);
           $userId      = $_SESSION['userId'];
           
          
            if((strlen ($newPassword) < 6) || (strlen ($newPassword) > 20)) {
                return PASSWORD_DO_NOT_MATCH;
            }
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

	        $allOk = false;
                
            $query = "UPDATE users SET password = '$passwordHash'"
	        	   . " WHERE users.id = '$userId'";
	        
	        if($this->dbo->query($query)) {
	           $allOk = true;
	        }
	        if($allOk == true) {
	           return ACTION_OK;
	        } else {
	        	return ACTION_FAILED;
	        }        	
        }
    }

    function editUserLogin()
    {
		if (isset($_POST['newLogin'])) {  
		    
		    $newLogin = $_POST['newLogin'];

            $newLogin = htmlentities($newLogin, ENT_QUOTES, 'UTF-8');

            $newLogin = $this->dbo->real_escape_string($newLogin);
            $userId   = $_SESSION['userId'];

            $query = "SELECT * FROM users WHERE username = '$newLogin'";
         
            if (!$result = $this->dbo->query($query)) {
                return SERVER_ERROR;
            } 

            if($result->num_rows > 0) {
            	return LOGIN_ALREADY_EXIST;
            } else {

	            $allOk = false;
                
                $query = "UPDATE users SET username = '$newLogin'"
	        	       . " WHERE users.id = '$userId'";
	            if($this->dbo->query($query)) {
	               $allOk = true;
	        	}

	        	if($allOk == true) {
	        		return ACTION_OK;
	        	} else {
	        		return ACTION_FAILED;
	        	}        	
            }
		}
    }

	function addIncome()
	{
		if (isset($_POST['income_amount'])) {
			//spr kwoty

			$incomeDate   = $_POST['income_date'];
			$amount       = $_POST['income_amount'];
			$comment      = $_POST['income_comment'];
			$incomeSelect = $_POST['income_select'];

			$_SESSION['amountIncomeRemember']   = $amount;
            $_SESSION['dateIncomeRemember']     = $incomeDate;
            $_SESSION['commentIncomeRemember']  = $comment;
            $_SESSION['categoryIncomeRemember'] = $incomeSelect;




			if (is_numeric($amount) == false) {
				return INVALID_FORMAT;
			}
			
			// spr daty 
			$year  = substr($incomeDate, 0, 4);
			$month = substr($incomeDate, 5, 2);
			$day   = substr($incomeDate, 8);

			if (checkdate((int)$month, (int)$day, (int)$year) == false) {
                return INVALID_FORMAT;
			}

			//spr komentarza max 100 
			
			if (strlen($comment) > 100 ) {
                return COMMENT_TOO_LONG;
          	}
			
			// spr wyboru listy
			$incomeCategoryArray = [];

			$incomeCategory = $this->selectAllIncomes();
			while ($row = $incomeCategory->fetch_assoc()) {
				  $incomeCategoryArray[] .= $row['name'];
			}
			
			if (!in_array($_POST['income_select'], $incomeCategoryArray)) {
                return FORM_DATA_MISSING;
			}
		    
			$username = $_SESSION['loginUser'];
						
            $userId = $_SESSION['userId'];	



            $query = "SELECT id FROM incomes_category_assigned_to_users WHERE "
                   . "name = '$incomeSelect' AND user_id = '$userId'";

            $result = $this->dbo->query($query);
            $row    = $result->fetch_assoc();
			$idIncomeAssignedToUser = $row['id'];

			$query = "INSERT INTO incomes VALUES" 
				   . "(NULL, '$userId',  '$idIncomeAssignedToUser',"
				   . " '$amount', '$incomeDate', '$comment' )";

			if ($this->dbo->query($query)) {
				return ACTION_OK;
			} else {
				return SERVER_ERROR;
			}
		}
	}

	function modifyIncome($idRecordToModify)
	{
		if ((isset($_POST['income_amount'])) || (isset($_POST['income_comment'])) || (isset($_POST['income_select'])) || (isset($_POST['income_date']))) {
			//spr kwoty
			$amount = $_POST['income_amount'];
			if (is_numeric($amount) == false) {
				return INVALID_FORMAT;
			}
			
			// spr daty 
			$incomeDate = $_POST['income_date'];

			$year  = substr($incomeDate, 0, 4);
			$month = substr($incomeDate, 5, 2);
			$day   = substr($incomeDate, 8);

			if (checkdate((int)$month, (int)$day, (int)$year) == false) {
                return INVALID_FORMAT;
			}

			//spr komentarza max 100 
			$incomeComment = $_POST['income_comment'];
			if (strlen($incomeComment) > 100 ) {
                return COMMENT_TOO_LONG;
          	}

			$incomeSelect = $_POST['income_select'];

            $userId = $_SESSION['userId'];					

            $query = "SELECT id FROM incomes_category_assigned_to_users WHERE "
                   . "name = '$incomeSelect' AND user_id = '$userId'";

            $result = $this->dbo->query($query);
            $row    = $result->fetch_assoc();
			$idIncomeAssignedToUser = $row['id'];

	        $allOk = false;

        	if(isset($_POST['income_amount'])) {
        	  $query = "UPDATE incomes SET amount = '$amount'"
        	         . " WHERE incomes.id = '$idRecordToModify'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}
        	if(isset($_POST['income_select'])) {
        	  $query = "UPDATE incomes SET income_category_assigned_to_user_id = '$idIncomeAssignedToUser' "
        	         . "WHERE id = '$idRecordToModify' AND user_id = '$userId'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}	        	
        	if(isset($_POST['income_date'])) {
        	  $query = "UPDATE incomes SET date_of_income = '$incomeDate' "
        	         . "WHERE id = '$idRecordToModify' AND user_id = '$userId'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}	        	
        	if(isset($_POST['income_comment'])) {
        	  $query = "UPDATE incomes SET income_comment = '$incomeComment' "
        	         . "WHERE id = '$idRecordToModify' AND user_id = '$userId'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}
        	if($allOk == true) {
        		return ACTION_OK;
        	} else {
        		return ACTION_FAILED;
        	}
		}
	}

    function addExpense()
    {
        if (isset($_POST['expense_amount'])) {

			$amount                = $_POST['expense_amount'];
			$expenseDate           = $_POST['expense_date'];
			$paymentMethodFromPost = $_POST['expense_payment_method'];
            $expenseCategorySelect = $_POST['expense_category_select'];
			$comment               = $_POST['expense_comment'];


			$_SESSION['amountExpenseRemember']   = $amount;
            $_SESSION['dateExpenseRemember']     = $expenseDate;
            $_SESSION['commentExpenseRemember']  = $comment;
            $_SESSION['categoryExpenseRemember'] = $expenseCategorySelect;
            $_SESSION['expensePaymentRemember']  = $paymentMethodFromPost;


			//spr kwoty
			if (is_numeric($amount) == false) {
				return INVALID_FORMAT;
			}

			// spr daty 
			$year  = substr($expenseDate, 0, 4);
			$month = substr($expenseDate, 5, 2);
			$day   = substr($expenseDate, 8);

			if (checkdate((int)$month, (int)$day, (int)$year) == false) {
                return INVALID_FORMAT;
			}
		
		    // spr wyboru listy
			$paymentMethodsArray = [];

			$payments = $this->selectAllPaymentMethods();
			while ($row = $payments->fetch_assoc()) {
				  $paymentMethodsArray[] .= $row['name'];
			}


			if(!in_array($paymentMethodFromPost, $paymentMethodsArray)) {
                return FORM_DATA_MISSING;
			}
		
			if (strlen($comment) > 100 ) {
                return COMMENT_TOO_LONG;
            }

			$expensesCategoryArray = [];

			$expensesCategory = $this->selectAllExpenses();
			while ($row = $expensesCategory->fetch_assoc()) {
				  $expensesCategoryArray[] .= $row['name'];
			}		
			
			if(!in_array($expenseCategorySelect, $expensesCategoryArray)) {
                return FORM_DATA_MISSING;
			}


            $paymentMethod = $_POST['expense_payment_method'];
            $username      = $_SESSION['loginUser'];
			
            $userId = $_SESSION['userId'];					

            $query = "SELECT id FROM expenses_category_assigned_to_users WHERE "
                   . "name = '$expenseCategorySelect' AND user_id = '$userId'";

	        $query  = "SELECT id FROM expenses_category_assigned_to_users WHERE "
	                . "name = '$expenseCategorySelect' AND user_id = '$userId'";

            $result = $this->dbo->query($query);
            $row    = $result->fetch_assoc();       
            $idExpenseAssignedToUser = $row['id'];

            $query  = "SELECT id FROM payment_methods_assigned_to_users WHERE "
                    . "name = '$paymentMethod' AND user_id = '$userId'";

            $result = $this->dbo->query($query);
            $row    = $result->fetch_assoc();
			$idPaymentMethod = $row['id'];

			$query  = "INSERT INTO expenses VALUES" 
				    . "(NULL, '$userId',  '$idExpenseAssignedToUser',"
				    . " '$idPaymentMethod', '$amount', '$expenseDate', '$comment')";
			
			if ($this->dbo->query($query)) {
				return ACTION_OK;
			} else {
				return SERVER_ERROR;
			}			
			
		}
	}

	function modifyExpense($idRecordToModify)
	{
		if ( (isset($_POST['expense_amount'])) || (isset($_POST['expense_comment'])) || 
			 (isset($_POST['expense_category_select'])) || (isset($_POST['expense_date'])) || 
			 (isset($_POST['expense_payment_method']))) {
			//spr kwoty
			$amount = $_POST['expense_amount'];
			if (is_numeric($amount) == false) {
				return INVALID_FORMAT;
			}
			
			// spr daty 
			$expenseDate = $_POST['expense_date'];

			$year  = substr($expenseDate, 0, 4);
			$month = substr($expenseDate, 5, 2);
			$day   = substr($expenseDate, 8);

			if (checkdate((int)$month, (int)$day, (int)$year) == false) {
                return INVALID_FORMAT;
			}

			//spr komentarza max 100 
			$expenseComment = $_POST['expense_comment'];
			if (strlen($expenseComment) > 100 ) {
                return COMMENT_TOO_LONG;
          	}

			$expenseSelect = $_POST['expense_category_select'];

            $userId = $_SESSION['userId'];					

            $query = "SELECT id FROM expenses_category_assigned_to_users WHERE "
                   . "name = '$expenseSelect' AND user_id = '$userId'";

            $result = $this->dbo->query($query);
            $row    = $result->fetch_assoc();
			$idExpenseAssignedToUser = $row['id'];


			$paymentMethod = $_POST['expense_payment_method'];

            $query = "SELECT id FROM payment_methods_assigned_to_users WHERE "
                   . "name = '$paymentMethod' AND user_id = '$userId'";

            $result = $this->dbo->query($query);
            $row    = $result->fetch_assoc();
			$idPaymentMethodAssignedToUser = $row['id'];
	        $allOk = false;

        	if(isset($_POST['expense_amount'])) {
        	  $query = "UPDATE expenses SET amount = '$amount'"
        	         . " WHERE expenses.id = '$idRecordToModify'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}
        	if(isset($_POST['expense_category_select'])) {
        	  $query = "UPDATE expenses SET expense_category_assigned_to_user_id = '$idExpenseAssignedToUser' "
        	         . "WHERE id = '$idRecordToModify' AND user_id = '$userId'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}	
        	if(isset($_POST['expense_payment_method'])) {
        	  $query = "UPDATE expenses SET payment_method_assigned_to_user_id = '$idPaymentMethodAssignedToUser' "
        	         . "WHERE id = '$idRecordToModify' AND user_id = '$userId'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}
        	if(isset($_POST['expense_date'])) {
        	  $query = "UPDATE expenses SET date_of_expense = '$expenseDate' "
        	         . "WHERE id = '$idRecordToModify' AND user_id = '$userId'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}	        	
        	if(isset($_POST['expense_comment'])) {
        	  $query = "UPDATE expenses SET expense_comment = '$expenseComment' "
        	         . "WHERE id = '$idRecordToModify' AND user_id = '$userId'";
        	  if($this->dbo->query($query)) {
        	  	$allOk = true;
        	  }
        	}
        	if($allOk == true) {
        		return ACTION_OK;
        	} else {
        		return ACTION_FAILED;
        	}
		}
	}

	function showBalance($peroid, $startDate, $lastDate)
	{
        $userId = $_SESSION['userId'];

		if ($peroid == 'currentMonth') {

			$dateStart = new DateTime('first day of this month');
		    $startDate = $dateStart->format('Y-m-d');

			$dateLast  = new DateTime('last day of this month');
			$lastDate  = $dateLast->format('Y-m-d');

            $query = "SELECT id FROM incomes_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }

			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			             . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			             . " AND income_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$userId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC";
                
            $query = "SELECT id FROM expenses_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }
			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " AND expense_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

		    include 'templates/currentBalanceForm.php';

		} else if ($peroid == 'previousMonth') {

			$dateStart = new DateTime('first day of last month');
		    $startDate = $dateStart->format('Y-m-d');

			$dateLast  = new DateTime('last day of last month');
			$lastDate  = $dateLast->format('Y-m-d');


            $query = "SELECT id FROM incomes_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }

			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			             . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			             . " AND income_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$userId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC";
                
            $query = "SELECT id FROM expenses_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }
			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " AND expense_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

			include 'templates/previousMonthBalanceForm.php';

		} else if ($peroid == 'currentYear') {

			$startDate = new DateTime('first day of January ' . date('Y'));
			$startDate = $startDate->format('Y-m-d');

			$lastDate = new DateTime('last day of December ' . date('Y'));
			$lastDate = $lastDate->format('Y-m-d');


            $query = "SELECT id FROM incomes_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }

			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			             . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			             . " AND income_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$userId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC";
                
            $query = "SELECT id FROM expenses_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }
			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " AND expense_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

			include 'templates/currentYearBalanceForm.php';

		} else if ($peroid == 'nonStandard') {

			$startDate = $startDate; 
			$lastDate  = $lastDate;

            $query = "SELECT id FROM incomes_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }

			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			             . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			             . " AND income_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$userId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC";
                
            $query = "SELECT id FROM expenses_category_assigned_to_users WHERE name = 'Pozostale'"
                   . " AND user_id = '$userId'";

            if ($result = $this->dbo->query($query)) {
                $row = $result->fetch_assoc();
                $idCategoryNamePozostale = $row['id'];
            }
			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " AND expense_category_assigned_to_user_id <> '$idCategoryNamePozostale'";

			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$userId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

			include 'templates/nonStandardBalanceForm.php';
		}
	}

    function dropIncomeCategory($dropIncomeCategory)
    {
        if (!$this->dbo) {
            return SERVER_ERROR;
        }

        $userId = $_SESSION['userId'];
        
        $query  = "SELECT id FROM incomes_category_assigned_to_users WHERE name = '$dropIncomeCategory'"
                . " AND user_id = '$userId'";

        $result = $this->dbo->query($query);
        $row    = $result->fetch_assoc();
        $dropCategoryId = $row['id'];
        
        $query = "SELECT id FROM incomes_category_assigned_to_users WHERE name = 'Pozostale'"
               . " AND user_id = '$userId'";

        if ($result = $this->dbo->query($query)) {
        	if ($result->num_rows < 1) {         
                $query1  = "INSERT INTO incomes_category_assigned_to_users  VALUES"
                        . " (NULL, $userId, 'Pozostale')";
                if($this->dbo->query($query1)) {
                   $query2 = "SELECT id FROM incomes_category_assigned_to_users WHERE name = 'Pozostale'"
                           . " AND user_id = '$userId'";
                   $result = $this->dbo->query($query2);               
        		   $row                 = $result->fetch_assoc();
                   $idCategoryPozostale = $row['id'];       
                }
            } else {
                $row                 = $result->fetch_assoc();
                $idCategoryPozostale = $row['id'];  
            }

	        $query = "UPDATE incomes SET income_category_assigned_to_user_id = '$idCategoryPozostale'"
	               . " WHERE incomes.income_category_assigned_to_user_id = '$dropCategoryId'";

	        if ($this->dbo->query($query)) {
	            $query  = "DELETE FROM incomes_category_assigned_to_users"
	                    . " WHERE name = '$dropIncomeCategory' AND user_id = '$userId'";

	    	    if ($this->dbo->query($query)) {
	    		    return ACTION_OK;
	        	} else {
	    	    	return ACTION_FAILED;
	    	    }
	        }
	    }
    }

    function dropPaymentMethod($dropPaymentMethod)
    {
        if (!$this->dbo) {
            return SERVER_ERROR;
        }

        $userId = $_SESSION['userId'];
        
        $query  = "DELETE FROM payment_methods_assigned_to_users"
                . " WHERE name = '$dropPaymentMethod' AND user_id = '$userId'";

	    if ($this->dbo->query($query)) {
		    return ACTION_OK;
    	} else {
	    	return ACTION_FAILED;
	    }
    }

    function dropExpenseCategory($dropExpenseCategory)
    {
        if (!$this->dbo) {
            return SERVER_ERROR;
        }

        $userId = $_SESSION['userId'];
        
        $query  = "SELECT id FROM expenses_category_assigned_to_users WHERE name = '$dropExpenseCategory'"
                . " AND user_id = '$userId'";


        $result = $this->dbo->query($query);
        $row = $result->fetch_assoc();
        $dropCategoryId = $row['id'];
        
        $query = "SELECT id FROM expenses_category_assigned_to_users WHERE name = 'Pozostale'"
               . " AND user_id = '$userId'";

        if ($result = $this->dbo->query($query)) {
        	if ($result->num_rows < 1) {              
                $query1  = "INSERT INTO expenses_category_assigned_to_users  VALUES"
                         . " (NULL, $userId, 'Pozostale')";
                if($this->dbo->query($query1)) {
                   $query2 = "SELECT id FROM expenses_category_assigned_to_users WHERE name = 'Pozostale'"
                           . " AND user_id = '$userId'";

                   $result = $this->dbo->query($query2);               
        		   $row                 = $result->fetch_assoc();
                   $idCategoryPozostale = $row['id'];       
                }
            } else {
                $row                 = $result->fetch_assoc();
                $idCategoryPozostale = $row['id'];  
            }

	        $query = "UPDATE expenses SET expense_category_assigned_to_user_id = '$idCategoryPozostale'"
	               . " WHERE expenses.expense_category_assigned_to_user_id = '$dropCategoryId'";

	        if ($this->dbo->query($query)) {
	            $query  = "DELETE FROM expenses_category_assigned_to_users"
	                    . " WHERE name = '$dropExpenseCategory' AND user_id = '$userId'";

	    	    if ($this->dbo->query($query)) {
	    		    return ACTION_OK;
	        	} else {
	    	    	return ACTION_FAILED;
	    	    }
	        }
	    }
    }

    function dropSingleRecordOfIncome($singleRecordId)
    {
        if (!$this->dbo) {
            return SERVER_ERROR;
        }

        $userId = $_SESSION['userId'];
        
        $query  = "DELETE FROM incomes"
                . " WHERE id = '$singleRecordId' AND user_id = '$userId'";

	    if ($this->dbo->query($query)) {
		    return ACTION_OK;
    	} else {
	    	return ACTION_FAILED;
	    }
    }

    function dropSingleRecordOfExpense($singleRecordId)
    {
        if (!$this->dbo) {
            return SERVER_ERROR;
        }

        $userId = $_SESSION['userId'];
        
        $query  = "DELETE FROM expenses"
                . " WHERE id = '$singleRecordId' AND user_id = '$userId'";

	    if ($this->dbo->query($query)) {
		    return ACTION_OK;
    	} else {
	    	return ACTION_FAILED;
	    }
    }


    function selectAllExpenses()
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];

        $query = "SELECT name FROM expenses_category_assigned_to_users WHERE user_id = '$userId'"
               . " AND name <> 'Pozostale'";

        if ($allExpenses = $this->dbo->query($query)) {
        	return $allExpenses;
        }
    }

    function selectAllPaymentMethods()
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];

        $query = "SELECT name FROM payment_methods_assigned_to_users WHERE user_id = '$userId'";

        if ($allPaymentMethods = $this->dbo->query($query)) {
        	return $allPaymentMethods;
        }
    }

    function selectAllIncomes()
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];

        $query = "SELECT name FROM incomes_category_assigned_to_users WHERE user_id = '$userId'"
               . " AND name <> 'Pozostale'";

        if ($allIncomes = $this->dbo->query($query)) {
        	return $allIncomes;
        }
    }

    function selectSingleRowOfIncome($idRecordToModify)
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];
        
        $query = "SELECT income_category_assigned_to_user_id, amount, date_of_income,"
               . " income_comment FROM incomes WHERE id = '$idRecordToModify' AND"
               . " user_id = '$userId'";

        if ($singleRow = $this->dbo->query($query)) {
        	return $singleRow;
        }
    }

    function selectSingleRowOfExpense($idRecordToModify)
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];
        
        $query = "SELECT * FROM expenses WHERE id = '$idRecordToModify' AND"
               . " user_id = '$userId'";

        if ($singleRow = $this->dbo->query($query)) {
        	return $singleRow;
        }
    }

    function selectSingleIncomeCategoryName($idCategoryToModify)
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];
        
        $query = "SELECT name FROM incomes_category_assigned_to_users"
               . " WHERE id = '$idCategoryToModify' AND user_id = '$userId'";
                            	    
        if($result = $this->dbo->query($query)) {
           $row = $result->fetch_assoc();
           return $categoryNameToModify = $row['name'];
        }
    }

    function selectSingleExpenseCategoryName($idCategoryToModify)
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];
        
        $query = "SELECT name FROM expenses_category_assigned_to_users"
               . " WHERE id = '$idCategoryToModify' AND user_id = '$userId'";
                            	    
        if($result = $this->dbo->query($query)) {
           $row = $result->fetch_assoc();
           return $categoryNameToModify = $row['name'];
        }
    }

    function selectSinglePaymentMethod($idCategoryToModify)
    {
      	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
 
        $userId = $_SESSION['userId'];
        
        $query = "SELECT name FROM payment_methods_assigned_to_users"
               . " WHERE id = '$idCategoryToModify' AND user_id = '$userId'";
                            	    
        if($result = $this->dbo->query($query)) {
           $row = $result->fetch_assoc();
           return $categoryNameToModify = $row['name'];
        }
    }


    function addIncomeCategoryName($categoryName)
    {
    	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
        $userId = $_SESSION['userId'];
    	$newCategoryName = ucwords(strtolower($categoryName));

        $query = "SELECT name FROM  incomes_category_assigned_to_users"
               . " WHERE name = '$newCategoryName' AND user_id = '$userId'";
        if($result = $this->dbo->query($query)) {
        	if($result->num_rows > 0) {
        	   return CATEGORY_ALREADY_EXIST;
        	}
        }

        $userId = $_SESSION['userId'];

    	$query = "INSERT INTO incomes_category_assigned_to_users VALUES"
    	       . " (NULL, '$userId', '$newCategoryName')";

    	if ($this->dbo->query($query)) {
    		return ACTION_OK;
    	} else {
    		return ACTION_FAILED;
    	}
    }

    function addExpenseCategoryName($categoryName)
    {
    	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
        $userId = $_SESSION['userId'];
    	$newCategoryName = ucwords(strtolower($categoryName));
        $query = "SELECT name FROM  expenses_category_assigned_to_users"
               . " WHERE name = '$newCategoryName' AND user_id = '$userId'";
        if($result = $this->dbo->query($query)) {
        	if($result->num_rows > 0) {
        	   return CATEGORY_ALREADY_EXIST;
        	}
        }

        $userId = $_SESSION['userId'];

    	$query = "INSERT INTO expenses_category_assigned_to_users VALUES"
    	       . " (NULL, '$userId', '$newCategoryName')";

    	if ($this->dbo->query($query)) {
    		return ACTION_OK;
    	} else {
    		return ACTION_FAILED;
    	}
    }

    function addPaymentMethod($paymentMethodName)
    {
    	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}

    	$newCategoryName = ucwords(strtolower($paymentMethodName));

        $userId = $_SESSION['userId'];

        $query  = "SELECT name FROM  payment_methods_assigned_to_users"
                . " WHERE name = '$newCategoryName' AND user_id = '$userId'";
        if($result = $this->dbo->query($query)) {
        	if($result->num_rows > 0) {
        	   return CATEGORY_ALREADY_EXIST;
        	}
        }

    	$query = "INSERT INTO payment_methods_assigned_to_users VALUES"
    	       . " (NULL, '$userId', '$newCategoryName')";

    	if ($this->dbo->query($query)) {
    		return ACTION_OK;
    	} else {
    		return ACTION_FAILED;
    	}
    }




    function changeExpenseCategory($categoryNameToModify, $newExpenseCategoryName)
    {
       	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
        
        $query = "SELECT id FROM expenses_category_assigned_to_users WHERE"
               . " name = '$categoryNameToModify'";

        if ($result = $this->dbo->query($query)) {
            $row    = $result->fetch_assoc();
            $idCategoryNameToModify = $row['id'];
        }

        $newCategoryName = ucwords(strtolower($newExpenseCategoryName));

        $query = "UPDATE expenses_category_assigned_to_users SET name = '$newCategoryName'"
               . " WHERE expenses_category_assigned_to_users.id = '$idCategoryNameToModify'";
        
        if ($this->dbo->query($query)) {
        	return ACTION_OK;
        } else {
        	return ACTION_FAILED;
        }
    }

    function changeIncomeCategory($categoryNameToModify, $newIncomeCategoryName)
    {
       	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}

        $query = "SELECT id FROM incomes_category_assigned_to_users WHERE"
               . " name = '$categoryNameToModify'";

        if ($result = $this->dbo->query($query)) {
            $row    = $result->fetch_assoc();
            $idCategoryNameToModify = $row['id'];
        }

        $newCategoryName = ucwords(strtolower($newIncomeCategoryName));

        $query = "UPDATE incomes_category_assigned_to_users SET name = '$newCategoryName'"
               . " WHERE incomes_category_assigned_to_users.id = '$idCategoryNameToModify'";
        
        if ($this->dbo->query($query)) {
        	return ACTION_OK;
        } else {
        	return ACTION_FAILED;
        }
    }

    function changePaymentMethod($categoryNameToModify, $newPaymentMethod)
    {
       	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}
        
        $query = "SELECT id FROM payment_methods_assigned_to_users WHERE"
               . " name = '$categoryNameToModify'";

        if ($result = $this->dbo->query($query)) {
            $row    = $result->fetch_assoc();
            $idCategoryNameToModify = $row['id'];
        }

    	$newCategoryName = ucwords(strtolower($newPaymentMethod));

        $query = "UPDATE payment_methods_assigned_to_users SET name = '$newCategoryName'"
               . " WHERE payment_methods_assigned_to_users.id = '$idCategoryNameToModify'";
        
        if ($this->dbo->query($query)) {
        	return ACTION_OK;
        } else {
        	return ACTION_FAILED;
        }
    }



    function deleteProfile()
    {
       	if (!$this->dbo) {
    		return SERVER_ERROR;
    	}

        $allOk = false;
    	$userId = $_SESSION['userId'];


    	$query = "DELETE FROM expenses WHERE user_id = '$userId'";

    	if($this->dbo->query($query)) {
    	   $allOk = true;
        } else {
        	$allOk = false;
        }

    	$query1 = "DELETE FROM incomes WHERE user_id = '$userId'";   
    	if($this->dbo->query($query1)) {
    	   $allOk = true;
        } else {
        	$allOk = false;
        }

    	$query2 = "DELETE FROM expenses_category_assigned_to_users WHERE user_id = '$userId'";   
    	if($this->dbo->query($query2)) {
    	   $allOk = true;
        } else {
        	$allOk = false;
        }

    	$query3 = "DELETE FROM incomes_category_assigned_to_users WHERE user_id = '$userId'";   
    	if($this->dbo->query($query3)) {
    	   $allOk = true;
        } else {
        	$allOk = false;
        }

    	$query4 = "DELETE FROM payment_methods_assigned_to_users WHERE user_id = '$userId'";   
    	if($this->dbo->query($query4)) {
    	   $allOk = true;
        } else {
        	$allOk = false;
        }

    	$query5 = "DELETE FROM users WHERE id = '$userId'";   
    	if($this->dbo->query($query5)) {
    	   $allOk = true;
        } else {
        	$allOk = false;
        }

        if($allOk == true) {
           return ACTION_OK;

        } else {
        	return ACTION_FAILED;
        }	
    }
}
?>