<?php

require_once( "includes.php" );

dbConnect();
	dbSQL( "truncate table beingHandled" );
dbClose();

?>
