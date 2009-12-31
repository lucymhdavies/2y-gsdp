<?php

header ("content-type: text/xml");

require_once( "includes.php" );

$username=$_GET['username'];
$password=$_GET['password'];

$sql =
"select *
from gsdp_users
where username = '$username'
AND password = '$password'";

dbConnect();
	$return = dbSQL( $sql );
dbClose();

$return = mysql_fetch_array( $return );


if ($return)  //if the results of the query are not null
{
	$role = $return['role'];
	$name = $return['name'];
	$return = array (
		'role'=>$role,
		'name'=>$name
	);
}
else
{
	$return = array (
		'role'=>"IncorrectPassword"
	);
}

echo ArrayToXML::toXml($return, "login");
?>
