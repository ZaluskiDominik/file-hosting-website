<?php

//urls to some more important project directories
$htmlPaths = [
	'PAGES' => '/html',
	'LIB' => '/resources/lib',
	'API' => '/resources/routes/api',
	'TEMPLATES' => '/resources/routes/templates'
];

//absolute system paths to some more important project directories
$phpPaths = [
	//directory containing html pages
	'HTML' => $_SERVER['DOCUMENT_ROOT'] . '/html',
	//directory where html templates are stored
	'TEMPLATES' => $_SERVER['DOCUMENT_ROOT'] . '/../private/templates',
	//directory with php logic files
	'PHP' => $_SERVER['DOCUMENT_ROOT'] . '/../private/php',
	//directory where uploaded files are stored
	'UPLOADED_FILES' => $_SERVER['DOCUMENT_ROOT'] . '/../private/uploaded_files',
	//directory where server side configuration is stored
	'CONFIG' => $_SERVER['DOCUMENT_ROOT'] . '/../private/config',
];