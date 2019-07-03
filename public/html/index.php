<!DOCTYPE html>
<html lang="pl">
<head>
	<?php require_once($phpPaths['TEMPLATES'] . "/head.php"); ?>

	<link rel="stylesheet" href="css/index/upload_section.css"/>
	<link rel="stylesheet" href="css/index/why_us_section.css"/>
	<link rel="stylesheet" href="css/index/compare_accounts_section.css"/>
	<link rel="stylesheet" href="css/index/upload_button.css"/>
	<link rel="stylesheet" href="css/index/upload_window.css"/>
	<link rel="stylesheet" href="css/index/upload_alert.css"/>
	<link rel="stylesheet" href="css/compare_accounts_table.css"/>

	<script src="js/index/upload_btn.js"></script>
	<script src="js/index/upload_window.js"></script>
	<script src="js/index/upload_alert.js"></script>
	<script src="js/index/scroll_compare_accounts.js"></script>

	<!-- upload plugin -->
	<script src=<?php echo $htmlPaths['LIB'] . 
	"/upload/js/vendor/jquery.ui.widget.js"; ?> >
	</script>
	
	<script src=<?php echo $htmlPaths['LIB'] . 
	"/upload/js/jquery.iframe-transport.js"; ?> >
	</script>
	
	<script src=<?php echo $htmlPaths['LIB'] . 
	"/upload/js/jquery.fileupload.js"; ?> >
	</script>
</head>
<body>
	<?php include($phpPaths['TEMPLATES'] . "/navbar.php"); ?>

	<section id="uploadSection">
		<h1>Wrzucaj pliki całkowicie za darmo!</h1>
		<div>
			<div id="uploadTextFrame">
				Wrzucaj i pobieraj pliki kiedy checesz i jak chcesz, bez zbędnych reklam i
				haczyków. Szanujemy Twój czas, dlatego zebraliśmy dla Ciebie wszystkie korzyści z posiadania darmowego konta jak i konta premium w naszym serwisie, i zestawilyśmy je w <a href="">tabeli</a>. Nie chcesz zakładać konta? Nie ma sprawy, rejestracja nie jest wymagana by korzystać z naszych usług, choć daje Ci dodatkowe korzyści.<br>
				<b>Kliknij przycisk po prawej stronie by zacząć...</b>
			</div>

			<div id="uploadBtnWrapper">
				<div class="uploadBtnOutline" id="uploadBtnOuterOutline">
					<div class="uploadBtnOutline" id="uploadBtnInnerOutline">
						<button id="uploadBtn" type="button" tabindex="-1">
							<div id="uploadBtnBcg"></div>
							<i class="icon-upload-cloud-outline"></i>
						</button>
					</div>
				</div>
			</div>			
	</section>

	<section id="whyUsSection">
		<h1>Czy warto?</h1>
		<h2><span>3</span> razy TAK!</h2>
		
		<div id="prosWrapper">
			<div class="prosRow">
				<div class="pros">
					<div class="prosGroup">
						<span>
							Nasz serwis jest całkowicie darmowy, nie zawiera żadnych
							reklam i wyskakujących okienek. Jako niezarejestrowany użytkownik masz do wykorzystania 10GB przestrzeni dyskowej na
							pliki. Jeżeli założysz konto zwiększymy tą wartość do 15GB!
						</span>
						<div class="number ml-3">1</div>
					</div>
				</div>
			</div>
			
			<div class="prosRow">
				<div class="pros">
					<div class="prosGroup">
						<div class="number mr-3">2</div>
						<span>
							Prosty i intuicyjny layout serwisu umożliwia szybką pracę
							z uploadem Twoich plików na dysk. Jako niezarejestrowany użytkowik możesz przesyłać aż do 10 plików naraz! Po rejestracji podwoimy tą ilość!
						</span>
					</div>
				</div>
			</div>

			<div class="prosRow">
				<div class="pros">
					<div class="prosGroup">
						<span>
							Mechanizm Drag&drop pozwala na bezpośrednie przerzucanie
							plików z pulpitu na dysk. Koniec z uciążliwą nawigacją
							w menadżerze plików!
						</span>
						<div class="number ml-3">3</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="compareAccountsSection">
		<h1>
			<img src="/resources/img/medal.png">
			Premium mają lepiej!
		</h1>
		<div id="accountsTableWrapper">
			<?php include($phpPaths['TEMPLATES'] . '/compare-accounts-table.php'); ?>
		</div>
	</section>

	<?php 
	include($phpPaths['TEMPLATES'] . '/login-window.php'); 
	include($phpPaths['TEMPLATES'] . '/upload-window.php'); 
	?>
</body>
</html>