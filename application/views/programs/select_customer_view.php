<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title"><?php echo $program;?> Registration: </h4><select style="display:none" id="staffcombo"></select>
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
                                            <a type="button" class="btn waves-effect waves-light btn-custom newcustomeradding" href="<?php echo base_url().$program_type;?>/0"><i class="fa fa-plus"></i> Add Customer</a>
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
                                    <button class="btn btn-inverse btn-xs w-md m-b-5" onclick="back('#multiplesearch', '#divsearch');newcustomerbtn_show_hide('');  $('#cell-search').val(''); $('#name-search').val(''); $('#balanceid').html('');"><i class="glyphicon glyphicon-chevron-left"></i> Back</button>
                                </div>
                                <h4 class="header-title m-t-0 m-b-30">Searched Customers:</h4>
                                <div class="row">
                                    <div id="customer_list" class="inbox-widget nicescroll_1" style="height: 250px; overflow: hidden; outline: none;" tabindex="5000">

                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-lg-12 m-t-10">
                                        <div align="center" id="newcustomeraddinglist">
                                            <a type="button" class="btn waves-effect waves-light btn-custom newcustomeradding" href="<?php echo base_url().$program_type;?>/0"><i class="fa fa-plus"></i> Add Customer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Customer List -->
                    
                </div>
            </div>
        </div>
    </div>
</div>

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
        $('#newcustomeradding').hide();
        $("#divsearch").fadeIn();
    }
       
    $(document).ready(function () {
        hideOpenDivs();
   
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

     });
       
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
    
    
    function fillcustomerform(data) {
     
        var mhtml = '';
        if (data.length >= 1) {    
            $(".nicescroll_1").niceScroll({cursoropacitymin: 1});
            for (x = 0; x < data.length; x++) {
                mhtml += '<a href="<?php echo base_url().$program_type;?>/' + data[x]['id_customers'] + '">';
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
            
        } else {
            $('#newcustomeradding').fadeIn();
        }
    }
    
    
    function newcustomerbtn_show_hide(a) {
        if (a === "") {
            $('#newcustomeradding').css('display', 'none');
        }
    }
</script>