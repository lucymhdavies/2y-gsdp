<?php

require_once( "includes.php" );

$action = $_GET['action'];
$cashFlowId = $_GET['cashFlowId'];
$userUsername = $_SESSION['user_username'];
$userName = $_SESSION['user_name'];
$userRole = $_SESSION['user_role'];

getTimeAndDate();
$day = $currentDay;
$time = $currentTime;
$hour = $absoluteHour;

if ( $action == "approve 2" || $action == "reject 2"
	|| $action == "approve 4" || $action == "reject 4" )
{
	$table = ($userRole == "STC")
		? "twoEyes" : "fourEyes" ;
	$flag = ($action == "approve 2" || $action == "approve 4") ? "null" : "0";
	$sql =
	"update $table
	set flag = $flag
	and checkedby = '$userUsername'
	where nettId = $cashFlowId;";
	
	dbConnect();
		dbSQL( $sql );
		
		dbSQL(	"delete from beingHandled
				where CashFlowId = $cashFlowId" );
	dbClose();
}

if ( $action == "approveSimilar 2" || $action == "rejectSimilar 2"
	|| $action == "approveSimilar 4" || $action == "rejectSimilar 4" )
{
	$table = ($userRole == "STC")
		? "twoEyes" : "fourEyes" ;
	
	$sql =
	"select
	feed.nettId,
	Currency,
	GsdId,
	LegalEntity,
	ValueDate

	from $table
	join incomingFeed as feed
	on $table.nettId = feed.nettId

	where
	$table.nettId = $cashFlowId";
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
	
	
	$flag = ($action == "approveSimilar 2" || $action == "approveSimilar 4") ? "null" : "0";
	$sql =
	"update $table
	set flag = $flag
	and checkedby = '$userUsername'
	where nettId = $cashFlowId;";
	
	$s_currency = $_GET['currency'];
	$s_counterparty = $_GET['counterparty'];
	$s_dbentity = $_GET['dbentity'];
	$s_date = $_GET['date'];

	
	
	dbConnect();
		dbSQL( $sql );
		
		$sql =
		"select
		feed.nettId as CashFlowId

		from $table
		join incomingFeed as feed
		on $table.nettId = feed.nettId

		where flag
		";
		$sql .= ($s_currency == "true") ? " and Currency='$cf_currency'" : "";
		$sql .= ($s_counterparty == "true") ? " and GsdId='$cf_counterparty'" : "";
		$sql .= ($s_dbentity == "true") ? " and LegalEntity='$cf_dbentity'" : "";
		$sql .= ($s_date == "true") ? " and ValueDate='$cf_valuedate'" : "";
		

		$approveCashflows = dbSQL( $sql );

		if ($return)  //if the results of the query are not null
		{
			$similar = mysql_num_rows( $approveCashflows );
		}
		else
		{
			$similar = "FAILED";
		}
		
		dbSQL(	"delete from beingHandled
				where CashFlowId = $cashFlowId" );
	dbClose();
}


switch( $action )
{
	case "approve 2":
		$status = "Cashflow Approved by $userName";
		break;
	case "approve 4":
		$status = "Cashflow Approved by $userName as part of a four eyes check";
		break;
	case "reject 2":
		$status = "Cashflow Rejected by $userName";
		break;
	case "reject 4":
		$status = "Cashflow Rejected by $userName as part of a four eyes check";
		break;
	case "approveSimilar 2":
	case "approveSimilar 4":
		$status = "Cashflow (and $similar similar) Approved by $userName";
		break;
	case "rejectSimilar 2":
	case "rejectSimilar 4":
		$status = "Cashflow (and $similar similar) Rejected by $userName";
		break;
	default:
		$status = "$action";
}

$boxclass = ( $action == "reject 2" || $action == "reject 4" ) ? "errorbox" : "messagebox";

?>
<div class="<?php echo $boxclass; ?>" style="width:600px; margin-left: auto; margin-right: auto; margin-top:30px;">
<h1 style="text-align: center;">
	<?php echo $status; ?>
</h1>
</div>

<?php
if ( $approveCashflows )
{
	$ids = "";
		
	while ($row = mysql_fetch_array($approveCashflows))
	{
	    $ids .= $row["CashFlowId"] . ",";
	}
	
	$ids = substr( $ids, 0, -1 );
	
	$sql =
	"update $table
	set flag = $flag
	and checkedby = '$userUsername'
	where nettId in ($ids)
	and flag;";
	
	dbConnect();
		dbSQL( $sql );
	dbClose();
}
?>
