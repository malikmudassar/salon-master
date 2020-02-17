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
                <h4 class="page-title">Service Type</h4>
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
                                <th class="hidden">ID Service Type</th>
                                <th>Service Type Name</th>
                                <th>Active</th>
                                <th>Display Order</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($servicetype)) { foreach ($servicetype as $type){ ?>
                            <tr>
                                <td>
                                    <a title="<?php echo $type['service_type']; ?>" onclick="upload_image('<?php echo $type['id_service_types']; ?>', '<?php echo $type['service_type_image'] ? $type['service_type_image'] : NULL; ?>')" href="javascript:void(0)">
                                        <img width="50px;" src="<?php echo base_url() . 'assets/images/servicetype/'; ?><?php echo $type['service_type_image'] ? $type['service_type_image'] : "nu.jpg"; ?>" alt="<?php echo $type['service_type'] ?>"/>
                                    </a>
                                </td>
                                <td class="hidden"><?php echo $type['id_service_types']; ?></td>
                                <td><?php echo $type['service_type']; ?></td>
                                <td><span class="label <?php if($type['service_type_active']==="Yes"){echo 'label-pink';}else{ echo 'label-inverse'; } ?> "><?php echo $type['service_type_active']; ?></span></td>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <input class="form-control" size="2" type="text" name="orderid" id="orderid" onblur="orderservicetype('<?php echo $type['id_service_types']; ?>', this.value);" value="<?php echo $type['order_id']; ?>" />
                                        </div>
                                    </div>
                                </td>
                                <td class='noprint' > 
                                    <div style="display:inline;">
                                        <a href="<?php echo base_url('service_categories'); ?>/<?php echo $type['id_service_types']; ?>" class="btn btn-warning waves-effect waves-light m-b-5"> 
                                            <i class="fa fa-cloud m-r-5"></i> <span> Category </span> 
                                        </a>
                                    </div>
                                    <button id='btnedit' onclick="openupdate(<?php echo $type['id_service_types']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> </td>
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
        <div id="addservicetype" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addservicetype" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Service Type</h4>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtservicetype" class="control-label">Service Type Name</label>
                                    <input type="text" class="form-control" placeholder="Service Type Name" id="txtservicetype" name="txtservicetype">
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
        <div id="editservicetype" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editservicetype" aria-hidden="true" style="display: none;">
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
                                    <label for="txteditservicetypeid" class="control-label">ID</label>
                                    <input readonly="readonly" type="text" class="form-control" id="txteditservicetypeid" name="txteditservicetypeid">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditservicetype" class="control-label">Service Type Name</label>
                                    <input type="text" class="form-control" placeholder="Service Type Name" id="txteditservicetype" name="txteditservicetype">
                                </div> 
                            </div> 
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditservicetypeactive" class="control-label">Active</label>
                                    <select class="form-control" id="txteditservicetypeactive" name="txteditservicetypeactive">
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
            <form action="<?php echo base_url('servicetypeimage'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add Type Image</h4>
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
                                                <label for="service_type_image" class="control-label">Type Image</label>
                                                <input class="form-control" type="file" id="service_type_image" name="service_type_image" />
                                                <input type="hidden" name="org_image" id="org_image" />
                                                <input type="hidden" name="id_service_type_image" id="id_service_type_image" />
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
                
            });
            
            function orderservicetype(id, orderid){
                var type = "servicetype";
                
                if(id && orderid){
                    $.ajax({
                        type: 'POST',
                        url: 'service_controller/order_function',
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
                //alert('ok');
                $("#addservicetype").modal('show');
            }
            function addnew(){
                if($("#txtservicetype").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: 'service_controller/add_service_type',
                        data: {service_type: $("#txtservicetype").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Service Type Added');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            
            function openupdate(id_service_types){
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>service_controller/edit_service_types',
                    data: {id_service_types: id_service_types},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        
                        $("#txteditservicetypeid").val(data.id_service_types);
                        $("#txteditservicetype").val(data.service_type);
                        $("#txteditservicetypeactive").val(data.service_type_active);

                        $("#editservicetype").modal('show');
                        
                    }
                });
            }
            function update(){
                if($("#txteditservicecategory").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: 'service_controller/update_service_type',
                        data: {id_service_types: $("#txteditservicetypeid").val(), service_type: $("#txteditservicetype").val(), service_type_active: $("#txteditservicetypeactive :selected").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Service Type Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            function upload_image(id_service_type, image) {
                image = image || null;
                if (id_service_type && id_service_type != null) {
                    $("#org_image").val('');
                    $("#id_service_type_image").val('');
                    $("#id_service_type_image").val(id_service_type);
                    if (image && image != null) {
                        $("#org_image").val(image);
                        $("#msg #img").attr('src', 'assets/images/servicetype/' + image);
                    } else {
                        $("#msg #img").attr('src', 'assets/images/category/nu.jpg');
                    }
                    $("#addtypeimage").modal("show");
                }
            }
            

        </script>