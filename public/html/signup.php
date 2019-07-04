<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once($phpPaths['TEMPLATES'] . "/head.php"); ?>

    <link rel="stylesheet" href="css/signup.css">

    <script src="js/signup.js"></script>
</head>

<body>
    <?php include($phpPaths['TEMPLATES'] . "/navbar.php"); ?>

    <div id="signupFormWrapper">
        <h1>Rejestracja</h1>

        <form method="post" 
        action=<?php echo $htmlPaths['API'] . '/user/signup.php'; ?>>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                    <input id="email" name="email" type="email" class="form-control" 
                    placeholder="email@example.com">
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Imię</label>
                <div class="col-sm-9">
                    <input id="name" name="name" type="text" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="surname" class="col-sm-3 col-form-label">Nazwisko</label>
                <div class="col-sm-9">
                    <input id="surname" name="surname" type="text" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-sm-3 col-form-label">Hasło</label>
                <div class="col-sm-9">
                    <input id="password" name="password" 
                    type="password" class="form-control">
                </div>
            </div>

            <div class="form-group row">
                <label for="confirmPassword" class="col-sm-3 col-form-label">
                    Powtórz hasło
                </label>
                <div class="col-sm-9">
                    <input id="confirmPassword" name="confirmPassword"
                    type="password" class="form-control">
                </div>
            </div>

            <button id="signupBtn" type="submit" class="btn btn-primary mt-4">
                Zarejestruj
            </button>
        </form>
    </div>


    <?php include($phpPaths['TEMPLATES'] . '/login-window.php'); ?>
</body>
</html>