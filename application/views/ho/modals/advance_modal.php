<div id="advancemodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="advancemodal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-md"  >
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="custom-width-modalLabel">Add Advance Payment</h4>
                <input style="border:none;" name="visitid" id="visitid" type="text" readonly="readonly" value=""/>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-md-12" id="advance_table">
                        <div>
                            <table id="adv_table" class="table table-stripped">
                                <tbody>
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class="col-md-6 " id="advance_block">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-4">
                                    Advance Amount:
                                </div>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rs. </span>
                                        <input class="form-control numeric" onchange="advanceamountchanged();" name="advance_amount" id="advance_amount" style="text-align: right;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="advance_inst_div" style="display:none;" >
                            <div class="row">    
                                <div class="form-group">
                                    <div class="col-md-4">
                                        Inst. #:
                                    </div>
                                    <div class="col-md-8">
                                        <input class="form-control numeric" name="advance_inst" id="advance_inst" style="text-align: right; " />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="advance_card_div" style="display:none;" >
                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-4">
                                        CC Fee %:
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly="readonly" class="form-control numeric" name="cc_charge_setting" id="cc_charge_setting" style="text-align: right; " />
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="form-group">
                                    <div class="col-md-4">
                                        Extra :
                                    </div>
                                    <div class="col-md-8">
                                        <input readonly="readonly" class="form-control numeric" name="advance_cccharge" id="advance_cccharge" style="text-align: right; " value="0" />
                                    </div>
                                </div>    
                            
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" onchange="showhideinst();" id="advance_mode" name = "advance_mode">
                                <option value="cash">Cash</option>
                                <option value="card">Credit Card</option>
                                <option value="card">Debit Card</option>
                                <option value="check">Bank</option>
                            </select>
                        </div>
                        
                    
                    </div>
                    <div class='col-md-6'>
                        <div>
                            Enter Advance Comment:
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="advance_comment" id="advance_comment" ></textarea>
                        </div>
                    </div>
                </div>
                    
                    
            </div>
        
            <div class='modal-footer'>
                <button type="button" onclick="printadvance();"  class="btn btn-default waves-effect waves-light pull-right m-l-5"><i class="fa fa-print"></i></button>
                <button type="button" onclick="saveadvance();"  class="btn btn-custom waves-effect waves-light pull-right">Save</button>

            </div>
        </div>
    </div>
</div>



<script>
    function printadvance() {
        //if($("#advance_amount").val()!=='' && parseInt($("#advance_amount").val())>0){
        // console.log($('#adv_table').find('tbody').children().length);
        if ($("#adv_table tbody tr").length > 0 || $("#advance_amount").val() !== '') {
            window.open('<?php echo base_url(); ?>invoice_controller/print_advance/' + $('#visitid').val());
        }
    }

    function showhideinst() {
        console.log($("#advance_mode option:selected").val());
        if ($("#advance_mode option:selected").val() === "card") {
            $("#advance_inst_div").show();
            
            if(parseFloat($("#cc_charge_setting").val())>0){
                $("#advance_card_div").show();
                if($("#advance_amount").val() !==""){
                    $("#advance_cccharge").val((parseInt($("#advance_amount").val()) * parseInt($("#cc_charge_setting").val())) / 100 );
                }
            }
        } else if ($("#advance_mode option:selected").val() === "check") {
            $("#advance_inst_div").show();
            $("#advance_card_div").hide();
        } else {
            $("#advance_inst_div").hide();
            $("#advance_card_div").hide();
        }
        
    }


    function advanceamountchanged(){
        if($("#advance_amount").val()!=='' && parseFloat($("#cc_charge_setting").val())>0){
                $("#advance_cccharge").val((parseInt($("#advance_amount").val()) * parseInt($("#cc_charge_setting").val())) / 100 );
                
            }
    }
    
    function takeadvance() {
        var advancedate = '';
        var newtoday = new Date();
        var todaya = newtoday.getFullYear() + "-" + (newtoday.getMonth() + 1) + "-" + newtoday.getDate();
        var today = todaya;
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'visits_controller/check_visit'; ?>",
            data: {visit_id: $('#visitid').val()},
            dataType: "json",
            cache: false,
            async: true,
            success: function (data) {
                if (data.length > 0 && parseInt(data[0]['advance_amount']) > 0) {
                    //console.log(data[0]['advance_date']);
                    var newadvancedate = new Date(data[0]['check_date']);
                    var advancedatea = newadvancedate.getFullYear() + "-" + (newadvancedate.getMonth() + 1) + "-" + newadvancedate.getDate();
                    console.log("raw " + data[0]['check_date'] + " advance " + advancedatea + " today " + today);
                    advancedate = advancedatea;
                } else {
                    advancedate = today;
                }

                if (advancedate == today) {
                    saveadvance();
                } else {
                    swal({
                        title: 'You cannot change the Advance Amount taken on a previous date!',
                        text: 'This action is not allowed now!',
                        type: 'error',
                        confirmButtonText: 'OK!'
                    });
                }
            }
        });


    }

    function saveadvance() {

        if ($("#advance_amount").val() === '' || $("#advance_inst_div").is(":visible") && $("#advance_inst").val() == "") {
            if ($("#advance_amount").val() === '') {
                swal({
                    title: 'Please Enter Advance Amount!',
                    text: '',
                    type: 'error',
                    confirmButtonText: 'OK!'
                });
                $("#advance_amount").focus();
            } else if ($("#advance_inst_div").is(":visible") && $("#advance_inst").val() == "") {
                swal({
                    title: 'Please Enter Instrument Number!',
                    text: '',
                    type: 'error',
                    confirmButtonText: 'OK!'
                });
                $("#advance_inst").focus();
            }
            return false;
        } else {

            $.ajax({
                type: 'POST',
                //url: 'Scheduler_controller/active_staff_list',
                url: "<?php echo base_url() . 'visits_controller/add_visit_advance'; ?>",
                data: {visit_id: $('#visitid').val(),
                    advance_amount: $("#advance_amount").val(),
                    advance_mode: $("#advance_mode option:selected").val(),
                    advance_inst: $("#advance_inst").val(),
                    advance_cc_charge: $("#advance_cccharge").val(),
                    advance_comment: $("#advance_comment").val()
                },
                dataType: "json",
                cache: false,
                async: true,
                success: function (data) {
                    toastr.success('Advance of Rs' + $("#advance_amount").val() + ' Updated in Visit ' + $('#visitid').val(), 'Done!');
                    printadvance();
                    advancemodalclose();
                }
            });
        }

    }

</script>