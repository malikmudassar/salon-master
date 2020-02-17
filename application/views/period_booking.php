<style>
    .datepicker{position:absolute !important; top:250px !important;}
    
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Period Booking: </h4><select style="display:none" id="staffcombo"></select>
            </div>
        </div>

        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <!-- Search Box -->
                    <div class="row" id="divsearch">
                        <div class="col-lg-12">
                            <div id="searchpanel" class="card-box">
                                <h4 class="header-title m-t-0 m-b-30">Search Customer:</h4>
                                <div class="row">
                                    <?php if (isset($scheduler_style) && $scheduler_style[0]['scheduler_input_search'] === "Y") { ?>
                                        <div class="col-lg-5 m-b-30">
                                            <!--Cell Phone Search Form-->
                                            <div id="cellsearchform">
                                                <div class="input-group">
                                                    <input type="text" id="cell-search" name="cell-search" class="form-control numeric" placeholder="Cell Phone Search" onchange="newcustomerbtn_show_hide(this.value);">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn waves-effect waves-light btn-custom" id="btncell-search"><i class="fa fa-phone"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--End Name Search -->
                                        </div>

                                        <div class="col-lg-5 m-b-30">
                                            <!--Name Search Form-->
                                            <div id="namesearchform">
                                                <div class="input-group">
                                                    <input type="text" id="name-search" name="name-search" class="form-control" placeholder="Name Search" onchange="newcustomerbtn_show_hide(this.value);">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn waves-effect waves-light btn-pink" id="btnname-search"><i class="fa fa-tag"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--End Name Search -->
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-lg-5 m-b-30">
                                            <!--Name Search Form-->
                                            <div id="namesearchform">
                                                <div class="input-group">
                                                    <input type="text" id="name-search" name="name-search" class="form-control" placeholder="Name Search" onchange="newcustomerbtn_show_hide(this.value);">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn waves-effect waves-light btn-pink" id="btnname-search"><i class="fa fa-tag"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--End Name Search -->
                                        </div>
                                        <div class="col-lg-5 m-b-30">
                                            <!--Cell Phone Search Form-->
                                            <div id="cellsearchform">
                                                <div class="input-group">
                                                    <input type="text" id="cell-search" name="cell-search" class="form-control numeric" placeholder="Cell Phone Search" onchange="newcustomerbtn_show_hide(this.value);">
                                                    <span class="input-group-btn">
                                                        <button type="submit" class="btn waves-effect waves-light btn-custom" id="btncell-search"><i class="fa fa-phone"></i></button>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--End Name Search -->
                                        </div>
                                    <?php } ?>
                                    <div class="col-lg-2 m-b-30">
                                        <span class="input-group-btn">
                                            <button onclick="clearall();" class="btn waves-effect waves-light btn-default">Clear</button>

                                        </span>
                                    </div>

                                    <div class="col-lg-12">
                                        <div align="center" id="newcustomeradding">
                                            <button type="submit" class="btn waves-effect waves-light btn-custom newcustomeradding"><i class="fa fa-plus"></i> Add Customer</button>
                                        </div>
                                    </div>
                                </div>     
                            </div> 
                        </div>
                    </div>
                    <!-- End Search Box -->
                    
                    <!-- Customer List -->
                <div id="multiplesearch" class="row" style="display:none;">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button class="btn btn-inverse btn-xs w-md m-b-5" onclick="back('#multiplesearch', '#divsearch'); removeNiceScroll(); $('#cell-search').val(''); $('#name-search').val(''); $('#balanceid').html('');"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Searched Customers:</h4>
                            <div class="row">
                                <div id="customer_list" class="inbox-widget nicescroll_1" style="height: 250px; overflow: hidden; outline: none;" tabindex="5000">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Customer List -->
                    
                  <!-- Add/View Customer -->
                <div class="row" id="divmain" style="">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="pull-right">
                                <button onclick="back('#divmain', '#divsearch'); $('#txt-customer-id').val(''); $('#cell-search').val(''); $('#name-search').val(''); $('#balanceid').html('');" class="btn btn-inverse btn-xs w-md m-b-5"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                            </div>
                            <h4 class="header-title m-t-0 m-b-30">Customer Details:</h4>
                            <div id="customer_alert" class="row" style="display: none">
                                <div id="alert_text" class="alert alert-danger">
                                    <strong>Customer Alert!</strong>
                                </div>
                            </div>
                            <form role="form" id="customerform">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Reference #</label>
                                            <input readonly="readonly" type="text" id="txt-customer-id" name="txt-customer-id" class="form-control" placeholder="Reference #">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Name<span id="customer-color"></span></label>
                                            <input readonly="readonly" type="text" id="txt-customer-name" name="txt-customer-name" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Email</label>
                                            <input readonly="readonly" type="email"  id="txt-customer-email" name="txt-customer-email" class="form-control" parsley-type="email" parsley-trigger="change" required placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Cell</label>
                                            <input readonly="readonly" type="text" id="txt-customer-cell" name="txt-customer-cell" class="form-control numeric" placeholder="Cell Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Address</label>
                                            <input readonly="readonly" type="text" id="txt-customer-address" name="txt-customer-address"  class="form-control" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label class="control-label">Birthday</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select disabled="disabled" id="txt-customer-bday" name="txt-customer-bday" class="form-control">
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <select disabled="disabled" id="txt-customer-bmonth" name="txt-customer-bmonth" class="form-control">
                                                        <option value=""></option>
                                                        <option value="January">January</option>
                                                        <option value="February">February</option>
                                                        <option value="March">March</option>
                                                        <option value="April">April</option>
                                                        <option value="May">May</option>
                                                        <option value="June">June</option>
                                                        <option value="July">July</option>
                                                        <option value="August">August</option>
                                                        <option value="September">September</option>
                                                        <option value="October">October</option>
                                                        <option value="November">November</option>
                                                        <option value="December">December</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group has-feedback">
                                            <label class="control-label">Profession</label>
                                            <input readonly="readonly" type="text" id="txt-customer-profession" name="txt-customer-profession"  class="form-control" placeholder="Profession">
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="div_careof" style="display:none">
                                        <div class="form-group">
                                            <label class="control-label">Care Of:</label>
                                            <input onchange="oncareofchange();"  type="hidden" id="txt-customer-co" name="txt-customer-co"  class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="div_careof_display" style="display:block">
                                        <div class="form-group">
                                            <label class="control-label">Care Of:</label>
                                            <input  type="text" id="txt-customer-display" name="txt-customer-display"  class="form-control" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="txt-customer-gender" class="control-label">Gender</label>
                                            <select tabindex="2" type="text" class="form-control numeric" placeholder="Gender" id="txt-customer-gender" name="txt-customer-gender">
                                                <option value="F">Female</option>
                                                <option value="M">Male</option>
                                                
                                            </select>
                                        </div> 
                                    </div>
                                </div>
                                <div style="display:none" class="col-lg-4 hidden-md hidden-sm hidden-xs">
                                    <div id = "imgdisplay" style="display:block; text-align: center;">
                                        <img src="<?php echo base_url(); ?>assets/images/users/avatar-1.jpg" id="img-customer" name="img-customer" alt="customer" style="width:100%"/>
                                        <input id="img-customer-file" type="hidden" value="avatar-1.jpg"/>
                                        <br/>
                                        <button onclick="changepic();"  type="button" class="btn btn-sm btn waves-effect w-md waves-success m-b-5">Change</button>
                                    </div>
                                    <div id = "imguploader" style="display:none;">
                                        <input id="img-uploader-customer" name="img-uploader-customer" data-height="300" type="file" class="dropify"  />
                                    </div>
                                </div>
                            </form>
                            <div class="row" style="margin-top: 20px;">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        
                                        <a href="javascript:void(0);" onclick="previousdirect();" class="btn btn-primary btn waves-effect w-md waves-success m-b-5 visit-message">Account</a>
                                        <button id="btnupdate" onclick="addeditcustomer();" type="button" class="btn btn-purple btn waves-effect waves-primary w-md m-b-5">Add New</button>
                                        <button id="schedulerFunctionBtn" type="button" onclick="packagebookingform();" class="btn btn-warning btn waves-effect w-md waves-success m-b-5">Select Package</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Add/View Customer -->
                
                <!----PACKAGE BOOKING FORM-->
                 <div class="row" id="divbooking" style="">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="packageselect">Select Package:</lable>
                                        <select id="packageselect" class="form-control">
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
               
                <!----END PACKAGE BOOKING FORM-->
                
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <div id="bookingform">
                        
                    </div>
                    <div id="divadvance" style="display:none">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="col-md-12 ">
                                    <label for="txtvisitremarks">Visit Remarks:</label>
                                    <textarea row="5" class="form-control" id="txtvisitremarks" name="txtvisitremarks"></textarea>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-addon">Advance Rs.</span>
                                        <input class="form-control numeric" name="advance_amount" id="advance_amount" style="text-align: right;" value="0" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" onchange="showhideinst();" id="advance_mode" name = "advance_mode">
                                            <option value="cash">Cash</option>
                                            <option value="card">Credit Card</option>
                                            <option value="check">Bank</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none" id="advance_inst_div">
                                    <div class="input-group" >
                                        <span class="input-group-addon">Instrument#</span>
                                        <input class="form-control numeric" name="advance_inst" id="advance_inst" style="text-align: right; " value="0" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="btncreatevisits" onclick="check_advance();"  class="btn btn-custom waves-effect waves-light">Generate Visits</button>
                                </div>
                            </div>
                                
                        </div>
                            
                    </div>

                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->



        <script>
            
             function back(selector1, selector2){
                $(selector1).hide();
                $(selector2).fadeIn();
            }
    
            function next(selector1, selector2){
                $(selector2).hide();
                $(selector1).fadeIn();
            }
    
            function hideOpenDivs(){

                if($('#txt-customer-id').val() === ""){

                    $("#divmain").hide();
                    $("#divsearch").fadeIn();
                    $('#multiplesearch').hide();
                    $('#blocktime').hide();
                    $('#newcustomeradding').hide();
                    $('#con-close-modal').hide();
                    $('#divbooking').hide();
                    //$('#gift-voucher').hide();

                } else{

                    $("#divmain").fadeIn();
                    $("#divsearch").hide();
                    $('#newcustomeradding').hide();
                    $('#blocktime').hide();
                    $("#divvisit").hide();
                    $('#con-close-modal').hide();
                    $('#divbooking').hide();

                }

            }
            $(document).ready(function () {
                 
                hideOpenDivs();
                getpackagetypes();
                staff=new Array();
                 getstaff();
                fillBday();
                
                $("#packageselect").on("change", function(){
                    getpackagecategory();
                });
                
                 $("#searchpanel input").keypress(function(e) {
                    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
                        var mvar = "#btn" + $(this).attr('id');

                        $(mvar).trigger('click');

                        return false;
                    } else {
                        return true;
                    }
                });

                $("#btnname-search").on('click', function() {
                     general_search("#btncard-search"); return false;
                    var mid = $("#name-search").val();
                    $(this).html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#name-search').prop('readonly', true);
                    $('#cell-search').prop('readonly', true);
                    $.ajax({
                        type: 'POST',
                        //url: 'customer_controller/searchname',
                        url: "<?php echo base_url() . 'customer_controller/searchname'; ?>",
                        data: {customername: mid},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            fillcustomerform(data);
                            $('#btnname-search').html('<i class="fa fa-tag"></i>');
                            $('#name-search').prop('readonly', false);
                            $('#cell-search').prop('readonly', false);
                        }
                    });
                });

                $("#btncell-search").on('click', function() {
                    general_search("#btncard-search"); return false;
                    var mid = $("#cell-search").val();
                    $(this).html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#name-search').prop('readonly', true);
                    $('#cell-search').prop('readonly', true);
                    $.ajax({
                        type: 'POST',
                        //url: 'customer_controller/searchcell',
                        url: "<?php echo base_url() . 'customer_controller/searchcell'; ?>",
                        data: {customercell: mid},
                        dataType: "json",
                        cache: false,
                        async: true,
                        success: function(data) {
                            fillcustomerform(data);
                            $('#btncell-search').html('<i class="fa fa-tag"></i>');
                            $('#name-search').prop('readonly', false);
                            $('#cell-search').prop('readonly', false);
                        }
                    });
                });

                $('.newcustomeradding').on('click', function() {
                    $('#txt-customer-name').prop('readonly', false);
                    $('#txt-customer-email').prop('readonly', false);
                    $('#txt-customer-cell').prop('readonly', false);
                    $('#txt-customer-address').prop('readonly', false);
                    $('#txt-customer-bday').prop('disabled', false);
                    $('#txt-customer-bmonth').prop('disabled', false);
                    $('#txt-customer-profession').prop('readonly', false);
                    $('#txt-customer-gender').prop('disabled', false);
                    enable_careof();
                    $('#div_careof').show();
                    $('#div_careof_display').hide();
            
                    $('#txt-customer-name').val(ucwords($('#name-search').val()));
                    $('#txt-customer-cell').val($('#cell-search').val());
                    $('.visit-message').hide();
                    $('#schedulerFunctionBtn').hide();
                    $('#newcustomeradding').hide();
                    back("#divsearch", "#divmain");
                });

                $(".numeric").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });

            });

            function general_search(from){
     
                    var name = $("#name-search").val();
                    var cell = $("#cell-search").val();
                    var card = $("#card-search").val();
                    ////console.log(cell);
                    $(from).html('<i class="fa fa-spin fa-spinner"></i>');
                    $('#name-search').prop('readonly', true);
                    $('#cell-search').prop('readonly', true);
                    $('#card-search').prop('readonly', true);
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url() . 'customer_controller/generalsearch'; ?>",
                            data: {customername: name, customercell: cell, customercard: ''},
                            dataType: "json",
                            cache: false,
                            async: true,
                            success: function(data) {

                                fillcustomerform(data,'search');
                                $('#btnname-search').html('<i class="fa fa-tag"></i>');
                                $('#btncell-search').html('<i class="fa fa-phone"></i>');
                                $('#btncard-search').html('<i class="fa fa-credit-card"></i>');
                                $('#name-search').prop('readonly', false);
                                $('#cell-search').prop('readonly', false);
                                $('#card-search').prop('readonly', false);
                            }
                        });

                }

            function newcustomerbtn_show_hide(a) {
                if (a === "") {
                    $('#newcustomeradding').css('display', 'none');
                }
            }
            function clearall() {

                clearcustomerform();

                $('#name-search').val('');
                $('#cell-search').val('');
                $('#newcustomeradding').hide();

                $('#multiplesearch').hide();

            }
            
            function fillcustomerform(data) {

                $(".nicescroll_1").getNiceScroll().remove();
                $(".nicescroll_2").getNiceScroll().remove();
                $(".nicescroll_3").getNiceScroll().remove();
                $(".nicescroll_service_types").getNiceScroll().remove();
                $(".nicescroll_products").getNiceScroll().remove();
                $(".nicescrollproducts").getNiceScroll().remove();

                $('.visit-message').show();
                $('#schedulerFunctionBtn').show();

                clearcustomerform();
                var mhtml = '';

                if (data.length > 1) {

                    $(".nicescroll_1").niceScroll({cursoropacitymin: 1});

                    for (x = 0; x < data.length; x++) {
                        mhtml += '<a href="javascript:void(0)" onclick="getbyid(' + data[x]['id_customers'] + ');">';
                        mhtml += '<div class="inbox-item">';
                        mhtml += '<div class="inbox-item-img"><img src="<?php echo base_url(); ?>assets/images/users/' + data[x]['customer_image'] + '" class="img-circle" alt=""></div>';
                        mhtml += '<p class="inbox-item-author">' + data[x]['customer_name'] + '</p>';
                        mhtml += '<p class="inbox-item-text">' + data[x]['customer_cell'] + '</p>';
                        mhtml += '<p class="inbox-item-date">' + data[x]['customer_email'] + '</p>';
                        mhtml += '</div>';
                        mhtml += '</a>';
                    }
                    $("#customer_list").html(mhtml);
                    back("#divsearch", "#multiplesearch");
                } else if (data.length === 1) {

                    if (data[0]['customer_type'] === "") {
                        $('#customer-color').css({
                            'width': '0px',
                            'height': '0px',
                            'margin-left': '0px',
                            'background': 'transparent'
                        });
                    } else {
                        $('#customer-color').css({
                            'width': '5px',
                            'height': '5px',
                            'margin-left': '5px',
                            'display': 'inline-block',
                            'background': data[0]['customer_type'] === 'green' ? '#31e031' : data[0]['customer_type']
                        });
                    }

                    $('#txt-customer-name').prop('readonly', true);
                    $('#txt-customer-email').prop('readonly', true);
                    $('#txt-customer-cell').prop('readonly', true);
                    $('#txt-customer-address').prop('readonly', true);
                    $('#txt-customer-bday').prop('disabled', true);
                    $('#txt-customer-bmonth').prop('disabled', true);
                    $('#txt-customer-gender').prop('disabled', true);
                    
                    $('#txt-customer-profession').prop('readonly', true);
                    $('#txt-customer-profession').val(data[0]['profession']);

                    $("#txt-customer-id").val(data[0]['id_customers']);
                    $("#txt-customer-name").val(data[0]['customer_name']);
                    $("#txt-customer-cell").val(data[0]['customer_cell']);
                    $("#txt-customer-email").val(data[0]['customer_email']);
                    $("#txt-customer-address").val(data[0]['customer_address']);
                    $("#txt-customer-bday").val(data[0]['customer_birthday']);
                    $("#txt-customer-gender").val(data[0]['customer_gender']);
                    $("#txt-customer-profession").val(data[0]['customer_profession']);
                    //$('#txt-customer-bmonth option[value="' + data[0]['customer_birthmonth'] + '"]').attr("selected", "selected");
                    $('#txt-customer-bmonth').val(data[0]['customer_birthmonth']);
                    $("#img-customer").attr('src', '<?php echo base_url(); ?>assets/images/users/' + data[0]['customer_image']);
                    $("#btnupdate").hide();
                    $("#img-customer-file").val(data[0]['customer_image']);
                    $("#imguploader").hide();
                    $("#imgdisplay").show();

                    $('#multiplesearch').hide();

                    back("#divsearch", "#divmain");

                    localStorage.setItem("customer_id", data[0]['id_customers']);
                    localStorage.setItem("customer_name", data[0]['customer_name']);
                    localStorage.setItem("customer_cell", data[0]['customer_cell']);
                    localStorage.setItem("customer_email", data[0]['customer_email']);
                    
                    fillupdateform(data);
                } else {
                    $('#newcustomeradding').fadeIn();
                    clearcustomerform();
                }
            }
            
            function clearcustomerform() {

        if ($("#txt-customer-email").length > 0) {
            mfield = $("#txt-customer-email").parsley();
            window.ParsleyUI.removeError(mfield, 'required');
            window.ParsleyUI.removeError(mfield, 'email');
            $("#txt-customer-email").removeClass('parsley-error');
        }
        if ($("#detail-customer-email").length > 0) {
            mfield = $("#detail-customer-email").parsley();
            window.ParsleyUI.removeError(mfield, 'required');
            window.ParsleyUI.removeError(mfield, 'email');
            $("#detail-customer-email").removeClass('parsley-error');
        }

        //localStorage.setItem("customer_id", "");
        localStorage.setItem("customer_name", "");
        localStorage.setItem("customer_cell", "");
        localStorage.setItem("customer_email", "");

        //$('#name-search').val('');
        $("#txt-customer-id").val('');
        $("#txt-customer-name").val('');
        $("#txt-customer-cell").val('');
        $("#txt-customer-email").val('');
        $("#txt-customer-address").val('');
        $("#txt-customer-profession").val('');
        
        $('#txt-customer-bday option:eq(0)').prop('selected', true);
        $('#txt-customer-bmonth option:eq(0)').prop('selected', true);
        $("#img-customer").attr('src', '<?php echo base_url(); ?>assets/images/users/avatar-1.jpg');
        $("#btnupdate").html("Add New");
        $("#btnupdate").show();
        $("#imguploader").hide();
        $("#imgdisplay").show();
        $("#customer_alert").hide();
    }
    
    function getbyid(customerid) {
        $.ajax({
            type: 'POST',
            //url: 'customer_controller/searchid',
            url: "<?php echo base_url() . 'customer_controller/searchid'; ?>",
            data: {id: customerid},
            dataType: "json",
            cache: false,
            async: true,
            success: function(data) {
                fillcustomerform(data);
                //$("#multiplesearch").slideUp();
            }
        });
        
    }
    
    function fillupdateform(data) {
        if (data[0]['customer_allergies'] != "" || data[0]['customer_alert'] != "") {
            $("#alert_text").html('<strong>Customer Alert! Allergic to :</strong> ' + data[0]['customer_allergies'] + ' | <strong>Other Alerts : </strong>' + data[0]['customer_alert']);
            $("#customer_alert").show();
        }
        var d2 = "";
        var d1 = "";
        if (data[0]['customer_anniversary'] !== "" && data[0]['customer_anniversary'] !== null) {
            var d2 = new Date(Date.parse(data[0]['customer_anniversary']));
            m = d2.getMonth() + 1;
            d1 = d2.getFullYear() + "/" + m + "/" + d2.getDate();
        }

        $("#detail-customer-id").val(data[0]['id_customers']);
        $("#detail-customer-name").val(data[0]['customer_name']);
        $("#detail-customer-cell").val(data[0]['customer_cell']);
        $("#detail-customer-email").val(data[0]['customer_email']);
        $("#detail-customer-address").val(data[0]['customer_address']);
        $("#detail-customer-bday").val(data[0]['customer_birthday']);
        $('#detail-customer-bmonth').val(data[0]['customer_birthmonth']);
        if (d1 !== "") {
            $('#detail-customer-wedding').val(d1);
        }
        $('#detail-customer-phone1').val(data[0]['customer_phone1']);
        $('#detail-customer-phone2').val(data[0]['customer_phone2']);
        $('#detail-customer-allergies').val(data[0]['customer_allergies']);
        $('#detail-customer-alert').val(data[0]['customer_alert']);
        $('#detail-customer-profession').val(data[0]['profession']);

    }
    
    function addeditcustomer() {
        if ($("#btnupdate").text() === "Add New") {

            var customer_name = $("#txt-customer-name").val().trim();
            customer_name = customer_name.split(" ");

            if (customer_name.length > 1) {

                if ($("#txt-customer-name").val() === "" || $("#txt-customer-cell").val() === "") {
                    swal({
                        title: "Add Name and Cell Phone",
                        text: "You forgot to enter the NAME, CELL PHONE of the new customer. Let's start with putting in this mandatory information first.",
                        type: "warning",
                        confirmButtonText: 'OK!'
                    });
                } else {
                    addnewcustomer();
                }

            } else {

                swal({
                    title: "Please enter Customer's last name also!",
                    text: "",
                    type: "error",
                    confirmButtonText: 'OK!'
                });

            }
        } else if ($("#btnupdate").text() === "Update") {
            
        }
    }
    
      
    function hidemultisearch() {
        $("#multiplesearch").slideUp();
    }

    function showcustomerdetails() {
        back("#divmain", "#con-close-modal");
    }
    
    function CheckCustomer_Exist(){
        
    }
    
    
     function fillBday() {
        for (x = 1; x <= 31; x++) {
            $("#txt-customer-bday").append('<option value=' + x + '>' + x + '</option>');
            $("#detail-customer-bday").append('<option value=' + x + '>' + x + '</option>');

        }
    }

    //This function is using in Add customer visit modal in account button...for customer_id from line number 167 file scheduler_modal.php...
    function get_customer_id_for_account(idcustomer) {
        return $.ajax({
            type: 'POST',
            data:{param:'none'},
            //url: 'customer_controller/get_customer_openvisit/'+idcustomer,
            url: "<?php echo base_url() . 'customer_controller/get_customer_openvisit/'; ?>" + idcustomer,
            async: false,
            success: function(data) {
                console.log(data);
            }
        }).responseText;
    }

    function openAccount() {
        var customer_id = $('#visit-customerid').val();
        window.open('customer_previous_visit/' + customer_id);
    }

    function previousdirect() {
        var customer_id = $('#txt-customer-id').val();
        window.open('customer_previous_visit/' + customer_id);


    }
    

    function addnewcustomer() {
        var customer_name = $("#txt-customer-name").val();
        var customer_cell = $("#txt-customer-cell").val();
        var customer_careof = $("#txt-customer-co").text();
        var flag = false;
        
         if(customer_cell.length !== 11){
             swal({
                        title: "Cell Length",
                        text: 'use 11 digits for cell number',
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                    return false;
        }
        
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>customer_controller/CheckCustomer_Exist',
            data: {customer_name: customer_name, customer_cell: customer_cell},
            async: false,
            success: function(data){
                var exist = data;
                var name = "name "+customer_name.toLowerCase();
                var cell = "cell "+customer_cell;
                if(exist === name){ 
                    swal({
                        title: "Alert",
                        text: "Customer name & Cell number already exists! Add another?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                          sumbit_customer();
                        } else {
                           flag = true;
                        }
                    });
                    
                }else if(exist === cell &&  $("#txt-customer-co").val()==''){ 
                    swal({
                        title: "Alert",
                        text: "Cell number already exists! Add another?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes",
                        cancelButtonText: "No",
                        //closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                          //sumbit_customer();
                          // $("#name-search").val('');
                          
                         // $("#cell-search").val($("#txt-customer-cell").val());
                         // general_search("#btncell-search");
                        } else {
                           flag = true;
                        }
                    });
                   
                } else{
                    sumbit_customer();
                }
               
            }
        });

    }
    function sumbit_customer(){
            $.ajax({
            type: 'POST',
            //url: 'customer_controller/addnew',
            url: "<?php echo base_url() . 'customer_controller/addnew'; ?>",
            data: $("#customerform").serialize(),
            success: function(data) {
                var result = data.split("|");
                if (result[0] === "success") {
                    getbyid(result[1]);
                    // Display a success toast, with a title
                    toastr.success('New Customer Created!', 'Cool!');
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
    
    function packagebookingform(){
        $("#divmain").slideUp();
        $("#divbooking").slideDown();
    
    }
    
    function getpackagetypes() {
        $.ajax({
            type: 'POST',
            data:{param:'none'},
            url: "<?php echo base_url() . 'service_controller/get_package_types'; ?>",
            success: function(response) {
                var data = $.parseJSON(response);
                $("#packageselect").append('<option value="0" >Select</option>');
                for (x = 0; x < data.length; x++) {
                    
                    var id = data[x]['id_package_type'];
                    var name = data[x]['service_type'];
                   
                    $("#packageselect").append('<option value="' + id + '" >'+ name + '</option>');
                }
                
            }
        });
    }
    
    
    function getpackagecategory() {
        $("#bookingform").html('');
        
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'service_controller/get_package_category'; ?>",
            data:{package_type_id: $("#packageselect :selected").val()},    
            success: function(response) {
                var data = $.parseJSON(response);
                records=data.length;
                chtml="<table id='visittable' class='table table-responsive'><thead><th>Category</th><th>Day</th><th>Hour</th><th>Staff</th><thead><tbody>";
                for (x = 0; x < data.length; x++) {
                    chtml+="<tr><td id='"+ x +"_category'>" + data[x]['service_category']  + "</td>";
                    chtml+="<td ><input id='"+ x +"_day' onchange='updateothers("+ x +")' class='form-control day' type='text' placeholder='mm/dd/yyyy'/></td>";
                    chtml+="<td ><input id='"+ x +"_hour' class='form-control' type='text' placeholder='hh:mm'/></td>";
                    chtml+="<td ><select id='"+ x +"_staff' onchange='updateotherstaff("+ x +")' class='form-control staff'><option>Staff</option></select></td>";
                    chtml+="<td style='display:none;'>"+  data[x]['id_package_category'] +"</td></tr>";
                }
                chtml+="</tbody></table>";
                
                $("#bookingform").html(chtml);
                var opentime ='<?php $to = explode(':', $scheduler_style[0]['business_opening_time']); echo $to[0];?>';
                 var closetime ='<?php $tc = explode(':', $scheduler_style[0]['business_closing_time']); echo $tc[0];?>';
                for (x=0; x<records; x++){
                    ///date
                    $("#"+x+"_day").datepicker({autoclose:true,todayHighlight:true});
                    ///time
                    $('#'+x+"_hour").timepicker({
                        showMeridian: false                
                        , maxHours: closetime
                        , minuteStep: 15
                        ,showInputs: true
                    }).on('changeTime.timepicker', function(e) {
                        if(e.time.hours < opentime){
                            $(this).timepicker('setTime', opentime + ":00");
                        }
                    });
                    
                    
//                    $('#'+x+"_hour").timepicker({minuteStep : 15, showInputs: true}).on('changeTime.timepicker', function(e) {   
//                        
//                        var h= e.time.hours;
//                        var m= e.time.minutes;
//                        var mer= e.time.meridian;
//                        //convert hours into minutes
//                        m+=h*60;
//                        //10:15 = 10h*60m + 15m = 615 min
//                        //08:00 = 8h*60m + 0m = 480 min
//                        
//                        if(mer=='AM' && m<480){ $(this).timepicker('setTime', '9:00 AM');}
//                      });
                    ///staff
                    $('#'+x+"_hour").timepicker('setTime', '12:00 PM');
                    $("#staffcombo > option").each(function() {
                        $('#'+x+"_staff").append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
                    });
                }
                $("#divadvance").slideDown();
                
            }
        });
    }
    function updateothers(id){
        if(id===0){
            $("#bookingform > table .day").each(function(index) {
                //$(this).val($("#0_day").val());
                 var firstdate = new Date($("#0_day").val());

                if(index>0){
                    var newDate = new Date(firstdate.setTime(firstdate.getTime() + index * 86400000)); 
                    $(this).datepicker('update', newDate);
                }
            });
        }
    }
    function updateotherstaff(id){
        if(id===0){
            $("#bookingform > table .staff").each(function(index) {
                if(index>0){
                    $(this).val($("#0_staff").val());
                }
            });
        }
    }
    
    function getstaff(){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'staff_controller/get_active_staff'; ?>",
            data:{param:'none'},
            success: function(response) {
                var data = $.parseJSON(response);
                for (x = 0; x < data.length; x++) {
                    $("#staffcombo").append('<option value='+data[x]['id_staff']+'>'+data[x]['staff_fullname']+'</option>');
                }
            }
        });
    }
        
    function check_advance(){
        if($("#advance_amount")==='' ){
           $("#advance_amount").val('0');
        }
        
        var filled=true;
        ///check table values        
        var TableData= new Array();
        TableData = storeOTblValues();
        
        $.each(TableData, function(index, value){
            //console.log(value);
            $.each(value, function(key, value){
                
                if(key=="day" && value=="" || key=="hour" && value=="" || key=="staffid" && value=="Staff"){
                    filled=false;
                }
            });

        });
        if(filled===false){
              swal({
                    title: 'Select Date Time and Staff Name for All Categories',
                    text: '',
                    type: 'error',
                    confirmButtonText: 'OK!'
                });
                return false;
        }
       
        
        if(parseInt($("#advance_amount").val())===0){
            swal({
                title: 'Want to Continue with 0 Advance?',
                text: "Total Amount will be Balanced!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff5b5b !important',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No',
                confirmButtonText: 'Yes'
            }, function(e) {
                if(e===false){
                    return false;
                } else if (e===true){
                   create_new_visits('fales');
                }
            });
        }else {
           create_new_visits('true');
        }
    }
    
    function create_new_visits(adv){
        ///visit parameters
        var package_type_id = $("#packageselect :selected").val();
        var customer_id = $("#txt-customer-id").val();
        var customer_name = $("#txt-customer-name").val();
        var visit_color='#FDEDEC';
        var visit_status="open";
        var visit_color_type="Light";
        var advance=adv;
        var advance_amount=$("#advance_amount").val();
        var advance_mode=$("#advance_mode :selected").val();
        var advance_inst=$("#advance_inst").val();
        var visit_remarks = $("#txtvisitremarks").val();
        var TableData;
        TableData = storeOTblValues();
        TableData = $.toJSON(TableData);
        
        $("#btnbtncreatevisits").attr('disabled','disabled');
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url() . 'visits_controller/create_booking'; ?>",
            data: {tabledata:TableData, 
                    package_id:package_type_id, 
                    customer_id:customer_id,customer_name:customer_name, 
                    visit_color:visit_color,visit_status:visit_status,visit_color_type:visit_color_type,
                    advance:advance,
                    advance_amount:advance_amount,
                    advance_mode:advance_mode,
                    advance_inst:advance_inst,
                    visit_remarks:visit_remarks
                },
            success: function(response) {
                res=response.split("|");
                console.log(res[0]);
                if(res[0]=="success"){
                    window.open('<?php echo base_url(); ?>print_booking/' + res[1]);
                    window.location.href='<?php echo base_url(); ?>scheduler';
                } else {
                    swal({
                        title: "Error!",
                        text: res[1],
                        type: "error",
                        confirmButtonText: 'OK!'
                    });
                }
            }
        });
        
    }
    
    
    
    function storeOTblValues()
    {
        var TableData = new Array();

        $('#visittable tr').each(function(row, tr) {
            TableData[row] = {
                "category": $(tr).find('td:eq(0)').text()
                , "day": $(tr).find('td:eq(1)>input').val()
                , "hour": $(tr).find('td:eq(2)>input').val()
                , "staffid": $(tr).find('td:eq(3)>select :selected').val()
                , "staffname": $(tr).find('td:eq(3)>select :selected').text()
                , "category_id": $(tr).find('td:eq(4)').text()
                
            }
        });
        TableData.shift();  // first row will be empty - so remove
        return TableData;
    }
    function showhideinst(){
        if($("#advance_mode option:selected").val()!=="cash"){
            $("#advance_inst_div").show();
        } else {
            $("#advance_inst_div").hide();
        }
    }
    
    
    
    function oncareofchange(){
        var data = $("#txt-customer-co").select2('data');
        
        if($("#txt-customer-cell").val()===""){
            $("#txt-customer-cell").val(data.customer_cell);
        }
    }
    
    function oncareofdetailchange(){
        var data = $("#detail-customer-careof").select2('data');
        
        if($("#detail-customer-cell").val()===""){
            $("#detail-customer-cell").val(data.customer_cell);
        }
    }
    
    function enable_careof(){
       $("#txt-customer-co").select2({
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
    
    
    function enable_detailcareof(){
       $("#detail-customer-careof").select2({
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
               return option.customer_name ;
            },
            formatSelection: function (option) {
                return option.customer_name;
            }
          });
         
    }
    
</script>
