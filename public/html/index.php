<!DOCTYPE html>
<html lang="pl">
<head>
	<?php require_once($phpPaths['TEMPLATES'] . "/head.php"); ?>

	<link rel="stylesheet" href="css/index/upload_section.css"/>
	<link rel="stylesheet" href="css/index/why_us_section.css"/>
	<link rel="stylesheet" href="css/index/compare_accounts_section.css"/>
	<link rel="stylesheet" href="css/index/upload_button.css"/>
	<link rel="stylesheet" href="css/modal_window.css"/>
	<link rel="stylesheet" href="css/index/upload_window.css"/>
	<link rel="stylesheet" href="css/index/upload_alert.css"/>
	<link rel="stylesheet" href="css/compare_accounts_table.css"/>

	<script src="js/index/upload_btn.js"></script>
	<script src="js/index/upload_window.js"></script>
	<script src="js/index/upload_alert.js"></script>

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
				Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
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
							Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur.
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
							Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur.
						</span>
					</div>
				</div>
			</div>

			<div class="prosRow">
				<div class="pros">
					<div class="prosGroup">
						<span>
							Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur.
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