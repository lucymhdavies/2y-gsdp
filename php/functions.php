<?php

require_once( "includes.php" );

$currentDay;
$currentTime;
$absoluteHour;

function getTimeAndDate()
{
	global	$currentDay,
			$currentTime,
			$absoluteHour;
	
	$sql =
	"select *
	from dateTime";

	dbConnect();
		$return = dbSQL( $sql );
	dbClose();

	$return = mysql_fetch_array( $return );


	if ($return)  //if the results of the query are not null
	{
		$currentDay  = $return['currentDay'];
		$currentTime = $return['currentTime'];
		$absoluteHour = $return['absoluteHour'];
		$return = "Day $currentDay, Hour $currentTime";
	}
	else
	{
		$return = "UNKNOWN ERROR";
	}
	
	return $return;
}


$totalCashFlows;
$fourEyesCashFlows;
$twoEyesCashFlows;
$approvedCashFlows;
$rejectedCashFlows;
$beingHandledCashFlows;
function countCashflows()
{
	global	$totalCashFlows,
			$fourEyesCashFlows,
			$twoEyesCashFlows,
			$approvedCashFlows,
			$rejectedCashFlows,
			$beingHandledCashFlows;
	
	$sql =
	"select * from
	(
		select count(*) as count
		from incomingFeed
	) as f
	join
	(
		select count(*) as twoEyes
		from twoEyes
		where flag
	) as twoeyes
	join
	(
		select count(*) as fourEyes
		from fourEyes
		where flag
	) as foureyes
	join
	(
		select count(*) as approved
		from twoEyes
		where flag is null
	) as a
	join
	(
		select count(*) as rejected
		from twoEyes
		where flag='0'
	) as r
	join
	(
		select count(*) as beingHandled
		from beingHandled
	) as h";

	dbConnect();
		$return = dbSQL( $sql );
		
		// delete those cashflows that have timed out
		dbSQL(
		"delete from beingHandled
		where
		(
			timeout < utc_timestamp()
			and detail = 0
		)");
	dbClose();

	$return = mysql_fetch_array( $return );


	if ($return)  //if the results of the query are not null
	{
		$totalCashFlows  = $return['count'];
		$fourEyesCashFlows  = $return['fourEyes'];
		$twoEyesCashFlows  = $return['twoEyes'];
		$approvedCashFlows  = $return['approved'];
		$rejectedCashFlows  = $return['rejected'];
		$beingHandledCashFlows  = $return['beingHandled'];
	}
	else
	{
		$return = "UNKNOWN ERROR";
	}
	
	return $totalCashFlows;
}

function getColor( $hour )
{
	global	$currentDay,
			$currentTime,
			$absoluteHour;
	
	getTimeAndDate();
	switch ( $hour )
	{
		case ( $hour < $absoluteHour ):
			$cf_color = "red";
			break;
		case ( ($hour / 24) < ($absoluteHour / 24) + 5 ):
			$cf_color = "orange";
			break;
		case ( ($hour / 24) < ($absoluteHour / 24) + 8 ):
			$cf_color = "yellow";
			break;
		case ( ($hour / 24) >= ($absoluteHour / 24) + 8 ):
			$cf_color = "green";
			break;
		default:
			$cf_color = "blue";
	}
	
	return $cf_color;
}

function addCommas( $number )
{
	return number_format( $number, 0, ".", "," );
}

?>
