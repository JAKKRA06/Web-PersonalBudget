 <?php if (!isset($_SESSION['loginUser'])) exit(); ?>

 <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Wybierz przedział czasowy: </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <div class="modal-body">
              <form method="post" action="index.php?action=showBalance&peroid=nonStandard">
              Od: <input type="date" id="startDate" name="startDate" value="startDate"> <br/><br/>
              do: <input type="date" id="lastDate" name ="lastDate" value="lastDate">

              <button class=" btn btn-primary" id="modal_nonStandard" type="submit">Potwierdź</button>
              </form>
        </div>
        </div>
    </div>
</div>

<div class="row">
      <div class="col-sm-12">
        <section class="logger">
            <?php
                $str = $_SESSION['loginUser'];
                $str = strtoupper($str);
                     echo "Witaj: ".'<i>'.$str.'</i>';
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
                    <section class="dropdown" id="drop">
                        <div class="dropdown">
                            <button class="dropbtn">Wybierz okres</button>
                            <div class="dropdown-content" id="peroid">
                            <a href="index.php?action=showBalance&peroid=currentMonth">Bieżący miesiąc</a>
                            <a href="index.php?action=showBalance&peroid=previousMonth">Poprzedni miesiąc</a>
                            <a href="index.php?action=showBalance&peroid=currentYear">Bieżący rok</a>
                            <a data-toggle="modal" href="#myModal">Niestandardowy</a>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-md-12">
                    <section id="dropDownPeroid">
                        <?php echo 'Bieżący rok';?>
                    </section>
                <?php
                    if(isset($_SESSION['statement'])) {
                       echo '<div class="income_success">'.$_SESSION['statement'].'</div>';
                       unset($_SESSION['statement']);
                    }
                ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <table class="table1 responsive">
                        <tr>
                            <td id="tableTitle">PRZYCHODY</td>
                        </tr>
                        <tr>
                            <td id="tableIncome">
<?php
if ($result = $this->dbo->query($queryIncome)) :
  while ($row = $result->fetch_assoc()) :
          
        $incomeCategoryId = $row['income_category_assigned_to_user_id'];
        $sumIncome        = $row['SUM(amount)'];

        $query1  = "SELECT * FROM incomes_category_assigned_to_users "
                 . " WHERE id = '$incomeCategoryId'";

        $result1 = $this->dbo->query($query1);
        $row1    = $result1->fetch_assoc();
        $categoryName = $row1['name'];

        if ($categoryName != 'Pozostale') :
            echo '<div class="category_list_name_income">'.$categoryName.':'.' '.$sumIncome.'</div>'.'<br/>';

            $query2 = "SELECT id, amount, date_of_income, income_comment FROM "
                    . "`incomes` WHERE date_of_income BETWEEN '$startDate' "
                    . " AND '$lastDate' AND user_id = '$userId' AND "
                    . " income_category_assigned_to_user_id = '$incomeCategoryId'"
                    . " ORDER BY amount DESC";

            $result2 = $this->dbo->query($query2);

            while ($row2 = $result2->fetch_assoc()) :
                   $incomeId      = $row2['id'];
                   $incomeDate    = $row2['date_of_income'];
                   $incomeAmount  = $row2['amount'];
                   $incomeComment = $row2['income_comment'];

                   echo '<div class="category_list"><i class="icon-bank"></i>'
                        . ' ' .$incomeAmount.' '.$incomeDate.'<i>'.'  '. $incomeComment.'</i>'
                        .'<a href=index.php?action=showModifyIncomeForm&incomeId='.$incomeId.'&peroid=currentYear><i class="icon-pencil"></i></a>'
                        .'<a data-toggle=modal href="#confirmRecord"><i class="icon-trash"></i></a></div>'.'<br/>';
                        //.'<a href="index.php?action=dropSingleRecordOfIncome&incomeId='.$incomeId.'"><i class="icon-trash"></i></a></div>'.'<br/>';
?>

<div class="modal fade" id="confirmRecord" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Potwierdź</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <div class="modal-body">
            <p style="text-align: left;">Czy na pewno chcesz usunąć wybrany rekord ?</p>
            <button class="btn btn-danger" data-dismiss="modal">Odrzuć</button>
            <a href="index.php?action=dropSingleRecordOfIncome&incomeId=<?=$incomeId?>"><button class="btn btn-primary" type="submit">Potwierdź</button></a>
        </div>
        </div>
    </div>
</div>

<?php endwhile; endif; endwhile; endif;?>             
                            </td>
                        </tr>
                    </table>
                    <table class='tableResultIncome'><tr><td><?='PRZYCHODY: '.$sumAllIncomes.'zł'?></td></tr></table>
                </div>
                <div class="col-sm-6">
                    <table class="table2 responsive">
                        <tr>
                            <td id="tableTitle">WYDATKI</td>
                        </tr>
                        <tr>
                            <td id="tableExpense">
