<?php include('header.php'); ?>
<?php include('account.php'); ?>

<?php
$user = new Account($db);
?>
<?php
if(isset($_POST['btnLogin'])){
    $user->login($_POST['username'],md5($_POST['password']));


}

?>

<form action="login.php" method="POST">
    <div class="container">
        <h4>Admin Inloggen</h4>
        <div class="col-md-4">
            <div class="form-group">
                <label for="username">gebruikersnaam</label>
                <input type="text" name="username" class="form-control" placeholder="gebruikersnaam...">
            </div>
            <div class="form-group">
                <label for="password">wachtwoord</label>
                <input type="password" name="password" class="form-control" placeholder="wachtwoord...">
            </div>
            <div class="form-group">
                <button type="submit" name="btnLogin" class="btn btn-success">Inloggen</button>
            </div>

        </div>
    </div>
</form>
