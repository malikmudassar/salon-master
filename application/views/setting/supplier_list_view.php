        <div class="wrapper">
            <div class="container">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="btn-group pull-right m-t-15">
                            <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add <span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                        </div>
                        <h4 class="page-title">Suppliers</h4>
                    </div>
                </div>
                
                 <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                            <table id="tblsupplier" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Supplier ID</th>
                                        <th>Supplier Name</th>
                                        <th>Contact Person</th>
                                        <th>Contact Number</th>
                                        <th>Office Phone</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Website</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($suppliers as $supplier){?>
                                    <tr>
                                        <td><?php echo $supplier['id_business_supplier']; ?></td>
                                        <td><?php echo $supplier['supplier_name']; ?></td>
                                        <td><?php echo $supplier['contact_person']; ?></td>
                                        <td><?php echo $supplier['contact_number']; ?></td>
                                        <td><?php echo $supplier['office_phone1']. ' ' . $supplier['office_phone2']; ?></td>
                                        <td><?php echo $supplier['ho_address']; ?></td>
                                        <td><?php echo $supplier['email']; ?></td>
                                        <td><?php echo $supplier['website']; ?></td>
                                        <td class='noprint'> 
                                            <button id='btnedit' onclick="openupdate(<?php echo $supplier['id_business_supplier']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end col -->
                </div>
                <!-- end row -->
                
                 <!--Modals-->
        
        <!--Add Supplier Modal-->
        <div id="addsupplier" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addsupplier" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Supplier</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtsuppliername" class="control-label">Supplier Name</label>
                                            <input type="text" class="form-control" placeholder="Supplier Name" id="txtsuppliername" name="txtsuppliername">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcontactnumber" class="control-label">Contact Number</label>
                                            <input type="text" class="form-control numeric" placeholder="Number of the Contact Person" id="txtcontactnumber" name="txtcontactnumber">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtofficephone2" class="control-label">Office Phone 2</label>
                                            <input type="text" class="form-control" placeholder="Office Phone 2" id="txtofficephone2" name="txtofficephone2">
                                        </div> 
                                    </div> 
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txthoaddress" class="control-label">HO Address</label>
                                            <input type="text" class="form-control" placeholder="Head office address" id="txthoaddress" name="txthoaddress">
                                        </div> 
                                    </div> 
                                </div>
                                
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtcontactperson" class="control-label">Contact Person</label>
                                            <input type="text" class="form-control" placeholder="Contact Person" id="txtcontactperson" name="txtcontactperson">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtofficephone1" class="control-label">Office Phone 1</label>
                                            <input type="text" class="form-control numeric" placeholder="Office Phone 1" id="txtofficephone1" name="txtofficephone1">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtwebsite" class="control-label">Web Site</label>
                                            <input type="text" class="form-control" placeholder="Web Site" id="txtwebsite" name="txtwebsite">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtemail" class="control-label">Email</label>
                                            <input type="text" class="form-control" placeholder="Email" id="txtemail" name="txtemail">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brandad1" class="control-label">Brand</label>
                                    <select class="form-control" name="brandad1" id="brandad1" multiple>
                                        <?php 
                                        if(isset($brands)){
                                        foreach ($brands as $brand){
                                        ?>
                                        <option value="<?php echo $brand['id_business_brands']; ?>"><?php echo $brand['business_brand_name']; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brandad2" class="control-label">&nbsp;</label>
                                    <select class="form-control" name="brandad2" id="brandad2" multiple></select>
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
        
        <!--Edit Supplier Modal-->
        <div id="editsupplier" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editsupplier" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Supplier</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditsuppliername" class="control-label">Supplier ID</label>
                                            <input type="text" class="form-control" placeholder="Supplier ID" readonly="readonly" id="txteditsupplierid" name="txteditsupplierid">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditsuppliername" class="control-label">Supplier Name</label>
                                            <input type="text" class="form-control" placeholder="Supplier Name" id="txteditsuppliername" name="txteditsuppliername">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcontactperson" class="control-label">Contact Person</label>
                                            <input type="text" class="form-control" placeholder="Contact Person" id="txteditcontactperson" name="txteditcontactperson">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditcontactnumber" class="control-label">Contact Number</label>
                                            <input type="text" class="form-control numeric" placeholder="Number of the Contact Person" id="txteditcontactnumber" name="txteditcontactnumber">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditofficephone1" class="control-label">Office Phone 1</label>
                                            <input type="text" class="form-control numeric" placeholder="Office Phone 1" id="txteditofficephone1" name="txteditofficephone1">
                                        </div> 
                                    </div> 
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditofficephone2" class="control-label">Office Phone 2</label>
                                            <input type="text" class="form-control numeric" placeholder="Office Phone 2" id="txteditofficephone2" name="txteditofficephone2">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditwebsite" class="control-label">Web Site</label>
                                            <input type="text" class="form-control" placeholder="Web Site" id="txteditwebsite" name="txteditwebsite">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtedithoaddress" class="control-label">HO Address</label>
                                            <input type="text" class="form-control" placeholder="Head office address" id="txtedithoaddress" name="txtedithoaddress">
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditemail" class="control-label">Email</label>
                                            <input type="text" class="form-control" placeholder="Email" id="txteditemail" name="txteditemail">
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brandad3" class="control-label">Brand</label>
                                    <select class="form-control" name="brandad3" id="brandad3" multiple>
                                        <?php 
                                        if(isset($brands)){
                                        foreach ($brands as $brand){
                                        ?>
                                        <option value="<?php echo $brand['id_business_brands']; ?>"><?php echo $brand['business_brand_name']; ?></option>
                                        <?php }} ?>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="brandad4" class="control-label">&nbsp;</label>
                                    <select class="form-control" name="brandad4" id="brandad4" multiple></select>
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
                
    <script type="text/javascript">
         $(document).ready(function() {

                $('#tblsupplier').DataTable({
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
                    if (e.which != 13 && e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                        return false;
                    }
                });
                
                //Two Select box for products insert moving....Start
                $('#brandad1').on('change', function() {
                    var val1 = $("#brandad1 option:selected").val();
                    var txt1 = $("#brandad1 option:selected").text();
                    
                    
                    $('#brandad2 option').each(function() {
                        if($(this).attr('value') == val1){
                            alert("already exist!");die;
                        }
                    });
                    
                    $('#brandad2').append('<option selected value="'+val1+'">'+txt1+'</opiton>');
     
                });
                $('#brandad2').on('click', function() {
                    $("#brandad2 option:selected").remove();
                    $('#brandad2').find('option').prop('selected',true);
                });
                //Two Select box for products insert moving....End
                
                //Two Select box for products insert moving....Start
                $('#brandad3').on('change', function() {
                    var val1 = $("#brandad3 option:selected").val();
                    var txt1 = $("#brandad3 option:selected").text();
                    
                    
                    $('#brandad4 option').each(function() {
                        if($(this).attr('value') == val1){
                            alert("already exist!");die;
                        }
                    });
                    
                    $('#brandad4').append('<option selected value="'+val1+'">'+txt1+'</opiton>');
     
                });
                $('#brandad4').on('click', function() {
                    $("#brandad4 option:selected").remove();
                    $('#brandad4').find('option').prop('selected',true);
                });
                //Two Select box for products insert moving....End
                
            });
  
        function openupdate(id_business_supplier){
                
            $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>supplier_controller/edit_supplier',
                    data: {id_business_supplier: id_business_supplier},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        var supplier = data['supplier'];
                        var supplier_brand = data['supplier_brand'];
                        
                        $("#txteditsupplierid").val(id_business_supplier);
                        $("#txteditsuppliername").val(supplier.supplier_name);
                        $("#txteditcontactperson").val(supplier.contact_person);
                        $("#txteditcontactnumber").val(supplier.contact_number);
                        $("#txteditofficephone1").val(supplier.office_phone1);
                        $("#txteditofficephone2").val(supplier.office_phone2);
                        $("#txteditwebsite").val(supplier.website);
                        $("#txtedithoaddress").val(supplier.ho_address);
                        $("#txteditemail").val(supplier.email);
                        
                        $('#brandad4').html('');
                        for(var i = 0; i < supplier_brand.length; i++){
                            $("#brandad4").append('<option selected value="'+supplier_brand[i]['id_business_brands']+'">'+supplier_brand[i]['business_brand_name'].substr(0, 25)+'</option>');
                        }
                        
                    }
                });
            
            $("#editsupplier").modal('show');
            
            
        }
        function update(){
                if($("#txteditsupplierid").val()!== ""){
                    var brand = [];
                    $('#brandad4 :selected').each(function(i, selected) {
                        brand[i] = $(selected).val();
                    });
                $.ajax({
                        type: 'POST',
                        url: 'supplier_controller/update_supplier',
                        data: {id_business_supplier: $("#txteditsupplierid").val(), supplier_name: $("#txteditsuppliername").val(), contact_person:$("#txteditcontactperson").val(), contact_number: $("#txteditcontactnumber").val(), office_phone1: $("#txteditofficephone1").val(), office_phone2: $("#txteditofficephone2").val(), website: $("#txteditwebsite").val(), email: $("#txteditemail").val(), ho_address:$("#txtedithoaddress").val(),brand: brand},
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Service Updated');
                                location.reload();
                            }
                        }
                    });
                }
            }
        
        function openaddnew(){
            $("#addsupplier").modal('show');
        }
        function addnew(){
            if($("#txtsuppliername").val()!== "" ){
            var brand = [];
            $('#brandad2 :selected').each(function(i, selected) {
                brand[i] = $(selected).val();
            });
            
            $.ajax({
                    type: 'POST',
                    url: 'supplier_controller/add_supplier',
                    data: {supplier_name: $("#txtsuppliername").val(), contact_person:$("#txtcontactperson").val(), contact_number: $("#txtcontactnumber").val(), office_phone1: $("#txtofficephone1").val(), office_phone2: $("#txtofficephone2").val(), website: $("#txtwebsite").val(), email: $("#txtemail").val(), ho_address:$("#txthoaddress").val(),brand: brand},
                    success: function(data) {
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success(data, 'New Supplier Added');
                            location.reload();
                        }
                    }
                });
            }
        }
      
        
    </script>
