<?php

require_once( "includes.php" );

if ( $_GET['username'] )
{
	$username = $_GET['username'];
	dbConnect();
		$return = dbSQL( "
			select u.*, s.name as supervisorName
			from gsdp_users as u
			left join gsdp_users as s
			on u.supervisor = s.username
			where u.username = '$username'" );
	dbClose();
	
	if ( mysql_num_rows( $return ) == 0 )
		die( "invalid user" );

	$return = mysql_fetch_array( $return );

	if ($return)  //if the results of the query are not null
	{
		$_SESSION['user_username'] = $return['username'];
		$_SESSION['user_name'] = $return['name'];
		$_SESSION['user_role'] = $return['role'];
		$_SESSION['user_supervisor'] = $return['supervisor'];
		$_SESSION['user_supervisor_name'] = $return['supervisorName'];
	}
}
else
{
	$_SESSION['user_username'] = "anon";
	$_SESSION['user_name'] = "Lucy Davies";
	$_SESSION['user_role'] = "STC";
	$_SESSION['user_supervisor'] = "norris";
	$_SESSION['user_supervisor_name'] = "Chuck Norris";
}

switch ( $_SESSION['user_role'] )
{
	case "STC":
	case "STS":
		include( "settlements.php" );
		break;
	case "RDC":
	case "RDS":
	case "OM":
	case "IT":
	default:
}

?>

<p>
	FAIL
</p>
