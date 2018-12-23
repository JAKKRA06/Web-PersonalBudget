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
                <?php
                    if (isset($_SESSION['statement'])) {
                        echo '<div class="expense_success">'.$_SESSION['statement'].'</div>';
                        unset($_SESSION['statement']);
                    }
                ?>
            <form method="post" action="index.php?action=addExpense">
                             
            <article class=" row">
                <label for="kwota" class="col-sm-4 col-form-label">Kwota</label>
                    <div class="col-sm-8">
                        <input type="text" name="expense_amount" class="form-control"  id="kwota" placeholder="kwota">                     
                    </div>
            </article>
                              
            <article class=" row">
                <label for="currentDateEx" class="col-sm-4 col-form-label">Data</label>
                    <div class="col-sm-8">
                        <input type="date" name="expense_date" id="currentDateEx" class="form-control">
                    </div>
            </article>
                              
            <article class="row">
                <label class="col-sm-6">Sposób płatności</label>
                    <div class="col-sm-6">
                        <select class="custom-select" name="expense_payment_method">
                            <option selected >Rozwiń</option>
                            <option value="Gotowka">Gotówka</option>
                            <option value="Karta platnicza">Karta płatnicza</option>
                            <option value="Karta kredytowa">Karta kredytowa</option>
                        </select>

                    </div>
            </article> 
                              
            <article class="row">
                <label class="col-sm-4">Kategoria</label>
                    <div class="col-sm-8">
                        <select class="custom-select" name="expense_category_select">
                            <option selected >Rozwiń</option>
                            <option value="Transport">Transport</option>
                            <option value="Ksiazki">Książki</option>
                            <option value="Jedzenie">Jedzenie</option>
                            <option value="Mieszkanie">Mieszkanie</option>
                            <option value="Telekomunikacja">Telekomunikacja</option>
                            <option value="Higiena">Higiena</option>
                            <option value="Ubranie">Ubranie</option>
                            <option value="Opieka zdrowotna">Opieka zdrowotna</option>
                            <option value="Dzieci">Dzieci</option>
                            <option value="Rozrywka">Rozrywka</option>
                            <option value="Wycieczka">Wycieczka</option>
                            <option value="Oszczednosci">Oszczędności</option>
                            <option value="Na zlota jesien, czyli emeryture">Na złotą jesień, czyli emeryturę</option>
                            <option value="Splta dlugow">Spłta długów</option>
                            <option value="Darowizna">Darowizna</option>
                            <option value="Inne wydatki">Inne wydatki</option>
                        </select>
                    </div>
                </article>

                <article class="row">
                   <label class="col-sm-4">Komentarz</label>
                        <div class="col-sm-8">
                        <input type="text" name="expense_comment" class="form-control" placeholder="opcjonalnie" onfocus="this.placeholder=''" onblur="this.placeholder='opcjonalnie'">
                        </div>
                </article>

                <article class="row" >
                    <div class="col-12">
                        <button type="submit" class="btn btn-lg btn-danger add"><i class="icon-plus"></i></button>
                    </div>
                </article>  
                </form>
        </article>
    </article>
</div>
<script src="js/currentDateEx.js"></script>