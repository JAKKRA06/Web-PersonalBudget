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
            <div class="row">
                <div class="col-sm-12">
                    <section>	
                        <h3>EDYCJA PROFILU UŻYTKOWNIKA</h3>
                    </section>

                </div>
            </div>	

            <article class="editionUser">
                <form>
                    <div class="row">
                        <label class="col-md-6">Ustaw nową nazwę</label>
                        <div class="col-md-6">
                            <input type="text" name="newLogin" class="modalInputText" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-6">Ustaw nowe hasło</label>
                        <div class="col-md-6">
                            <input type="password" name="newPassword" class="modalInputText"  placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'">
                        </div>							
                    </div>

                    <div class="row">
                        <label class="col-md-6">Ustaw nowy e-mail</label>
                        <div class="col-md-6">
                            <input type="text" name="newEmail" class="modalInputText" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <button class="btn btn-success" type="submit">Zatwierdź zmiany</button>
                    </div>
                </form>
            </article>

            <div class="row">
                <div class="col-md-4">
                    <article class="edition">
                        <p style="text-align: center;">PRZYCHODY</P>
                        <button type="button" id="editionButtons" class="btn btn-danger"  data-toggle="modal" data-target="#modalDropIncome">Usuń kategorię</button>
                        <button type="button" id="editionButtons" class="btn btn-success"  data-toggle="modal" data-target="#modalAddIncome">Dodaj nową kategorię</button>
                        <button type="button" id="editionButtons" class="btn btn-primary"  data-toggle="modal" data-target="#modalChangeIncome">Zmień nazwę kategorii</button>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="edition">
                        <p style="text-align: center;">WYDATKI</P>
                        <button type="button" id="editionButtons" class="btn btn-danger"  data-toggle="modal" data-target="#modalDropExpense">Usuń kategorię</button>
                        <button type="button" id="editionButtons" class="btn btn-success"  data-toggle="modal" data-target="#modalAddExpense">Dodaj nową kategorię</button>
                        <button type="button" id="editionButtons" class="btn btn-primary"  data-toggle="modal" data-target="#modalChangeExpense">Zmień nazwę kategorii</button>
                    </article>
                </div>

                <div class="col-md-4">
                    <article class="edition">
                        <p style="text-align: center;">METODY PŁATNOŚCI</P>
                        <button type="button" id="editionButtons" class="btn btn-danger"  data-toggle="modal" data-target="#modalDropPayment">Usuń metodę płatności</button>
                        <button type="button" id="editionButtons" class="btn btn-success"  data-toggle="modal" data-target="#modalAddPayment">Dodaj nową metodę płatności</button>
                        <button type="button" id="editionButtons" class="btn btn-primary"  data-toggle="modal" data-target="#modalChangePayment">Zmień nazwę metody płatności</button>
                    </article>
                </div>
            </div>
        </article>
    </article>	
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
						<form>
							<div class="modalForm">
								<input type="radio" name="dropCategory" value="Mieszkanie"> Mieszkanie<br>
								<input type="radio" name="dropCategory" value="Jedzenie"> Jedzenie<br>
								<input type="radio" name="dropCategory" value="Transport"> Transport<br>
								<input type="radio" name="dropCategory" value="Telekomunikacja"> Telekomunikacja<br>
								<input type="radio" name="dropCategory" value="Ksiazki"> Książki<br>
								<input type="radio" name="dropCategory" value="Higiena"> Higiena<br>
								<input type="radio" name="dropCategory" value="Ubranie"> Ubranie<br>
								<input type="radio" name="dropCategory" value="Opieka zdrowotna"> Opieka zdrowotna<br>
								<input type="radio" name="dropCategory" value="Dzieci"> Dzieci<br>
								<input type="radio" name="dropCategory" value="Rozrywka"> Rozrywka<br>
								<input type="radio" name="dropCategory" value="Wycieczka"> Wycieczka<br>
								<input type="radio" name="dropCategory" value="Oszczednosci"> Oszczędności<br>
								<input type="radio" name="dropCategory" value="Na zlota jesien, czyli emeryture"> Na złotą jesień, czyli emeryture<br>
								<input type="radio" name="dropCategory" value="Darowizna"> Darowizna<br>
								<input type="radio" name="dropCategory" value="Splata dlugow"> Spłata długów<br>
								<input type="radio" name="dropCategory" value="Inne wydatki"> Inne wydatki<br>
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
					  <p><b>Krok 1.</b> Wybierz spośród dostępnych kategorii jedną, <br> której chcesz zmienić nazwę.</p>
					  <p><b>Krok 2.</b> W polu poniżej wpisz nową nazwę kategorii.</p>
						<form>
							<div class="modalForm">
								<input type="radio" name="dropCategory" value="Mieszkanie"> Mieszkanie<br>
								<input type="radio" name="dropCategory" value="Jedzenie"> Jedzenie<br>
								<input type="radio" name="dropCategory" value="Transport"> Transport<br>
								<input type="radio" name="dropCategory" value="Telekomunikacja"> Telekomunikacja<br>
								<input type="radio" name="dropCategory" value="Ksiazki"> Książki<br>
								<input type="radio" name="dropCategory" value="Higiena"> Higiena<br>
								<input type="radio" name="dropCategory" value="Ubranie"> Ubranie<br>
								<input type="radio" name="dropCategory" value="Opieka zdrowotna"> Opieka zdrowotna<br>
								<input type="radio" name="dropCategory" value="Dzieci"> Dzieci<br>
								<input type="radio" name="dropCategory" value="Rozrywka"> Rozrywka<br>
								<input type="radio" name="dropCategory" value="Wycieczka"> Wycieczka<br>
								<input type="radio" name="dropCategory" value="Oszczednosci"> Oszczędności<br>
								<input type="radio" name="dropCategory" value="Na zlota jesien, czyli emeryture"> Na złotą jesień, czyli emeryture<br>
								<input type="radio" name="dropCategory" value="Darowizna"> Darowizna<br>
								<input type="radio" name="dropCategory" value="Splata dlugow"> Spłata długów<br>
								<input type="radio" name="dropCategory" value="Inne wydatki"> Inne wydatki<br>
							</div>
							<br>
							<input type="text"  class="modalInputText" name="changeCategory" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
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
					  <h4 class="modal-title">Dodaj nową kategorię wydatku:</h4>
					</div>
					<div class="modal-body">
						<form>
							<input type="text" class="modalInputText" name="" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
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
					  <h4 class="modal-title">Dodaj nową kategorię przychodu:</h4>
					</div>
					<div class="modal-body">
						<form>
							<input type="text" class="modalInputText" name="addCategory" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
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
						<form>
							<div class="modalForm">
								<input type="radio" name="dropCategory" value="Wynagrodzenie"> Wynagrodzenie<br>
								<input type="radio" name="dropCategory" value="Odsetki bankowe"> Odsetki bankowe<br>
								<input type="radio" name="dropCategory" value="Sprzedaz na Allegro"> Sprzedaż Allegro<br>
								<input type="radio" name="dropCategory" value="Inne"> Inne<br>
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
						<form>
							<div class="modalForm">
								<input type="radio" name="dropCategory" value="Wynagrodzenie"> Wynagrodzenie<br>
								<input type="radio" name="dropCategory" value="Odsetki bankowe"> Odsetki bankowe<br>
								<input type="radio" name="dropCategory" value="Sprzedaz na Allegro"> Sprzedaż na Allegro<br>
								<input type="radio" name="dropCategory" value="Inne"> Inne<br>
							</div>
							<br>
							<input type="text" class="modalInputText" name="changeCategory" placeholder="nazwa kategorii" onfocus="this.placeholder=''" onblur="this.placeholder='nazwa kategorii'">
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
					  <h4 class="modal-title">Dodaj nową metodę płatności:</h4>
					</div>
					<div class="modal-body">
						<form>
							<input type="text" class="modalInputText" name="" placeholder="sposób płatności" onfocus="this.placeholder=''" onblur="this.placeholder='sposób płatności'">
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
						<form>
							<div class="modalForm">
								<input type="radio" name="dropCategoryPayment" value="Gotowka"> Gotówka<br>
								<input type="radio" name="dropCategoryPayment" value="Karta platnicza"> Karta płatnicza<br>
								<input type="radio" name="dropCategoryPayment" value="Karta kredytowa"> Karta kredytowa<br>
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
						<form>
							<div class="modalForm">
								<input type="radio" name="dropCategory" value="Gotowka"> Gotowka<br>
								<input type="radio" name="dropCategory" value="Karta platnicza"> Karta płatnicza <br>
								<input type="radio" name="dropCategory" value="Karta kredytowa"> Karta kredytowa<br>
							</div>
							<br>
							<input type="text" class="modalInputText" name="changeCategory" placeholder="sposób płatności" onfocus="this.placeholder=''" onblur="this.placeholder='sposób płatności'">
							<button type="submit" class="btn btn-success">Potwierdź</button>
						</form>
					</div>
			  </div>
		  
		</div>
  </div>