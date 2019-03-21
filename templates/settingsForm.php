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
                <a href="index.php?action=showExpenseForm">Dodaj wydatek</a>
                <a href="index.php?action=showBalance">Przeglądaj bilans</a>
                <a href="index.php?action=showSettings" class="active">Ustawienia</a>
                <?php
                  echo '<a href="index.php?action=logout">Wyloguj</a>';
                ?>
                <a class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i></a>    
            </article>   
        </nav>                       
    </div>

    <article class="tab-content">
        <article class="active" id="settings">
            <section class="title">EDYCJA PROFILU UŻYTKOWNIKA</section>
                <?php
                    if(isset($_SESSION['statement'])) {
                        $statement = $_SESSION['statement'];
                        if(($statement == 'Zmieniono hasło !') || ($statement == 'Zmodyfikowano dane uzytkownika !') ||
                           ($statement == 'Zmodyfikowano nazwę kategorii przychodu !') || ($statement == 'Zmodyfikowano nazwę metody płatności !') ||
                           ($statement == 'Zmodyfikowano nazwę kategorii wydatku !') || ($statement == 'Dodano nową metodę płatności !') ||
                           ($statement == 'Dodano nową kategorię !') || ($statement == 'Usunięto wybraną kategorię !'))  {
                           
                           echo '<div class="success">'.$_SESSION['statement'].'</div>';
                        } else {
                           echo '<div class="warrning">'.$_SESSION['statement'].'</div>';
                        }

                       unset($_SESSION['statement']);
                    }
                ?>
            <article class="editionUser">
                <form method="post" action="index.php?action=editUserLogin">
                    <article class="row">
                        <label class="col-md-4 labelEdit">Ustaw nową nazwę</label>
                            <div class="col-md-4 labelEdit">
                                <input type="text" name="newLogin" class="modalInputText" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
                            </div>	  
                        <div class="col-md-4">
	                        <button class="btn btn-success editSubmit" type="submit">Zatwierdź zmiany</button>
	                    </div>
                    </article>
                </form>

                <form method="post" action="index.php?action=editUserPassword">
                    <article class="row">
                        <label class="col-md-4 labelEdit">Ustaw nowe hasło</label>
                            <div class="col-md-4 labelEdit">
                                <input type="password" name="newPassword" class="modalInputText"  placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
                            </div>     
                            <div class="col-md-4">
                                <button class="btn btn-success editSubmit" type="submit">Zatwierdź zmiany</button>
                            </div>
                    </article>
                </form>
<?php
 /*               <div class="col-md-12">
                	<article class="edition">
                		<button type="button" id="editionButtons" class="btn btn-danger"  data-toggle="modal" data-target="#modalDeleteProfile">Usuń profil</button>
                	</article>
                </div>   */ 
?>
            </article>

            <div class="row">
                <div class="col-md-4">
                    <article class="edition">
                        <p style="text-align: center;">PRZYCHODY</</p>
                        <button type="button" id="editionButtons" class="btn btn-danger"  data-toggle="modal" data-target="#modalDropIncome">Usuń kategorię</button>

                        <button type="button" id="editionButtons" class="btn btn-success"  data-toggle="modal" data-target="#modalAddIncome">Dodaj nową kategorię</button>
                        <button type="button" id="editionButtons" class="btn btn-primary"  data-toggle="modal" data-target="#modalChangeIncome">Zmień nazwę kategorii</button>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="edition">
                        <p style="text-align: center;">WYDATKI</p>
                        <button type="button" id="editionButtons" class="btn btn-danger"  data-toggle="modal" data-target="#modalDropExpense">Usuń kategorię</button>
                        <button type="button" id="editionButtons" class="btn btn-success"  data-toggle="modal" data-target="#modalAddExpense">Dodaj nową kategorię</button>
                        <button type="button" id="editionButtons" class="btn btn-primary"  data-toggle="modal" data-target="#modalChangeExpense">Edycja kategorii</button>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="edition">
                        <p style="text-align: center;">METODY PŁATNOŚCI</p>
                        <button type="button" id="editionButtons" class="btn btn-danger"  data-toggle="modal" data-target="#modalDropPayment">Usuń metodę płatności</button>
                        <button type="button" id="editionButtons" class="btn btn-success"  data-toggle="modal" data-target="#modalAddPayment">Dodaj nową metodę płatności</button>
                        <button type="button" id="editionButtons" class="btn btn-primary"  data-toggle="modal" data-target="#modalChangePayment">Zmień nazwę metody płatności</button>
                    </article>
                </div>

            </div>

        </article>
    </article>	
