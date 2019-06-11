<div id="uploadWindow">
	<h2 class="text-dark">Wybierz plik i możemy zaczynać...</h2>

	<div id="dropFilesArea" class="text-secondary">
		<form method="post" enctype="multipart/form-data"
		action=<?php echo '"' .  $htmlPaths['API'] . '/file/upload.php"'; ?> >
			<input id="uploadInput" type="file" name="files[]" multiple>
		</form>
		Przeciągnij i upuść pliki tutaj<br>
		lub<br>
		Kliknij by wybrać plik
	</div>

	<div id="progress">
		<div id="progressBarWrapper">
			<div id="progressBar"></div>
		</div>
		<span id="progressPercentage" class="ml-1">0%</span>
	</div>

	<div id="uploadSwitchResults">
		<button tabindex="-1" id="uploadLogsBtn">Logi</button>
		<div></div>
		<button tabindex="-1" id="uploadLinksBtn">Linki</button>	
	</div>

	<span id="uploadResultsTitle" class="text-dark d-block" style="text-align: left;">
		Szczegółowe informacje
	</span>
	<div id="uploadResults">
		<div id="uploadLogs"></div>
		<div id="uploadedFileLinks"></div>
	</div>	
</div>