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
                    <button type="button" onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    <button onclick="location.reload();" class="btn btn-pink waves-effect waves-light m-b-5"> <span>Refresh Order</span> <i class="fa fa-refresh m-l-5"></i> </button>
                </div>
                <h4 class="page-title" >Package Category in <?php echo isset($packages_category[0]['service_type']) ? $packages_category[0]['service_type'] : ""; ?></h4>
            </div>


        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">

                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="hidden">ID</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Business</th>
                                <th>Active</th>
                                <th>Display Order</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($packages_category[0]['service_category'])) {
                                foreach ($packages_category as $category) {
                                    ?>
                                    <tr>
                                        <td class="hidden"><?php echo $category['id_package_category']; ?></td>
                                        <td>
                                            <a title="<?php echo $category['service_category']; ?>" onclick="upload_image('<?php echo $category['id_package_category']; ?>', '<?php echo $category['service_category_image'] ? $category['service_category_image'] : NULL; ?>')" href="javascript:void(0)">
                                                <img width="50px;" src="<?php echo base_url() . 'assets/images/category/'; ?><?php echo $category['service_category_image'] ? $category['service_category_image'] : "nu.jpg"; ?>" alt="<?php echo $category['service_category'] ?>"/>
                                            </a>
                                        </td>
                                        <td><?php echo $category['service_category']; ?></td>
                                        <td><?php echo $category['business_name']; ?></td>
                                        <td><span class="label <?php
                                            if ($category['service_category_active'] === "Yes") {
                                                echo 'label-pink';
                                            } else {
                                                echo 'label-inverse';
                                            }
                                            ?> "><?php echo $category['service_category_active']; ?></span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <input class="form-control" size="2" type="text" name="orderid" id="orderid" onblur="orderservicetype('<?php echo $category['id_package_category']; ?>', this.value);" value="<?php echo $category['cat_order_id']; ?>" />
                                                </div>
                                            </div>
                                        </td>
                                        <td class='noprint' > 
                                            <div style="display:inline;">
                                                <a href="<?php echo base_url('ho_list_package_services'); ?>/<?php echo $category['id_package_category']; ?>" class="btn btn-warning waves-effect waves-light m-b-5"> 
                                                    <i class="fa fa-cloud m-r-5"></i> <span> Package Service </span> 
                                                </a>
                                            </div>
                                            <button id='btnedit' onclick="openupdate(<?php echo $category['id_package_category']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> Edit</button>
                                            <button id='btnduplicate' onclick="openduplicate(<?php echo $category['id_package_category']; ?>);" class="btn btn-icon waves-effect waves-light btn-pink m-b-5"> <i class="fa fa-copy"></i> Duplicate</button> 
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->

        <!--Add Service Category Modal-->
        <div id="addpackagecatmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addpackagecatmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Category in <?php echo isset($packages_category[0]['service_type']) ? $packages_category[0]['service_type'] : ""; ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="addpackagecat" class="control-label">Category</label>
                                    <input type="text" class="form-control" placeholder="Category" id="addpackagecat" name="addpackagecat">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="addpackagebusiness" class="control-label">Department/Business</label>
                                    <select  class="form-control" id="addpackagebusiness" name="addpackagebusiness">
                                        <?php foreach ($businesses as $business){?>
                                        <option value="<?php echo $business['id_business'];?>">
                                            <?php echo $business['business_name'];?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="addpackagestatus" class="control-label">Status</label>
                                    <select name="addpackagestatus" id="addpackagestatus" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
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
        <!--End Service Category Modal-->

        <!--Edit Service Category Modal-->
        <div id="editpackagecatmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editpackagecatmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Category in <?php echo isset($packages_category[0]['service_type']) ? $packages_category[0]['service_type'] : ""; ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="id_package_cat" class="control-label">ID</label>
                                    <input readonly="readonly" type="text" class="form-control" id="id_package_cat" name="id_package_cat">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editpackagecat" class="control-label">Category</label>
                                    <input type="text" class="form-control" placeholder="Category" id="editpackagecat" name="editpackagecat">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editpackagebusiness" class="control-label">Department/Business</label>
                                    <select disabled="disabled" class="form-control" id="editpackagebusiness" name="editpackagebusiness">
                                        <?php foreach ($businesses as $business){?>
                                        <option value="<?php echo $business['id_business'];?>">
                                            <?php echo $business['business_name'];?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="editpackagestatus" class="control-label">Status</label>
                                    <select name="editpackagestatus" id="editpackagestatus" class="form-control">
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
        <!--End Edit Service Category Modal-->

        <!--start upload image-->
        <div id="addtypeimage" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addtypeimage" aria-hidden="true" style="display: none;">
            <form action="<?php echo base_url('ho_list_package_category/image'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add Package Category Image</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div id="msg">
                                                    <img id="img" width="100px;" src="" />
                                                </div>
                                                <label for="package_cat_image" class="control-label">Type Image</label>
                                                <input class="form-control" type="file" id="package_cat_image" name="package_cat_image" />
                                                <input type="hidden" name="org_image" id="org_image" />
                                                <input type="hidden" name="id_package_cat_image" id="id_package_cat_image" />
                                                <input type="hidden" name="id_package_type_image" id="id_package_type_image" value="<?php echo $packages_category[0]['package_type_id'] ?>" />
                                            </div> 
                                        </div> 
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-custom waves-effect waves-light">Save</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </form>
        </div>
        <!--end upload image-->

        
        <!--Duplicate Category Modal-->
        <div id="duplicatecatmodal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="duplicatecatmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Duplicate this Category in <?php echo isset($packages_category[0]['service_type']) ? $packages_category[0]['service_type'] : ""; ?></h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" readonly="readonly" class="form-control"  id="idduplicatecategory" name="idduplicatecategory">
                                    <label for="addpackagecat" class="control-label">Enter New Category Name</label>
                                    <input type="text" class="form-control" placeholder="Category" id="duplicatecatname" name="duplicatecatname">
                                </div> 
                            </div> 
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="button" onclick ="duplicate_category();"class="btn btn-custom waves-effect waves-light">Save</button>
                    </div>
                </div>
            </div>
        </div>
        
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
                    responsive: !0,
                    "aoColumns": [
                        null,
                        null,
                        null,
                        null,
                        null,
                        {"orderSequence": ["asc"]},
                        null
                    ]
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

            function orderservicetype(id, orderid) {
                var type = "packagecat";

                if (id && orderid) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>packages_controller/order_function',
                        data: {id: id, orderid: orderid, type: type},
                        success: function(data) {
                            toastr.success(data, 'Display Order has been updated!');
                            //location.reload();
                        }
                    });
                }
            }

            function deletecategory(catid) {

                //Warning Message
                swal({
                    title: "Are you sure?",
                    text: "This action will also remove all services in this category!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-warning',
                    confirmButtonText: "Yes, remove it!",
                    closeOnConfirm: true
                }, function() {
                    $.ajax({
                        type: 'POST',
                        url: 'service_controller/delete_category',
                        data: {id_service_category: catid},
                        success: function(data) {
                            var result = data.split("|");

                            if (result[0] === "success") {
                                swal("Deleted!", "Service Category and all its Services have been removed.", "success");
                                location.reload();
                            } else {
                                swal("Error!", "Service Category was not removed!.", "error");
                            }
                        }
                    });
                });
            }

            function openaddnew() {
                //alert('ok');
                $("#addpackagecatmodal").modal('show');
            }
            function addnew() {
                if ($("#addpackagecat").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>ho_controller/add_package_category',
                        data: {
                            service_category: $("#addpackagecat").val(),
                            service_category_active: $("#addpackagestatus :selected").val(),
                            business_id: $("#addpackagebusiness :selected").val(),
                            package_type_id: '<?php echo $package_type_id; ?>'
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Package Category Added');
                                location.reload();
                            }
                        }
                    });
                }
            }
            

            function openupdate(id_package_category) {

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>ho_controller/edit_package_category',
                    data: {id_package_category: id_package_category},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        
                        $("#id_package_cat").val(id_package_category);
                        $("#editpackagecat").val(data.service_category);
                        $("#editpackagebusiness").val(data.business_id);
                        $("#editpackagestatus").val(data.service_category_active);

                        $("#editpackagecatmodal").modal('show');
                        
                    }
                });
            }
            function update() {
                if ($("#editpackagecat").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>packages_controller/update_package_category',
                        data: {
                            id_package_category: $("#id_package_cat").val(),
                            service_category: $("#editpackagecat").val(),
                            service_category_active: $("#editpackagestatus :selected").val()
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Package Category Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }

            function upload_image(id_package_cat, image) {
                image = image || null;
                if (id_package_cat && id_package_cat != null) {
                    $("#org_image").val('');
                    $("#id_package_cat_image").val('');
                    $("#id_package_cat_image").val(id_package_cat);
                    if (image && image != null) {
                        $("#org_image").val(image);
                        $("#msg #img").attr('src', '<?php echo base_url(); ?>assets/images/category/' + image);
                    } else {
                        $("#msg #img").attr('src', '<?php echo base_url(); ?>assets/images/category/nu.jpg');
                    }
                    $("#addtypeimage").modal("show");
                }
            }

            function openduplicate(id_package_category){
                if (id_package_category && id_package_category !== null) {
                    $("#idduplicatecategory").val(id_package_category);
                    $("#duplicatecatmodal").modal("show");
                }
            }
            
            function duplicate_category(){
                 if ($("#idduplicatecategory").val() !== "") {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>packages_controller/duplicate_package_category',
                        data: {
                            id_package_category: $("#idduplicatecategory").val(),
                            service_category: $("#duplicatecatname").val()
                           
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data+' services added', 'Package Category Duplicated');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
        </script>