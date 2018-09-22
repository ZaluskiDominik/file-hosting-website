<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php'); ?>

<header>
		<nav id="nav" class="navbar navbar-expand-xl navbar-light bg-light">
			<a class="navbar-brand" href=<?php echo '"' . $htmlPaths['PUBLIC_HTML'] . 'index.php"'; ?> >
				<img src="img/logo.png"/>
				<div>Upload<span>IT</span>.pl</div>
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navOptions">
   		 		<span class="navbar-toggler-icon"></span>
  			</button>

  			<div class="collapse navbar-collapse" id="navOptions">
  				<ul class="navbar-nav">
  					<li class="nav-item">
  						<a class="nav-link" href=<?php echo '"' . $htmlPaths['PUBLIC_HTML'] . 'index.php"'; ?> >Start</a>
  					</li>
  					<li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
  					<li class="nav-item"><a class="nav-link" href="#">Kontakt</a></li>
  					<li class="nav-item"><a class="nav-link" href="#">Login</a></li>
  					<li class="nav-item"><a class="nav-link" href="#">Register</a></li>
  				</ul>
  			</div>
		</nav>
</header>