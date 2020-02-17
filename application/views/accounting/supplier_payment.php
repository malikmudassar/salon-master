
<style>
    .datepicker-dropdown {top:190px !important;}
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Supplier Payment:</h4>
            </div>
        </div>
        <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != "") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != "") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <form class="form-horizontal" method="post" action="<?php echo base_url(); ?>insert_po_payment">
                        <input type="hidden" name="csrf_test_name" id="supplier_payment_csrf" value=""/>

                        <div class="divider"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <strong>Purchase Order #: <?php echo $purchase_order[0]['purchase_order_number']; ?></strong></h3>
                            </div>
                        </div>

                        <div class="row m-t-20">                                 
                            <div class="form-group">
                                <label for="txtsuppliername" class="col-md-2 control-label">Supplier Name</label>
                                <div class="col-md-10">
                                    <input tabindex="1" readonly="readonly" type="text" class="form-control" placeholder="Supplier Name" id="txtsuppliername" name="txtsuppliername" value="<?php if (isset($purchase_order)) {echo $purchase_order[0]['supplier_name'];} ?>" required="required">
                                    <input type="hidden" class="form-control" placeholder="Supplier ID" id="txtsupplierid" name="txtsupplierid" value="<?php if (isset($purchase_order)) {echo $purchase_order[0]['supplier_id'];} ?>">
                                    <input type="hidden" class="form-control" placeholder="PO ID" id="txtpurchaseorderid" name="txtpurchaseorderid" value="<?php if (isset($purchase_order)) {echo $purchase_order[0]['idpurchase_order'];} ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="div_rec_pay">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-3" >
                                   <div class="radio radio-info radio-inline">
                                       <input type="radio" onclick="showhidebank();" value="Bank" required="required" name="voucher_payment_mode" >
                                        <label for="voucher_payment_mode"> Bank </label>
                                    </div>
                                </div>
                                <div class="col-md-3 m-b-10">
                                  <div class="radio radio-info radio-inline">
                                        <input type="radio" onclick="showhidebank();" value="Cash" required="required" name="voucher_payment_mode">
                                        <label for="voucher_payment_mode"> Cash </label>
                                    </div>
                                </div>
