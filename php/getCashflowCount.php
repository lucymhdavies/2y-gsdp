<?php

require_once( "includes.php" );

countCashflows();

$totalCashFlows;
$incomingFeedCashFlows = $totalCashFlows - $approvedCashFlows - $rejectedCashFlows;
$fourEyesCashFlows;
$twoEyesCashFlows;
$onlyTwoEyesCashFlows = $twoEyesCashFlows - $fourEyesCashFlows;
$approvedCashFlows;
$rejectedCashFlows;
$beingHandledCashFlows;

?>

<b>incomingFeed:</b> <?php echo addCommas($incomingFeedCashFlows); ?> |
<b>Needs Check:</b> <?php echo addCommas($twoEyesCashFlows); ?> 
(<?php echo number_format( ($twoEyesCashFlows / $incomingFeedCashFlows * 100), 2, ".", "," ); ?> %) |
<b>4 Eyes:</b> <?php echo addCommas($fourEyesCashFlows); ?> 
(<?php echo number_format( ($fourEyesCashFlows / $incomingFeedCashFlows * 100), 2, ".", "," ); ?> %) |
<b>2 Eyes:</b> <?php echo addCommas($twoEyesCashFlows); ?> 
(<?php echo number_format( ($twoEyesCashFlows / $incomingFeedCashFlows * 100), 2, ".", "," ); ?> %)<br/>
<b>Approved:</b> <?php echo addCommas($approvedCashFlows); ?> |
<b>Rejected:</b> <?php echo addCommas($rejectedCashFlows); ?> |
<b>With ST:</b> <?php echo addCommas($beingHandledCashFlows); ?>
