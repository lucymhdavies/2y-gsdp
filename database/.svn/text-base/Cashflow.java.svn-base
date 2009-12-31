// Cashflow class and supporting classes
// @author=Lucy Davies
import java.util.*;

public class Cashflow
{
	private String		businessGroup;
	private String		legalEntity;
	private String		legalEntityBIC;
	private String		ourSettlementAgentBIC;
	private String		ourSettlementAgentAccount;
	private String		counterpartyID;
	private String		counterpartyBIC;
	private String		otherSettlementAgentBIC;
	private String		otherSettlementAgentAccount;
	private String		cashflowID;
	private GregorianCalendar		valueDate;
	private int			payOutVersion;
	private ISOCurrency	payOutCCY;
	private long		payOutAmount;
	private long		payOutNotionalAmount;
	private int			payInVersion;
	private ISOCurrency	payInCCY;
	private long		payInAmount;
	private long		payInNotionalAmount;
	private String		productType;
	private String		feature;
	private String		cashflowType;
	private String		tradeID;
	private GregorianCalendar		tradeDate;
	private GregorianCalendar		maturityDate;
	private GregorianCalendar		effectiveDate;
	private String		payoutIndexName;
	private String		indexAccruedCalcType;
	private double		payoutRefixRate;
	private GregorianCalendar		payoutRefixDate;
	private double		payInRefixRate;
	private String		bookID;
	
	Cashflow
	(
		String		businessGroup,
		String		legalEntity,
		String		legalEntityBIC,
		String		ourSettlementAgentBIC,
		String		ourSettlementAgentAccount,
		String		counterpartyID,
		String		counterpartyBIC,
		String		otherSettlementAgentBIC,
		String		otherSettlementAgentAccount,
		String		cashflowID,
		GregorianCalendar		valueDate,
		int			payOutVersion,
		ISOCurrency	payOutCCY,
		long		payOutAmount,
		long		payOutNotionalAmount,
		int			payInVersion,
		ISOCurrency	payInCCY,
		long		payInAmount,
		long		payInNotionalAmount,
		String		productType,
		String		feature,
		String		cashflowType,
		String		tradeID,
		GregorianCalendar		tradeDate,
		GregorianCalendar		maturityDate,
		GregorianCalendar		effectiveDate,
		String		payoutIndexName,
		String		indexAccruedCalcType,
		double		payoutRefixRate,
		GregorianCalendar		payoutRefixDate,
		double		payInRefixRate,
		String		bookID
	)
	{
		this.businessGroup = businessGroup;
		this.legalEntity = legalEntity;
		this.legalEntityBIC = legalEntityBIC;
		this.ourSettlementAgentBIC = ourSettlementAgentBIC;
		this.ourSettlementAgentAccount = ourSettlementAgentAccount;
		this.counterpartyID = counterpartyID;
		this.counterpartyBIC = counterpartyBIC;
		this.otherSettlementAgentBIC = otherSettlementAgentBIC;
		this.otherSettlementAgentAccount = otherSettlementAgentAccount;
		this.cashflowID = cashflowID;
		this.valueDate = valueDate;
		this.payOutVersion = payOutVersion;
		this.payOutCCY = payOutCCY;
		this.payOutAmount = payOutAmount;
		this.payOutNotionalAmount = payOutNotionalAmount;
		this.payInVersion = payInVersion;
		this.payInCCY = payInCCY;
		this.payInAmount = payInAmount;
		this.payInNotionalAmount = payInNotionalAmount;
		this.productType = productType;
		this.feature = feature;
		this.cashflowType = cashflowType;
		this.tradeID = tradeID;
		this.tradeDate = tradeDate;
		this.maturityDate = maturityDate;
		this.effectiveDate = effectiveDate;
		this.payoutIndexName = payoutIndexName;
		this.indexAccruedCalcType = indexAccruedCalcType;
		this.payoutRefixRate = payoutRefixRate;
		this.payoutRefixDate = payoutRefixDate;
		this.payInRefixRate = payInRefixRate;
		this.bookID = bookID;
	}
	
	public String toString()
	{
		return String.format
		(
			"Business Group:                 %s\n" +
			"Legal Entity:                   %s\n" + 
			"Legal Entity BIC:               %s\n" + 
			"Our Settlement Agent BIC:       %s\n" +
			"Our Settlement Agent Account:   %s\n" +
			"Counterparty ID:                %s\n" +
			"Counterparty BIC:               %s\n" +
			"Other Settlement Agent BIC:     %s\n" +
			"Other Settlement Agent Account: %s\n" +
			"Cashflow ID:                    %s\n" +
			"Value Date:                     %s\n" +
			"Pay Out Version:                %s\n" +
			"Pay Out CCY:                    %s\n" +
			"Pay Out Amount:                 %s\n" +
			"Pay Out Notional Amount:        %s\n" +
			"Pay In Version:                 %s\n" +
			"Pay In CCY:                     %s\n" +
			"Pay In Amount:                  %s\n" + 
			"Pay In Notional Amount:         %s\n" + 
			"Product Type:                   %s\n" + 
			"Feature:                        %s\n" + 
			"Cashflow Type:                  %s\n" + 
			"Trade ID:                       %s\n" + 
			"Trade Date:                     %s\n" + 
			"Maturity Date:                  %s\n" + 
			"Effective Date:                 %s\n" + 
			"Payout Index Name:              %s\n" + 
			"Index Accrued Calc Type:        %s\n" + 
			"Payout Refix Rate:              %s\n" + 
			"Payout Refix Date:              %s\n" + 
			"Pay In Refix Rate:              %s\n" + 
			"Book ID:                        %s" ,
			businessGroup, legalEntity, legalEntityBIC, ourSettlementAgentBIC,
			ourSettlementAgentAccount, counterpartyID, counterpartyBIC, otherSettlementAgentBIC,
			otherSettlementAgentAccount, cashflowID, GCtoString(valueDate), payOutVersion,
			payOutCCY, payOutAmount, payOutNotionalAmount, payInVersion,
			payInCCY, payInAmount, payInNotionalAmount, productType,
			feature, cashflowType, tradeID, GCtoString(tradeDate),
			GCtoString(maturityDate), GCtoString(effectiveDate), payoutIndexName, indexAccruedCalcType,
			payoutRefixRate, GCtoString(payoutRefixDate), payInRefixRate, bookID
		);
	}
	
