<?php

$initCommands = array(
	"SET NAMES 'UTF8';",
	"SET SQL_MODE = 'STRICT_ALL_TABLES'",
	"SET SQL_MODE = 'ONLY_FULL_GROUP_BY'",
	"SET SQL_MODE = 'NO_ZERO_IN_DATE'",
	"SET SQL_MODE = 'NO_ZERO_DATE'",
	"SET SQL_MODE = 'NO_ENGINE_SUBSTITUTION'",
);

$host = 'localhost';
$name = 'vice';
$login = 'www';
$password = 'www';

$db = new PDO("mysql:host={$host};dbname={$name}", $login, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => join(';', $initCommands)));
