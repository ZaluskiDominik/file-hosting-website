'use strict'

//api entry point
const API_PATH = '/resources/routes/api';
//entry point for requesting templates from server
const TEMPLATES_PATH = '/resources/routes/templates';
//url to download page(need to concatenate file name)
const DOWNLOAD_PAGE_URL = window.location.protocol + "//" +
    window.location.hostname + "/html/download.php?file=";