	private String GCtoString( GregorianCalendar g )
	{
		if ( payoutRefixDate != null )
			return payoutRefixDate.get(Calendar.YEAR) + "-"
				+ (payoutRefixDate.get(Calendar.MONTH) + 1) + "-"
				+ payoutRefixDate.get(Calendar.DATE);
		else
			return null;
	}
}

class CashflowTest
{
	public static void main( String args[] )
	{
		Cashflow cf = new Cashflow
		(
			"OTC_TOK", "BA_AG", null, null,
			// String businessGroup, String legalEntity, String legalEntityBIC, String ourSettlementAgentBIC,
			
			null, "GREENSECUTOK", null, null,
			// String ourSettlementAgentAccount, String counterpartyID, String counterpartyBIC, String otherSettlementAgentBIC,
			
			null, "20091224ET041299", new GregorianCalendar(2009, 12, 24), 1,
			// String otherSettlementAgentAccount, String cashflowID, GregorianCalendar valueDate, int payOutVersion,
			
			new ISOCurrency("JPY"), -26352083L, 5000000000L, 1,
			// ISOCurrency payOutCCY, long payOutAmount, long payOutNotionalAmount, int payInVersion,
			
			new ISOCurrency("JPY"), 26288889L, 5000000000L, "SWAP",
			// ISOCurrency payInCCY, long payInAmount, long payInNotionalAmount, String productType,
			
			"VANILLA", "COUPON", "ET041299", new GregorianCalendar(2004, 6, 18),
			// String feature, String cashflowType, String tradeID, GregorianCalendar tradeDate,
			
			new GregorianCalendar(2024, 6, 24), new GregorianCalendar(2009, 12, 24), "LIBOR", "A360",
			// GregorianCalendar maturityDate, GregorianCalendar effectiveDate, String payoutIndexName, String indexAccruedCalcType,
			
			1.0425, new GregorianCalendar(2008, 12, 18), 1.04, "YAG_SWAPS"
			// double payoutRefixRate, GregorianCalendar payoutRefixDate, double payInRefixRate, String bookID
		);
		Cashflow cf2 = new Cashflow
		(
			"OTC_TOK", "BA_AG", "BAAUATVI", "BAANJP53",
			// String businessGroup, String legalEntity, String legalEntityBIC, String ourSettlementAgentBIC,
			
			"803335 45666", "GREENSECUTOK", "GRSEJPTKXXX", "NOMHJPSEXXX",
			// String ourSettlementAgentAccount, String counterpartyID, String counterpartyBIC, String otherSettlementAgentBIC,
			
			"804655 49652", "20091224ET041299", new GregorianCalendar(2009, 12, 24), 1,
			// String otherSettlementAgentAccount, String cashflowID, GregorianCalendar valueDate, int payOutVersion,
			
			new ISOCurrency("JPY"), -26352083L, 5000000000L, 1,
			// ISOCurrency payOutCCY, long payOutAmount, long payOutNotionalAmount, int payInVersion,
			
			new ISOCurrency("JPY"), 26288889L, 5000000000L, "SWAP",
			// ISOCurrency payInCCY, long payInAmount, long payInNotionalAmount, String productType,
			
			"VANILLA", "COUPON", "ET041299", new GregorianCalendar(2004, 6, 18),
			// String feature, String cashflowType, String tradeID, GregorianCalendar tradeDate,
			
			new GregorianCalendar(2024, 6, 24), new GregorianCalendar(2009, 12, 24), "LIBOR", "A360",
			// GregorianCalendar maturityDate, GregorianCalendar effectiveDate, String payoutIndexName, String indexAccruedCalcType,
			
			1.0425, new GregorianCalendar(2008, 12, 18), 1.04, "YAG_SWAPS"
			// double payoutRefixRate, GregorianCalendar payoutRefixDate, double payInRefixRate, String bookID
		);
		
		System.out.println( "=========================\n= Before Enrichment     =\n=========================\n");
		System.out.println( cf );
		
		System.out.println();System.out.println();
		
		System.out.println( "=========================\n= After Enrichment      =\n=========================\n");
		System.out.println( cf2 );
	}
}

class ISOCurrency
{
	private String code;		public String getCode()		{ return code; }
	private String name;		public String getName()		{ return name; }
	private boolean stp;		public boolean getSTP()		{ return stp; }
	private boolean foureyes;	public boolean getFourEyes(){ return foureyes; }
	private int sendout;		public int getSendout()		{ return sendout; }
	private int limit;			public int getLimit()		{ return limit; }
	
	ISOCurrency ( String code )
	{
		this.code = code;
	}
	ISOCurrency ( String code, String name, boolean stp, boolean foureyes, int sendout, int limit )
	{
		this.code = code;
		this.name = name;
		this.stp = stp;
		this.foureyes = foureyes;
		this.sendout = sendout;
		this.limit = limit;
	}
	
	public String toString()
	{
		return code;
	}
}