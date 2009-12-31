<?php

header ("content-type: text/xml");

require_once( "includes.php" );

$id=$_GET['id'];

$sql =
"select *
from gsdp_counterparties
where counterpartyID='$id'";

dbConnect();
	$return = dbSQL( $sql );
dbClose();

$return = mysql_fetch_array( $return );


if ($return)  //if the results of the query are not null
{
	$return = array (
		'counterpartyID'    => $return['counterpartyID'],
		'shortname'         => $return['shortname'],
		'longname'          => $return['longname'],
		'nett'              => $return['nett'],
		'stp'               => $return['stp'],
		'bic'               => $return['BIC'],
		'foureyes'          => $return['foureyes'],
		'local'             => $return['local'],
		'address'           => $return['address']
	);
}
else
{
	$return = array (
		'name'=>"IncorrectID"
	);
}

echo ArrayToXML::toXml($return, "counterparty");
?>
