<div class="loginWnd">
	<h4>Logowanie</h4>
	<form method="post" action=<?php echo $htmlPaths['API'] . '/user/login/login.php'; ?>>
        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <label class="input-group-text icon-mail" for="email"></label>
            </div>
            <input id="email" name="email" type="email" class="form-control" 
            placeholder="email@example.com" aria-label="email" 
            aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-1">
            <div class="input-group-prepend">
                <label class="input-group-text icon-key" for="password"></label>
            </div>
            <input id="password" name="password" type="password" class="form-control" 
            aria-label="password" aria-describedby="basic-addon1" placeholder="Hasło">
        </div>

        <input style="display: none;" type="text" name="prevPage"
        value=<?php echo $_SERVER['REQUEST_URI']; ?>>

        <div id="loginErr"></div>

        <button id="loginSubmitBtn" type="submit" class="btn btn-primary">Zaloguj</button>
	</form>
</div>