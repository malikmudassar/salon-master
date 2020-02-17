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
                    <?php if(isset($business_brands)){?>
                        <a type="button"  href="<?php echo base_url();?>product_list/professional/<?php echo $business_brands[0]['id_business_brands']; ?>" class="btn btn-custom waves-effect waves-light m-r-5" >Professional <span class="m-l-5"><i class="ti-spray"></i></span></a>
                        <a type="button"  href="<?php echo base_url();?>product_list/retail/<?php echo $business_brands[0]['id_business_brands']; ?>" class="btn btn-warning waves-effect waves-light m-r-5" >Retail <span class="m-l-5"><i class="ti-shopping-cart"></i></span></a>
                        <a type="button"  href="<?php echo base_url();?>product_list/all/<?php echo $business_brands[0]['id_business_brands']; ?>" class="btn btn-pink waves-effect waves-light m-r-5" >All <span class="m-l-5"><i class="ti-bookmark-alt"></i></span></a>
                    <?php } else if(!isset($business_brands)){?>
                        <a type="button"  href="<?php echo base_url();?>product_list/professional/0" class="btn btn-custom waves-effect waves-light m-r-5" >Professional <span class="m-l-5"><i class="ti-spray"></i></span></a>
                        <a type="button"  href="<?php echo base_url();?>product_list/retail/0" class="btn btn-warning waves-effect waves-light m-r-5" >Retail <span class="m-l-5"><i class="ti-shopping-cart"></i></span></a>
                        <a type="button"  href="<?php echo base_url();?>product_list/all/0" class="btn btn-pink waves-effect waves-light m-r-5" >All <span class="m-l-5"><i class="ti-bookmark-alt"></i></span></a>
                    <?php } ?>    
                        
                        
                    
                    <button type="button"  onclick="openaddnew();" class="btn btn-primary waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                </div>
                <?php if(isset($business_brands)){?>
                    <h4 class="page-title" >Products in Brand  <?php echo $business_brands[0]['business_brand_name']; ?></h4>
                    <input id='txt_id_business_brands' name='txt_id_business_brands' type='hidden' value="<?php echo $business_brands[0]['id_business_brands']; ?>"
                 <?php } else if(isset($title)){?>
                    <h4 class="page-title" ><?php echo $title; ?></h4>
                    <input id='txt_id_business_brands' name='txt_id_business_brands' type='hidden' value=""/>
                 <?php } ?>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 2%">ID</th>
                                <th style="width: 5%">Brand</th>
                                <th style="width: 15%">Product Name</th>
                                <th style="width: 5%">Category</th>
                                <th style="width: 5%">Type</th>                               
                                <th style="width: 5%">Price</th>
                                <th style="width: 5%">Total InStock</th>
                                <th style="width: 5%">Threshold</th>
                                <th style="width: 5%">Unit Type</th>
                                <th style="width: 5%">Measure Unit</th>
                                <th style="width: 5%">Quantity per unit</th>
                                <th style="width: 5%">Active</th>
                                 <th style="width: 5%">SKU</th>
                                 <th style="width: 5%">Barcode</th>
                                <th style="width: 22%" class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (isset($products)) {
                                foreach ($products as $product) {
                                    ?>
                                    <tr <?php if($product['total_stock']<=$product['product_threshold']){echo 'class="text-danger"';}  ?>>
                                        <td><?php echo $product['id_business_products']; ?></td>
                                        <td><?php echo $product['business_brand_name']; ?></td>
                                        <td><?php echo $product['product']; ?></td>
                                        <td><?php echo $product['category']; ?></td>
                                        <td>
                                            <span class="label <?php if ($product['professional'] === "y"){ ?> label-info <?php } if ($product['professional'] === "n"){ ?> label-warning <?php } ?>">
                                                <?php 
                                                if ($product['professional'] === "y"){
                                                    echo "Professional";
                                                }else{
                                                    echo "Retail";
                                                } 
                                                ?>
                                            </span>
                                            
                                        </td>
                                        
                                        <td><?php echo $product['price']; ?></td>
                                        
                                        <td ><strong><?php echo $product['total_stock']; ?></strong></td>
                                        <td><?php echo $product['product_threshold']; ?></td>
                                        <td><?php echo $product['unit_type']; ?></td>
                                        <td><?php echo $product['measure_unit']; ?></td>
                                        <td><?php echo $product['qty_per_unit']; ?></td>
                                        <td><span class="label <?php
                                            if ($product['business_product_active'] === "Yes") {
                                                echo 'label-pink';
                                            } else {
                                                echo 'label-inverse';
                                            }
                                            ?> "><?php echo $product['business_product_active']; ?></span></td>
                                        <td><?php echo $product['sku']; ?></td>
                                        <td><?php echo $product['barcode_products']; ?></td>
                                        <td class='noprint' > 
                                            <button id='btnedit' onclick="openupdate(<?php echo $product['id_business_products']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
                                            <a id='btnaddstock' href="<?php echo base_url();?>batches/<?php echo $product['id_business_products']; ?>" class="btn waves-effect waves-light btn-pink m-b-5"><i class="fa fa-shopping-basket"></i> Add Stock </a> 
                                        </td>
                                    </tr>
                                <?php }
                            }
                            ?>
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
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Product</h4>
                    </div>
                    <div class="modal-body">
                         <div class="row">
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtbrandid" class="control-label">Brand</label>
                                    <select class="form-control" id="txtbrandid" name="txtbrandid">
                                        <?php foreach($brands as $brand){?>
                                        <option value="<?php echo $brand['id_business_brands'];?>">
                                            <?php echo $brand['business_brand_name'];?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div> 
                             
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="txtbusinessproduct" class="control-label">Product Name</label>
                                    <input type="text" class="form-control" placeholder="Product" id="txtbusinessproduct" name="txtbusinessproduct">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtbusinesscategory" class="control-label">Category</label>
                                            <input type="text" class="form-control" placeholder="Category" id="txtbusinesscategory" name="txtbusinesscategory">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtpurchaseprice" class="control-label">Purchase Price</label>
                                            <input type="text" class="form-control"  placeholder="Purchase Price" id="txtpurchaseprice" name="txtpurchaseprice">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtprice" class="control-label">Price</label>
                                            <input type="text" class="form-control" placeholder="Price" id="txtprice" name="txtprice">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtunittype" class="control-label">Unit Type</label>
                                            <select class="form-control" name="txtunittype" id="txtunittype">
                                                <?php foreach($unit_types as $ut){?>
                                                <option value="<?php echo $ut['unit_type']; ?>"><?php echo $ut['unit_type']; ?></option>
                                                <?php }?>
                                               
                                            </select>
                                        </div> 
                                    </div> 
                                </div>

                                
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtprofessional" class="control-label">Professional</label>
                                            <select class="form-control" name="txtprofessional" id="txtprofessional">
                                                <option value="n">No</option>
                                                 <option value="y" <?php if($title=="Professional Products"){echo 'selected'; }?>>Yes</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                
                               
                            </div>
                            <div class="col-lg-6">
                                
                                 <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtsku" class="control-label">SKU</label>
                                            <input type="text" class="form-control" placeholder="Product SKU" id="txtsku" name="txtsku">
                                        </div> 
                                    </div> 
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtcommission" class="control-label">Commission</label>
                                            <input type="text" class="form-control decimal" placeholder="Product SKU" id="txtcommission" name="txtcommission">
                                        </div> 
                                    </div> 
                                </div>
                                
                                
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtbarcode" class="control-label">Barcode</label>
                                            <input type="text" class="form-control" placeholder="Barcode" id="txtbarcode" name="txtbarcode">
                                        </div> 
                                    </div> 
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                                
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtmeasurementunit" class="control-label">Measurement Unit</label>
                                            <select class="form-control" name="txtmeasurementunit" id="txtmeasurementunit">
                                                <?php foreach ($measurement_unit as $mu){ ?>
                                                <option value="<?php echo $mu['m_unit']; ?>"><?php echo $mu['m_unit']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
<!--                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtinstock" class="control-label">In Stock</label>
                                            <input type="text" class="form-control" placeholder="In Stock" id="txtinstock" name="txtinstock">

                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtinhousestock" class="control-label">Inhouse Stock</label>
                                            <input type="text" class="form-control" placeholder="Inhouse Stock" id="txtinhousestock" name="txtinhousestock">
                                        </div> 
                                    </div> 
                                </div>-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtqtyperunit" class="control-label">Quantity per unit</label>
                                            <input type="text" class="form-control numeric" placeholder="Quantity per unit" id="txtqtyperunit" name="txtqtyperunit">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txtthreshold" class="control-label">Threshold</label>
                                            <input type="text" class="form-control" placeholder="Procurement Threshold" id="txtthreshold" name="txtthreshold">
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
        <!--End Product Modal-->

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
                                            <input readonly="readonly" type="text" class="form-control" placeholder="Product ID" id="txteditbusinessproductid" name="txteditbusinessproductid">
                                        </div> 
                                    </div> 
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditbrandid" class="control-label">Brand</label>
                                            <select class="form-control" id="txteditbrandid" name="txteditbrandid">
                                                <?php foreach($brands as $brand){?>
                                                <option value="<?php echo $brand['id_business_brands'];?>">
                                                    <?php echo $brand['business_brand_name'];?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                   
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditprice" class="control-label">Price</label>
                                            <input type="text" <?php if(isset($business[0]['allow_price_update']) && $business[0]['allow_price_update']==='No' && $this->session->userdata('role')=="Store Manager"){?> readonly="readonly" <?php } ?>   class="form-control" placeholder="Price" id="txteditprice" name="txteditprice">
                                        </div> 
                                    </div> 
                                </div>

<!--                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditinstock" class="control-label">In Stock</label>
                                            <input type="text" class="form-control numeric" placeholder="In Stock" id="txteditinstock" name="txteditinstock">
                                        </div> 
                                    </div> 
                                </div>-->
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditunittype" class="control-label">Unit Type</label>
                                            <select class="form-control" name="txteditunittype" id="txteditunittype">
                                                <?php foreach($unit_types as $ut){?>
                                                <option value="<?php echo $ut['unit_type']; ?>"><?php echo $ut['unit_type']; ?></option>
                                                <?php }?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditbarcode" class="control-label">Barcode</label>
                                            <input type="text" class="form-control" placeholder="Barcode" id="txteditbarcode" name="txteditbarcode">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditprofessional" class="control-label">Professional</label>
                                            <select class="form-control" name="txteditprofessional" id="txteditprofessional">
                                                <option value="y">Yes</option>
                                                <option value="n">No</option>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                

                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                 <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditproduct" class="control-label">Product Name</label>
                                            <input type="text" class="form-control" placeholder="Product Name" id="txteditproduct" name="txteditproduct">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditbusinesscategory" class="control-label">Category</label>
                                            <input type="text" class="form-control" placeholder="Category" id="txteditbusinesscategory" name="txteditbusinesscategory">
                                        </div> 
                                    </div> 
                                </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditpurchaseprice" class="control-label">Purchase Price</label>
                                            <input type="text" class="form-control" placeholder="Purchase Price" id="txteditpurchaseprice" name="txteditpurchaseprice">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditqtyperunit" class="control-label">Quantity per unit</label>
                                            <input type="text" class="form-control numeric" placeholder="Quantity per unit" id="txteditqtyperunit" name="txteditqtyperunit">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditmeasurementunit" class="control-label">Measurement Unit</label>
                                            <select class="form-control" name="txteditmeasurementunit" id="txteditmeasurementunit">
                                                <?php foreach ($measurement_unit as $mu){ ?>
                                                <option value="<?php echo $mu['m_unit']; ?>"><?php echo $mu['m_unit']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditsku" class="control-label">SKU</label>
                                            <input type="text" class="form-control" placeholder="SKU" id="txteditsku" name="txteditsku">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditcommission" class="control-label">Commission</label>
                                            <input type="text" class="form-control decimal" placeholder="Commission" id="txteditcommission" name="txteditcommission">
                                        </div> 
                                    </div> 
                                </div>
<!--                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditinhousestock" class="control-label">Inhouse Stock</label>
                                            <input type="text" class="form-control" placeholder="Inhouse Stock" id="txteditinhousestock" name="txteditinhousestock">
                                        </div> 
                                    </div> 
                                </div>-->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditproductactive" class="control-label">Active</label>
                                            <select class="form-control" id="txteditproductactive" name="txteditproductactive">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="txteditthreshold" class="control-label">Threshold</label>
                                            <input type="text" class="form-control" placeholder="Procurement Threshold" id="txteditthreshold" name="txteditthreshold">
                                        </div> 
                                    </div> 
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
                
                $(".numeric").keypress(function(e) {
                   
                    //if the letter is not digit then display error and don't type anything
                    if (e.which!=46 && e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });
                $(".decimal").keypress(function(e) {
                    //if the letter is not digit then display error and don't type anything
                    if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57) ) {

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
                }, function() {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>product_controller/delete_product',
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

            function openaddnew() {
               
                if($("#txt_id_business_brands").val()!==""){
                    $("#txtbrandid").val($("#txt_id_business_brands").val());
                } 
               
                $("#addbusinessproduct").modal('show');
            }
            function addnew() {
                if ($("#txtbusinessproduct").val() !== "" && $("#txtbrandid option:selected").index() > -1) {
                    
                   
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>product_controller/add_product',
                        data: {brand_id: $("#txtbrandid option:selected").val(), category: $("#txtbusinesscategory").val(), product: $("#txtbusinessproduct").val(), sku: $("#txtsku").val(), commission: $("#txtcommission").val(), barcode: $("#txtbarcode").val(),price: $("#txtprice").val(), purchase_price: $("#txtpurchaseprice").val(), measurement_unit: $("#txtmeasurementunit option:selected").val(),unit_type: $('#txtunittype option:selected').val(),qty_per_unit: $('#txtqtyperunit').val(), professional: $('#txtprofessional option:selected').val(), threshold: $('#txtthreshold').val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Product Added');
                                location.reload();
                            }
                        }
                    });
                }
            }


            function openupdate(id_business_products) {

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>product_controller/edit_product',
                    data: {id_business_products: id_business_products},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        
                        $("#txteditbusinessproductid").val(data.id_business_products);
                        
                        $("#txteditbrandid").val(data.brand_id);
                        $("#txteditproduct").val(data.product);
                        $("#txteditbusinesscategory").val(data.category);
                        $("#txteditsku").val(data.sku);
                        $("#txteditcommission").val(data.commission);
                        $("#txteditbarcode").val(data.barcode_products);
                        $("#txteditprice").val(data.price);
                        $("#txteditpurchaseprice").val(data.purchase_price);
                       // $("#txteditinstock").val(data.in_stock);
                        //$("#txteditinhousestock").val(data.inhouse_stock);
                        $("#txteditmeasurementunit").val(data.measure_unit);
                        $("#txteditunittype").val(data.unit_type);
                        $("#txteditqtyperunit").val(data.qty_per_unit);
                        $("#txteditproductactive").val(data.business_product_active);
                        $("#txteditprofessional").val(data.professional);
                        $("#txteditthreshold").val(data.product_threshold);
                    
                        $("#editbusinessproduct").modal('show');
                        
                    }
                });
            }
            function update() {
                if ($("#txteditproduct").val() !== "" && $("#txteditbrandid option:selected").index() > -1) {
                    
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>product_controller/update_product',
                        data: {brand_id: $("#txteditbrandid option:selected").val(), id_business_products: $("#txteditbusinessproductid").val(), category: $("#txteditbusinesscategory").val(), product: $("#txteditproduct").val(), sku: $("#txteditsku").val(), commission: $("#txteditcommission").val(), barcode: $("#txteditbarcode").val(), price: $("#txteditprice").val(), purchase_price: $("#txteditpurchaseprice").val(), measurement_unit: $("#txteditmeasurementunit option:selected").val(), business_product_active: $("#txteditproductactive :selected").val(),unit_type: $('#txteditunittype option:selected').val(),qty_per_unit: $('#txteditqtyperunit').val(),professional: $('#txteditprofessional option:selected').val(), threshold: $('#txteditthreshold').val()},
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