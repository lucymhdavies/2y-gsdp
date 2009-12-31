<?php

require_once( "includes.php" );

$cf_id = 0;
$cf_id = $_GET['cashflow_id'];


$sql = //sql to select time and date from currently non-existant table
"update beingHandled
set detail = 0
where CashFlowId = '$cf_id';";

dbConnect();
	dbSQL( $sql );
dbClose();

?>
