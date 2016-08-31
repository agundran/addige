<!--<script runat="server">


    protected void OnbtnLinkOperatorView_Clicked(object sender, EventArgs e) 
    {
	if(InvoiceView.SelectedIndex == -1)
		return;

	GridViewRow selectRow = InvoiceView.SelectedRow;
	int Contract = Convert.ToInt32((string)selectRow.Cells[0].Text);
	string SysCode = (string)selectRow.Cells[1].Text;
	decimal Net = Convert.ToDecimal((string)selectRow.Cells[8].Text);

	AddToBilledAmount(Contract, SysCode, StartDateName.Text, EndDateName.Text, Net);

	CheckBox cb = (CheckBox)selectRow.Cells[0].FindControl("ViewCheck");
	cb.Checked = true;

    }

    // Generate a client side script to download a generated file
    void GenerateDownload(string FileName)
    {
	// Check that we have an IP address before going anywhere...
        string IPAddress = System.Web.Configuration.WebConfigurationManager.AppSettings["IPAddress"];
        if (IPAddress == null)	{
	    throw new ArgumentException("IP address must be specified");
	    return;
	}

	// Setup to generate the scripts..
	Type cstype = this.GetType();
	ClientScriptManager cs = Page.ClientScript;
	String csDownload = "OpenPageScript";
	StringBuilder cstextDownload = new StringBuilder();

	cstextDownload.Append("function FileDownload() {\n");
	cstextDownload.Append("window.open(\"http://" + IPAddress + "/Downloads/" + FileName + "\"");
	cstextDownload.Append(");\n");
	cstextDownload.Append("}\n");

	cs.RegisterClientScriptBlock(cstype, csDownload, cstextDownload.ToString(), true);
    }

    // Generate a client side script to print an invoice
    void GeneratePrintInvoice(string Seq, string StartDate, string EndDate)
    {
	// Check that we have an IP address before going anywhere...
        string IPAddress = System.Web.Configuration.WebConfigurationManager.AppSettings["IPAddress"];
        if (IPAddress == null)	{
	    throw new ArgumentException("IP address must be specified");
	    return;
	}

	// Setup to generate the scripts..
	Type cstype = this.GetType();
	ClientScriptManager cs = Page.ClientScript;
	String csPrintInvoice = "OpenPageScript";
	StringBuilder cstextPrintInvoice = new StringBuilder();

	cstextPrintInvoice.Append("function PrtInvoice() {\n");
	cstextPrintInvoice.Append("window.open(\"http://" + IPAddress + "/billing/archive/prtinvoice.aspx?Seq=");
	cstextPrintInvoice.Append(Seq);
	cstextPrintInvoice.Append("&StartDate=");
	cstextPrintInvoice.Append(StartDate);
	cstextPrintInvoice.Append("&EndDate=");
	cstextPrintInvoice.Append(EndDate);
	cstextPrintInvoice.Append("\", \"_blank\" ");
	cstextPrintInvoice.Append(");\n");
	cstextPrintInvoice.Append("}\n");
	cstextPrintInvoice.Append("function PrtSpotLog() {\n");
	cstextPrintInvoice.Append("window.open(\"http://" + IPAddress + "/billing/archive/prtspotlog.aspx?Seq=");
	cstextPrintInvoice.Append(Seq);
	cstextPrintInvoice.Append("&StartDate=");
	cstextPrintInvoice.Append(StartDate);
	cstextPrintInvoice.Append("&EndDate=");
	cstextPrintInvoice.Append(EndDate);
	cstextPrintInvoice.Append("\", \"_blank\" ");
	cstextPrintInvoice.Append(");\n");
	cstextPrintInvoice.Append("}\n");

	cs.RegisterClientScriptBlock(cstype, csPrintInvoice, cstextPrintInvoice.ToString(), true);
    }

</script>
-->
    <div id="container">
		
        <center>
		<h3><?php echo $title; ?></h3>
		<h4><?php echo $title1; ?></h4>
        </center>
        
        
        <table>
        <tr>
        
        <td align="right" >
       	<button type="button" class="btn btn-default" onclick="tableToExcel('table2excel', 'Invoicing')" value="Export to Excel">
      	<span class="glyphicon glyphicon-export"></span> Export to Excel
        
    	</button>
        <script src="js/tableToExcel.js"></script>
        </td>
              
		
        </tr>
        </table>  
          
       
        <div class="paging"><?php //echo $pagination; ?></div>
		
        <div class="data">
		
		<?php echo $table; ?>
        
        </div>
		
        <div class="paging"><?php //echo $pagination; ?></div>
        
      
    
        
        
        <br />
        
        <font size="2" face="verdana">
		    <br />
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    
        <!--    <asp:Button ID="lnkOperatorView"
			OnClick="OnbtnLinkOperatorView_Clicked"
			text="Export"
			runat="server" >
		    </asp:Button>
		-->
                   
            Click to export invoice for viewing by cable operator
		</font>
                
                         