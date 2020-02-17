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
                <h4 class="page-title" >Color Types</h4>
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
                                <th>Types</th>
                                <th>Active</th>
                                <th>Display Order</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($color_type_list)) { foreach ($color_type_list as $list){ ?>
                            <tr>
                                <td class="hidden"><?php echo $list['id']; ?></td>
                                <td><?php echo $list['type']; ?></td>
                                <td><span class="label <?php if($list['status']==="Yes"){echo 'label-pink';}else{ echo 'label-inverse'; } ?> "><?php echo $list['status']; ?></span></td>
                                <td>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <input class="form-control"  size="2" type="text" name="orderid" id="orderid" onchange="orderservicetype('<?php echo $list['id']; ?>', this.value);" value="<?php echo $list['order_id']; ?>" />
                                        </div>
                                    </div>
                                </td>
                                <td class='noprint' > 
                                    <form method="Post" action="<?php echo base_url('color_number');?>" style="display:inline">
                                        <input type="hidden" name="csrf_test_name" id="color_numner_csrf" value=""/>
                                        <input type="hidden" id="id_types" name="id_types" value="<?php echo $list['id'] ;?>">
                                        <button type="submit" onclick="$('#color_numner_csrf').val($('#cook').val());" class="btn btn-warning waves-effect waves-light m-b-5"> 
                                            <i class="fa fa-cloud m-r-5"></i> <span> Number </span> 
                                        </button> 
                                    </form>
                                    <button id='btnedit' onclick="openupdate(<?php echo $list['id']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button> 
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
        
        <!--Add Service Category Modal-->
        <div id="addlist" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addlist" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Color Type</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txttype" class="control-label">Type</label>
                                    <input type="text" class="form-control" placeholder="Color Type" id="txttype" name="txttype">
                                </div> 
                            </div> 
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtorderid" class="control-label">Order</label>
                                    <input class="vertical-spin" type="text" name="txtorderid" id="txtorderid"  />
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
        <div id="edittype" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="edit$list" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Color Type</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtedittypeid" class="control-label">ID</label>
                                    <input readonly="readonly" type="text" class="form-control" placeholder="ID" id="txtedittypeid" name="txtedittypeid">
                                </div> 
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtedittype" class="control-label">Type</label>
                                    <input type="text" class="form-control" placeholder="Color Type" id="txtedittype" name="txtedittype">
                                </div> 
                            </div> 
                        </div>
                         <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txteditstatus" class="control-label">Active</label>
                                    <select class="form-control" id="txteditstatus" name="txteditstatus">
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
                var type = "colortype";
                
                if(id && orderid){
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>/service_controller/order_function',
                        data:{id: id, orderid: orderid, type: type},
                        success: function(data){
                            //toastr.success(data, 'Order changed');
                            location.reload();
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
                $("#addlist").modal('show');
            }
            function addnew(){
                if($("#txttype").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: 'colors_controller/add_color_type',
                        data: {type: $("#txttype").val(), orderid: $('#txtorderid').val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Color Type Added');
                                location.reload();
                            }
                        }
                    });
                }
            }
            
            
            function openupdate(id){
                
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>colors_controller/edit_color_types',
                    data: {id_color_type: id},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $("#txtedittypeid").val(id);
                        $("#txtedittype").val(data.type);
                        $("#txteditstatus").val(data.status);

                        $("#edittype").modal('show');
                        
                    }
                });
            }
            function update(){
                if($("#txtedittype").val()!== ""){
                $.ajax({
                        type: 'POST',
                        url: 'colors_controller/update_color_type',
                        data: {id_type: $("#txtedittypeid").val(), type: $("#txtedittype").val(), status: $("#txteditstatus :selected").val()},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Color Type Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
       
        </script>