<?php
if ($result = $this->dbo->query($queryExpense)) :
  while ($row = $result->fetch_assoc()) :
          
        $expenseCategoryId = $row['expense_category_assigned_to_user_id'];
        $sumExpense        = $row['SUM(amount)'];

        $query1  = "SELECT * FROM expenses_category_assigned_to_users "
                 . " WHERE id = '$expenseCategoryId'";
    
        $result1 = $this->dbo->query($query1);
        $row1    = $result1->fetch_assoc();
        $categoryName = $row1['name'];

        if ($categoryName != 'Pozostale') :
            echo '<div class="category_list_name_expense">'.$categoryName.':'.' '.$sumExpense.'</div>'.'<br/>';

            $dataPoints[] = array ("label"=>$categoryName, "y"=>$sumExpense);

            $query2 = "SELECT id, amount, date_of_expense, expense_comment FROM "
                    . "`expenses` WHERE date_of_expense BETWEEN '$startDate' "
                    . " AND '$lastDate' AND user_id = '$userId' AND "
                    . " expense_category_assigned_to_user_id = '$expenseCategoryId'"
                    . " ORDER BY amount DESC";
            
            $result2  =  $this->dbo->query($query2);

            while ($row2 = $result2->fetch_assoc()) :
                  $expenseId      = $row2['id'];                  
                  $expenseDate    = $row2['date_of_expense'];
                  $expenseAmount  = $row2['amount'];
                  $expenseComment = $row2['expense_comment'];
                
                  echo '<div class="category_list"><i class="icon-bank"></i>'
                       . ' ' .$expenseAmount.' '.$expenseDate.'<i> '.' '. $expenseComment.'</i>'
                       .'<a href=index.php?action=showModifyExpenseForm&expenseId='.$expenseId.'&peroid=currentYear><i class="icon-pencil"></i></a>'
                     //.'<a data-toggle=modal href="#confirmRecord"><i class="icon-trash"></i></a></div>'.'<br/>';
                       .'<a href="index.php?action=dropSingleRecordOfExpense&expenseId='.$expenseId.'"><i class="icon-trash"></i></a></div>'.'<br/>';
?>

<div class="modal fade" id="confirmRecord" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Potwierdź</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <div class="modal-body">

            <p style="text-align: left;">Czy na pewno chcesz usunąć wybrany rekord ?</p>
            <button class="btn btn-danger" data-dismiss="modal">Odrzuć</button>
            <a href="index.php?action=dropSingleRecord&incomeId=<?=$incomeId?>"><button class="btn btn-primary" type="submit">Potwierdź</button></a>
        </div>
        </div>
    </div>
</div>

<?php endwhile; endif; endwhile; endif;?>                 
                            </td>
                        </tr>
                    </table>
                    <table class='tableResultExpense'><tr><td><?='WYDATKI: '.$sumAllExpenses.'zł'?></td></tr></table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <section class="comment" id="comment">
                        <h3 id="comentary">
                            <span>Bilans:
                                <?php 
                                    echo round($sumAllIncomes - $sumAllExpenses, 2).' zł'.'</br>';

                                    if ($sumAllIncomes > $sumAllExpenses) {
                                        echo '<div class = "saving">'.'<br/>'."Świetnie zarządzasz swoimi finansami !".'</div>';
                                    } else if ($sumAllIncomes < $sumAllExpenses) {
                                              echo '<div class = "debt">'.'<br/>'."Uważaj !".'<br/>'."W tym okresie wygenerowałeś straty !".'</div>';
                                    } else
                                          echo '';
                                ?></span></br>
                        </h3>
                    </section>
                </div>
            </div>
                        
            <div class="row">
                <div class="col-sm-12">                                
                    <article>
                        <script>
                            function drawPie() {
                                var chart = new CanvasJS.Chart("chartContainer", {
                                    animationEnabled: true,
                                    title: {
                                    text: "Wydatki jakie wygenerowałeś w wybranym okresie"
                                    },
                                    data: [{
                                        type: "pie",
                                        yValueFormatString: "#,##0.00\"zł\"",
                                        indexLabel: "{label} ({y})",
                                        dataPoints: <?php echo json_encode($dataPoints); ?> 
                                        }]
                                    });
                                    chart.render();
                                    }
                                    window.addEventListener('load', drawPie, false);
                        </script>

                        <div id="chartContainer" style="height: 450px; width: 100%;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>  
                    </article>
                </div>
            </div>
        </article>
    </article>      
 </div> 