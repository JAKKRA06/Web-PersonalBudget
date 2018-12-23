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
                <a href="index.php?action=showMain" class="active">Strona główna</a>
                <a href="index.php?action=showIncomeForm">Dodaj przychód</a>
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
        <article class="tab-pane active" id="mainpage">
            <div class="row">
                <div class="col-sm-6">
                    <table class="tableMenu responsive" >
                        <tr>
                            <td id="tableTitleHome"><i class="icon-bank"></i></td>
                        </tr>
                        <tr>
                            <td><p>Zacznij kontrolować swoje wydatki już dzisiaj! <br><br>
                                  Dziękuję, że dołączyłeś do mojej aplikacji!</p><a href="https://github.com/JAKKRA06" target="_blank">O autorze</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="tableMenu responsive">
                        <tr>
                            <td id="tableTitleBulb"><i class="icon-lightbulb"></i></td>
                        </tr>
                        <tr>
                            <td><i>Kiedy zaczynasz interes, 
                                   nie martw się, że masz za mało pieniędzy. 
                                   Ograniczone fundusze to nie wada lecz zaleta. 
                                   Nic bardziej nie rozwija pomysłowości <br><br>

                                   - Jackson  Brown Jr.</i></td>
                        </tr>
                    </table>
                </div>
            </div>  
        </article>     
    </article>
</div>