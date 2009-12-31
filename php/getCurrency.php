<?php

header ("content-type: text/xml");

require_once( "includes.php" );

$code=$_GET['code'];

$sql =
"select *
from gsdp_currencies
where code = '$code'";

dbConnect();
	$return = dbSQL( $sql );
dbClose();

$return = mysql_fetch_array( $return );


if ($return)  //if the results of the query are not null
{
	$return = array (
		'code'=>$return['code'],
		'name'=>$return['name'],
		'stp'=>$return['stp'],
		'foureyes'=>$return['foureyes'],
		'sendout'=>$return['sendout'],
		'limit'=>$return['limit']
	);
}
else
{
	$return = array (
		'name'=>"IncorrectCode"
	);
}

echo ArrayToXML::toXml($return, "currency");
?>
