<?php

require_once( "includes.php" );

$userRole = $_SESSION['user_role'];
$eyes = ( $userRole == "STC" ) ? "2" : "4";

$cf_id = 0;
$cf_id = $_GET['cashflow_id'];


$sql = //sql to select time and date from currently non-existant table
"select feed.*, extra.*,
curr.name as CurrencyName, curr.sendout as CurrencySendout,
cp.longname as cp_longname, db.longname as db_longname,
notionalcurrency.name as NotionalCurrencyName,
payoutcurr.name as PayOutCurrencyName,
payincurr.name as PayInCurrencyName,
fourEyes.flag as foureyes

from incomingFeed as feed
join relatedCashFlowData as extra
on feed.CollectionId = extra.CollectionId

join gsdp_currencies as curr on
feed.Currency = curr.code

join gsdp_currencies as notionalcurrency on
extra.NotionalCurrency = notionalcurrency.code

join gsdp_currencies as payoutcurr on
extra.PayOutCurrency = payoutcurr.code

join gsdp_currencies as payincurr on
extra.PayInCurrency = payincurr.code

join gsdp_counterparties as cp on
feed.GsdId = cp.shortname
join gsdp_counterparties as db on
feed.LegalEntity = db.counterpartyID

left join fourEyes
on feed.nettId = fourEyes.nettId

