<?php

# Define database connection
define("DB_SERVER", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "root");
define("DB_NAME", "learn");

# Define base seeder data
define("DEFAULT_ADMIN_USERNAME", "admin");
define("DEFAULT_ADMIN_GMAIL", "admin@gmail.com");
define("DEFAULT_ADMIN_PASSWORD", "admin");

# Define base url and path
define("__BASEURL__", "/LearnPHP/auth");
define("__BASEPATH__", dirname(__DIR__, 2));


session_start();
