<?php
include_once __DIR__."/../boot.php";

function getDatabaseConnection(): mysqli
{
	$dbHost=getConfigurationOption("DB_HOST");
	$dbUser=getConfigurationOption("DB_USER");
	$dbPassword=getConfigurationOption("DB_PASSWORD");
	$dbName=getConfigurationOption("DB_NAME");

	$connection = mysqli_init();
	$connected = mysqli_real_connect($connection, $dbHost, $dbUser, $dbPassword, $dbName);
	if (!$connected)
	{
		$error = mysqli_connect_errno().': '.mysqli_connect_error();
		throw new RuntimeException($error);
	}

	$encodingResult = mysqli_set_charset($connection, 'utf8');
	if (!$encodingResult)
	{
		header("Location: /public/error.php");
		throw new RuntimeException(mysqli_error($connection));
	}

	return $connection;
}