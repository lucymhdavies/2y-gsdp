function addContent(divId, content)
{
	document.getElementById(divId).innerHTML += content;
}
function setContent(divId, content)
{
	document.getElementById(divId).innerHTML = content;
}
function removeDiv(divId)
{
	var thisDiv = document.getElementById(divId);
	var parentDiv = document.getElementById(divId).parentNode;
	parentDiv.removeChild(thisDiv);
}
function showDiv(divId)
{
	document.getElementById(divId).style.display = "block";
}
function hideDiv(divId)
{
	document.getElementById(divId).style.display = "none";
}

var ajaxRequests = [];
function getAJAXResult(url, type)
{
	if (window.XMLHttpRequest)
	{ // code for IE7+, Firefox, Chrome, Opera, Safari
		ajaxRequests[type]=new XMLHttpRequest();
	}
	else
	{ // code for IE6, IE5
		ajaxRequests[type]=new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajaxRequests[type].open("GET",url,false);
	ajaxRequests[type].send(null);
	
	response = ajaxRequests[type].responseText;
	return response
}

function firstLoad()
{
	setContent('leftlist', getNewCashflows( 1 ));
	loadTime(1000);
	
	setTimeout( 'loadCashflows(' + 100 + ')', 100 );
}

function loadTime(loadDelay)
{
	setContent('theTime', getAJAXResult("/gsdp/getTime.php", "time"));
	setContent('cashflowCount', getAJAXResult("/gsdp/getCashflowCount.php", "currencyCount"));
	setTimeout( 'loadTime(' + loadDelay + ')', loadDelay );
}

function loadCashflows(loadDelay)
{
	if ( cashflows.length < 10 )
	{
		setContent('leftlist', getNewCashflows( 1 ));
		recolorCashflows();
	}
	
	setTimeout( 'loadCashflows(' + loadDelay + ')', loadDelay );
}


function approveCashflow( cashflowId, eyes )
{
	approveOrRejectCashflow( cashflowId, "approve " + eyes );
}
function rejectCashflow( cashflowId, eyes )
{
	approveOrRejectCashflow( cashflowId, "reject " + eyes );
}
function approveSimilarCashflows( cashflowId, eyes )
{
	approveOrRejectCashflow( cashflowId, "approveSimilar " + eyes );
	expireAllCashflows();
}
function rejectSimilarCashflows( cashflowId, eyes )
{
	approveOrRejectCashflow( cashflowId, "rejectSimilar " + eyes );
	expireAllCashflows();
}
function approveOrRejectCashflow( cashflowId, action )
{
	url = "/gsdp/approveCashflows.php?action=" + action
			+ "&cashFlowId=" + cashflowId;
	
	if ( action == "approveSimilar 2" || action == "rejectSimilar 2"
		|| action == "approveSimilar 4" || action == "rejectSimilar 4" )
	{
		url += "&currency=" + currencyCheck
			+ "&counterparty=" + counterpartyCheck
			+ "&dbentity=" + dbentityCheck
			+ "&date=" + dateCheck;
	}
	
	for ( i = 0; i < cashflows.length; i++ )
	{
		if ( cashflows[i]['id'] == cashflowId )
			cashflows[i]['focus'] = false;
	}
	removeCashflow( cashflowId );
	
	response = getAJAXResult( url , "approval");
	
	
	setContent("centercontent", response);
	
	// setTimeout( 'clearCenter();', 2000 );
	
	checkboxesChecked = 0;
}

function recolorCashflows()
{
	for ( i = 0; i < cashflows.length; i++ )
	{
		c_id = cashflows[i]['id'];
		c_color = cashflows[i]['color'];
		c_focus = cashflows[i]['focus'];
		cfDiv = document.getElementById("cashflow_" + c_id);
		boxclass = c_focus ? "box-focus " : "box ";
		cfDiv.className = boxclass + c_color;
	}
}

function showMoreInfo()
{
	hideDiv("lessInfo");
	showDiv("moreInfo");
}
function hideMoreInfo()
{
	hideDiv("moreInfo");
	showDiv("lessInfo");
}

function showRegularButtons()
{
	hideDiv("similarButtons");
	showDiv("regularButtons");
	
	setContent("similarCount", "");
}
function showSimilarButtons( eyes )
{
	hideDiv("regularButtons");
	showDiv("similarButtons");
	
	similarCount = Math.floor( Math.random() * 1000 );
	
	for ( i = 0; i < cashflows.length; i++ )
	{
		if ( cashflows[i]['focus'] == true )
		{
			c_id = cashflows[i]['id'];
		}
	}
	
	currencyCheck = document.getElementById("similarCurrency").checked;
	counterpartyCheck = document.getElementById("similarCounterparty").checked;
	dbentityCheck = document.getElementById("similarDBEntity").checked;
	dateCheck = document.getElementById("similarDate").checked;
	url = "/gsdp/countSimilar.php?cashflow_id=" + c_id
		+ "&currency=" + currencyCheck
		+ "&counterparty=" + counterpartyCheck
		+ "&dbentity=" + dbentityCheck
		+ "&date=" + dateCheck
		+ "&eyes=" + eyes;
	similarCount = getAJAXResult( url, "countSimilar");
	
	setContent("similarCount", "<b>Count:</b></p><p>" + similarCount);
}
var checkboxesChecked = 0;
function showButtons( change, eyes )
{
	if ( change ) // i.e. if the checkbox just went from false to true
		checkboxesChecked++;
	else
		checkboxesChecked--;
	
	if ( checkboxesChecked > 0 )
		showSimilarButtons( eyes );
	else
		showRegularButtons();
}

var expireDeletionDelay = 5000;

function expireAllCashflows()
{
	for ( i = cashflows.length - 1; i >= 0; i-- )
	{
		removeCashflow( cashflows[i]['id'] );
	}
}

function expireCashflow( cashflowId )
{
	for ( i = 0; i < cashflows.length; i++ )
	{
		if ( cashflows[i]['id'] == cashflowId && cashflows[i]['focus'] == false )
		{
			c_id = cashflows[i]['id'];
			c_timeout = 0;
			divString = cashflows[i]['content'];
			c_color = "gray";
			cf = new Cashflow( c_id, c_timeout, divString , c_color );
			
			cashflows[i] = cf;
			
			cfDiv = document.getElementById("cashflow_" + cashflowId);
			cfDiv.className = 'box ' + "gray";
			
		
			setTimeout( "removeCashflow("+ cashflowId +");", expireDeletionDelay );
			
			break;
		}
	}
}



function Cashflow( id, timeout, content, color )
{
    this.id = id;
    this.timeout = timeout;
    this.content = content;
    this.color = color;
    switch( color )
    {
    	case "red":		this.priority = 1; break;
    	case "orange":	this.priority = 2; break;
    	case "yellow":	this.priority = 3; break;
    	case "green":	this.priority = 4; break;
    	default:		this.priority = 0;
    }
    this.focus = false;
}

var cashflows = [];

function getNewCashflows( n )
{
	content = '';
	
	for ( i = 0 ; i < n ; i++ )
	{
		response = getAJAXResult("/gsdp/getCashflows.php", "getCashflow");
		if ( response == "empty database" )
			break;
		
		var jsonObject = eval('(' + response + ')');
		
		c_id = jsonObject['id'];
		c_timeout = jsonObject['timeout'];
		c_color = jsonObject['color'];
		c_amount = jsonObject['amount'];
		c_currency = jsonObject['currency'];
		c_gsdid = jsonObject['gsdid'];
		divString =
		"<div class='box " + c_color + "' id='cashflow_" + c_id + "'" +
			"onclick='focusCashflow(" + c_id + ");' >" +
			"<div style='float:right'>" +
				c_currency + /* " (" + 
				c_id + ")" + */
			"</div>" +
			c_amount + "<br/>" +
			c_gsdid +
		"</div>";
		
		cf = new Cashflow( c_id, c_timeout, divString , c_color );
		
		setTimeout( "expireCashflow( " + c_id + " );", c_timeout - expireDeletionDelay * 2 );
		
		cashflows.push( cf );
	}
	
	cashflows.sort(comparePriorities)
	
	returnString = "";
	
	for ( i = 0; i < cashflows.length; i++ )
	{		
		returnString += cashflows[i]['content'];
	}
	
	return returnString;
}

function comparePriorities(a,b)
{
	return a['priority'] - b['priority'];
}


function clearCenter()
{
	// center needs clearing
	// i.e. cashflow has just been approved
	// but new content may have taken its place!
	newContent = false;
	for ( i = 0; i < cashflows.length; i++ )
	{
		c_focus = cashflows[i]['focus'];
		// we have found some new content
		if ( c_focus )
			newContent = true;
	}
	// if still displaying the approval message
	if ( ! newContent )
		setContent("centercontent", "<p>&nbsp;</p>");
}

function removeCashflow(cashflowId)
{
	removeDiv( "cashflow_" + cashflowId );
	
	for ( i = 0; i < cashflows.length; i++ )
	{
		if ( cashflows[i]['id'] == cashflowId && ! cashflows[i]['focus'] )
		{
			cashflows.splice(i, 1);
			break;
		}
	}
}


function focusCashflow(cashflowId)
{
	var newFocus = null;
	var oldFocus = null;
	for ( i = 0; i < cashflows.length; i++ )
	{
		if ( cashflows[i]['id'] == cashflowId )
		{
			cashflows[i]['focus'] = true;
			newFocus = i;
		}
		else
		{
			if( cashflows[i]['focus'] )
			{
				cfDiv = document.getElementById("cashflow_" + cashflows[i]['id']);
				cfDiv.className = 'box ' + cashflows[i]['color'];
				cashflows[i]['focus'] = false;
				
				// tell the database that the cashflow is not being looked at (i.e. it may expire)
				response = getAJAXResult("/gsdp/unfocusCashflow.php?cashflow_id=" + cashflows[i]['id'], "unfocusCashflow");
			}
		}
	}
			
	cfDiv = document.getElementById("cashflow_" + cashflowId);
	cfDiv.className = 'box-focus ' + cashflows[newFocus]['color'];
	
	setContent('centercontent', getAJAXResult("/gsdp/getCashflowDetails.php?cashflow_id=" + cashflowId, "focus" ) );
	checkboxesChecked = 0;
}
