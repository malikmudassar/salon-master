<style>
    .mouse-cursor{
        
    }
</style>  
<div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row hidden-print">
                    <div class="col-sm-12" >
                        <div class="col-sm-3" >
                            <h4 class="page-title">Payment Slips</h4>
                        </div>
                        <div class="col-sm-9 m-t-15 pull-right" style="text-align:right;">
                             <div class="col-sm-3">
                                <select type="text" id="selected_staff" name="payment_staff" class="form-control" >
                                    <?php foreach ($staff as $s){?>
                                    <option value='<?php echo $s['id_staff']; ?>'><?php echo $s['staff_fullname']?></option>
                                    <?php } ?>
                                </select>    
                            </div>
<!--                           <div class="col-sm-2 ">
                                <select type="text" id="selected_type" name="payment_type" class="form-control" >
                                    <option value="Salary">Salary</option>
                                    <option value="Commission">Commission</option>
                                    <option value="Loan">Loan</option>
                                    <option value="Bonus">Bonus</option>
                                    <option value="Special Occasion">Special Occasion</option>
                                    <option value="Gift">Gift</option>
                                    
                                </select>    
                            </div>-->
                            <div class="col-sm-3 ">
                               <select class="form-control" id="selected_month">
                                   <?php $month = $lastmonthyear[0]['Month']; ?>
                                       <option value="1" <?php if ($month === '1') {
                                           echo "selected";
                                       } ?> >January</option>
                                       <option value="2" <?php if ($month === '2') {
                                           echo "selected";
                                       } ?>>February</option>
                                           <option value="3" <?php if ($month === '3') {
                                           echo "selected";
                                       } ?>>March</option>
                                           <option value="4" <?php if ($month === '4') {
                                           echo "selected";
                                       } ?>>April</option>
                                           <option value="5" <?php if ($month === '5') {
                                           echo "selected";
                                       } ?>>May</option>
                                           <option value="6" <?php if ($month === '6') {
                                           echo "selected";
                                       } ?>>June</option>
                                           <option value="7" <?php if ($month === '7') {
                                           echo "selected";
                                       } ?>>July</option>
                                           <option value="8" <?php if ($month === '8') {
                                           echo "selected";
                                       } ?>>August</option>
                                           <option value="9" <?php if ($month === '9') {
                                           echo "selected";
                                       } ?>>September</option>
                                           <option value="10" <?php if ($month === '10') {
                                           echo "selected";
                                       } ?>>October</option>
                                           <option value="11" <?php if ($month === '11') {
                                           echo "selected";
                                       } ?>>November</option>
                                           <option value="12" <?php if ($month === '12') {
                                           echo "selected";
                                       } ?>>December</option>
                               </select>
                            </div>
                             <div class="col-sm-2  ">
                               <select class="form-control" id="selected_year">
                                   <?php $year=$lastmonthyear[0]['Year']; for($x=1; $x<=4; $x++){?>
                                   <option value="<?php echo $year;?>" <?php if($year===$lastmonthyear[0]['Year']){ echo "selected";} ?>><?php echo $year;?></option>
                                   <?php $year=$year-1; }?>
                               </select>
                            </div>
                            <div class='col-sm-1'>
                                <button type="button"  onclick="reloadslips();" class="btn btn-default waves-effect waves-light  pull-right" ><span class="m-l-5"><i class="fa fa-refresh"></i></span></button>
                            </div>
                           
                           
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body" >
                                <div id="print_area">
                                    <div class="row">
                                        <div class="pull-left">
                                            <h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src='".base_url().'assets/images/business/'.$business[0]['business_logo']."' alt='".$business[0]['business_name']."' class='img-responsive' />";} else {echo 'SalonPK';}?></h3>
                                        </div>
                                        <div class="pull-right">
                                            <p ><strong>Date: </strong> 22-2-2017</p>
                                            <p id="modep"><strong>Payment Type: </strong>Salary</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="pull-left m-t-10">

                                            </div>
                                            <div class="pull-right m-t-10">

                                            </div>
                                        </div><!-- end col -->
                                    </div>
                                    <!-- end row -->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12 ">
                                           <div class="clearfix m-t-10">
                                                <h5 class="small text-inverse font-600">PAYMENT TERMS AND POLICIES</h5>
                                                <small>
                                                    <?php echo $business[0]['payment_terms'];?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="hidden-print">
                                    <div class="pull-right">
                                        <a href="javascript:window.print()" class="btn btn-inverse waves-effect waves-light" id="btnprint"><i class="fa fa-print"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
               
