<?php
if (!isset($PB))
    die();
?>
<div class="row">
    <div class="col-sm-12">
        <header><h2><a href="index.php">TWÓJ OSOBISTY MENAGER FINANSÓW</a></h2></header>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <section class="description">
            <h2>Logowanie</h2>
        <form method= "post" action="index.php?action=login">

          <label for="usr">Nazwa użytkownika:</label>
          <input type="text" name= "login" class="form-control" id="usr" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">
          <label for="pwd">Hasło:</label>
          <input type="password" name= "password" class="form-control" id="pwd" placeholder="minimum 6 znaków" onfocus="this.placeholder=''" onblur="this.placeholder='minimum 6 znaków'">

          <button type="submit" class="btn btn-lg btn-success"><i class="icon-logout"></i>ZALOGUJ</button>
          <button class="btn btn-lg btn-primary"><a href="index.php"><i class="icon-home"></i>POWRÓT</a></button>

        </form>
          <?php
if (isset($_SESSION['statement'])) {
    echo '<div class="error">' . $_SESSION['statement'] . '</div>';
    unset($_SESSION['statement']);
}
?>
       </section>
     </div>
</div>