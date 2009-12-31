// Operations Management database tasks
// @author=Lucy Davies
import java.util.*;

public class OpMan
{
	private static OpManData previousData = new OpManData( 0, 0, 0, 0, 0, 0, 0, 0 );
	
	public static OpManData getData()
	{
		/*
		returns (numbers of cashflows in different stages, as well as the number of newly processed cashflows. needs to be called every second and monitor changes so recording of the previous state is necessary)
		*/
		Random generator = new Random();
		
		// previous fake data
		int pe = previousData.getEnrichmentCashflows();
		int pa = previousData.getApprovalCashflows();
		int pd = previousData.getDispatchCashflows();
		
		// new fake data
		int fakeNE = generator.nextInt( 1000 );
		int fakeDE = Math.min( generator.nextInt( 1200 ), pe );
		int fakeE = pe + fakeNE - fakeDE;
		
		int fakeNA = fakeDE;
		int fakeDA = Math.min( generator.nextInt( 1400 ), pa );
		int fakeA = pa + fakeNA - fakeDA;
		
		int fakeND = fakeDA;
		int fakeDD = Math.min( generator.nextInt( 1800 ), pd );
		int fakeD = pd + fakeND - fakeDD;
		
		
		int fakeTotal = previousData.getTotalCashflows() + fakeE + fakeA + fakeD;
		
		OpManData currentData = new OpManData( fakeE, fakeNE, fakeA, fakeNA, fakeD, fakeND, fakeTotal, previousData.getTotalCashflows() );
		previousData = currentData;
		return currentData;
	}
}

class OpManData
{
	// number of cashflows currently in each stage,
	// also, number of those which are new
	// Enrichment (i.e. in need of Reference Data Team)
	// Netting + Approval (i.e. in need of Settlements Team)
	// Dispatch (ready to send out)
	
	private int enrichmentCashflows;
	private int newEnrichmentCashflows;
	public int getEnrichmentCashflows()
	{
		return enrichmentCashflows;
	}
	public int getNewEnrichmentCashflows()
	{
		return newEnrichmentCashflows;
	}
	
	private int approvalCashflows;
	private int newApprovalCashflows;
	public int getApprovalCashflows()
	{
		return approvalCashflows;
	}
	public int getNewApprovalCashflows()
	{
		return newApprovalCashflows;
	}
	
	private int dispatchCashflows;
	private int newDispatchCashflows;
	public int getDispatchCashflows()
	{
		return dispatchCashflows;
	}
	public int getNewDispatchCashflows()
	{
		return newDispatchCashflows;
	}
	
	
	// previous number of cashflows processed so far
	private int previousTotalCashFlows;
	// number of cashflows processed so far
	private int totalCashFlows;
	public int getTotalCashflows()
	{
		return totalCashFlows;
	}
	// number of new cashflows
	public int getNewTotalCashflows()
	{
		return totalCashFlows - previousTotalCashFlows;
	}
	
	OpManData ( int e, int ne, int a, int na, int d, int nd, int t, int pt )
	{
		enrichmentCashflows = e;
		newEnrichmentCashflows = ne;
		
		approvalCashflows = a;
		newApprovalCashflows = na;
		
		dispatchCashflows = d;
		newDispatchCashflows = nd;
		
		totalCashFlows = t;
		previousTotalCashFlows = pt;
	}
}