<?php
class Budget
{
	private $dbo = null;

	function __construct($dbo)
	{
		$this->dbo = $dbo;
	}

	function addIncome()
	{
		if (isset($_POST['income_amount'])) {
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
			
			$comment = $_POST['income_comment'];
			if (strlen($comment) > 100 ) {
                return COMMENT_TOO_LONG;
          	}
			
			// spr wyboru listy
			
			$incomeCategory = array("Wynagrodzenie", "Odsetki bankowe", "Allegro", "Inne");
			
			if (!in_array($_POST['income_select'], $incomeCategory)) {
                return FORM_DATA_MISSING;
			}
			
			$incomeSelect = $_POST['income_select'];
			$username = $_SESSION['loginUser'];
						
						
			$query = "SELECT * FROM users WHERE username = '$username'";

			if ($result = $this->dbo->query($query)) {

                $row = $result->fetch_assoc();
				$loginUserId = $row['id'];						


                $query = "SELECT id FROM incomes_category_assigned_to_users WHERE "
                       . "name = '$incomeSelect' AND user_id = '$loginUserId'";

                $result = $this->dbo->query($query);
                $row    = $result->fetch_assoc();
				$idIncomeAssignedToUser = $row['id'];

						
				$query = "INSERT INTO incomes VALUES" 
					   . "(NULL, '$loginUserId',  '$idIncomeAssignedToUser',"
					   . " '$amount', '$incomeDate', '$comment' )";
				
				if ($this->dbo->query($query)) {
					return ACTION_OK;
				} else {
					return SERVER_ERROR;
				}
			}
		}
	}

	function addExpense()
	{ //oddsielenie metody dla spr poprawnosci danych income i expense ?????????????????
		if (isset($_POST['expense_amount'])) {

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
		
		    // spr wyboru listy
			$paymentMethod = array("Gotowka", "Karta platnicza", "Karta kredytowa");
			
			if (!in_array($_POST['expense_payment_method'], $paymentMethod)) {
                return FORM_DATA_MISSING;
			}
		
			$comment = $_POST['expense_comment'];
			if (strlen($comment) > 100 ) {
                return COMMENT_TOO_LONG;
            }

			$expenseCategory = array("Mieszkanie", "Jedzenie", "Transport", "Telekomunikacja", "Opieka zdrowotna", "Ubranie", "Higiena", "Dzieci", "Rozrywka", "Wycieczka", "Ksiazki", "Oszczednosci", "Splta dlugow","Darowizna", "Na zlota jesien, czyli emeryture", "Inne wydatki");
			
			if (!in_array($_POST['expense_category_select'], $expenseCategory)) {
                return FORM_DATA_MISSING;
			}

			$paymentMethod = $_POST['expense_payment_method'];
			$expenseCategorySelect = $_POST['expense_category_select'];
		    $username = $_SESSION['loginUser'];
			
			$query = "SELECT * FROM users WHERE username = '$username'";

			if ($result = $this->dbo->query($query)) {

                $row = $result->fetch_assoc();
				$loginUserId = $row['id'];


                $query  = "SELECT id FROM expenses_category_assigned_to_users WHERE "
                        . "name = '$expenseCategorySelect' AND user_id = '$loginUserId'";

                $result = $this->dbo->query($query);
                $row    = $result->fetch_assoc();
				$idExpenseAssignedToUser = $row['id'];

                $query  = "SELECT id FROM payment_methods_assigned_to_users WHERE "
                        . "name = '$paymentMethod' AND user_id = '$loginUserId'";

                $result = $this->dbo->query($query);
                $row    = $result->fetch_assoc();
				$idPaymentMethod = $row['id'];
						
				$query  = "INSERT INTO expenses VALUES" 
					    . "(NULL, '$loginUserId',  '$idExpenseAssignedToUser',"
					    . " '$idPaymentMethod', '$amount', '$expenseDate', '$comment')";
				
				if ($this->dbo->query($query)) {
					return ACTION_OK;
				} else {
					return SERVER_ERROR;
				}			
			}
		}
	}

	function showBalance($peroid)
	{
      	$username  = $_SESSION['loginUser'];

		$query  = "SELECT * FROM users WHERE username = '$username'";
		$result = $this->dbo->query($query);
		$row    = $result->fetch_assoc();
		$loginUserId = $row['id'];

		if ($peroid == 'currentMonth') {

			$dateStart = new DateTime('first day of this month');
		    $startDate = $dateStart->format('Y-m-d');

			$dateLast  = new DateTime('last day of this month');
			$lastDate  = $dateLast->format('Y-m-d');

			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			       . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$loginUserId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC";
                

			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";

			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

		    include 'templates/currentBalanceForm.php';

		} else if ($peroid == 'previousMonth') {

			$dateStart = new DateTime('first day of last month');
		    $startDate = $dateStart->format('Y-m-d');

			$dateLast  = new DateTime('last day of last month');
			$lastDate  = $dateLast->format('Y-m-d');


			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			             . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$loginUserId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC"; 
                


			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";
			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

			include 'templates/previousMonthBalanceForm.php';

		} else if ($peroid == 'currentYear') {

			$startDate = new DateTime('first day of January ' . date('Y'));
			$startDate = $startDate->format('Y-m-d');

			$lastDate = new DateTime('last day of December ' . date('Y'));
			$lastDate = $lastDate->format('Y-m-d');


			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			             . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$loginUserId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC"; 
                


			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";
			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

			include 'templates/currentYearBalanceForm.php';
		} else if ($peroid == 'nonStandard') {

			$startDate = $_POST['startDate'];
			$lastDate  = $_POST['lastDate'];

			$queryIncome = "SELECT SUM(amount) FROM `incomes` WHERE date_of_income"
			             . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";

			$result = $this->dbo->query($queryIncome);
			$row    = $result->fetch_assoc();
			$sumAllIncomes = $row['SUM(amount)'];
			

			$queryIncome = "SELECT income_category_assigned_to_user_id, SUM(amount)"
			             . " FROM `incomes` WHERE date_of_income BETWEEN '$startDate'"
			             . " AND '$lastDate' AND user_id = '$loginUserId' GROUP BY"
			             . " income_category_assigned_to_user_id ORDER BY SUM(amount) DESC"; 
                


			$queryExpense = "SELECT SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'";
			$result = $this->dbo->query($queryExpense);
			$row    = $result->fetch_assoc();
			$sumAllExpenses = $row['SUM(amount)'];


			$queryExpense = "SELECT expense_category_assigned_to_user_id,"
			              . " SUM(amount) FROM `expenses` WHERE date_of_expense"
			              . " BETWEEN '$startDate' AND '$lastDate' AND user_id = '$loginUserId'"
			              . " GROUP BY expense_category_assigned_to_user_id ORDER BY SUM(amount) DESC";

			include 'templates/nonStandardBalanceForm.php';
		}
	}
}
?>