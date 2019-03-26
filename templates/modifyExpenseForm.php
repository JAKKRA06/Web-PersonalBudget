<?php
if (!isset($_SESSION['loginUser']))
    exit();
?>

<div class="row">
      <div class="col-sm-12">
        <section class="logger">
            <?php
$str = $_SESSION['loginUser'];
$str = strtoupper($str);
echo "Witaj: " . '<i>' . $str . '</i>';
?>
       </section>
    </div>
              
    <div class="col-sm-12">
        <header><h2>TWÓJ OSOBISTY MENAGER FINANSÓW</h2></header>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <section id="hello"><h1>Witaj !</h1></section>
    </div>

    <div class="col-sm-12">
        <nav class="menu">
            <article class="nav nav-tabs" id="myTopnav" role="tablist">
                <a href="index.php?action=showMain">Strona główna</a>
                <a href="index.php?action=showIncomeForm">Dodaj przychód</a>
                <a href="index.php?action=showExpenseForm">Dodaj wydatek</a>
                <a href="index.php?action=showBalance" id = "balanceTab" class="active">Przeglądaj bilans</a>
                <a href="index.php?action=showSettings">Ustawienia</a>
                <?php
echo '<a href="index.php?action=logout">Wyloguj</a>';
?>
               <a class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i></a>    
            </article>   
        </nav>                       
    </div>
               
     <article class="tab-content">
        <article class="active" id="balance">
            <div class="row">
                <div class="col-sm-12">
                    <section class="title">EDYCJA DANYCH</section>
                    <?php
$idRecordToModify = $_GET['expenseId']?>
                   <?php
$peroid = $_GET['peroid']?>
                   <?php
if (isset($_GET['startDate'])) {
    $startDate = $_GET['startDate'];
} else {
    $startDate = '';
}
?>
                   <?php
if (isset($_GET['startDate'])) {
    $lastDate = $_GET['lastDate'];
} else {
    $lastDate = '';
}
?>
                   <form method="post" action="index.php?action=modifyExpense&idRecordToModify=<?= $idRecordToModify ?>&peroid=<?= $peroid ?>&startDate=<?= $startDate ?>&lastDate=<?= $lastDate ?>">

                        <?php
$singleRow = $PB->selectSingleRowOfExpense($idRecordToModify);
while ($row = $singleRow->fetch_assoc()):
    $idCategoryToModify      = $row['expense_category_assigned_to_user_id'];
    $idPaymentMethodToModify = $row['payment_method_assigned_to_user_id'];
?>
                       <article class="row">
                            <label class="col-sm-4 label">Kwota</label>
                                <div class="col-sm-8 label">
                                    <input type="text" name="expense_amount" value="<?= $row['amount'] ?>" class="form-control" id="kwota" placeholder="kwota" onfocus="this.placeholder=''" onblur="this.placeholder='kwota'">                                  
                                </div>
                        </article>

                        <article class="row">
                            <label class="col-sm-4 label">Data</label>
                                <div class="col-sm-8 label">
                                    <input type="date" id="currentDate" value="<?= $row['date_of_expense'] ?>" name="expense_date" class="form-control">    
                                </div>
                        </article>

                        <article class="row">
                            <label class="col-sm-4 label">Komentarz</label>
                                <div class="col-sm-8 label">
                              <input type="text" name="expense_comment" value="<?= $row['expense_comment'] ?>" class="form-control" placeholder="opcjonalnie" onfocus="this.placeholder=''" onblur="this.placeholder='opcjonalnie'"> 
                            </div>
                        </article>

                        <article class="row">
                          <label class="col-sm-4 label">Kategoria</label>
                            <div class="col-sm-8 label">
                              <select class="custom-select" name="expense_category_select">  
                              <?php
    $singleNameOfExpense = $PB->selectSingleExpenseCategoryName($idCategoryToModify);
?>
                               <option selected><?= $singleNameOfExpense ?></option>
                                <?php
endwhile;
$allExpenses = $PB->selectAllExpenses();
while ($row = $allExpenses->fetch_assoc()):
?>
                               <option value="<?= $row['name'] ?>" type="text" id="kategoria"><?= $row['name'] ?></option>
                                <?php
endwhile;
?>
                             </select> 
                            </div>
                        </article>

                        <article class="row">
                          <label class="col-sm-6 label">Sposób płatności</label>
                            <div class="col-sm-6 label">
                              <select class="custom-select" name="expense_payment_method">
                              <?php
$singleNameOfPaymentMethod = $PB->selectSinglePaymentMethod($idPaymentMethodToModify);
?><option selected ><?= $singleNameOfPaymentMethod ?></option>
                              <?php
$allPaymentMethods = $PB->selectAllPaymentMethods();
while ($row = $allPaymentMethods->fetch_assoc()):
?>
                             <option value="<?= $row['name'] ?>" type="text" id="kategoria"><?= $row['name'] ?></option>
                              <?php
endwhile;
?>                         
                              </select>
                            </div>
                        </article>     

                        <article class="row">
                            <div class="col-12">
                                <button class="btn btn-success button-modify" type="submit">Potwierdź</button>
                            </div>
                        </article>

                    </form>
                    <article class="row">
                        <div class="col-12">
                            <a href="index.php?action=showBalance"><button class="btn btn-danger button-modify">  Odrzuć  </button>
                        </div>
                    </article>
                </div>
            </div>
        </article>
    </article>

</div>