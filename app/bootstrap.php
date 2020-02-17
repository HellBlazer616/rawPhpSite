<?php

// load config file
require_once '../app/config/config.php';
// Load Helpers
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';


//Autoload libraries
spl_autoload_register(function ($className) {
    require_once 'libraries/' . $className . '.php';
});
