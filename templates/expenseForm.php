<?php if (!isset($_SESSION['loginUser'])) exit(); ?>
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
                <a href="index.php?action=showExpenseForm" class="active">Dodaj wydatek</a>
                <a href="index.php?action=showBalance">Przeglądaj bilans</a>
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
        <article class="active" id="expense">
            <section class="title">DODAWANIE WYDATKU</section>

            <div id="ajaxResponse">
                <p id="infoLimit">Brak informacji o limicie. Wpisz kwotę.</p>
            </div>
                <?php
                    if(isset($_SESSION['statement'])) {
                        $statement = $_SESSION['statement'];
                        if($statement == 'Dodano wydatek !') {
                           echo '<div class="success">'.$_SESSION['statement'].'</div>';
                        } else {
                           echo '<div class="warrning">'.$_SESSION['statement'].'</div>';
                        }

                       unset($_SESSION['statement']);
                    }
                ?>

            <form method="post" action="index.php?action=addExpense">
                             
                <article class="row">
                    <label class="col-sm-4 label">Kwota</label>
                        <div class="col-sm-8 label">
                            <input type="text" name="expense_amount" class="form-control" id="kwota" placeholder="kwota" onfocus="this.placeholder=''" onblur="this.placeholder='kwota'" value="<?php  if (isset($_SESSION['amountExpenseRemember'])) { echo $_SESSION['amountExpenseRemember']; unset($_SESSION['amountExpenseRemember']);
                         } ?>">
                        </div>
                </article>

                <article class="row">
                    <label class="col-sm-4 label">Data</label>
                        <div class="col-sm-8 label">
                            <input type="date" id="currentDateEx" name="expense_date" class="form-control">    
                        </div>
                </article>

                <article class="row">
                    <label class="col-sm-4 label">Kategoria</label>
                        <div class="col-sm-8 label">
                            <select class="custom-select" name="expense_category_select"> 
                        <?php 
                            $allExpenses = $PB->selectAllExpenses();
                            while ($row = $allExpenses->fetch_assoc()) :
                        ?>
                        <option value="<?=$row['name']?>" type="text" id="kategoria"><?=$row['name']?></option>
                        <?php endwhile;?> 
                            </select> 
                        </div>
                </article>
                              
                <article class="row">
                    <label class="col-sm-6 label">Sposób płatności</label>
                        <div class="col-sm-6 label">
                            <select class="custom-select" name="expense_payment_method">
                        <?php 
                            $allPaymentMethods = $PB->selectAllPaymentMethods();
                            while ($row = $allPaymentMethods->fetch_assoc()) :
                        ?>
                                <option value="<?=$row['name']?>" type="text" id="kategoria"><?=$row['name']?></option>
                        <?php endwhile;?>                            
                            </select>
                        </div>
                </article> 

                <article class="row">
                    <label class="col-sm-4 label">Komentarz</label>
                        <div class="col-sm-8 label">
                      <input type="text" name="expense_comment" class="form-control" placeholder="opcjonalnie" onfocus="this.placeholder=''" onblur="this.placeholder='opcjonalnie'" value="<?php  if (isset($_SESSION['commentExpenseRemember'])) { echo $_SESSION['commentExpenseRemember']; unset($_SESSION['commentExpenseRemember']);
                         } ?>"> 
                    </div>
                </article>

                <article class="row" >
                    <div class="col-12">
                        <button type="submit" id="buttonExpensForm" class="btn btn-lg btn-danger add"><i class="icon-plus"></i></button>
                    </div>
                </article>
                                
            </form>
        </article>
    </article>
</div>
<script src="js/currentDateEx.js"></script>