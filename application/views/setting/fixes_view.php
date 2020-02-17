
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Fixes:</h4>
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
        <div class="row" id="divselection">
            <div class="col-md-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Fix Total Sales:</h4>
                    <form method="post" action="<?php echo base_url();?>fixes_controller/fix_total_sales">
                        <input type="hidden" name="csrf_test_name" id="total_sale_csrf" value=""/>
                        <div class="row">
                            <div class="col-md-3">
                                <button onclick="$('#total_sale_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink ">Fix Total</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        <div class="row" id="divselection">
            <div class="col-md-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Fix Services Sales:</h4>
                    <form method="post" action="<?php echo base_url();?>fixes_controller/fix_services_sales">
                        <input type="hidden" name="csrf_test_name" id="service_sale_csrf" value=""/>
                        <div class="row">
                            <div class="col-md-3">
                                <button onclick="$('#service_sale_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink ">Fix Services</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row" id="divselection">
            <div class="col-md-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30">Fix Retail Sales:</h4>
                    <form method="post" action="<?php echo base_url();?>fixes_controller/fix_retail_sales">
                        <input type="hidden" name="csrf_test_name" id="retail_sale_csrf" value=""/>
                        <div class="row">
                            <div class="col-md-3">
                                <button onclick="$('#retail_sale_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink ">Fix Retail</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    