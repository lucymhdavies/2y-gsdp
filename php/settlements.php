<?php

require_once( "includes.php" );

if ( isset( $_SESSION['user_username'] ) )
{
	$userUsername = $_SESSION['user_username'];
	$userName = $_SESSION['user_name'];
	$supervisorName = $_SESSION['user_supervisor_name'];
}
else
	   header( "Location: ". $PUBLIC_HTML );

?>


<html>

<head>
<link rel="stylesheet" type="text/css" href="<?php echo $PUBLIC_HTML ?>style/settlements.css" />
<script type="text/javascript" src="<?php echo $PUBLIC_HTML ?>ajax.js"></script>
<title>Settlements</title>
</head>

<body onload='firstLoad();'>
<div id="banner">
	<div id="timeDiv">
		<p id='theTime'>
		</p>
	</div>
	<div id="welcome">
		<p>
			<?php
				echo "U: ". $userName;
				if ( $supervisorName )
					echo "<br/>S: ". $supervisorName;
			?>
		</p>
	</div>
	<div>
		<p style="float:left">
			<span id="cashflowCount"></span>
		</p>
	</div>
</div>
<div id="leftcontent"> 
	<h1>Approvals</h1>
	<div id="leftlist">
	</div>
</div> 
 
<div id="centercontent">
	<h1>Click Something!</h1>
	<p>
		Click a cashflow on the left or a net on the right
	</p>
</div> 


<div id="rightcontent"> 
	<h1>Netting</h1> 
	<div class="box gray">
		<p>
			Content
		</p>
	</div>
	<div class="box green">
		<p>
			Content
		</p>
	</div>
</div> 
</body>

</html>
