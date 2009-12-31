<?php

header ("content-type: text/xml");

require_once( "includes.php" );

$entity=$_GET['entity'];
$currency=$_GET['currency'];

$sql =
"select *
from gsdp_entityCurrencies";
if ( isset( $entity ) )
{
	$sql .= " where entity='$entity'";
	if ( isset( $currency ) )
		$sql .= " and currency='$currency';";
}
else
{
if ( isset( $currency ) )
	$sql .= " where currency='$currency';";
}

//echo $sql . "<br/><br/>";

dbConnect();
	$result = dbSQL( $sql );
dbClose();

$return = array();

while ($row = mysql_fetch_array($result) )
{
	$row = array (
		'entity'        => $row['entity'],
		'currency'      => $row['currency'],
		'effectiveDate' => $row['effectiveDate'],
		'agent'         => $row['agent'],
		'account'       => $row['account'],
		'nett'          => $row['nett'],
		'stp'           => $row['stp'],
		'foureyes'      => $row['foureyes']
	);
	
	$return[] = $row;
	//$return[] = ArrayToXML::toXml($row, "entitycurrency");
}
/*
	echo "<pre>";
	print_r( $return );
	echo "</pre>";
*/
echo ArrayToXML::toXml($return, "entitycurrencylist");

?>