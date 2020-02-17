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
               
                <h4 class="page-title">Dispatch List</h4>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="dispatch_product" class="control-label">Select Product</label>
                    <input type="text" class='form-control' onchange="getproduct();" id="dispatch_product" name="dispatch_product"  placeholder="Brand Product Category . . .">
                    <!--<select class='form-control' id="dispatch_product" name="order-products" > </select>-->
                    
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="dispatch_staff" class="control-label">Dispatch To</label>
                    <select class='form-control'  id="dispatch_staff" name="dispatch_staff"> 
                        <?php foreach($staff as $s){?>
                        <option value="<?php echo $s['id_staff'];?> "><?php echo $s['staff_fullname'];?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                 <div class="form-group">
                    <label for="" class="control-label">Select Action</label>
                    <div>
                        <input type="hidden" value="" id="txt_product_id"/><input type="hidden" value="" id="txt_product_name"/><input type="hidden" value="" id="txt_available_stock"/>
                        <input type="hidden" value="" id="txt_batch_id"/><input type="hidden" value="" id="txt_batch"/><input type="hidden" value="" id="txt_unit_type"/><input type="hidden" value="" id="txt_measure_unit"/><input type="hidden" value="" id="txt_qty_per_unit"/>
                        <button onclick="check_history();" class="btn btn-pink  waves-effect waves-light m-r-5"><i class="ti-ruler"></i> Check History</button>
                        <button onclick="openaddnew();"  class="btn btn-primary  waves-effect waves-light m-r-5"><i class="ti-paint-bucket"></i> Dispatch Now</button>
                        <div class="checkbox checkbox-primary">
                            <form id='showoutofstockform' method='post' action='<?php echo base_url('dispatch'); ?>'>
                                <input type="hidden" name="csrf_test_name" id="cd_csrf" value=""/>
                                <input id="showoutofstock" name="showoutofstock" type="checkbox" <?php if($showoutofstock=="Yes"){ echo 'checked="checked"';}?>  onchange="submit_form();">
                                <label for="showoutofstock">
                                    Show Out of Stock Batches
                                </label>
                            </form>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="col-md-6">
                    <label class="inline">Product:</label>
                    <input class="form-control" style="border:none; background-color:transparent;" id="txtproductname">
                </div>
                <div class="col-md-6">
                    <label class="inline">In Stock:</label>
                    <input class="form-control" style="border:none; background-color:transparent;" id="txtinstock">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Staff</th>
                                <th>Product</th>
                                <th>Batch</th>
                                <th>Dispatch Qty</th>
                                <th>Dispatch Measure</th>
                                <th>Measure Unit</th>
                                <th>Unit Type</th>
                                <th>Comment</th>
                                <th>Dispatch Date</th>
                                <th class='noprint'>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
        <!--Modals-->
        <!--Add Service  Modal-->
        <div id="adddispatch" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="adddispatch" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Dispatching . . .</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                   <label for="addproduct" id="span_product" class="control-label text-primary">Product Name</label> <label id="span_staff" class="control-label text-primary">Staff Name</label>
                                </div> 
                            </div> 

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="adddate" class="control-label">Date</label>
                                            <input type="text" class="form-control" placeholder="Date" id="adddate" name="adddate">
                                        </div> 
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="stock" class="control-label">Available Stock  </label>
                                            <input readonly type="text" class="form-control" placeholder="Available Stock" id="stock" name="stock">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="addunitqty" class="control-label">If you are dispatching whole <span class="unit_type"></span>/s then add the number of <span class="unit_type"></span>s here: <i class="ti-arrow-down text-pink"></i></label>
                                            <input type="text" class="form-control numeric" placeholder="Whole Unit" id="addunitqty" name="addunitqty" onKeyUp="$('#addmeasureqty').val(''); if(parseInt(this.value) > parseInt($('#txtinstock').val())){this.value=parseInt($('#txtinstock').val());}else if(this.value<0){this.value=0;}" >
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="addmeasureqty" class="control-label">If you are dispatching <span class="measure_unit"></span>/s then add the <span class="measure_unit"></span>/s here: <i class="ti-arrow-down text-pink"></i> </label>
                                            <input type="text" class="form-control decimal" placeholder="Measured Qty" id="addmeasureqty" name="addmeasureqty" onKeyUp="$('#addunitqty').val(''); if(this.value > parseFloat($('#txt_qty_per_unit').val())*parseFloat($('#txtinstock').val())){this.value=parseFloat($('#txt_qty_per_unit').val())*parseFloat($('#txtinstock').val());} else if(this.value<0){this.value=0;}">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                     <div class="col-md-6">
                                         <div class="form-group">
                                             <label for="adddispatchcomment" class="control-label">Comment</label>
                                             <textarea class="form-control" id="adddispatchcomment" name="adddispatchcomment"></textarea>
                                         </div>
                                     </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                             <label for="adddispatchvisit" class="control-label">For Customer</label>
                                             <select class="form-control"  id="adddispatchvisit" name="adddispatchvisit">
                                                 <option value=""></option>
                                                 <?php foreach($todayvisits as $tv){?>
                                                 <option value="<?php echo $tv['id_customer_visits'];?>"><?php echo $tv['customer_name'];?></option>
                                                     
                                                 <?php }?>
                                             </select>
                                         </div>
                                     </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                            <button onclick="addnew();" id="btndispatchnow" type="button" class="btn btn-custom waves-effect waves-light">Save</button>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!--End Add Service  Modal-->

<script>
    $(document).ready(function() {

        $("#dispatch_product").select2({
            ajax: {
              url: '<?php echo base_url().'dispatch_controller/getproducts'; ?>',
              dataType: 'json',
              delay: 250,
              data: function (term, page) {
                  
                return {
                    productname: term, // search term
                    page_limit: 30, // page size
                    page: page, // page number
                    showoutofstock: '<?php echo $showoutofstock;?>'
                };
              },
              results: function (data, page) {
                  
                    var more = (page * 30) < data.length;
                    return {results: data, more: more};
                }
              },
            escapeMarkup: function (m) { return m; }, // let our custom formatter work
            minimumInputLength: 1,
            formatResult: function (option) {
                var type='Retail';
                if (option.professional=="y"){type = 'Pro';}
                return option.business_brand_name + ' - ' + option.product+ ' - ' + option.mcategory + ' - Batch: ' + option.batch + ' - Type: ' + type + ' ('+ option.business_store +': '+ option.instock+')';
            },
            formatSelection: function (option) {
                var type='Retail';
                if (option.professional=="y"){type = 'Pro';}
                return option.business_brand_name + ' - ' + option.product+ ' - ' + option.mcategory + ' - Batch: ' + option.batch + ' - Type: ' + type + ' ('+ option.business_store +': '+ option.instock+')';
            }
          });

         $("#dispatch_staff").select2();
        $('#datatable-buttons').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            stateSave: true,
            dom: "Bfrtlip",
            buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                    extend: "excel",
                    className: "btn-sm btn-warning btn-trans"
                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
            responsive: !0,
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

        
        $(".decimal").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 13 && e.which != 8 && e.which != 0  && e.which != 46 && (e.which < 48 || e.which > 57) ) {
                
                return false;
            }
        });

        $('#adddate').datepicker({
            default: today,
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        }).datepicker('setDate', new Date());



    });



    function check_history(){
        
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>dispatch_controller/check_history',
                data:{product_id: $("#txt_product_id").val(), staff_id:$("#dispatch_staff option:selected").val()},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                  
                    var mhtml='';
                    var today = new Date('<?php echo date('Y,m,d'); ?>');
                    for (x = 0; x < data.length; x++) {
                        var myd=data[x]['dispatch_date'].split("-");
                        var vdate=new Date(myd[0]+','+myd[1]+','+myd[2]);
                      
                        mhtml+="<tr>";
                        mhtml+="<td>"+data[x]['id_dispatch_note']+"</td>";
                        mhtml+="<td>"+data[x]['staff_fullname']+"</td>";
                        mhtml+="<td>"+data[x]['business_brand_name']+" "+data[x]['product'] +" "+data[x]['category'] + "</td>";
                        mhtml+="<td>"+data[x]['batch']+"</td>";
                        mhtml+="<td>"+data[x]['dispatch_qty']+"</td>";
                        if(parseFloat(data[x]['dispatch_measure'])>0){
                            mhtml+="<td>"+data[x]['dispatch_measure']+"</td>";
                        }else{
                            mhtml+="<td>"+parseFloat(data[x]['dispatch_qty'])*parseFloat(data[x]['qty_per_unit'])+"</td>";
                        }
                        mhtml+="<td>"+data[x]['measure_unit']+"</td>"; 
                        mhtml+="<td>"+data[x]['unit_type']+"</td>";
                        mhtml+="<td>"+data[x]['dispatch_comment']+"</td>";
                        mhtml+="<td>"+data[x]['d']+"</td>";
                       
                        mhtml+="<td class='noprint'> <button onclick='cancel_dispatch("+data[x]['id_dispatch_note'] +");' "+ (vdate < today ? 'style=\"display:none;\"' : '')+" class='btn btn-small btn-danger' id='btnedit"+data['id_dispatch_note']+"'>Cancel</button></td>";
                       // mhtml+="<td class='noprint'> <button onclick='cancel_dispatch("+data[x]['id_dispatch_note'] +");' class='btn btn-small btn-danger' id='btnedit"+data['id_dispatch_note']+"'>Cancel</button></td>";
                        mhtml+="</tr>";
                    }
                    $("#datatable-buttons").dataTable().fnDestroy();
                    $("#datatable-buttons tbody").html('');
                    $("#datatable-buttons tbody").append(mhtml);
                    //$("#datatable-buttons tfoot").html('');

                    $('#datatable-buttons').DataTable({
                        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                       fixedHeader: {header: true},
                        dom: "Bfrtlip",
                        buttons: [{extend: "copy", className: "btn-sm"}, {extend: "csv", className: "btn-sm"}, {
                                extend: "excel",
                                className: "btn-sm"
                            }, {extend: "pdf", className: "btn-sm"}, {extend: "print", className: "btn-sm"}],
                        responsive: 0,
                        order: [[ 5, "Asc" ]]
                    });
                }
                
        });
    
    }

    function getproduct(){
        r = $("#dispatch_product").val().split(',');
        //console.log(r);
        var product_id = parseInt(r[0]);
        var in_stock = parseFloat(r[1]);
        var product_name = r[2].trim();
        var category = r[3].trim();
        var batch = r[4].trim();
        var batch_id = parseInt(r[5]);
        var unit_type = r[6].trim();
        var measure_unit = r[7].trim();
        var qty_per_unit = parseFloat(r[8]);
        
        $("#txtproductname").val(r[2].trim());
        $("#txtinstock").val(parseFloat(r[1]));
        
        $("#txt_product_id").val(product_id);
        $('#txt_product_name').val(product_name);
        $('#txt_batch').val(batch);
        $('#txt_batch_id').val(batch_id);
        $('#txt_unit_type').val(unit_type);
        $('#span_measure_unit').html(measure_unit);
        $('#txt_measure_unit').val(measure_unit);
        $('#txt_available_stock').val(in_stock);
        $('#span_qty_per_unit').html(qty_per_unit);
        
        $('#txt_qty_per_unit').val(qty_per_unit);
    }



    function cancel_dispatch(dispatch_note_id) {

        //Warning Message
        swal({
            title: "Are you sure?",
            text: "This action will cancel this dispatch!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-warning',
            confirmButtonText: "Yes, cancel it!",
            closeOnConfirm: true
        }, function() {
            $.ajax({
                type: 'POST',
                url: 'dispatch_controller/cancel_dispatch',
                data: {dispatch_note_id: dispatch_note_id},
                success: function(data) {

                    var result = data.split("|");

                    if (result[0] === "success") {
                        remaining=parseFloat($("#txtinstock").val()) + parseFloat(result[1]);
                        $("#txtinstock").val(remaining);
                        swal("Cancelled!", "Dispatch has been cancelled.", "success");
                        check_history();
                    } else {
                        swal("Error!", "Dispatch was not cancelled!.", "error");
                    }
                }
            });
        });
    }

    function openaddnew() {
        
        
        $("#addunitqty").val('');
        $("#addmeasureqty").val('');
        $("#adddispatchcomment").val('');
        $("#adddispatchvisit ").val('');
        
        $("#btndispatchnow").show();
        if($("#txt_product_id").val() !=="" && parseFloat($("#txt_available_stock").val())>0){
            $("#stock").val($("#txtinstock").val() +' ' + $("#txt_unit_type").val()+'/s');
            $(".unit_type").html($("#txt_unit_type").val());
            $(".measure_unit").html($("#txt_measure_unit").val());
            $("#addmeasureqty").attr('placeholder', $("#txt_measure_unit").val());
            $("#addunitqty").attr('placeholder', $("#txt_unit_type").val()+'s');
            
            
            $("#span_product").html($('#txt_product_name').val() + " " + $("#txt_qty_per_unit").val() + " " + $("#txt_measure_unit").val() + " " + "  <i style='font-weight:bold' class='ti-share text-pink'></i>  ");
            $("#span_staff").html($('#dispatch_staff option:selected').text());
            $("#adddispatch").modal('show');
        }else{
            swal("No Stock!", "0 Items in stock can not be Dispatched!", "error");
        }
    }
    
    function addnew(){
        // console.log($("#adddispatchcomment").val());
        //console.log($("#adddispatchvisit option:selected").val());
        //return false;
        $("#btndispatchnow").hide();
        if($("#addunitqty").val() !== '' || $("#addmeasureqty").val() !== ''){
            
             $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>dispatch_controller/add_dispatch',
                data: {
                    product_id: $("#txt_product_id").val(),
                    dispatch_to_staff: $("#dispatch_staff option:selected").val(),
                    dispatch_unit:$("#addunitqty").val(),
                    dispatch_measure:$("#addmeasureqty").val(),
                    unit_type:$("#txt_unit_type").val(),
                    measure_unit:$("#txt_measure_unit").val(),
                    dispatch_date: $('#adddate').val(),
                    batch: $('#txt_batch').val(),
                    batch_id: $('#txt_batch_id').val(),
                    qty_per_unit:$('#txt_qty_per_unit').val(),
                    dispatch_comment:$("#adddispatchcomment").val(),
                    visit_id:$("#adddispatchvisit option:selected").val()
                },
                success: function(data) {
                    var result = data.split("|");
                    if (result[0] === "success") {
                        var dispatchqty=result[1];
                        var remaining = parseFloat($("#txtinstock").val())-parseFloat(dispatchqty);
                        $("#txtinstock").val(remaining);
                        $("#addunitqty").val('');
                        $("#addmeasureqty").val('');
                        toastr.success(data, 'Item Dispatched');
                        $("#adddispatch").modal('hide');
                        check_history();
                    }
                }
            });
            
        }
    
    }
    
    function submit_form(){
        $('#cd_csrf').val($('#cook').val());     
        $("#showoutofstockform").submit();
    }

</script>