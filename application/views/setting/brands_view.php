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
                <h4 class="page-title" >Product Brands</h4>
            </div>
            
            
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th >ID Brand</th>
                                <th>Brand Name</th>
                                <th>Abbreviation</th>
                                <th>Website</th>
                                <th>Active</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($brands)) { foreach ($brands as $brand){ ?>
                            <tr>
                                <td ><?php echo $brand['id_business_brands']; ?></td>
                                <td><?php echo $brand['business_brand_name']; ?></td>
                                <td><?php echo $brand['business_brand_short']; ?></td>
                                <td><?php echo $brand['business_brand_website']; ?></td>
                                <td><span class="label <?php if($brand['business_brand_active']==="Yes"){echo 'label-pink';}else{ echo 'label-inverse'; } ?> "><?php echo $brand['business_brand_active']; ?></span></td>
                                <td class='noprint' > 
                                    
                                    <input type="hidden" id="id_business_brands" name="id_business_brands" value="<?php echo $brand['id_business_brands'] ;?>">
                                    <a href="<?php echo base_url();?>product_list/all/<?php echo $brand['id_business_brands']; ?>" class="btn btn-warning waves-effect waves-light m-b-5"> 
                                        <i class="fa fa-cloud m-r-5"></i> <span> Products </span> 
                                    </a> 
                                    
                                    <button id='btnedit' onclick="openupdate(<?php echo $brand['id_business_brands']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
        
        <!--Modals-->
        
        <!--Add Brand Modal-->
        <div id="addbusinessbrand" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addbusinessbrand" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Brand</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtbusinessbrand" class="control-label">Brand Name</label>
                                    <input type="text" class="form-control" placeholder="Brand Name" id="txtbusinessbrand" name="txtbusinessbrand">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtbrandshort" class="control-label">Abbreviation</label>
                                    <input type="text" class="form-control" placeholder="Brand Short" id="txtbusinessbrand" name="txtbrandshort">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtbrandwebsite" class="control-label">Website</label>
                                    <input type="text" class="form-control" placeholder="Brand Website" id="txtbrandwebsite" name="txtbrandwebsite">
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
        <!--End Brand Modal-->
        
        <!--Edit Brand Modal-->
        <div id="editbusinessbrand" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editbusinessbrand" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Brand</h4>
                    </div>
                    <div class="modal-body">
                        
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditbrandname" class="control-label">Brand Name</label>
                                    <input type="hidden" id="txteditbusinessbrandid">
                                    <input type="text" class="form-control" placeholder="Brand Name" id="txteditbrandname" name="txteditbrandname">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditbrandshort" class="control-label">Abbreviation</label>
                                    <input type="text" class="form-control" placeholder="Brand Name" id="txteditbrandshort" name="txteditbrandshort">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditbrandwebsite" class="control-label">Website</label>
                                    <input type="text" class="form-control" placeholder="Brand Website" id="txteditbrandwebsite" name="txteditbrandwebsite">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditbrandactive" class="control-label">Active</label>
                                    <select class="form-control" id="txteditbrandactive" name="txteditbrandactive">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                    
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
        <!--End Brand Modal-->
        
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

            function deletebrand(brandid){
                
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
                        url: 'product_controller/delete_brand',
                        data: {id_business_brands: brandid},
                        success: function(data) {
                            var result = data.split("|");
                            
                            if (result[0] === "success") {
                                swal("Deleted!", "Brand and all its Products have been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Brand was not removed!.", "error");
                            }
                        } 
                    });
                });
            }
            
            function openaddnew(){
                $("#addbusinessbrand").modal('show');
            }
            function addnew(){
                if($("#txtbusinessbrand").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>product_controller/add_brand',
                        data: {business_brand_name: $("#txtbusinessbrand").val(), business_brand_short: $("#txtbrandshort").val(), business_brand_website: $("#txtbrandwebsite").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Brand Added');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            
            function openupdate(id_business_brands){
                
                
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>product_controller/edit_brand',
                    data: {id_business_brands: id_business_brands},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        
                        $("#txteditbusinessbrandid").val(data.id_business_brands);
                        $("#txteditbrandname").val(data.business_brand_name);
                        $("#txteditbrandshort").val(data.business_brand_short);
                        $("#txteditbrandwebsite").val(data.business_brand_website);
                        $("#txteditbrandactive").val(data.business_brand_active);

                        $("#editbusinessbrand").modal('show');
                        
                    }
                });
            }
            function update(){
                if($("#txteditbusinessbrand").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>product_controller/update_brand',
                        data: {id_business_brands: $("#txteditbusinessbrandid").val(), business_brand_name: $("#txteditbrandname").val(), business_brand_short: $("#txteditbrandshort").val(), business_brand_website: $("#txteditbrandwebsite").val(), business_brand_active: $("#txteditbrandactive :selected").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Brand Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
            

        </script>