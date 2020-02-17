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
                <h4 class="page-title">Edit Visit (<?php echo $visit->id_customer_visits;?>):</h4>
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
                    <h4 class="header-title m-t-0 m-b-30"></h4>
                    <form method="post" action="<?php echo base_url();?>superuser_controller/update_visit">
                        <input type="hidden" name="csrf_test_name" id="visit_csrf" value=""/>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Visit ID</label>
                                    <input class="form-control" readonly="readonly" name="id_customer_visits" value = "<?php echo $visit->id_customer_visits;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Customer</label>
                                    <input class="form-control"  readonly="readonly" id="customer_name" name="customer_name" value = "<?php echo $visit->customer_name;?>">
                                    <input class="form-control" onchange="oncustomerchange();" id="txt_customer_name" name="customer_name" value = "">
                                    <input type="text" readonly="readonly" class="form-control" id="txt_customer_id" name="customer_id" value = "<?php echo $visit->customer_id;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Visit Created On</label>
                                    <input class="form-control" readonly="readonly" name="customer_visit_date" value = "<?php echo $visit->customer_visit_date;?>">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Visit Status</label>
                                    <select class="form-control" name="visit_status">
                                        <option <?php if($visit->visit_status=='open'){echo "selected='selected'";}?> value="open">open</option>
                                        <option <?php if($visit->visit_status=='invoiced'){echo "selected='selected'";}?> value="invoiced">invoiced</option>
                                        <option <?php if($visit->visit_status=='canceled'){echo "selected='selected'";}?> value="canceled">canceled</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row m-t-20">
                                <div class="col-md-6">
                                    <div class="btn-group pull-right m-t-15">
                                        <a href="<?php echo base_url();?>super_visits" class="btn waves-effect waves-light btn-default m-t-20">Back</a>
                                        <button onclick="$('#visit_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink m-t-20">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>   
        
        <div class="row">
            <div class="card-box">
                <div class="row m-t-20">
                    <div class="col-md-12">
                        <table class="table table-reponsive">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Payment Mode</th>
                                    <th>Inst. #</th>
                                    <th>Remarks</th>
                                    <th>CC charge</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($advances as $advance){ ?>
                            <tr>
                            <form action="<?php echo base_url()."/superuser_controller/edit_advance"?>" method="post">
                                <td><input name="id_visit_advance" readonly="readonly" class="form-control" value="<?php echo $advance['id_visit_advance'];?>"/> <input type="hidden" name="id_customer_visits" value="<?php echo $advance['customer_visit_id'];?>"</td>
                                <td><input name="advance_amount" class="form-control" value="<?php echo $advance['advance_amount'];?>"</td>                                           
                                <td><input name="advance_date" class="form-control isdate" value="<?php echo $advance['advance_date'];?>" /></td>
                                <td>
                                    <select name="advance_mode" class="form-control">
                                        <option value="cash" <?php if($advance['advance_mode']=="cash"){echo "selected='selected'";}?>>Cash</option>
                                        <option value="card" <?php if($advance['advance_mode']=="card"){echo "selected='selected'";}?>>Credit Card</option>
                                        <option  value="card" >Debit Card</option>
                                        <option value="check"  <?php if($advance['advance_mode']=="check"){echo "selected='selected'";}?>>Check</option>
                                    </select>
                                    
                                </td>
                                <td><input name="advance_inst" class="form-control" value="<?php echo $advance['advance_inst'];?>"></td>
                                <td><input name="advance_remarks" class="form-control" value="<?php echo $advance['advance_remarks'];?>"/></td>
                                <td><input name="advance_cc_charge" class="form-control" value="<?php echo $advance['advance_cc_charge'];?>"/></td>
                                <td><button type="submit" onclick="$('#visit_csrf').val($('#cook').val());" class="btn waves-effect waves-light btn-pink">Save</button></td>
                            </form>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>                                
                </div>
            </div>            
        </div>
        
    </div>
</div>

<script>
    $(document).ready(function() {
        enable_customer();
        
        $(".isdate").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
        
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
    
    
    function enable_customer(){
       $("#txt_customer_name").select2({
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
    function oncustomerchange(){
        var data = $("#txt_customer_name").select2('data');
        
        
            $("#customer_name").val(data.customer_name);
            $("#txt_customer_id").val(data.id_customers);
        
    }

</script>