<style>
    table.dataTable tr.group td{font-weight:bold;background-color:#e0e0e0}
    
     table.dataTable tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }
    
</style>

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Edit (<?php echo $account_head[0]['account_head'];?>):</h4>
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
            <div class="col-sm-12">
                <div class="card-box ">
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <form method="post" action="<?php echo base_url();?>accounting_controller/update_account_head">
                        <input type="hidden" name="csrf_test_name" id="account_head_csrf" value=""/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">ID</label>
                                    <input class="form-control" readonly="readonly" name="id_account_heads" value = "<?php echo $account_head[0]['id_account_heads'];?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Account Head</label>
                                    <input class="form-control" name="account_head" value = "<?php echo $account_head[0]['account_head'];?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                               <div class="col-md-6">
                                    <label class="form-label">Head Number</label>
                                    <input class="form-control" name="account_head_number" value = "<?php echo $account_head[0]['account_head_number'];?>">
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Account Sub Type</label>
                                    <select class="form-control" name="account_head_type">
                                         <?php foreach($account_sub_types as $account_sub_type){?>
                                         <option <?php if($account_sub_type['id_account_sub_types']==$account_head[0]['account_sub_type']){echo 'selected';}?> value="<?php echo $account_sub_type['id_account_sub_types']; ?>"><?php echo $account_sub_type['account_sub_type'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <label class="form-label">Account Nature</label>
                                    <select class="form-control" name="account_type">
                                        <option <?php if($account_head[0]['account_type']=="Bank"){echo "selected='selected'";}?> value="Bank">Bank</option>
                                        <option <?php if($account_head[0]['account_type']=="Cash"){echo "selected='selected'";}?> value="Cash">Cash</option>
                                        <option <?php if($account_head[0]['account_type']=="Bank"){echo "selected='selected'";}?> value="Card">Card</option>
                                        <option <?php if($account_head[0]['account_type']=="Card"){echo "selected='selected'";}?> value="Asset">Asset</option>
                                       <option <?php if($account_head[0]['account_type']=="Expense"){echo "selected='selected'";}?> value="Expense">Expense</option>
                                       <option <?php if($account_head[0]['account_type']=="Liability"){echo "selected='selected'";}?> value="Liability">Liability</option>
                                       <option <?php if($account_head[0]['account_type']=="Revenue"){echo "selected='selected'";}?> value="Revenue">Revenue</option>
                                       <option <?php if($account_head[0]['account_type']=="Equity"){echo "selected='selected'";}?> value="Equity">Equity</option>
                                    </select>
                                </div>
                            </div>
                            <div clas
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="btn-group pull-right m-t-15">
                                        <a href="<?php echo base_url();?>coa" class="btn waves-effect waves-light btn-default m-t-20">Back</a>
                                        <button onclick="$('#account_head_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink m-t-20">Save</button>
                                        
                                    </div>
                                </div>
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
            if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });
    });

</script>