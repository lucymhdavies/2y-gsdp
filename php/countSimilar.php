<?php

require_once( "includes.php" );

$userRole = $_SESSION['user_role'];
$eyes = ( $userRole == "STC" ) ? "2" : "4";

$cf_id = 0;
$cf_id = $_GET['cashflow_id'];

$s_currency = $_GET['currency'];
$s_counterparty = $_GET['counterparty'];
$s_dbentity = $_GET['dbentity'];
$s_date = $_GET['date'];


$sql =
"select
nettId,
Currency,
GsdId,
LegalEntity,
ValueDate

from incomingFeed as feed

where
feed.nettId = $cf_id";
dbConnect();
	$return = dbSQL( $sql );
dbClose();

$return = mysql_fetch_array( $return );

if ($return)  //if the results of the query are not null
{
	$cf_currency		= $return['Currency'];
	$cf_counterparty	= $return['GsdId'];
	$cf_dbentity		= $return['LegalEntity'];
	$cf_valuedate		= $return['ValueDate'];
}
else
{
	die( "FAILED" );
}

$table = ( $eyes == "2" ) ? "twoEyes" : "fourEyes";

$sql =
"select count(*) as count

from $table
join incomingFeed as feed
on $table.nettId = feed.nettId

where $table.flag='1'
";
$sql .= $s_currency == "true" ? " and Currency='$cf_currency'" : "";
$sql .= $s_counterparty == "true" ? " and GsdId='$cf_counterparty'" : "";
$sql .= $s_dbentity == "true" ? " and LegalEntity='$cf_dbentity'" : "";
$sql .= $s_date == "true" ? " and ValueDate='$cf_valuedate'" : "";



dbConnect();
	$return = dbSQL( $sql );
dbClose();

$return = mysql_fetch_array( $return );

if ($return)  //if the results of the query are not null
{
	echo $return['count'];
}
else
{
	die( "FAILED" );
}

?>
