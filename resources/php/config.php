<?php
//db credentials
$db = [
	'HOSTNAME' => "localhost",
	'NAME' => "file_upload",
	'LOGIN' => "root",
	'PASSWORD' => ""
];

//paths to some more important directories beginning from localhost
$htmlPaths = [
	'PUBLIC_HTML' => '/file_upload/public_html/',
	//templates like navbar
	'HTML_INCLUDE' => '/file_upload/resources/html_include/',
	'LIB' => '/file_upload/lib/',
	//php logic
	'PHP' => '/file_upload/resources/php/'
];

//absolute sstem paths to some more important directories
$phpPaths = [
	'PUBLIC_HTML' => $_SERVER['DOCUMENT_ROOT'] . '/file_upload/public_html/',
	'HTML_INCLUDE' => $_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/html_include/',
	'LIB' => $_SERVER['DOCUMENT_ROOT'] . '/file_upload/lib/',
	'PHP' => $_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/'
];
?>