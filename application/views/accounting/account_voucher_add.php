<div class="wrapper">
    <div class="container">
        <div class="card-box">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><i class="ti-bookmark-alt"></i> Create Voucher:</h4>
               
            </div>
        </div>
        <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != ""){  ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-success">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != ""){  ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                </div>
            </div>
        </div>
        <?php } ?>
    
    <form class="form-horizontal" id="voucher-form">
        <input type="hidden" name="account_voucher_csrf" id="account_voucher_csrf" value=""/>
        <div class="row" id="divselection">
            <div class="card-box " style="background:#f7f7f7;">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-md-2">
                                 <label class="control-label">Voucher Type</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control" name="account_voucher_type" id="account_voucher_type" onchange="voucher_type_change();">
                                    <?php foreach($account_voucher_types as $avt){?>
                                    <option value="<?php echo $avt['id_account_voucher_type'];?>"><?php echo $avt['account_voucher_type'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-md-2">
                                <label class="control-label">Voucher Date</label>
                           </div>
                            <div class="col-md-10">
                                <input class="form-control"  name="account_voucher_date" id="account_voucher_date" value = "">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">Description</label>
                            </div>
                            <div class="col-md-10">
                                <textarea type="" class='form-control' name='description'></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <div class="col-md-2">
                                 <label class="control-label">Business Partner</label>
                            </div>
                            <div class="col-md-10">   
                                <select onchange="partnertypechange();" class="form-control" name="business_partner_type" id="business_partner_type">
                                    <option value="0">Select</option>
                                    <?php foreach($account_business_partners as $abp){?>
                                    <option value="<?php echo $abp['id_account_business_partner'];?>"><?php echo $abp['account_business_partner'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-2">
                                <label class="control-label">Business Partner Name</label>
                            </div>
                            <div class="col-md-10">
                                <input class='form-control' name='business_partner' id='business_partner'/>
                            </div>
                        </div>

                        <div class="form-group" id="div_rec_pay">
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-3" >
                                   <div class="radio radio-info radio-inline">
                                       <input type="radio" onclick="showhidebank();" value="Bank" name="voucher_payment_mode" >
                                        <label for="voucher_payment_mode"> Bank </label>
                                    </div>
                                </div>
                                <div class="col-md-3 m-b-10">
                                  <div class="radio radio-info radio-inline">
                                        <input type="radio" onclick="showhidebank();" value="Cash" checked="checked" name="voucher_payment_mode">
                                        <label for="voucher_payment_mode"> Cash </label>
                                    </div>
                                </div>
                                <div class="col-md-3 m-b-10">
                                  <div class="radio radio-info radio-inline">
                                        <input type="radio" onclick="showhidebank();" value="Card" name="voucher_payment_mode">
                                        <label for="voucher_payment_mode"> Card </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="showbank" style="display:none">
                            <div class="col-md-2">
                                <label class="control-label">Select Bank</label>
                            </div>
                            <div class="col-md-10">    

                                <select class="form-control" name="bank_accounts">
                                    <option value="0">Select</option>
                                    <?php foreach($bank_accounts as $ba){?>
                                    <option value="<?php echo $ba['account_head'];?>"><?php echo $ba['account_head'];?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="divvoucherentries" >
            <div class="card-box " style="background:#f7f7f7;">
                <div class="row">
                    <h2 class="header-title m-t-0 m-b-30" style="border-bottom:#f7f7f7 1px dashed">Voucher Entry</h2>
                    
                    <div class="col-sm-6" style="border-right:#f7f7f7 1px dashed">
                        <div class="form-group">
                            <!--Transaction Type-->
                            <div class="col-md-2">
                                <label class="control-label">Transaction Type</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control" name="transaction_type" id="transaction_type">
                                    <option value="Debit">Debit</option>
                                    <option value="Credit">Credit</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <!--Transaction Amount-->
                            <div class="col-md-2">
                                <label class="control-label">Transaction Account</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control" name="account_head" id="account_head">
                                    <?php foreach($account_heads as $ah){?>
                                    <option value="<?php echo $ah['id_account_heads'];?>"><?php echo $ah['account_head_number']." | ".$ah['account_type']." | ".$ah['account_head'];?></option>
                                    <?php } ?>
                                </select>
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
                                    <option value="<?php echo $cct['id_account_cost_center'];?>"><?php echo $cct['account_cost_center'];?></option>
                                    <?php } ?>
                                </select>
                             </div>
                        </div>
                        <div class="form-group">    
                            <!--Cost Center-->
                            <div class="col-md-2">
                                <label class="control-label">Cost Center</label>
                            </div>
                            <div class="col-md-10">
                                <input class="form-control" name="cost_center" id="cost_center" value=""/>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                        <!--Payment Mode-->
                        
                            <div class="col-md-2">
                                <label class="control-label">Payment Mode</label>
                            </div>
                            <div class="col-md-10">
                                <select class="form-control" name="payment_mode" id="payment_mode" disabled="disabled">
                                    <option value="Cash">Cash</option>
                                    <option value="Bank">Check</option>
                                    <option value="Card">Card</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                        <!--Instrument Number-->
                            <div class="col-md-2">
                                <label class="control-label">Instrument #</label>
                             </div>
                             <div class="col-md-10">
                                 <input class="form-control" name="instrument_number" id="instrument_number" value = "">
                             </div>
                        </div>
                        <div class="form-group">
                        <!--Amount-->
                            <div class="col-md-2">
                                <label class="control-label">Amount</label>
                             </div>
                             <div class="col-md-10">
                                
                                 <input class="form-control numeric" name="amount" id="amount" value = "" required="required">
                             </div>
                        </div>
                        <div class="form-group">
                        <!--Remarks-->
                            <div class="col-md-2">
                                <label class="control-label">Remarks</label>
                             </div>
                             <div class="col-md-10">
                               
                                <input class="form-control" name="remarks" id="remarks" value = "">
                            </div>
                        </div>
                        <div class="row m-t-20">
                            <div class='col-md-12'>
                                <div class="pull-right">
                                    <button type="button" onclick="addrow();" class="btn btn-sm waves-effect waves-light btn-info"><i class="fa fa-arrow-down"></i>Add</button>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>
        
        <div class="row" id="div_voucher_details">
            
            
                <div class="card-box " style="background:#f7f7f7;">
                    <h4 class="header-title m-t-0 m-b-30">Voucher Details</h4>
                    <hr>
                    <table id="voucher_details" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%" style="background: #fff;">
                        <thead>
                            <tr>
                                <th>Account # | Type | Title</th>
                                <th>Payment Mode</th>
                                <th>Instrument #</th>
                                <th>Cost Center</th>
                                <th>Remarks</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Action</th>
                            </tr>

                        </thead>
                        <tbody></tbody>
                        <tfoot></tfoot>
                    </table>
                    
                </div>
            
        </div>    
        <div class="row m-t-20">
            <div class="col-md-12">
                <div class="btn-group pull-right m-t-15">
                    <a href="<?php echo base_url();?>account_vouchers" class="btn waves-effect waves-light btn-default m-t-20">Back</a>
                    <button type="button" onclick="$('#account_voucher_csrf').val($('#cook').val()); save_voucher('reload');" class="btn waves-effect waves-light btn-pink m-t-20">Save</button>
                </div>
            </div>
        </div>
        
        
        
    </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        toastr.options = {
            "closeButton": true,
            "debug": true,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-bottom-center",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        $(".numeric").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
        
        
        $('#account_voucher_date').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
        
        $("#account_head").select2();
        
    });


    function voucher_type_change(){
        
        //if($("#account_voucher_type option:selected").text()==="Payment Voucher" || $("#account_voucher_type option:selected").text()==="Receive Voucher"){
            $("#div_rec_pay").show();
        //} else {
       //     $("#div_rec_pay").hide();
        //}
    }

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

    function partnertypechange(){
        
        partnertypeid = $("#business_partner_type option:selected").val();
        console.log(partnertypeid);
        if(partnertypeid=='1'){
            enable_customers();
        } else if (partnertypeid=='2'){
            enable_suppliers();
        } else if (partnertypeid=='3'){            
            enable_staff();
        }
        
    }
    
    
    function enable_customers(){
       $("#business_partner").select2({
            ajax: {
              url: '<?php echo base_url();?>customer_controller/searchnameforco',
              dataType: 'json',
              delay: 250,
              data: function (term, page) {
                  
                return {
                    customername: term, // search term
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
            minimumInputLength: 3,
            formatResult: function (option) {
               return option.customer_name+" | "+option.customer_cell ;
            },
            formatSelection: function (option) {
                
                return option.customer_name+" | "+option.customer_cell;
            }
          });
         
    }
    
    function enable_suppliers(){
       $("#business_partner").select2({
            ajax: {
              url: '<?php echo base_url();?>supplier_controller/searchnameforsupplier',
              dataType: 'json',
              delay: 250,
              data: function (term, page) {
                  
                return {
                    suppliername: term, // search term
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
               return option.supplier_name+" | "+option.contact_person ;
            },
            formatSelection: function (option) {
                
                return option.supplier_name+" | "+option.contact_person;
            }
          });
         
    }
    
    
    
    function enable_staff(){
       $("#business_partner").select2({
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
    
    
    function addrow(){
        if($("#amount").val()==""){return false;}
        var mhtml='';
        var accountdata = $("#account_head").select2('data');
        var rowcount=0;
        var debittotal=0;
        var credittotal=0;
        var cancel=false;
        $('#voucher_details tbody>tr').each(function(index) {
            //check already added qty for this product id
            if (parseInt($(this).find('td.id').html()) == accountdata.id) {
                cancel=true;
                 swal({
                    title: "Account Head already in Voucher!",
                    text: 'Please verify your entries.',
                    type: "info",
                    confirmButtonText: 'OK!'
                });
                return false;
                
            }   
            if($(this).find('td.debit').html()!==""){
                debittotal = debittotal + parseFloat($(this).find('td.debit').html());
                rowcount++;
            }
            
            if($(this).find('td.credit').html()!==""){
                credittotal = credittotal + parseFloat($(this).find('td.credit').html());    
                rowcount++;
            }
            
            
        });
        
        if(cancel==false){
            mhtml += '<tr>';
            mhtml += '<td row="'+rowcount+'" class="id" style="display:none;">' + accountdata.id + '</td>';
            mhtml += "<td  ><input type='hidden' id='account_head' name='account_head' value='"+ accountdata.id +"'>" + accountdata.text + "</td>";

             mhtml += '<td>'+ $("#payment_mode option:selected").val() +'</td>';
             mhtml += '<td>'+$("#instrument_number").val()+'</td>';
             mhtml += '<td cost_center_type="'+ $("#cost_center_type option:selected").val() +'">'+$("#cost_center").val()+'</td>';

            mhtml += '<td>'+$("#remarks").val()+'</td>';
            if($("#transaction_type option:selected").val()=="Debit"){
                mhtml += '<td class="debit">'+$("#amount").val()+'</td>';
                debittotal=debittotal+parseFloat($("#amount").val());
            } else{
                mhtml += '<td class="debit"></td>';
            }
            if($("#transaction_type option:selected").val()=="Credit"){
                mhtml += '<td class="credit">'+$("#amount").val()+'</td>';
                credittotal=credittotal+parseFloat($("#amount").val());
            } else{
                mhtml += '<td class="credit"></td>';
            }
            mhtml += '<td><span class="label label-danger" onclick="removebyrow(\'' + rowcount + '\');" style="cursor:pointer">x</span></td>';
            mhtml += '</tr>';
            $("#voucher_details tbody").append(mhtml);

            $("#voucher_details tfoot").html('');
            var addclass="text-danger";

            if(debittotal===credittotal){addclass='text-success';}

            mhtml ='<tr>';
            mhtml +='<th colspan="5"></th>';
            mhtml +='<th class="debittotal '+addclass+'">'+debittotal+'</th>';
            mhtml +='<th class="credittotal '+addclass+'">'+credittotal+'</th>';
            mhtml +='<th></th>';
            mhtml += '</tr>';
            $("#voucher_details tfoot").append(mhtml);
        }
    }
    
    function removebyrow(val) {
        
        var debittotal=0;
        var credittotal=0;
        $('#voucher_details').find("td.id").each(function(index) {
           
            if ($(this).attr("row") === val) {
                $(this).closest('tr').remove();
            }
        });
        
        $('#voucher_details tbody>tr').each(function(index) {
             if($(this).find('td.debit').html()!==""){
                debittotal = debittotal + parseFloat($(this).find('td.debit').html());
                
            }
            
            if($(this).find('td.credit').html()!==""){
                credittotal = credittotal + parseFloat($(this).find('td.credit').html());    
                
            }
         });
          $("#voucher_details tfoot").html('');
            var addclass="text-danger";

            if(debittotal===credittotal){addclass='text-success';}

            mhtml ='<tr>';
            mhtml +='<th colspan="5"></th>';
            mhtml +='<th class="debittotal '+addclass+'">'+debittotal+'</th>';
            mhtml +='<th class="credittotal '+addclass+'">'+credittotal+'</th>';
            mhtml +='<th></th>';
            mhtml += '</tr>';
            $("#voucher_details tfoot").append(mhtml);
    }
    
    function save_voucher(val=""){
        
        var gen_voucher=false;
        if($("#account_voucher_date").val()===""){
            swal({
                title: 'Date not selected',
                text: "Select the date of the transaction for the voucher to be generated!",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#ff5b5b !important',
                confirmButtonText: 'Ok'
            });
            $("#account_voucher_date").focus();
            return false;
        } else {
            gen_voucher=true;
        }
        //console.log($('#account_voucher_type option:selected').text());
        if($('#account_voucher_type option:selected').text()!=="Journal Voucher" && $(".debittotal").html()!==$(".credittotal").html()){
            
             swal({
                title: 'Not Balanced . . .',
                text: "The debit side should equal the credit side for a double entry system!",
                type: 'info',
                showCancelButton: false,
                confirmButtonColor: '#ff5b5b !important',
                confirmButtonText: 'Ok'
            });
            return false;
            
        } else {
           gen_voucher=true;
        }
        if(gen_voucher===true){
            generate_voucher(val);
        }
    }
    function generate_voucher(val=""){
            var business_partner = $("#business_partner").select2('data');
            var business_partner_id='';
            
            if($("#business_partner_type").val()==1){
                business_partner_id = business_partner.id_customers;
            } else if ($("#business_partner_type").val()==2){
                business_partner_id = business_partner.id_business_supplier;
            } else if ($("#business_partner_type").val()==3){
                business_partner_id = business_partner.id_staff;
            }
            
            var TableData;
            TableData = voucher_storeOTblValues();
            TableData = $.toJSON(TableData);
            if (TableData.length > 2) {
                $.ajax({
                    type: "POST",
                    //url: "order_controller/updateorder",
                    url: "<?php echo base_url();?>accounting_controller/create_account_voucher",
                    data: {
                        voucherdetails:TableData,
                        voucherdata:$("#voucher-form").serialize(),
                        business_partner_id:business_partner_id
                    },
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            if(val==''){
                                toastr.success('Voucher posted!', 'Done!');                               
                            } else if (val=== 'reload'){
                                toastr.success('Voucher Posted!', 'Done!');
                                window.location.assign("<?php echo base_url();?>account_vouchers");
                            } 
                        } else {
                            swal({
                                title: "Error",
                                text: result[1],
                                type: "error",
                                confirmButtonText: 'OK!'
                            });
                        }
                    }
                });
            }
       
    }
    
    function voucher_storeOTblValues(){
        var TableData = new Array();
        $('#voucher_details tr').each(function(row, tr) {
            TableData[row] = {
                "account_head": $(tr).find('td:eq(0)').text()
                , "payment_mode": $(tr).find('td:eq(2)').text()
                , "instrument_number": $(tr).find('td:eq(3)').text()
                , "cost_center": $(tr).find('td:eq(4)').text()
                , "cost_center_type": $(tr).find('td:eq(4)').attr("cost_center_type")
                , "remarks": $(tr).find('td:eq(5)').text()
                , "debit": $(tr).find('td:eq(6)').text()
                , "credit": $(tr).find('td:eq(7)').text()
               
            }
        });
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }
    
</script>