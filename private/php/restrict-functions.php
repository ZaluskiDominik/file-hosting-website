<?php
//starts session if it wasn't already started
function startSession()
{
	if (session_status() == PHP_SESSION_NONE)
		session_start();
}

//redirects client to page
function redirect(string $page)
{
	header('Location: ' . $GLOBALS['htmlPaths']['PAGES'] . '/' . $page);
	exit();
}

//exits script with 401 html response code if client isn't logged in
function allowLoggedInOnly()
{
	if ( !isset($_SESSION['user']) )
	{
		http_response_code(401);
		exit();
	}
}

//sets 400 html code and exits script echoing error msg
function badRequest(string $msg)
{
    http_response_code(400);
    die($msg);
}