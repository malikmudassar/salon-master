
<style type="text/css">
    @media print
    {
        .noprint {display:none;}
    }
    
    .input-sm {
        width:100px !important;
    }
</style>
<div class="wrapper">
    <div class="container" style="width:100%">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="btn-group pull-right m-t-15">
                    
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
                    <div class="row m-b-30">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <div class="table-container"  >
                            <div class="table-actions-wrapper ">
                                
                            </div>
                        <table id="loadedlist" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="max-width:100% !important">
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th >Brand</th>
                                    <th >Product Name</th>                                    
                                    <th >Type</th>                               
                                    <th >Price</th>                                    
                                                                   
                                    <th >Unit Type</th>
                                    <th >Measure Unit</th>
                                    <th >Quantity per unit</th>
                                    <th >Active</th>
                                    <th >SKU</th>
                                    <th >Barcode</th>
                                    <th  class='noprint'>Action</th>
                                </tr>
                                <tr role="row" class="filter">
                                    <th ></th>
                                    <th >
                                        <select type="text" class="form-control form-filter input-sm" name="brand" id="brand">
                                            <option value="">All</option>
                                            <?php foreach($brands as $brand){?>
                                            <option value="<?php echo $brand['id_business_brands'];?>"><?php echo $brand['business_brand_name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th ><input type="text" class="form-control form-filter input-sm" name="product"></th>
                                   
                                    <th >
                                        <select type="text" class="form-control form-filter input-sm" name="professional" id="professional">
                                            <option value="">All</option>
                                            <option value="y">Professional</option>
                                            <option value="n">Retail</option>
                                        </select>
                                    </th>                               
                                    <th > </th>     
                                     
                                    <th > </th>
                                    <th > </th>
                                    <th >  </th>
                                    <th >
                                        <select type="text" class="form-control form-filter input-sm" name="business_product_active" id="business_product_active">
                                            <option value="">All</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </th>
                                    <th ><input type="text"  class="form-control form-filter input-sm" name="sku"></th>
                                    <th ><input type="text"  class="form-control form-filter input-sm" name="barcode_products"></th>
                                    <th >
                                            <div class="margin-bottom-5">
                                                <button class="btn btn-sm teal-500 filter-submit margin-bottom"><i class="icon-magnifier"></i> Search</button>
                                            </div>
                                            <button class="btn btn-sm orange-500 filter-cancel"><i class="icon-refresh"></i> Reset</button>
                                        </th>
                                </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    </div>
                    <!-- end list table -->
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
                                                <option value="Bottle">Bottle</option>
                                                <option value="Jar">Jar</option>
                                                <option value="Drum">Drum</option>
                                                <option value="Tube">Tube</option>
                                                <option value="sachet">Sachet</option>
                                                 <option value="box">Box</option>
                                                <option value="other">other</option>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtsku" class="control-label">SKU</label>
                                            <input type="text" class="form-control" placeholder="Product SKU" id="txtsku" name="txtsku">
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditsku" class="control-label">SKU</label>
                                            <input type="text" class="form-control" placeholder="SKU" id="txteditsku" name="txteditsku">
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
      
<script src="<?php echo base_url(); ?>assets/js/datatable.js"></script>

        <script>
            $(document).ready(function() {


            productlist.init();


//                $('#datatable-buttons').DataTable({
//                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
//                    stateSave: true,
//                    dom: "Bfrtlip",
//                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
//                            extend: "excel",
//                            className: "btn-sm btn-warning btn-trans"
//                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
//                    responsive: !0
//                });


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
                
            });


        var productlist = function () {
          var initPickers = function () {
            //init date pickers
                $('.date-picker').datepicker({
                    autoclose: true
                });
            }

            var handleProducts = function () {
                var grid = new Datatable();

                grid.init({
                    src: $("#loadedlist"),
                    onSuccess: function (grid) {
                        // execute some code after table records loaded
                    },
                    onError: function (grid) {
                        // execute some code on network or other general error  
                    },
                    loadingMessage: 'Loading...',
                    dataTable: {// here you can define a typical datatable settings from http://datatables.net/usage/options 
                        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: js/datatable.js). 
                        // So when dropdowns used the scrollable div should be removed. 
                        "dom": "<'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>Bt<'row'<'col-md-12 col-sm-12'><'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'p><'col-md-12 col-sm-12'i>>",
                        //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 text-right col-sm-12'p>>",

                       
                        "lengthMenu": [
                            [10, 20, 50, 100, 150, -1],
                            [10, 20, 50, 100, 150, "All"] // change per page values here
                        ],
                        "pageLength": 10, // default record count per page
                        "pagingType": "full_numbers",
                        "stateSave":"true",
                        "ajax": {
                            "url": "<?php echo base_url(); ?>product_controller/get_productsbysearch" // ajax source
                        },
                        "order": [
                            [1, "desc"]
                        ], // set first column as a default sort by asc
                        "columns": [
                           
                            {"data": "id_business_products"},
                            {"data": "business_brand_name"},
                            {"data": "product"},
                            {"data": "professional", "class": "text-success"},
                            {"data": "price"},                            
                                                       
                            {"data": "unit_type"},
                            {"data": "measure_unit"},
                            {"data": "qty_per_unit"},
                            {"data": "business_product_active", "class": "text-success"},
                            {"data": "sku"},
                            {"data": "barcode_products"},
                            {"data": "action"}
                        ],
                        //"columnDefs": [{"sortable": false, "targets": 2}]
                        buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}]
                    }
                });


                // handle group actionsubmit button click
                grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
                    e.preventDefault();
                    var action = $(".table-group-action-input", grid.getTableWrapper());
                    if (action.val() !== "" && grid.getSelectedRowsCount() > 0) {
                        grid.setAjaxParam("customActionType", "group_action");
                        grid.setAjaxParam("customActionName", action.val());
                        grid.setAjaxParam("id", grid.getSelectedRows());
                        grid.getDataTable().ajax.reload();
                        grid.clearAjaxParams();
                    } else if (action.val() == "") {
                        swal({
                            title: "Please select an action",
                            text: "",
                            type: "warning",
                            confirmButtonText: 'OK!'
                        });
                        
                    } else if (grid.getSelectedRowsCount() === 0) {
                         swal({
                            title: "No record selected",
                            text: "",
                            type: "danger",
                            confirmButtonText: 'OK!'
                        });
                    }
                });
            }
            return {
                //main function to initiate the module
                init: function () {

                    initPickers();
                    handleProducts();
                }

            };

        }();



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
                        data: {brand_id: $("#txtbrandid option:selected").val(), category: $("#txtbusinesscategory").val(), product: $("#txtbusinessproduct").val(), sku: $("#txtsku").val(), barcode: $("#txtbarcode").val(),price: $("#txtprice").val(), purchase_price: $("#txtpurchaseprice").val(), measurement_unit: $("#txtmeasurementunit option:selected").val(),unit_type: $('#txtunittype option:selected').val(),qty_per_unit: $('#txtqtyperunit').val(), professional: $('#txtprofessional option:selected').val(), threshold: $('#txtthreshold').val()},
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
                        data: {brand_id: $("#txteditbrandid option:selected").val(), id_business_products: $("#txteditbusinessproductid").val(), category: $("#txteditbusinesscategory").val(), product: $("#txteditproduct").val(), sku: $("#txteditsku").val(), barcode: $("#txteditbarcode").val(), price: $("#txteditprice").val(), purchase_price: $("#txteditpurchaseprice").val(), measurement_unit: $("#txteditmeasurementunit option:selected").val(), business_product_active: $("#txteditproductactive :selected").val(),unit_type: $('#txteditunittype option:selected').val(),qty_per_unit: $('#txteditqtyperunit').val(),professional: $('#txteditprofessional option:selected').val(), threshold: $('#txteditthreshold').val()},
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