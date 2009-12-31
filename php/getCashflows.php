<?php

require_once( "includes.php" );

$userRole = $_SESSION['user_role'];

getTimeAndDate();

dbConnect();

	dbSQL( "START TRANSACTION" );

	dbSQL(
	"create temporary table nextCashflow
	(
	  `CashFlowId` int(1) NOT NULL
	)");
	
	// delete those cashflows that have timed out
	dbSQL(
	"delete from beingHandled
	where
	(
		timeout < utc_timestamp()
		and detail = 0
	)");
	
	// select the first cashflow that has not timed out
	
	$table = ($userRole == "STC") ? "twoEyes" : "fourEyes";
	dbSQL(
	"insert into nextCashflow
	select feed.nettId as CashFlowId
	from $table
	join incomingFeed as feed
	on feed.nettId = $table.nettId
	
	where feed.nettId not in
	(
		select
		CashFlowId as nettId
		from
		beingHandled
		where
		timeout is null
		or timeout > utc_timestamp()
		or detail
	)
	and $table.flag
	
	order by AbsoluteValueHour
	limit 1");

	dbSQL(
	"insert into beingHandled
	select
	CashFlowId, '".$_SESSION['user_username']."' as user,
	UTC_TIMESTAMP() as timestamp,
	false as detail, null as timeout
	from
	nextCashflow");

	$return = dbSQL(
	"select incomingFeed.*
	from incomingFeed
	join nextCashflow
	on incomingFeed.nettId = nextCashflow.CashFlowId
	limit 1;");

	dbSQL( "COMMIT" );

dbClose();

if ( mysql_num_rows( $return ) == 0 )
	die( "empty database" );

$return = mysql_fetch_array( $return );

if ($return)  //if the results of the query are not null
{
	$LegalEntity = $return['LegalEntity'];
	$GsdId = $return['GsdId'];
	$CashFlowId = $return['nettId'];
	$ValueDate = $return['ValueDate'];
	$AbsoluteValueHour = $return['AbsoluteValueHour'];
	$Currency = $return['Currency'];
	$Amount = $return['Amount'];
}

$cf_color = getColor( $AbsoluteValueHour );

switch( $cf_color )
{
	case "red":
		$timeout = 2;
		break;
	case "orange":
	case "yellow":
		$timeout = 4;
		break;
	default:
		$timeout = 20;
}

dbConnect();
	dbSQL(
	"update beingHandled
	set timeout = date_add(utc_timestamp(), interval $timeout minute)
	where CashFlowId = '$CashFlowId';");
dbClose();

// convert to milliseconds
$timeout *= 60 * 1000;



$json = array
(
	"id"=>$CashFlowId,
	"timeout"=>$timeout,
	"amount"=>addCommas($Amount),
	"currency"=>$Currency,
	"gsdid"=>$GsdId,
	"color"=>$cf_color
);

echo json_encode( $json );

?>
