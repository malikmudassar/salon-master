<style type="text/css">
@media print
{
.noprint {display:none;}
}
</style>
<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <h4 class="page-title" >Retail Products</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >ID Product</th>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>SKU</th>
                                <th>Price</th>
                                <th>Purchase Price</th>
                                <th>In Stock</th>
                                <th>Measure Unit</th>
                                <th>Active</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($products)) { foreach ($products as $product){ ?>
                            <tr>
                                <td><?php echo $product['id_business_products']; ?></td>
                                <td><?php echo $product['product']; ?></td>
                                <td><?php echo $product['business_brand_name']; ?></td>
                                <td><?php echo $product['category']; ?></td>
                                <td><?php echo $product['sku']; ?></td>
                                <td><?php echo $product['price']; ?></td>
                                <td><?php echo $product['purchase_price']; ?></td>
                                <td><?php echo $product['in_stock']; ?></td>
                                <td><?php echo $product['measure_unit']; ?></td>
                                <td><span class="label <?php if($product['business_product_active']==="Yes"){echo 'label-pink';}else{ echo 'label-inverse'; } ?> "><?php echo $product['business_product_active']; ?></span></td>
                                <td class='noprint' > 
                                    <button id='btnedit' onclick="openupdate(<?php echo $product['id_business_products']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
                                </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
        
        <!--Modals-->
        
        <!--Add Product Modal-->
        <div id="addbusinessproduct" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addbusinessproduct" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add Product</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="brand" class="control-label">Brand</label>
                                            <select name="brand" id="brand" class="form-control" tabindex="1">
                                                <?php foreach($brands as $brand){ ?>
                                                <option value="<?php echo $brand['id_business_brands']; ?>"><?php echo $brand['business_brand_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="category" class="control-label">Category</label>
                                            <input type="text" class="form-control" placeholder="Category" id="category" name="category" tabindex="3">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sku" class="control-label">SKU</label>
                                            <input type="text" class="form-control" placeholder="SKU" id="sku" name="sku" tabindex="5">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="qtyperunit" class="control-label">Quantity Per Unit</label>
                                            <input type="text" class="form-control" placeholder="Quantity Per Unit" id="qtyperunit" name="qtyperunit" tabindex="7">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="purchase_price" class="control-label">Purchase Price</label>
                                            <input type="text" class="form-control" placeholder="Purchase Price" id="purchase_price" name="purchase_price" tabindex="7">
                                        </div> 
                                    </div> 
                                </div>
                        
                        
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="product_name" class="control-label">Product Name</label>
                                            <input type="text" class="form-control" placeholder="Product Name" id="product_name" name="product_name" tabindex="2">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="price" class="control-label">Price</label>
                                            <input type="text"  class="form-control" placeholder="Price" id="price" name="price" tabindex="4">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="in_stock" class="control-label">In Stock</label>
                                            <input type="text" class="form-control numeric" placeholder="In Stock" id="in_stock" name="in_stock" tabindex="6">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row hidden">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="professional" class="control-label">Professional</label>
                                            <select class="form-control" id="professional" name="professional" tabindex="8">
                                                <option value="n">No</option>
                                                <option value="y">Yes</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="unittype" class="control-label">Unit Type</label>
                                            <select class="form-control" name="unittype" id="unittype">
                                                <option value="Bottle">Bottle</option>
                                                <option value="Jar">Jar</option>
                                                <option value="Drum">Drum</option>
                                                <option value="Tube">Tube</option>
                                                <option value="sachet">Sachet</option>
                                                <option value="other">other</option>                                        
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="measure_unit" class="control-label">Measurement Unit</label>
                                            <!--<input type="text" class="form-control" placeholder="Measurement Unit" id="measure_unit" name="measure_unit" tabindex="9">-->
                                            <select class="form-control" name="measure_unit" id="measure_unit">
                                                <?php foreach ($measurement_unit as $mu){ ?>
                                                <option value="<?php echo $mu['m_unit']; ?>"><?php echo $mu['m_unit']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" tabindex="10">Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light" tabindex="9">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--Add Professional Modal-->
        <!--Edit Product Modal-->
        <div id="editbusinessproduct" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editbusinessproduct" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Product</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditbusinessproductid" class="control-label">ID</label>
                                            <input readonly="readonly" type="text" class="form-control" placeholder="Product ID" id="txteditbusinessproductid" name="txteditbusinessproductid" tabindex="1">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditproduct" class="control-label">Product Name</label>
                                            <input type="text" class="form-control" placeholder="Product Name" id="txteditproduct" name="txteditproduct" tabindex="3">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditprice" class="control-label">Price</label>
                                            <input type="text" <?php if(isset($business[0]['allow_price_update']) && $business[0]['allow_price_update']==='No' && $this->session->userdata('role')=="Store Manager"){?> readonly="readonly" <?php } ?>   class="form-control" placeholder="Price" id="txteditprice" name="txteditprice" tabindex="5">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditqtyperunit" class="control-label">Quantity Per Unit</label>
                                            <input type="text" class="form-control" placeholder="Quantity Per Unit" id="txteditqtyperunit" name="txteditqtyperunit" tabindex="7">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditinstock" class="control-label">In Stock</label>
                                            <input type="text" class="form-control numeric" placeholder="In Stock" id="txteditinstock" name="txteditinstock" tabindex="7">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditproductactive" class="control-label">Active</label>
                                            <select class="form-control" id="txteditproductactive" name="txteditproductactive" tabindex="9">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditbrand" class="control-label">Brand</label>
                                            <select name="txteditbrand" id="txteditbrand" class="form-control" tabindex="2">
                                                <?php foreach($brands as $brand){ ?>
                                                <option value="<?php echo $brand['id_business_brands']; ?>"><?php echo $brand['business_brand_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditsku" class="control-label">SKU</label>
                                            <input type="text" class="form-control" placeholder="SKU" id="txteditsku" name="txteditsku" tabindex="4">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditpurchaseprice" class="control-label">Purchase Price</label>
                                            <input type="text" class="form-control" placeholder="Purchase Price" id="txteditpurchaseprice" name="txteditpurchaseprice" tabindex="6">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditunittype" class="control-label">Unit Type</label>
                                            <select class="form-control" name="txteditunittype" id="txteditunittype">
                                                <option value="Bottle">Bottle</option>
                                                <option value="Jar">Jar</option>
                                                <option value="Drum">Drum</option>
                                                <option value="Tube">Tube</option>
                                                <option value="sachet">Sachet</option>
                                                <option value="other">other</option>                                        
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditmeasurementunit" class="control-label">Measurement Unit</label>
                                            <!--<input type="text" class="form-control" placeholder="Measurement Unit" id="txteditmeasurementunit" name="txteditmeasurementunit" tabindex="8">-->
                                            <select class="form-control" name="txteditmeasurementunit" id="txteditmeasurementunit">
                                                <?php foreach ($measurement_unit as $mu){ ?>
                                                <option value="<?php echo $mu['m_unit']; ?>"><?php echo $mu['m_unit']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="editprofessional" class="control-label">Professional</label>
                                            <select class="form-control" id="editprofessional" name="editprofessional" tabindex="10">
                                                <option value="y">Yes</option>
                                                <option value="n">No</option>
                                            </select>

                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" tabindex="12">Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light" tabindex="11">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Product Modal-->
        
        <script>
           $(document).ready(function() {

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
                
            });

            function deleteproduct(productid){
                
                //Warning Message
                swal({
                    title: "Are you sure?",
                    text: "This action will also remove all services in this category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: "Yes, remove it!",
                    closeOnConfirm: true
                }, function (){
                    $.ajax({
                        type: 'POST',
                        url: 'product_controller/delete_product',
                        data: {id_business_products: productid},
                        success: function(data) {
                            var result = data.split("|");
                            
                            if (result[0] === "success") {
                                swal("Deleted!", "Product has been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Product was not removed!.", "error");
                            }
                        } 
                    });
                });
            }
            
            function openaddnew(){
                $('#addbusinessproduct').modal('show');
            }
            
            function addnew(){
                if($("#product_name").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>product_controller/add_listproduct',
                        data: {brand_id: $("#brand").val(), product: $("#product_name").val(), sku: $("#sku").val(), price: $("#price").val(), purchase_price: $("#purchase_price").val(), in_stock: $("#in_stock").val(), measurement_unit: $("#measure_unit").val(), unit_type: $("#unittype option:selected").val(), qty_per_unit: $("#qtyperunit").val(), category: $('#category').val(), professional: $('#professional').val(),in_retail: '1'},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Product Added');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            function openupdate(id_business_products){
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>product_controller/edit_product',
                    data: {id_business_products: id_business_products},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        
                        $("#txteditbusinessproductid").val(id_business_products);
                        $("#txteditproduct").val(data.product);
                        $("#txteditsku").val(data.sku);
                        $("#txteditprice").val(data.price);
                        $("#txteditpurchaseprice").val(data.purchase_price);
                        $("#txteditinstock").val(data.in_stock);
                        $("#txteditmeasurementunit").val(data.measure_unit);
                        $("#txteditproductactive").val(data.business_product_active);
                        $("#txteditunittype").val(data.unit_type);
                        $("#txteditqtyperunit").val(data.qty_per_unit);
                        $("#txteditbrand").val(data.brand_id);
                        $("#editprofessional").val(data.professional);
                
                        $("#editbusinessproduct").modal('show');
                        
                    }
                });
            }
            function update(){
                if($("#txteditproduct").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>product_controller/update_listproduct',
                        data: {id_business_products: $("#txteditbusinessproductid").val(), brand_id: $("#txteditbrand").val(), product: $("#txteditproduct").val(), sku: $("#txteditsku").val(), price: $("#txteditprice").val(), purchase_price: $("#txteditpurchaseprice").val(), in_stock: $("#txteditinstock").val(), measurement_unit: $("#txteditmeasurementunit option:selected").val(), unit_type: $("#txteditunittype option:selected").val(), qty_per_unit: $("#txteditqtyperunit").val(), business_product_active: $("#txteditproductactive option:selected").val(), professional: $("#editprofessional option:selected").val(),in_retail: '1'},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Product Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
            

        </script>