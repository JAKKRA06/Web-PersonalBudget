<?php if (!isset($PB)) die(); ?>
<div class="row">
    <div class="col-sm-12">
        <header><h2><a href="index.php">TWÓJ OSOBISTY MENAGER FINANSÓW</a></h2></header>
    </div>
</div>  
<div class="row">
    <div class="col-sm-12">
        <section class="description">
            <h2>Rejestracja</h2>
        <form method="post" action="index.php?action=register">

            <label for="pwd">Nazwa użytkownika:</label>
              <input type="text" name="nick" id="pwd" class="form-control" placeholder="login" onfocus="this.placeholder=''" onblur="this.placeholder='login'">

            <label for="pwd2">Hasło:</label>
              <input type="password" name="password" class="form-control" id="pwd2" placeholder="minimum 6 znaków" onfocus="this.placeholder=''" onblur="this.placeholder='minimum 6 znaków'">

            <button type="submit" class="btn btn-lg btn-danger"><i class="icon-plus"></i>DOŁĄCZ</button>
            <button class="btn btn-lg btn-primary"><a href="index.php"><i class="icon-home"></i>POWRÓT</a></button>
        </form>
          <?php if(isset($_SESSION['statement'])) {
                  echo '<div class="error">'.$_SESSION['statement'].'</div>';
                  unset($_SESSION['statement']);
                }
          ?>
        </section>
    </div>
</div>