<h1>Description</h1>
Website offering file hosting services

<h1>How to run?</h1>
Clone repository and move it to your apache root server directory.<br>
Below is an configuration file of vhost for this web app that needs to be put inside one of apache's configuration files. You need to edit it with appropriate absolute paths of your system(Directives where path should be edited are marked by <b>*</b> and have bold font).<br>
It's also important that you set the same timezone in this file as you have on php server and mysql server. Those timezones need to be the same.
<br><br>

<pre>
&lt;VirtualHost 127.0.0.3:80&gt;
	ServerName upload-it.pl
	ServerAlias www.upload-it.pl

	#root directory of web application - should point to public directory(<b>*</b>)
	DocumentRoot <b>C:\xampp\htdocs\file-hosting-website\public</b>
	#turn on errors displaying
	Php_flag display_errors On
	#prepend config file to all scripts - absolute path to web app's main config file(<b>*</b>)
	Php_value auto_prepend_file <b>C:\xampp\htdocs\file-hosting-website\private\config\config.php</b>
	
	#set default charset to utf8
	Php_value default_charset UTF-8
	AddDefaultCharset urf-8

	#logs
	LogLevel debug
	#path to apache error logs file(<b>*</b>)
	ErrorLog <b>C:\xampp\htdocs\file-hosting-website\private\logs\apache\error.txt</b>
	#path to access logs file(<b>*</b>)
	CustomLog <b>C:\xampp\htdocs\file-hosting-website\private\logs\apache\access.txt</b> combined
	#path to php error logs file(<b>*</b>)
	Php_value error_log <b>C:\xampp\htdocs\file-hosting-website\private\logs\php\error.txt</b>	

	#path to public directory of web app(<b>*</b>)
	&lt;Directory <b>C:\xampp\htdocs\file-hosting-website\public</b>&gt;
		#disable index of
		Options Includes FollowSymlinks
		#redirect root url to index page
		RedirectMatch ^/$ /html
	&lt;/Directory&gt;

	#turn on file uploads
	Php_flag file_uploads On
	#max size of one file
	Php_value upload_max_filesize 40G
	Php_value max_file_uploads 20
	#max size of post request
	Php_value post_max_size 100G

	#set timezone to UTC+1 - timezone need to be the same as system timezone and mysql server system timezone
	Php_value date.timezone Europe/Warsaw
&lt;/VirtualHost&gt;
</pre>
