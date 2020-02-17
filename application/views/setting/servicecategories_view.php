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
                    <?php //if($this->input->post('id_service_types') && $this->input->post('id_service_types') != ""){ ?>
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    <button onclick="location.reload();" class="btn btn-pink waves-effect waves-light m-b-5"> <span>Refresh Order</span> <i class="fa fa-refresh m-l-5"></i> </button>
                    <?php //} ?>
                </div>
                <h4 class="page-title" >Service Categories in <?php echo $service_type->service_type; ?></h4>
            </div>
            
            
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                            	<th>Image</th>
                                <th class="hidden">ID Service Category</th>
                                <th>Service Category Name</th>
                                <th>Active</th>
                                <th>Display Order</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($servicecategories)) { foreach ($servicecategories as $servicecategory){ ?>
                            <tr>
                            	<td>
                                    <a onclick="upload_image('<?php echo $servicecategory['id_service_category']; ?>', '<?php echo $servicecategory['service_category_image'] ? $servicecategory['service_category_image'] : NULL; ?>')" href="javascript:void()">
                                        <img width="50px;" src="<?php echo base_url() . 'assets/images/category/'; ?><?php echo $servicecategory['service_category_image'] ? $servicecategory['service_category_image'] : "nu.jpg"; ?>" alt="<?php echo $servicecategory['service_category'] ?>"/>
                                    </a>
                                </td>
                                <td class="hidden"><?php echo $servicecategory['id_service_category']; ?></td>
                                <td><?php echo $servicecategory['service_category']; ?></td>
                                <td><span class="label <?php if($servicecategory['service_category_active']==="Yes"){echo 'label-pink';}else{ echo 'label-inverse'; } ?> "><?php echo $servicecategory['service_category_active']; ?></span></td>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <input class="form-control" size="2" type="text" name="orderid" id="orderid" onblur="orderservicetype('<?php echo $servicecategory['id_service_category']; ?>', this.value);" value="<?php echo $servicecategory['order_id']; ?>" />
                                        </div>
                                    </div>
                                </td>
                                <td class='noprint' > 
                                    <a href="<?php echo base_url('services'); ?>/<?php echo $servicecategory['id_service_category']; ?>" class="btn btn-warning waves-effect waves-light m-b-5"> 
                                        <i class="fa fa-cloud m-r-5"></i> <span> Services </span> 
                                    </a> 
                                    <!--</form>-->
                                    <button id='btnedit' onclick="openupdate(<?php echo $servicecategory['id_service_category']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> </td>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
        
        <!--Modals-->
        
        <!--Add Service Category Modal-->
        <div id="addservicecategory" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addservicecategory" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Service Category</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtservicecategory" class="control-label">Service Category Name</label>
                                    <input type="text" class="form-control" placeholder="Service Category Name" id="txtservicecategory" name="txtservicecategory">
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
        <div id="editservicecategory" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editservicecategory" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Service Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditservicecategoryid" class="control-label">ID</label>
                                    <input readonly="readonly" type="text" class="form-control" placeholder="Service Category Name" id="txteditservicecategoryid" name="txteditservicecategoryid">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditservicetype" class="control-label">Service Type</label>
                                    <select class="form-control" placeholder="Service Type" id="txteditservicetype" name="txteditservicetype">
                                        <?php foreach($service_types as $st){?>
                                        <option <?php if($st['id_service_types']==$service_type->id_service_types){echo "selected";}?> value="<?php echo $st['id_service_types'];?>"><?php echo $st['service_type'];?></option>
                                        <?php } ?>
                                    </select>
                                </div> 
                            </div> 
                        </div>                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditservicecategory" class="control-label">Service Category Name</label>
                                    <input type="text" class="form-control" placeholder="Service Category Name" id="txteditservicecategory" name="txteditservicecategory">
                                </div> 
                            </div> 
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditservicecategoryactive" class="control-label">Active</label>
                                    <select class="form-control" id="txteditservicecategoryactive" name="txteditservicecategoryactive">
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
        <div id="addcategoryimage" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addcategoryimage" aria-hidden="true" style="display: none;">
            <form action="<?php echo base_url('categoryimage'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add Category Image</h4>
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
                                                <label for="txtcategoryimage" class="control-label">Category Image</label>
                                                <input class="form-control" type="file" id="service_category_image" name="service_category_image" />
                                                <input type="hidden" name="org_image" id="org_image" />
                                                <input type="hidden" name="id_service_category_image" id="id_service_category_image" />
                                            </div> 
                                        </div> 
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <input type="hidden" name="id_service_type_image" id="id_service_type_image" value="<?php echo $idservice_type; ?>" />
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-custom waves-effect waves-light">Save</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </form>
        </div>
        <!--end upload image-->
        
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
                        { "orderSequence": [ "asc" ] },
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
                
                $(".vertical-spin").TouchSpin({
                    verticalbuttons: true,
                    buttondown_class: "btn btn-primary",
                    buttonup_class: "btn btn-primary",
                    verticalupclass: 'ti-plus',
                    verticaldownclass: 'ti-minus'
                });
                var vspinTrue = $(".vertical-spin").TouchSpin({
                    verticalbuttons: true
                });
                if (vspinTrue) {
                    $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
                }
                
            });
            
            function orderservicetype(id, orderid){
                var type = "servicecategory";
                
                if(id && orderid){
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>service_controller/order_function',
                        data:{id: id, orderid: orderid, type: type},
                        success: function(data){
                            toastr.success(data, 'Display Order has been updated!');
                            //location.reload();
                        }
                    });
                }
            }

            function deletecategory(catid){
                
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
            
            function openaddnew(){
                $("#addservicecategory").modal('show');
            }
            
            
            function addnew(){
                if($("#txtservicecategory").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>service_controller/add_category',
                        data: {service_category: $("#txtservicecategory").val(), service_type_id: <?php echo $idservice_type; ?>},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Service Category Added');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            
            function openupdate(id_service_category){
                
                
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>service_controller/edit_service_category',
                    data: {id_service_category: id_service_category},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        
                        $("#txteditservicecategoryid").val(data.id_service_category);
                        $("#txteditservicecategory").val(data.service_category);
                        $("#txteditservicecategoryactive").val(data.service_category_active);

                        $("#editservicecategory").modal('show');
                        
                    }
                });
            }
            
            function update(){
                if($("#txteditservicecategory").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>service_controller/update_category',
                        data: {id_service_category: $("#txteditservicecategoryid").val(), 
                            service_category: $("#txteditservicecategory").val(), 
                            service_category_active: $("#txteditservicecategoryactive :selected").val(), 
                            service_type_id: $("#txteditservicetype :selected").val()
                            
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Service Category Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            
            function upload_image(id_service_category, image) {
                image = image || null;
                if (id_service_category && id_service_category != null) {
                    $("#org_image").val('');
                    $("#id_service_category_image").val('');
                    $("#id_service_category_image").val(id_service_category);
                    if (image && image != null) {
                        $("#org_image").val(image);
                        $("#msg #img").attr('src', '<?php echo base_url(); ?>assets/images/category/' + image);
                    } else {
                        $("#msg #img").attr('src', '<?php echo base_url(); ?>assets/images/category/nu.jpg');
                    }
                    $("#addcategoryimage").modal("show");
                }
            }
            

        </script>