<?php

/*** mysql hostname ***/
$hostname = 'localhost';
/*** mysql username ***/
$username = 'root';
/*** mysql password ***/
$password = '';
/*** mysql database name ***/
$databaseName = 'shop';
// check connection, prepare query and execute it and stop script if something was wrong
// when something was wrong catch error (exception) and show it
try {
    $connection = new PDO("mysql:host=$hostname;dbname=$databaseName;charset=utf8", $username, $password);
    $connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $connection->setAttribute( PDO::ATTR_EMULATE_PREPARES, FALSE );

} catch( PDOException $e ) {
    echo "Something was wrong. Error: " . $e->getMessage();
    die();
}

