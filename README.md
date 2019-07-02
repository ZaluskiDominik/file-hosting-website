<h1>Description</h1>
Website offering file hosting services

<h1>How to run?</h1>
Clone repository and move it to your apache root server directory.<br>
Below is an configuration file of vhost for this web app that needs to be put inside one of apache's configuration files.

<pre>
  <VirtualHost 127.0.0.3:80>
	ServerName upload-it.pl
	ServerAlias www.upload-it.pl

	#Server root directory
	DocumentRoot C:\xampp\htdocs\file-hosting-website\public
	#turn on errors displaying
	Php_flag display_errors On
	#prepend config file to all scripts
	Php_value auto_prepend_file C:\xampp\htdocs\file-hosting-website\private\config\config.php
	
	#set default charset to utf8
	Php_value default_charset UTF-8
	AddDefaultCharset urf-8

	#logs
	LogLevel debug
	ErrorLog "C:\xampp\htdocs\file-hosting-website\private\logs\apache\error.txt"
	CustomLog "C:\xampp\htdocs\file-hosting-website\private\logs\apache\access.txt" combined
	Php_value error_log "C:\xampp\htdocs\file-hosting-website\private\logs\php\error.txt"	

	<Directory C:\xampp\htdocs\file-hosting-website\public>
		#disable index of
		Options Includes FollowSymlinks
		#redirect root url to index page
		RedirectMatch ^/$ /html
	</Directory>

	#file uploads config
	Php_flag file_uploads On
	Php_value upload_max_filesize 40G
	Php_value max_file_uploads 20
	Php_value post_max_size 100G

	#set timezone to UTC+1
	Php_value date.timezone Europe/Warsaw
</VirtualHost>
</pre>
