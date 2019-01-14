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
                <a href="index.php?action=showIncomeForm" class="active">Dodaj przychód</a>
                <a href="index.php?action=showExpenseForm">Dodaj wydatek</a>
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
        <article class="active" id="income">
            <section class="title">DODAWANIE PRZYCHODU</section>
                <?php
                    if(isset($_SESSION['statement'])) {
                       echo '<div class="income_success">'.$_SESSION['statement'].'</div>';
                       unset($_SESSION['statement']);
                    }
                ?>
            <form method="post" action="index.php?action=addIncome">

                <article class="row">
                    <label class="col-sm-4 label">Kwota</label>
                        <div class="col-sm-8 label">
                            <input type="text" name="income_amount" class="form-control" id="kwota" placeholder="kwota" onfocus="this.placeholder=''" onblur="this.placeholder='kwota'">                                  
                        </div>
                </article>

                <article class="row">
                    <label class="col-sm-4 label">Data</label>
                        <div class="col-sm-8 label">
                            <input type="date" id="currentDate" name="income_date" class="form-control">    
                        </div>
                </article>

                <article class="row">
                    <label class="col-sm-4 label">Komentarz</label>
                        <div class="col-sm-8 label">
                      <input type="text" name="income_comment" class="form-control" placeholder="opcjonalnie" onfocus="this.placeholder=''" onblur="this.placeholder='opcjonalnie'"> 
                    </div>
                </article>

                <article class="row">
                  <label class="col-sm-4 label">Kategoria</label>
                    <div class="col-sm-8 label">
                      <select class="custom-select" name="income_select">  
                        <option selected >Rozwiń</option>
                        <?php 
                            $allIncomes = $PB->selectAllIncomes();
                            while ($row = $allIncomes->fetch_assoc()) :
                        ?>
                        <option value="<?=$row['name']?>" type="text" id="kategoria"><?=$row['name']?></option>
                        <?php endwhile;?>
                      </select> 
                    </div>
                </article>
                
                <article class="row">
                    <div class="col-12">
                        <button class="btn btn-lg btn-success add" type="submit"><i class="icon-plus"></i></button>
                    </div>
                </article>

            </form>
        </article>
    </article>
</div>
<script src="js/currentDateIncome.js"></script>
