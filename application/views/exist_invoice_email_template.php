<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body style="font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 1.42857143; margin: 0; padding-bottom: 20px; padding-top: 20px; overflow-x: hidden; color: #797979;">
        <div style="width: 90%; margin: auto; border-radius: 4px; padding: 20px;">
            
            <!-- logo & invoice number -->
            <div style="float: left;">
                <?php 
                if(isset($business)){
                    echo "<img width='180px' src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."'>";
                } else {
                    echo 'SalonPK';
                }
                ?>
            </div>
            <div style="float: right">
                <h4>
                    Invoice # <br>
                    <strong><?php echo $invoice[0]['invoice_number'];?></strong>
                </h4>
            </div>
            <div style="clear: both;"></div>
            <!-- logo & invoice number end -->
            
            <!-- Customer info, payment mode & date -->
            <div style="float: left;">
                <strong><?php echo $invoice[0]['customer_name']; ?></strong><br>
                <?php echo $invoice[0]['customer_address']; ?><br>
                <?php echo $invoice[0]['customer_email']; ?><br>
                P: <?php echo $invoice[0]['customer_cell']; ?>
            </div>
            <div style="float: right;">
                <p><strong>Invoice Date: </strong> <?php echo $invoice[0]['invoice_date']; ?></p>
                <p class="m-t-0" id="modep"><strong>Payment: </strong> <span id="mode"><?php echo $invoice[0]['payment_mode']; ?></span></p>
            </div>
            <div style="clear: both;"></div>
            <!-- Customer info, payment mode & date end -->
            
            <!-- Items List in Table Format -->
            <table style="border-collapse: collapse; width: 100%;">
                <thead>
                    <tr style="border-bottom: 2px solid #ebeff2;">
                        <th style="text-align: left; padding: 8px;">#</th>
                        <th style="text-align: left; padding: 8px;">Item</th>
                        <th style="text-align: left; padding: 8px;">Description</th>
                        <th style="text-align: left; padding: 8px;">Service Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $x=1; if(isset($invoicedetails)){ foreach($invoicedetails as $invoicedetail){ ?>
                    <tr>
                        <td style="text-align: left; padding: 8px;"><?php echo $x;?></td>
                        <td style="text-align: left; padding: 8px;"><?php echo $invoicedetail['service_category']; ?></td>
                        <td style="text-align: left; padding: 8px;"><?php echo $invoicedetail['service_name']; ?></td>
                        <td style="text-align: left; padding: 8px;">Rs.<span><?php echo $invoicedetail['discounted_price']; ?></span></td>
                    </tr>
                    <?php $x++;}} ?>
                </tbody>
            </table>
            <div style="clear: both;"></div>
            <!-- Items List in Table Format end -->
            
            <div style="float: right;">
                <p><b>Sub-total:</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. <?php echo $invoice[0]['sub_total'];?></p>
                <p>Discount: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. <?php echo $invoice[0]['discount'];?></p>
                <p>Gross Total: &nbsp;&nbsp;&nbsp; Rs. <?php echo $invoice[0]['gross_amount'];?></p>
                <div style="display: <?php echo count($taxes) > 0 ? 'block' : 'none'; ?>;">
                    <?php if(isset($taxes)){$x=0;foreach ($taxes as $tax) {?>
                        <p>
                            <span><?php echo $tax['invoice_tax_name'].' '; ?></span> <?php echo $tax['invoice_tax_name'] === 'VAT ' ? '&nbsp;' : ''; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. <?php echo $tax['invoice_tax'];?>
                        </p>
                    <?php $x++;}}?>
                </div>
                <hr style="border: 1px solid #eee;">
                <p style="color: #10c469;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. <?php echo $invoice[0]['net_amount']; ?></p>
                <p>Paid &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. <?php echo ($invoice[0]['paid_amount'] + $invoice[0]['returnamount']); ?></p>
                <p style="color: #188ae2;">Return &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. <?php echo $invoice[0]['returnamount']; ?></p>
                <p style="color: #ff5b5b;">Balance &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. <?php echo $invoice[0]['balance']; ?></p>
            </div>
            <div style="clear: both;"></div>
            
        </div>
    </body>
</html>