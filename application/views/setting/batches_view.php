<style type="text/css">
    @media print
    {
        .noprint {display:none;}
    }
</style>
<div class="wrapper">
    <div class="full-container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <?php if($this->session->userdata('role') !== "Admin") {?>
                        <?php if(isset($business[0]['allow_stock_update']) && $business[0]['allow_stock_update']==='Yes'){?>
                            <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add Batch<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                        <?php }                         
                        } else { ?>
                        <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add Batch<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    <?php } ?>
                </div>
                <h4 class="page-title" >Batch wise Stock for "<?php echo $batches[0]['product']; ?>"</h4>
                <input id='txt_id_business_products' name='txt_id_business_products' type='hidden' value="<?php echo $batches[0]['id_business_products']; ?>"
            </div>
        </div>
        <div class="row">
            
            <div class="col-md-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">
                    </h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <table class="table table-stripped">
                                        <tr><td><label class="text-pink"> Product:  </label></td><td> <?php echo $batches[0]['product']; ?></td></tr>
                                        <tr><td><label class="text-pink"> SKU:  </label></td><td> <?php echo $batches[0]['sku']; ?></td></tr>
                                        <tr><td><label class="text-pink"> Category : </label></td><td> <?php echo $batches[0]['category']; ?> </td></tr>
                                        <tr><td><label class="text-pink"> Price : </label></td><td>  <?php echo $batches[0]['price']; ?> </td></tr>
                                        <tr><td><label class="text-pink"> Unit Type : </label></td><td>  <?php echo $batches[0]['unit_type']; ?>  <?php echo $batches[0]['qty_per_unit'] . ' ' . $batches[0]['measure_unit']; ?></td></tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <table id="datatable-buttons" class="table table-striped table-bordered">
                                    <thead>
                                        <tr >
                                            <th style="width: 5%">ID</th>
                                            <th style="width: 10%">Batch#</th>
                                            <th style="width: 10%">Store</th>
                                            <th style="width: 10%">Batch Created</th>
                                            <th ><strong>Expiry</strong></th>
                                            <th ><strong>Expires In (Months)</strong></th>
                                            <th style="width: 10%" class="text-primary">Added Manually</th>
                                            <th style="width: 10%" class="text-primary">Qty. Purchased</th>
                                            <th style="width: 10%" class="text-primary">Transfer In</th>
                                            <th style="width: 10%" class="text-danger">Transfer Out</th>
                                            <th style="width: 10%" class="text-danger">Sold</th>
                                            <th style="width: 10%" class="text-danger">Used</th>
                                            <th style="width: 10%" class="text-danger">Returned</th>
                                            <th style="width: 10%" class="text-success">Remaining Stock</th>
                                            <th style="width: 10%" class="text-primary">Unit Price</th>
                                            <th style="width: 10%" class='noprint'>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (isset($batches)) {
                                            foreach ($batches as $batch) {
                                                ?>
                                                <tr <?php if($batch['expiry']<=3){ echo "class='text-danger'";}?>>
                                                    <td><?php echo $batch['id_batch']; ?></td>
                                                    <td><?php echo $batch['batch_number']; ?></td>
                                                    <td><?php echo $batch['business_store']; ?></td>
                                                    <td><?php echo $batch['bdate']; ?></td>
                                                    <td ><strong><?php echo $batch['batch_expiry']; ?></strong></td>
                                                    <td ><?php echo $batch['expiry']; ?> Months</td>
                                                    <td class="text-primary"><?php echo $batch['manualQty']; ?></td>
                                                    <td class="text-primary"><?php echo $batch['purchasedQty']; ?></td>
                                                    <td class="text-primary"><?php echo $batch['transfer_in']; ?></td>
                                                    <td class="text-danger"><?php echo $batch['transfer_out']; ?></td>
                                                    
                                                    <td class="text-danger"><?php echo $batch['sold']; ?></td>
                                                    <td class="text-danger"><?php echo $batch['used']; ?></td>
                                                    <td class="text-danger"><?php echo $batch['returned']; ?></td>
                                                    <td class="text-success"><strong><?php echo (float)$batch['total_stock']; ?></strong></td>
                                                    <td class="text-primary"><strong><?php echo $batch['batch_amount']; ?></strong></td>
                                                    <td class='noprint' > 
                                                        <button id='btnedit' onclick="openupdate(<?php echo $batch['id_batch']; ?>);"  title='Edit Batch' class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
                                                        <button id='btntransfer' onclick="opentransfermodal('<?php echo $batch['id_batch']; ?>','<?php echo (float)$batch['total_stock']; ?>');"  title='Transfer Notes' class="btn btn-icon waves-effect waves-light btn-pink m-b-5"> <i class="fa fa-reply-all"></i> </button> 
                                                        <button id='btnreceivings' onclick="openareceivings('<?php echo $batch['id_batch']; ?>');" title='Receiving Notes' class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-tag"></i> </button> 
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->

        <!--Add Batch Modal-->
        <div id="addproductbatch" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addproductbatch" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add Product Batch</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtbusinessproduct" class="control-label">Product Name</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Product" id="txtbusinessproduct" name="txtbusinessproduct" value="<?php echo $batches[0]['product'];?>">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group form-group">
                                            <input type="text" onblur="checkbatchnumber()" class="form-control" placeholder="Batch #" id="txtbatchnumber" name="txtbatchnumber">
                                            <span class="input-group-addon"><i id="cog" class="fa fa-spinner " style=" width: auto;margin-right: 10px;"></i></span>
                                        </div> 
                                        <span id="used" class="text-danger text-small" style="display:none">This batch number is already in use!</span>
                                    </div> 

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtbatchdate" class="control-label">Addition Date</label>
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtbatchdate" name="txtbatchdate">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtbatchexpiry" class="control-label">Expiry Date</label>
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txtbatchexpiry" name="txtbatchexpiry">
                                            
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="txtbatchqty" class="control-label">Opening Quantity</label>
                                            <input type="text" <?php if(isset($business[0]['allow_stock_update']) && $business[0]['allow_stock_update']==='No' && $this->session->userdata('role')=="Store Manager"){?> readonly="readonly" <?php } ?> class="form-control numeric" name="txtbatchqty" id="txtbatchqty" placeholder="0"/>
                                        </div> 
                                    </div> 
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="txtunitprice" class="control-label">Unit Price</label>
                                            <input type="text" <?php if(isset($business[0]['allow_stock_update']) && $business[0]['allow_stock_update']==='No' && $this->session->userdata('role')=="Store Manager"){?> readonly="readonly" <?php } ?> class="form-control numeric" name="txtunitprice" id="txtunitprice" placeholder="0"/>
                                        </div> 
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="txtstoreid" class="control-label">Create Batch in</label>
                                            <select class="form-control" name="txtstoreid" id="txtstoreid">
                                                <?php foreach ($stores as $store){?>
                                                <option value="<?php echo $store['id_business_stores']; ?>">
                                                    <?php echo $store['business_store']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                    
                                    
                                    
                                    
                                </div>
                              
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Batch Modal-->

        <!--Edit Batch Modal-->
        <div id="editbatch" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editbatch" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Product Batch</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditbusinessproduct" class="control-label">Product Name</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Product" id="txteditbusinessproduct" name="txteditbusinessproduct" value="<?php echo $batches[0]['product'];?>">
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Product" id="txteditbatchid" name="txteditbatchid">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditbatchnumber" class="control-label">Batch #</label>
                                            <input type="text" readonly="readonly" class="form-control" placeholder="Batch #" id="txteditbatchnumber" name="txteditbatchnumber">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditbatchdate" class="control-label">Batch Date</label>
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txteditbatchdate" name="txteditbatchdate">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditbatchexpiry" class="control-label">Expiry Date</label>
                                            <input tabindex="9" type="text" class="form-control" placeholder="yyyy/mm/dd" id="txteditbatchexpiry" name="txteditbatchexpiry">
                                            
                                        </div> 
                                    </div> 
                                </div>
                                
                                
                            </div>
                        </div>
                        <div class="row p-t-10" style="border-top:1px solid #808080; ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="txteditbatchqty" class="control-label">Manually Add</label>
                                    <input type="text" <?php if(isset($business[0]['allow_stock_update']) && $business[0]['allow_stock_update']==='No' && $this->session->userdata('role')=="Store Manager"){?> readonly="readonly" <?php } ?> class="form-control numeric" name="txteditbatchqty" id="txteditbatchqty" placeholder="0"/>
                                </div> 
                            </div> 
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="txteditunitprice" class="control-label">Unit Price</label>
                                    <input type="text" class="form-control numeric" name="txteditunitprice" id="txteditunitprice" placeholder="0"/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txteditremarks" class="control-label">Remarks</label>
                                    <input type="text"  class="form-control" name="txteditremarks" id="txteditremarks"/>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button onclick="editOrderRows();" type="button" class="btn  m-t-20 btn-sm btn-custom waves-effect waves-light pull-right">Add<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                            </div>
                        </div>
                        <div class='row ' style="min-height: 150px;">
                            <div id='edit-adjustment-list' class='col-md-12'>
                                <div class="table-responsive">
                                    <table class="table" id="edit-ordertbl">
                                        <thead>
                                            <tr>
                                                
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Remarks</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Product Modal-->
        
        <!--Edit Transfer Modal-->
        <div id="transfermodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="transfermodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Transfer Inventory</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txttransferbusinessproduct" class="control-label">Product Name</label>
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Product" id="txttransferbusinessproduct" name="txttransferbusinessproduct" value="<?php echo $batches[0]['product'];?>">
                                    <input type="text" class="form-control" readonly="readonly" placeholder="Product" id="txttransferbatchid" name="txttransferbatchid">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txttransferbatchnumber" class="control-label">Batch #</label>
                                            <input type="text" readonly="readonly" class="form-control" placeholder="Batch #" id="txttransferbatchnumber" name="txttransferbatchnumber">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txttransferfrom" class="control-label">Transfer From</label>
                                            <input  type="text" class="form-control" readonly="readonly"  id="txttransferfrom" name="txttransferfrom">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txttransferto" class="control-label">Transfer To</label>
                                            <select class="form-control"  id="txttransferto" name="txttransferto">
                                                <?php foreach ($stores as $store){?>
                                                <option value="<?php echo $store['id_business_stores']; ?>">
                                                    <?php echo $store['business_store']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="txttranferqty" class="control-label">Qty to Transfer</label>
                                            <input type="number" class="form-control numeric" name="txttranferqty" id="txttranferqty" value="0" onKeyUp="if(parseFloat(this.value) > parseFloat($('#txttransferbatchqty').val())){this.value=$('#txttransferbatchqty').val();}else if(this.value<0 || this.value==''){this.value=0;}"/>
                                        </div> 
                                    </div> 
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="txttransferbatchqty" class="control-label">Total Available Qty</label>
                                            <input type="text"class="form-control numeric" readonly="readonly" name="txttransferbatchqty" id="txttransferbatchqty" placeholder="0"/>
                                        </div> 
                                    </div> 
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="transfer();" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Transfer Modal-->

        <script>
            $(document).ready(function () {

                $('#txtbatchdate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });

                $('#txtbatchexpiry').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });

                $('#txteditbatchdate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });

                $('#txteditbatchexpiry').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy/mm/dd'
                });




                $("#txtbatchnumber").keyup(function(event) {
                    if (event.which == 13) {
                        checkbatchnumber();
                    }                 
                });

                $('#datatable-buttons').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true,
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                    responsive: !0
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

                $(".numeric").keypress(function (e) {
                    console.log(e.which);
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 45 && e.which != 46 && e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });

            });

            function deleteproduct(productid) {

                //Warning Message
                swal({
                    title: "Are you sure?",
                    text: "This action will remove all details of this product!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: "Yes, remove it!",
                    closeOnConfirm: true
                }, function () {
                    $.ajax({
                        type: 'POST',
                        url: 'product_controller/delete_product',
                        data: {id_business_products: productid},
                        success: function (data) {
                            var result = data.split("|");

                            if (result[0] === "success") {
                                swal("Deleted!", "Batch has been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Batch was not removed!.", "error");
                            }
                        }
                    });
                });
            }

            function openaddnew() {
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>product_controller/get_next_batchno',
                    data: {product_id: $("#txt_id_business_products").val()},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function (data) {
                        if(data){
                            $("#txtbatchnumber").val(data.new_number);
                            
                            $("#addproductbatch").modal('show');
                        } else {
                            $("#txtbatchnumber").val('0001');
                            $("#addproductbatch").modal('show');
                        }   
                    }
                });
                    
                
                
            }
            
            function addnew() {
                if ($("#txtbusinessproduct").val() !== "") {

                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>product_controller/add_batch',
                        data: {product_id: $("#txt_id_business_products").val(), 
                                batch_number: $("#txtbatchnumber").val(), 
                                batch_date: $("#txtbatchdate").val(), 
                                batch_expiry: $("#txtbatchexpiry").val(), 
                                batch_qty: $("#txtbatchqty").val(),
                                store_id : $("#txtstoreid").val(),
                                unit_price: $("#txtunitprice").val(),
                            },
                        success: function (data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Batch Added');
                                location.reload();
                            }
                        }
                    });
                }
            }


            function openupdate(id_batch) {

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>product_controller/open_edit_batch',
                    data: {id_batch: id_batch},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function (data) {

                        $("#txteditbatchid").val(data.id_batch);                        
                        $("#txteditbatchnumber").val(data.batch_number);
                        $("#txteditbatchdate").val(data.batch_date);
                        $("#txteditbatchexpiry").val(data.expiry_date);
                        $("#txteditbatchqty").val(data.batch_qty);
                        $("#txteditbatchinstock").val(data.batch_in_stock);
                        $("#txteditbatchinhouse").val(data.batch_in_house);
                        $("#txteditbatchsold").val(data.batch_sold);
                        $("#txteditbatchused").val(data.batch_used);

                        $("#editbatch").modal('show');

                    }
                });
            }
            
            function update() {
                if ($("#txteditbatchid").val() !== "") {
                    var TableData;
                    TableData = edit_adjustment_storeOTblValues();
                    TableData = $.toJSON(TableData);
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>product_controller/update_batch',
                        data: {
                            batch_id: $("#txteditbatchid").val(), 
                            product_id: $("#txt_id_business_products").val(),
                            batch_number: $("#txteditbatchnumber").val(), 
                            batch_date: $("#txteditbatchdate").val(), 
                            batch_expiry: $("#txteditbatchexpiry").val(),
                            adjustments: TableData
                        },
                        success: function (data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Product Batch Inventory Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            
            function checkbatchnumber(){
               
                if ($("#txtbatchnumber").val() !== "") {
                    $("#cog").addClass('fa-spin');
                    $.ajax({
                        type: 'POST',
                        dataType: "json",
                        cache: false,
                        async: true,
                        url: '<?php echo base_url(); ?>product_controller/check_batch_number',
                        data: {product_id: $("#txt_id_business_products").val(), batch_number: $("#txtbatchnumber").val()},
                        success: function (data) {
                            $("#cog").removeClass('fa-spin');
                            if(data){
                                $("#used").fadeIn(200);
                            } else {
                                $("#used").fadeOut(200);
                                $("#txtbatchdate").focus();
                            }
                        }
                    });
                }
                
            }


            function opentransfermodal(id_batch,remaining_stock){
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>product_controller/open_edit_batch',
                    data: {id_batch: id_batch},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function (data) {

                        $("#txttransferbatchid").val(data.id_batch);                        
                        $("#txttransferbatchnumber").val(data.batch_number);
                        $("#txttransferfrom").val(data.business_store);
                        $("#txttransferbatchqty").val(remaining_stock);
                        $("#txttranferqty").val('0');
                        

                        $("#transfermodal").modal('show');

                    }
                });
            }
            
            function transfer() {
            
                if ($("#txttransferbatchid").val() !== "" && parseFloat($("#txttranferqty").val()) > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>product_controller/transfer_qty',
                        data: {
                            frombatch: $("#txttransferbatchid").val(), 
                            
                            fromstore: $("#txttransferfrom").val(), 
                            tostore: $("#txttransferto").val(), 
                            transfer_qty: $("#txttranferqty").val()
                        },
                                
                        success: function (data) {
                            console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Product Batch Inventory Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            
         
            
            //Editing product/status/usage qty functions start.....
            function editOrderRows() {

                if ($("#txteditbatchqty").val() === "" || $("#txteditunitprice").val() === "") {
                    swal({
                        title: "Unit Price & Qty Should not be empty!",
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                    return false;
                }

                var mhtml = "";
              
                var count = 1;

              

                mhtml += '<tr>';
                
                mhtml += '<td>' + $("#txteditbatchqty").val() + '</td>';
                mhtml += '<td>' + $("#txteditunitprice").val() + '</td>';
                mhtml += '<td>' + $("#txteditremarks").val() + '</td>';
              
                mhtml += "</tr>";
                
                $("#edit-adjustment-list tbody").append(mhtml);
                
            }

            
            
            
           

            function removeproductedit(val) {
                $('#edit-order-product-list').find("td.id").each(function(index) {
                    if ($(this).html() == val) {
                        $(this).closest('tr').remove();
                    }
                });
            }
            
            function edit_adjustment_storeOTblValues() {
                var TableData = new Array();
                $('#edit-adjustment-list tr').each(function(row, tr) {
                    TableData[row] = {
                         "adjustment_qty": $(tr).find('td:eq(0)').text()
                        , "unit_price": $(tr).find('td:eq(1)').text()
                        , "remarks": $(tr).find('td:eq(2)').text()

                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }
            
            
            function openareceivings(batch_id){
                
                
                
            }
        </script>