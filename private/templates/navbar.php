<?php 
require_once($phpPaths['PHP'] . '/restrict-functions.php');
startSession();
?>

<header>
    <nav id="nav" class="navbar navbar-expand-xl navbar-light bg-light">
        <button class="navbar-toggler" type="button"
        data-toggle="collapse" data-target="#navOptions">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- logo -->
        <a id="logo" class="navbar-brand" href=<?php echo '"' . $htmlPaths['PAGES'] . 
        '/index.php"'; ?> >
            <img src="/resources/img/logo.png"/>
            <span>Upload<span>IT</span>.pl</span>
        </a>

        <div class="collapse navbar-collapse" id="navOptions">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Start
                    </a>
                </li>
                
                <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Kontakt</a></li>
                
                <li class="nav-item">
                    <a class="nav-link" href="signup.php">
                        Rejestracja
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <div id="storageInfo">
                <div></div>
                <span>
                    Wykorzystane
                    <span id="storageUsedSize"></span>
                    z
                    <span id="storageMaxSize"></span>
                    GB
                </span>
            </div>
            <?php
            if ( isset($_SESSION['user']) )
            {
                //if user is logged in display profile picture and user's name
                include($phpPaths['TEMPLATES'] . '/profile-picture.php');
            }
            else
            {
                //if not logged in display login btn
                include($phpPaths['TEMPLATES'] . '/login-btn.php');
            }
            ?>
        </div>
    </nav>
</header>