<?php

header ("content-type: text/xml");

require_once( "includes.php" );

// obviously wrong, but a good starting point
$e_sql="select count(*) as count
from incomingFeed
where 1";

dbConnect();
	$return = dbSQL( $e_sql );
dbClose();

$return = mysql_fetch_array( $return );

if ( $return )
	$enrichment = $return['count'];
else
	$enrichment = 0;
// those cashflows which do not have matching reference data

$approval=0;
// those cashflows which have matching reference data but do not have approval

$dispatch=0;
// those cashflows which have approval but which have not been dispatched

$currentTotal=$enrichment + $approval + $dispatch;

$allTimeTotal=0;

$return = array (
	'stages'=>array(
		'enrichment'=>$enrichment,
		'approval'=>$approval,
		'dispatch'=>$dispatch
	),
	'totals'=>array(
		'current'=>$currentTotal,
		'alltime'=>$allTimeTotal
	)
);

echo ArrayToXML::toXml($return, "cashflowdata");
?>
