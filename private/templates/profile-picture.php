<div class="profile">
    <div class="profileIconWrapper" tabindex="-1">
        <i class="icon-user"></i>

        <div class="profileDropdown">
            <a href=<?php echo $htmlPaths['API'] . '/user/login/logout.php'
            . '?prev_page=' . $_SERVER['REQUEST_URI']; ?>>
                Wyloguj
            </a>
        </div>
    </div>
    <br>

    <span class="profileName">
        <?php echo $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname']; ?>
    </span>
</div>