where feed.nettId = '$cf_id'";

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
	
	dbSQL( "update beingHandled
			set detail = 1
			where CashFlowId = '$cf_id';" );
dbClose();

$return = mysql_fetch_array( $return );


if ($return)  //if the results of the query are not null
{
	$LegalEntity					= $return['LegalEntity'];
	$GsdId							= $return['GsdId'];
	$CashFlowId						= $return['nettId'];
	$CashFlowIdFromFeed				= $return['CashFlowIdFromFeed'];
	$CollectionId					= $return['CollectionId'];
	
	$ValueDate						= $return['ValueDate'];
	$AbsoluteValueHour				= $return['AbsoluteValueHour'];
	$EffectiveValueDate				= floor ( $AbsoluteValueHour / 24 ) + 1;
		// i.e. the day it is due, as opposed to how many days have passed
	$EffectiveValueDateTime			= $AbsoluteValueHour % 24;
	
	$Currency						= $return['Currency'];
	$CurrencyName					= $return['CurrencyName'];
	$CurrencySendout				= $return['CurrencySendout'];
	$Amount							= $return['Amount'];
	$inOrOut						= ( $Amount >= 0 ? " out" : " in" );
	
	$NotionalAmount					= $return['NotionalAmount'];
	$NinOrOut						= ( $NotionalAmount >= 0 ? " out" : " in" );
	$NotionalCurrency				= $return['NotionalCurrency'];
	$NotionalCurrencyName			= $return['NotionalCurrencyName'];
	
	
	
	
	$PayOutAmount				= $return['PayOutAmount'];
	$PayOutCurrency				= $return['PayOutCurrency'];
	$PayOutCurrencyName			= $return['PayOutCurrencyName'];
	$PayOutVersion				= $return['PayOutVersion'];
	$PayOutRefixDate			= $return['PayOutRefixDate'];
	$PayOutRefixRate			= $return['PayOutRefixRate'];


	$PayInAmount				= $return['PayInAmount'];
	$PayInCurrency				= $return['PayInCurrency'];
	$PayInCurrencyName			= $return['PayInCurrencyName'];
	$PayInVersion				= $return['PayInVersion'];
	$PayInRefixRate				= $return['PayInRefixRate'];




	$BusinessGroup				= $return['BusinessGroup'];
	$ProductType				= $return['ProductType'];
	$Feature					= $return['Feature'];
	$CashFlowType				= $return['CashFlowType'];


	$TradeDate					= $return['TradeDate'];
	$MaturityDate				= $return['MaturityDate'];
	$EffectiveDate				= $return['EffectiveDate'];


	$RateIndexName				= $return['RateIndexName'];
	$RateIndexTenor				= $return['RateIndexTenor'];


	$BookId						= $return['BookId'];
	
	
	
	$cp_longname				= $return['cp_longname'];
	$db_longname				= $return['db_longname'];
	
	$isFourEyes					= $return['foureyes'];
	$eyes						= $isFourEyes ? "4" : "2" ;
}
else
{
	die( "FAILED" );
}


$status = getColor( $AbsoluteValueHour );
switch( $status )
{
	case "red":
		$status = "Late";
		break;
	case "orange":
		$status = "Straight to STP<br/>(within 5 days of dispatch)";
		break;
	case "yellow":
		$status = "Close to STP<br/>(within 8 days of dispatch)";
		break;
	case "green":
		$status = "Future<br/>(more than 8 days from dispatch)";
		break;
	default:
		$status = $status;
}

?>



<div class="centerbox" style="width: 500px; padding: 15px; margin-left: auto; margin-right: auto; margin-top: 10px; border: 1px solid black" >
	<p>
		<span style="float: right; text-align:right;">
			<?php echo $db_longname; ?><br/>
			<?php echo $LegalEntity; ?>
		</span>
		<b>DB Legal Entity:</b>
		<div class="clear"></div>
	</p>
	<p>
		<span style="float: right; text-align:right;">
			<?php echo $cp_longname; ?><br/>
			<?php echo $GsdId; ?>
		</span>
		<b>GsdId:</b>
		<div class="clear"></div>
	</p>
	<p>
		<span style="float: right; text-align:right;">
			<?php echo addCommas(abs($Amount)); ?>
			<?php echo $CurrencyName; ?>
			(<?php echo $Currency; ?>)
		</span>
		<b>Amount<?php echo $inOrOut ?></b>:
	</p>
	<p>
		<span style="float: right; text-align:right;">
			<?php echo "Day $EffectiveValueDate, Hour $EffectiveValueDateTime"; ?>
		</span>
			<b>Value Date:</b>
	</p>
	<p>
		<span style="float: right; text-align:right;"><?php echo $status; ?></span>
		<b>Status</b>:
	</p>
</div>

<?php if ( $isFourEyes ) { ?>
<p style="text-align: center; font-size: 1.2em; margin-top:10px;">
	<b>This is part of a Four Eyes check</b>
</p>
<?php } ?>

<div id="lessInfo">
	<div class="clickbox" onclick="showMoreInfo();">
			More Info...
	</div>
</div>

<div id="moreInfo" style="display:none">
	<div class="clickbox" onclick="hideMoreInfo();">
		Less Info...
	</div>

<hr/>

<div class="detail-wrapper">
	<div class="detail-box centerbox" style="float: left; margin-left: 15px;">
		<p>
			<b>Pay Out</b>
		</p>
		<hr/>
		
		<p>
			<span style="float:right; text-align: right;">
				<?php echo $PayOutCurrencyName; ?> (<?php echo $PayOutCurrency; ?>)
			</span>
			<b>Currency:</b>
			<div class="clear"></div>
		</p>
		<p>
			<span style="float:right; text-align: right;">
				<?php echo addCommas(abs($PayOutAmount)); ?>
			</span>
			<b>Amount:</b>
			<div class="clear"></div>
		</p>
		
		<hr/>
		
		<p>
			<span style="float:right; text-align: right;">
				<?php echo $PayOutVersion; ?>
			</span>
			<b>Version:</b>
			<div class="clear"></div>
		</p>
		<p>
			<span style="float:right; text-align: right;">
				<?php echo $PayOutRefixDate; ?>
			</span>
			<b>Refix Date:</b>
			<div class="clear"></div>
		</p>
		<p>
			<span style="float:right; text-align: right;">
				<?php echo $PayOutRefixRate; ?>
			</span>
			<b>Refix Rate:</b>
			<div class="clear"></div>
		</p>
	</div>
	<div class="detail-box centerbox" style="float: right; margin-right: 15px;">
		<p>
			<b>Pay In</b>
		</p>
		
		<hr/>
		
		<p>
			<span style="float:right; text-align: right;">
				<?php echo $PayInCurrencyName; ?> (<?php echo $PayInCurrency; ?>)
			</span>
			<b>Currency:</b>
			<div class="clear"></div>
		</p>
		<p>
			<span style="float:right; text-align: right;">
				<?php echo addCommas(abs($PayInAmount)); ?>
			</span>
			<b>Amount:</b>
			<div class="clear"></div>
		</p>
		
		<hr/>
		
		<p>
			<span style="float:right; text-align: right;">
				<?php echo $PayInVersion; ?>
			</span>
			<b>Version:</b>
			<div class="clear"></div>
		</p>
		<p>
			<span style="float:right; text-align: right;">
				<?php echo $PayInRefixRate; ?>
			</span>
			<b>Refix Rate:</b>
			<div class="clear"></div>
		</p>
	</div>
	<div class="clear"></div>
</div>


<hr/>

<div class="detail-wrapper" style="margin-left: auto; margin-right: auto;">
	<div class="detail-box centerbox" style="float: left; margin-left: 15px;">
		<p>
			<span style="float: right;"><?php echo $BusinessGroup; ?></span>
			<b>BusinessGroup:</b>
		</p>
		<p>
			<span style="float: right;"><?php echo $ProductType; ?></span>
			<b>ProductType:</b>
		</p>
		<p>
			<span style="float: right;"><?php echo $Feature; ?></span>
			<b>Feature:</b>
		</p>
		<p>
			<span style="float: right;"><?php echo $CashFlowType; ?></span>
			<b>CashFlowType:</b>
		</p>

		<p>
			<span style="float: right;"><?php echo $TradeDate; ?></span>
			<b>TradeDate:</b>
		</p>
		<p>
			<span style="float: right;"><?php echo $MaturityDate; ?></span>
			<b>MaturityDate:</b>
		</p>
		<p>
			<span style="float: right;"><?php echo $EffectiveDate; ?></span>
			<b>EffectiveDate:</b>
		</p>

		<p>
			<span style="float: right;"><?php echo $RateIndexName; ?></span>
			<b>RateIndexName:</b>
		</p>
		<p>
			<span style="float: right;"><?php echo $RateIndexTenor; ?></span>
			<b>RateIndexTenor:</b>
		</p>

		<p>
			<span style="float: right;"><?php echo $BookId; ?></span>
			<b>BookId:</b>
		</p>
	</div>
	
	<div class="detail-box centerbox" style="float: right; margin-right: 15px;">
		<p>
			<span style="float: right;">
				<?php echo $CashFlowIdFromFeed; ?>
			</span>
			<b>Cashflow ID:</b>
		</p>
		<p>
			<span style="float: right;">
				<?php echo $CashFlowId; ?>
			</span>
			<b>Item ID:</b>
		</p>
		<p>
			<span style="float: right;">
				<?php echo $CollectionId; ?>
			</span>
			<b>Collection ID:</b>
		</p>
		<div class="clear"></div>
	</div>
	
	<div class="detail-box centerbox" style="float: right; margin-right: 15px; margin-top: 15px;">
		<p>
			<span style="float: right;">
				<?php echo addCommas(abs($NotionalAmount)); ?>
				<?php echo $NotionalCurrencyName; ?>
				(<?php echo $NotionalCurrency; ?>)
			</span>
			<b>Notional Amount<?php echo $NinOrOut ?></b>:
		</p>
		<div class="clear"></div>
	</div>
</div>
<div class="clear"></div>

</div> <!-- end of More Info -->

<hr/>


<div id="checkboxes" class="centerbox" style="width: 500px; padding: 15px; margin-left: auto; margin-right: auto; margin-top: 10px; border: 1px solid black" >
	<p>
		<b>Approve Similar Cashflows By...</b>
	</p>
	<div class="checkboxTriple" style="float: left; text-align: right;">
		<p>
			Same Currency:
				<input type="checkbox" id="similarCurrency"
				onchange="showButtons(this.checked, <?php echo $eyes; ?>);" value="currency" />
		</p>
		<p>
			Same Date:
				<input type="checkbox" id="similarDate"
				onchange="showButtons(this.checked, <?php echo $eyes; ?>);" value="date" />
		</p>
	</div>
	<div class="checkboxTriple" style="float: left; text-align: right;">
		<p>
			Same Counterparty:
				<input type="checkbox" id="similarCounterparty"
				onchange="showButtons(this.checked, <?php echo $eyes; ?>);" value="counterparty" />
		</p>
	</div>
	<div class="checkboxTriple" style="float: left; text-align: right;">
		<p>
			Same DB Entity:
				<input type="checkbox" id="similarDBEntity"
				onchange="showButtons(this.checked, <?php echo $eyes; ?>);" value="dbentity" />
		</p>
	</div>
	<div class="clear"></div>
	<p id="similarCount" style="text" >
	</p>
</div>



<hr/>

<div id="regularButtons">
	<div class="buttons">
		<button type="button" class="button" style="background-color: #9F9; border: 2px solid green;"
		onclick='approveCashflow("<?php echo $cf_id . "\", " . $eyes; ?>)'>Approve</button>
		<button type="button" class="button" style="background-color: #F99; border: 2px solid red;"
		onclick='rejectCashflow("<?php echo $cf_id . "\", " . $eyes; ?>)'>Reject</button>
	</div>
</div>
<div id="similarButtons" style="display:none" >
	<div class="buttons">
		<button type="button" class="button" style="background-color: #9F9; border: 2px solid green;"
		onclick='approveSimilarCashflows("<?php echo $cf_id . "\", " . $eyes; ?>);'>Approve Similar</button>
		<button type="button" class="button" style="background-color: #F99; border: 2px solid red;"
		onclick='rejectSimilarCashflows("<?php echo $cf_id . "\", " . $eyes; ?>);'>Reject Similar</button>
	</div>
</div>
