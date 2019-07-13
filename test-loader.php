<?php
$phpPaths['PHP'] = __DIR__ . '/private/php';

require_once(__DIR__ . '/private/config/database.php');
require_once(__DIR__ . '/private/config/byte-prefixes.php');

//change db database name to that designed for tests
$dbConf['NAME'] = 'test_file_upload';

//require vendor autoloader
require_once(__DIR__ . '/vendor/autoload.php');