<!--                                <div class="col-md-3 m-b-10">
                                  <div class="radio radio-info radio-inline">
                                        <input type="radio" onclick="showhidebank();" value="Card" required="required" name="voucher_payment_mode">
                                        <label for="voucher_payment_mode"> Card </label>
                                    </div>
                                </div>-->
                            </div>
                        </div>

                        <div class="form-group" id="showbank" style="display:none">
                            
                                <label class="control-label col-md-2">Select Bank</label>
                            
                            <div class="col-md-10">    

                                <select class="form-control" name="bank_accounts">
                                    
                                    <?php foreach($bank_accounts as $ba){?>
                                    <option value="<?php echo $ba['id_account_heads'];?>"><?php echo $ba['account_head'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">                                 
                            <div class="form-group">
                                <label for="txtpaymentamount" class="col-md-2 control-label">Payment Amount</label>
                                <div class="col-md-10">
                                    <input class="form-control decimal" id="txtpaymentamount" required="required" name="txtpaymentamount">                                           
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                            <!--Instrument Number-->
                                <label class="col-md-2  control-label">Instrument #</label>
                                <div class="col-md-10">
                                    <input class="form-control numeric" name="instrument_number" id="instrument_number" value = "">
                                </div>
                            </div>
                        </div>
                        <div class="row">                                 
                            <div class="form-group">
                                <label for="account_voucher_date" class="col-md-2 control-label">Payment Date</label>
                                <div class="col-md-10">
                                    <input class="form-control" required="required" id="account_voucher_date" name="account_voucher_date">                                           
                                </div>
                            </div>
                        </div>
                        
                        <div class="divider"></div>
                       
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-md-10">
                                <textarea type="" class='form-control' required="required"  id="description" name='description'><?php echo 'Payment against ' . $purchase_order[0]['purchase_order_number'] . ' to ' . $purchase_order[0]['supplier_name'] ; ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">Business Partner Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class='form-control' readonly="readonly" name='business_partner' id='business_partner' value="<?php echo $purchase_order[0]['supplier_name']; ?>"/>
                                <input type='hidden' class='form-control' name='business_partner_id' id='business_partner_id' value="<?php echo $purchase_order[0]['supplier_id']; ?>"/>
                            </div>
                            
                            
                            
                        </div>
                        <div class="form-group">    
                            <!--Cost Center Type-->
                            <div class="col-md-2">
                                <label class="control-label">Cost Center Type</label>
                            </div>
                            <div class="col-md-10">
                                
                                <select onchange="costcentertypechange();" class="form-control" name="cost_center_type" id="cost_center_type">
                                    <option value="0">Select</option>
                                    <?php foreach($cost_center_types as $cct){?>
                                    <?php if($cct['account_cost_center']!=='Staff'){;?>
                                    <option value="<?php echo $cct['id_account_cost_center'];?>"><?php echo $cct['account_cost_center'];?></option>
                                    <?php }} ?>
                                </select>
                             </div>
                        </div>
                        <div class="form-group">    
                            <!--Cost Center-->
                            <div class="col-md-2">
                                <label class="control-label">Cost Center</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" name="cost_center" required="required"  id="cost_center" value=""/>
                            </div>
                            
                        </div>
                        <!--
                            'description' => $voucher_data['description'],
                            'voucher_date' => $voucher_data['account_voucher_date'],
                            'voucher_amount' => $voucher_data['amount'],
                            'voucher_status' => 'Active',
                            'created_by' => $this->session->userdata('username'),
                            'cost_center'=> $voucher_data['cost_center_type'],
                            'cost_center_name'=> $voucher_data['cost_center'],
                            'business_partner'=> $voucher_data['business_partner_type'],
                            'business_partner_name'=> $voucher_data['business_partner'],
                            'voucher_type'=> $voucher_data['account_voucher_type']
                        -->
                        <div class="divider"></div>
                         <div class="form-group m-b-0">
                            <div class="col-sm-offset-11 col-sm-12">
                                <button type="submit" onclick='$("#supplier_payment_csrf").val($("#cook").val());' class="btn btn-info waves-effect waves-light">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</div>
<script>
$(document).ready(function() {
    $(".numeric").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    
    $(".decimal").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57) ) {

            return false;
        }
    });

    $('#account_voucher_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'yyyy-mm-dd'
    });

});

    function showhidebank(){
       
        if($('input[name=voucher_payment_mode]:checked').val()=="Bank"){
            
            $("#showbank").show();
            $("#payment_mode").val("Bank");
        } else if($('input[name=voucher_payment_mode]:checked').val()=="Cash"){ 
            $("#showbank").hide();
            $("#payment_mode").val("Cash");
        } else if($('input[name=voucher_payment_mode]:checked').val()=="Card"){ 
            $("#showbank").hide();
            $("#payment_mode").val("Card");
        }
        
    }
    
    function costcentertypechange(){
        if($("#cost_center_type option:selected").text()!=="Staff"){
            $("#cost_center").select2('destroy'); 
            $("#cost_center").val($("#cost_center_type option:selected").text()); 
        } else {
            enable_costcenterstaff();
        }
            
    }
    function enable_costcenterstaff(){
       $("#cost_center").select2({
            ajax: {
              url: '<?php echo base_url();?>staff_controller/searchnameforstaff',
              dataType: 'json',
              delay: 250,
              data: function (term, page) {
                  
                return {
                    staffname: term, // search term
                    page_limit: 30, // page size
                    page: page // page number
                };
              },
              results: function (data, page) {
                 
                    var more = (page * 30) < data.length;
                    return {results: data, more: more};
                }
              },
            escapeMarkup: function (m) { return m; }, // let our custom formatter work
            minimumInputLength: 1,
            formatResult: function (option) {
               return option.staff_fullname+" | "+option.staff_cell ;
            },
            formatSelection: function (option) {
                
                return option.staff_fullname+" | "+option.staff_cell;
            }
          });
         
    }
</script>