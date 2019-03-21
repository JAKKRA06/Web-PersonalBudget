<?php
session_start();

    $dbo = new mysqli('localhost', 'root', '', 'personal_budget');
    if($dbo->connect_errno) {
        echo "Brak połączenia z bazą danych: "
                 . $dbo->connect_errno;
        throw new Exception($message);
    }

    $userId = $_SESSION['userId'];
    $amount   = $_POST['expense_amount'];
    $category = $_POST['expense_category_select'];

    $query = "SELECT id FROM expenses_category_assigned_to_users"
           . " WHERE user_id = '$userId' AND name = '$category'";

    $result = $dbo->query($query);
    $row    = $result->fetch_assoc();
    $idCategory = $row['id'];

    $query = "SELECT SUM(amount) FROM expenses WHERE user_id = '$userId'"
           . " AND expense_category_assigned_to_user_id = '$idCategory'";

    $result = $dbo->query($query);
    $row    = $result->fetch_assoc();
    $sumAmountCategory = $row['SUM(amount)'];


    $query  = "SELECT expense_limit FROM expenses_category_assigned_to_users"
            . " WHERE name = '$category'"
            . " AND user_id = '$userId'";

    $result = $dbo->query($query);
    $row    = $result->fetch_assoc();
    $expenseLimit = $row['expense_limit'];

    //obliczenia 
    if($sumAmountCategory == 0) {
       $actualExpenses = 0;
    } else {
        $actualExpenses = ($expenseLimit-$sumAmountCategory);
    }
    if($amount == "") {
    	$expensesAndCurrentAmount = ($sumAmountCategory);
    } else {
    	$expensesAndCurrentAmount = ($sumAmountCategory+$amount);
    }
  
    if($expenseLimit == 0) {
	    echo '<div class="infoLimit">'."Nie ustawiono limitu w  wybranej kategorii. <br/>"
	         ." Możesz to zrobić w ustawieniach.". '</div>';

    } else {
    	if($expensesAndCurrentAmount > $expenseLimit) {
			echo '<table id="tabelaAjaxNotOk">
			<tr>
				<th>Limit</th>
				<th>Dotychczas wydano</th>
				<th>Różnica</th>
				<th>Wydatki+wpisana kwota</th>
			</tr>
			<tr>
				<td>'.$expenseLimit.'</td>
				<td>'.$sumAmountCategory.'</td>
				<td>'.$actualExpenses.'</td>
				<td>'.$expensesAndCurrentAmount.'</td>

			</tr>
		</table>';
		} else {
			echo '<table id="tabelaAjaxOk">
			<tr>
				<th>Limit</th>
				<th>Dotychczas wydano</th>
				<th>Różnica</th>
				<th>Wydatki+wpisana kwota</th>
			</tr>
			<tr>
				<td>'.$expenseLimit.'</td>
				<td>'.$sumAmountCategory.'</td>
				<td>'.$actualExpenses.'</td>
				<td>'.$expensesAndCurrentAmount.'</td>

			</tr>
		</table>';

		}
	}

?>