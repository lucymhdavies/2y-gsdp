// Operations Management database tasks
// @author=Lucy Davies

public class OpManTest
{
	public static void main( String args[] )
	{
		while( true )
		{
			OpManData o = OpMan.getData();
			int e = o.getEnrichmentCashflows(); // current enrichments
			int ne = o.getNewEnrichmentCashflows(); // current new enrichments
			int pe = e - ne; // unprocessed enrichments
			int a = o.getApprovalCashflows();
			int na = o.getNewApprovalCashflows();
			int pa = a - na;
			int d = o.getDispatchCashflows();
			int nd = o.getNewDispatchCashflows();
			int pd = d - nd;
			
			int nt = o.getNewTotalCashflows();
			int t = o.getTotalCashflows();
			
			System.out.printf(	"Enrichment: %5d (%5d new + %5d unprocessed)\n" + 
								"Approval:   %5d (%5d new + %5d unprocessed)\n" + 
								"Dispatch:   %5d (%5d new + %5d unprocessed)\n" +
								"Total:      %5d (%d)\n\n",
								e, ne, pe,
								a, na, pa,
								d, nd, pd,
								nt, t );
			
			try { Thread.sleep(1000); }
			catch( InterruptedException ie ) { ; }
		}
	}
}
