<?php

include( "settings.php" );

$db;

function dbConnect()
{
	global $db,
	       $dbhost,
	       $dbuser,
	       $dbpass,
	       $dbname;
	
	$db = mysql_connect( $dbhost, $dbuser, $dbpass ) or die ( 'Error connecting to mysql' );
	mysql_select_db( $dbname );
}

function dbClose()
{
	global $db;
	mysql_close( $db );
}

function dbSQL( $sql )
{
	global $db;
	$result = mysql_query( $sql, $db );
	if ( !$result )
	{
		die( 'Invalid query: ' . mysql_error() );
	}
	
	return $result;
}

?>