</div> 

<div class="modal fade" id="modalDeleteProfile" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Potwierdź</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <div class="modal-body">
            <p style="text-align: left;">Czy na pewno chcesz usunąć profil ? <br> Naciskając potwierdź 
            zostaniesz wylogowany i wszystkie Twoje dane zostaną <span style="text-decoration: underline; color: red" >usunięte </span>!</p>
            <button class="btn btn-danger" data-dismiss="modal">Odrzuć</button>
            <a href="index.php?action=deleteProfile"><button class="btn btn-primary" type="submit">Potwierdź</button></a>
        </div>
        </div>
    </div>
</div>


				<!-- Modal Expenses -->
  <div class="modal fade" id="modalDropExpense" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Usuń kategorię wydatku:</h4>
					</div>
					<div class="modal-body">
						<p style="color: red">Jeśli wybrana kategoria posiada jakieś wpisy to zostaną one przeniesione do kategorii 'Pozostałe'.</p>
						<form method="post" action="index.php?action=dropExpenseCategory">
							<div class="modalForm">
                        <?php 
                            $allExpenses = $PB->selectAllExpenses();
                            while ($row = $allExpenses->fetch_assoc()) :
                        ?>
  							<label><input type="radio" name="dropExpenseCategory" 
  								value="<?=$row['name']?>"> <?=$row['name']?></label><br>
						<?php endwhile;?>
							</div>
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>
  
   <div class="modal fade" id="modalChangeExpense" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Zmień nazwę kategorii wydatku:</h4>
					</div>
					<div class="modal-body" style="text-align: center;">
					  <p><b>Krok 1.</b> Wybierz spośród dostępnych kategorii jedną, <br> której chcesz zmienić nazwę lub wprowadzić limit kwoty.</p>
					  <p><b>Krok 2.</b> W polach poniżej zaznacz co chcesz zrobić.</p>
						<form method="post" action="index.php?action=changeExpenseCategory">
							<div class="modalForm">
                        <?php 
                            $allExpenses = $PB->selectAllExpenses();
                            while ($row = $allExpenses->fetch_assoc()) :
                        ?>
  							<label><input type="radio" name = "categoryNameToModify" value="<?=$row['name']?>"> <?=$row['name']?></label><br>
						<?php endwhile;?>
							</div>
							<br>
							<div class="limitDiv">
								<label><input type="checkbox" id="zaznaczLimit" name="zaznaczLimit"/>Zaznacz opcję, aby dodać limit kwoty</label>

								<label><input type="checkbox" id="zaznaczName" name="zaznaczName"/>Zaznacz opcję, aby zmienić nazwę wybranej kategorii</label>
							</div>
								

							<input type="text" id="inputLimit" name="inputLimit" placeholder="Podaj limit kwoty" onfocus="this.placeholder=''" onblur="this.placeholder='podaj limit kwoty'">

							<input type="text"  id = "inputName" class="modalInputText" name="newExpenseCategoryName" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
							
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>
  
   <div class="modal fade" id="modalAddExpense" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Dodaj nową kategorię wydatku (bez polskich znaków):</h4>
					</div>
					<div class="modal-body">
						<form method="post" action="index.php?action=addExpenseCategoryName">
							<input type="text" class="modalInputText" name="expenseCategoryName" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>
  

  					<!-- Modal Income -->
  <div class="modal fade" id="modalAddIncome" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Dodaj nową kategorię przychodu (bez polskich znaków):</h4>
					</div>
					<div class="modal-body">
						<form method="post" action="index.php?action=addIncomeCategoryName">
							<input type="text" class="modalInputText" name="incomeCategoryName" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>
  
   <div class="modal fade" id="modalDropIncome" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Usuń kategorię przychodu:</h4>
					</div>
					<div class="modal-body">
						<p style="color: red">Jeśli wybrana kategoria posiada jakieś wpisy to zostaną one przeniesione do kategorii 'Pozostałe'.</p>						
						<form method="post" action="index.php?action=dropIncomeCategory">
                            <div class="modalForm">
                        <?php 
                            $allIncomes = $PB->selectAllIncomes();
                            while ($row = $allIncomes->fetch_assoc()) :
                        ?>
  							<label><input type="radio" name="dropIncomeCategory" value="<?=$row['name']?>"> <?=$row['name']?></label><br>
						<?php endwhile;?>
							</div>
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>

   <div class="modal fade" id="modalChangeIncome" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Zmień nazwę kategorii przychodu:</h4>
					</div>
					<div class="modal-body">
					<p><b>Krok 1.</b> Wybierz spośród dostępnych kategorii jedną, <br> której chcesz zmienić nazwę.</p>
					  <p><b>Krok 2.</b> W polu poniżej wpisz nową nazwę kategorii.</p>
						<form method="post" action="index.php?action=changeIncomeCategory">
							<div class="modalForm">
                        <?php 
                            $allIncomes = $PB->selectAllIncomes();
                            while ($row = $allIncomes->fetch_assoc()) :
                        ?>
 							<label><input type="radio" name="categoryNameToModify" value="<?=$row['name']?>"> <?=$row['name']?></label><br>
						<?php endwhile;?>							
					        </div>
							<br>
							<input type="text" class="modalInputText" name="newIncomeCategoryName" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>

  
	 				<!-- Modal Payment methods -->		
  <div class="modal fade" id="modalAddPayment" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Dodaj nową metodę płatności (bez polskich znaków):</h4>
					</div>
					<div class="modal-body">
						<form method="post" action="index.php?action=addPaymentMethod">
							<input type="text" class="modalInputText" name="paymentMethod" placeholder="sposób płatności" onfocus="this.placeholder=''" onblur="this.placeholder='sposób płatności'">
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>
  
   <div class="modal fade" id="modalDropPayment" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Usuń metodę płatności:</h4>
					</div>
					<div class="modal-body">
						<form method="post" action="index.php?action=dropPaymentMethod">
							<div class="modalForm">
                        <?php 
                            $allPaymentMethods = $PB->selectAllPaymentMethods();
                            while ($row = $allPaymentMethods->fetch_assoc()) :
                        ?>
  							<label><input type="radio" name="dropPaymentMethod" value="<?=$row['name']?>"> <?=$row['name']?></label><br>
						<?php endwhile;?>
							</div>
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>
  
   <div class="modal fade" id="modalChangePayment" role="dialog">
		<div class="modal-dialog">
		
		  <!-- Modal content-->
			  <div class="modal-content">
					<div class="modal-header">
					  <h4 class="modal-title">Zmień nazwę metody płatności:</h4>
					</div>
					<div class="modal-body">
					<p><b>Krok 1.</b> Wybierz spośród dostępnych sposobów jeden, <br> któremu chcesz zmienić nazwę.</p>
					  <p><b>Krok 2.</b> W polu poniżej wpisz nową nazwę metody płatności.</p>
						<form method="post" action="index.php?action=changePaymentMethod">
							<div class="modalForm">
                        <?php 
                            $allPaymentMethods = $PB->selectAllPaymentMethods();
                            while ($row = $allPaymentMethods->fetch_assoc()) :
                        ?>
 							<label><input type="radio" name="categoryNameToModify" value="<?=$row['name']?>"> <?=$row['name']?></label><br>
						<?php endwhile;?>							
					        </div>
							<br>
							<input type="text" class="modalInputText" name="newPaymentMethod" placeholder="sposób płatności" onfocus="this.placeholder=''" onblur="this.placeholder='sposób płatności'">
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>