<script>
    
 function reloadslips(){
     $("#print_area").html('');
      $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>staff_controller/searchpayments',
            data: {payment_month: $("#selected_month :selected").val(), payment_year: $("#selected_year :selected").val(), payment_type: $("#selected_type :selected").val(), staff_id:$("#selected_staff :selected").val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                mhtml="";
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; 
                var yyyy = today.getFullYear();
                var total=0;
                    mhtml +='<div class="row m-b-30 m-t-30"><div class="pull-left">';
                    mhtml +='<h3 class="logo invoice-logo"><?php if(isset($business)){ echo "<img src=\"".base_url()."assets/images/business/".$business[0]['business_logo']."\" alt=\"".$business[0]["business_name"]."\" class=\"img-responsive\" />";} else {echo "SkedWise";}?>';
                    mhtml +='</h3></div><div class="pull-right">';
                    mhtml +='<p class="m-t-30"><strong>Date: </strong> '+ dd + '-' + mm + '-' + yyyy +'</p></div></div>';
                    mhtml +='<table class="table table-bordered">';
                    mhtml +='<tr>';    
                        mhtml +='<td><h4 class="text-inverse font-600">Name          :         '+data[0]['staff_name']+'</h4></td><td colspan="2"><h4 class="text-inverse font-600">Staff #:   '+ data[0]['staff_number'] +'</h4></td>';
                    mhtml +='</tr>';
                    mhtml +='<tr >';    
                        mhtml +='<td class="text-inverse font-600" style="border-bottom:1px solid #808080; border-top:1px solid #808080;">Remarks</td><td class="text-inverse font-600" style="border-bottom:1px solid #808080; border-top:1px solid #808080;">Payment Month</td><td class="text-inverse font-600" style="border-bottom:1px solid #808080; border-top:1px solid #808080; text-align:right;">Amount</td>';
                    mhtml +='</tr>';
                for (x = 0; x < data.length; x++) {    
                    mhtml +='<tr>' ;   
                        mhtml +='<td><h5>'+data[x]['payment_remarks']+'</h5></td>';
                        mhtml +='<td ><h5>'+data[0]['payment_month']+' '+data[x]['payment_year']+'</h5></td>';
                        mhtml +='<td style="text-align:right"><h5 class="text-inverse font-600">'+data[x]['payment_amount'].toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</h5>'; 
                    mhtml +='</tr>';
                    total = total + parseFloat(data[x]['payment_amount']);
                    }
                    mhtml +='<tr>' ;   
                    mhtml += '<td style="border-top:1px solid #808080; text-align:right;" colspan=2><h4 class="text-inverse font-600" >Total</h4></td><td style="text-align:right"><h4 class="text-inverse font-600">'+total.toString().replace(/,/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") +'</h4></td>';
                    mhtml +='</tr>' ;   
                    mhtml +='</table>';
                    mhtml +='<br/><br/><div class="row m-t-50"><div class="col-md-12 col-sm-12 col-xs-12 "><div class="pull-left">';
                        mhtml +='<h5 >Employee __________________</h5>';
                    mhtml +='</div>';
                    mhtml +='<div class="pull-right ">';
                        mhtml +='<h5>Director ___________________</h5>';
                    mhtml +='</div>';
                    mhtml +='</div><!-- end col --></div><!-- end row -->';
                    mhtml +='</div></div><div class="row"><div class="col-md-12 col-sm-12 col-xs-12 "><div class="clearfix m-t-10 m-b-20">';
                    mhtml +='';
                    mhtml +='<small></small>';
                    mhtml +='</div></div></div>';
                    
                
                $("#print_area").html(mhtml);
            }
        });
     
     
 }
   
    
   

</script>
