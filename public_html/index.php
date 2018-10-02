<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php') ?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<title></title>
	<?php require_once($phpPaths['HTML_INCLUDE'] . "head.php"); ?>

	<link rel="stylesheet" href="fontello/fontello1/css/fontello.css"/>
	<link rel="stylesheet" href="css/index/upload_section.css"/>
	<link rel="stylesheet" href="css/index/why_us_section.css"/>
	<link rel="stylesheet" href="css/modal_window.css"/>
	<link rel="stylesheet" href="css/index/upload_window.css"/>

	<!-- upload plugin -->
	<script src=<?php echo $htmlPaths['LIB'] . "upload/js/vendor/jquery.ui.widget.js"; ?> ></script>
	<script src=<?php echo $htmlPaths['LIB'] . "upload/js/jquery.iframe-transport.js"; ?> ></script>
	<script src=<?php echo $htmlPaths['LIB'] . "upload/js/jquery.fileupload.js"; ?> ></script>

	<script src="js/php_scripts_path.js"></script>
	<script src="js/upload_btn.js"></script>
	<script src="js/modal_window.js"></script>
	<script src="js/upload_window.js"></script>
</head>
<body>
	<?php require_once($phpPaths['HTML_INCLUDE'] . "navbar.php"); ?>

	<section id="uploadSection">
		<h1>Wrzucaj pliki całkowicie za darmo!</h1>
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md" id="uploadTextFrame">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
					cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
					proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</div>

				<div class="col-xs-12 col-md" id="uploadBtnWrapper">
					<div class="uploadBtnOutline" id="uploadBtnOuterOutline">
						<div class="uploadBtnOutline" id="uploadBtnInnerOutline">
							<button id="uploadBtn" type="button" tabindex="-1" onclick="uploadWindow.openClose()">
								<div id="uploadBtnBcg"></div>
								<i class="icon-upload-cloud-outline"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section id="whyUsSection">
		<h1>Czy warto?</h1>
		<h2><span style="font-weight: bold;">3</span> razy TAK!</h2>
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

	<div id="uploadWindowBcg" class="modalWindowBcg"></div>
	<div id="uploadWindow" class="modalWindow">
		<div class="closeBtnWrapper">
			<button id="closeUploadBtn" class="closeBtn" onclick="uploadWindow.openClose()">&times;</button>
		</div>

		<h4>Wybierz plik i możemy zaczynać...</h4>
		
		<div id="fileSelection">
			<form method="post" enctype="multipart/form-data" action=<?php echo $htmlPaths['PHP'] . 'upload.php'; ?> >
				<input id="uploadInput" type="file" name="file"/><br/>
				<input id="startUploadBtn" type="submit" class="btn btn-success" value="Start"/>
			</form>
		</div>

		<div id="progress">
			<div id="progressBarWrapper">
				<div id="progressBar"></div>
			</div>
			<span id="progressPercentage" class="ml-1">0%</span>
		</div>
	</div>
</body>
</html>