<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Abandoned Carts</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12" >
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>
                    <table id="tblinvoice" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Brand</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Sold By</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id_customer_order']; ?></td>
                                <td><?php echo $order['mDate']; ?></td>
                                <td><?php echo $order['customer_name']; ?></td>
                                <td><?php echo $order['business_brand_name']; ?></td>
                                <td><?php echo $order['product_name']; ?></td>
                                <td><?php echo $order['category']; ?></td>
                                <td><?php echo $order['staff_name']; ?></td>
                                <td><?php echo $order['qty']; ?></td>
                                <td><?php echo $order['price']; ?></td>
                                <td><?php echo $order['price'] * $order['qty']; ?></td>
                                <td><button type="button" order_id="<?php echo $order['id_customer_order']; ?>" customer_id="<?php echo $order['customer_id']; ?>" class="btn btn-warning btn btn-xs waves-effect w-md waves-success m-b-5 viewOrder">View</button></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->
        
        <div class="modal fade none-border" id="retailmodal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><strong>Retail</strong></h4>
                    </div>
                    <div class="modal-body">
                        <!--Products Sale Form-->
                        <div class="row" id="retail-divorder" style="display:none;">
                            <div class="col-md-12">
                                <!--<form id="visitform">-->
                                <div class="card-box">
                                    <h4 class="header-title m-t-0 m-b-30">Create Customer Product Order</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="order-customer-name" class="control-label">Name</label>
                                                <input readonly="readonly" type="text" class="form-control" id="order-customer-name" name="order-customer-name" placeholder="Name">
                                                <input type="hidden" class="form-control" id="order-customer-id" name="order-customer-id">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="order-customer-cell" class="control-label">Cell Number</label>
                                                <input readonly="readyonly" type="text" class="form-control" id="order-customer-cell" name="order-customer-cell" placeholder="Cell Phone">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="order-customer-email" class="control-label">Email</label>
                                                <input readonly="readyonly" type="text" class="form-control" id="order-customer-email" name="order-customer-email" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="retail-order-products" class="control-label">Select Product</label>
                                                <input type="text" class='form-control' id="retail-order-products" name="order-products"  placeholder="Brand Product Category . . .">
                                                <!--<select class='form-control' id="retail-order-products" name="order-products" > </select>-->
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                    <label for="checkboxall" class="control-label">?</label>
                                    <div class="checkbox checkbox-success">
                                        <input onchange="retail_getproducts();" id="checkboxall" type="checkbox">
                                        <label for="checkboxall">
                                            Show All Stores
                                        </label>
                                    </div>
                                </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="retail-order-staff" class="control-label">Sold By</label>
                                                <select class='form-control'  id="retail-order-staff" name="order-staff"> 

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="order-customer-qty" class="control-label">Qty.</label>
                                                <input class="vertical-spin form-control numeric" type="text" id="order-customer-qty" name="order-customer-qty" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class='row'>
                                        <div class='col-md-6'></div>
                                        <div class='col-md-6'>
                                            <button style='float:right' onclick='addOrderRows();' type='button' class='btn btn-sm btn-purple waves-effect '>Add Product <i class='ti-arrow-circle-down'></i></button>
                                        </div>
                                    </div>
                                    <div class='row ' style="min-height: 150px;">
                                        <div id='order-product-list' class='col-md-12'>
                                            <div class="table-responsive">
                                                <table class="table" id="ordertbl">
                                                    <thead>
                                                        <tr>
                                                            <th style="display:none;">Customer ID</th>
                                                            <th>#</th>
                                                            <th>Product</th>
                                                            <th>Category</th>
                                                            <th>Batch</th>
                                                            <th style="display:none;">Staff ID</th>
                                                            <th>Sold By</th>
                                                            <th>Qty.</th>
                                                            <th>Price</th>
                                                            <th>Total</th>
                                                            <th>Remove</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="text-align: right">
                                        <form action="open_order_invoice" method="post" target="_blank">
                                            <input type="hidden" class="form-control" id="order-id" name="order-id">
                                             <input type="hidden" name="csrf_test_name" id="retail_modal_csrf" value=""/>
                                            <div class="col-md-6" style="text-align:left">
                                                <button id="btngenorderinvoice" onclick="$('#retail_modal_csrf').val($('#cook').val()); retail_updateorder();" style='display:none;' class="btn btn-pink waves-effect waves-light">Generate Invoice</button>
                                            </div>
                                        </form>
                                        <div class="col-md-6" style="text-align: right">
                                            <button type="button" onclick="retail_updateorder();" class="btn btn-info waves-effect waves-light">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                                <!--</form>-->
                            </div>
                        </div>        
                        <!--End Products Sale Form-->
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function() {
        $('#tblinvoice').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            stateSave: true,
            fixedHeader: {header: true},
            dom: "Bfrtlip",
            buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                    extend: "excel",
                    className: "btn-sm btn-warning btn-trans"
                }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
            responsive: !0
        });
        $('.viewOrder').on('click', function(){
            var order_id = $(this).attr('order_id');
            var customer_id = $(this).attr('customer_id');
            retail_clearorder();
            retail_openOrder(order_id, customer_id);
            $('#retailmodal').modal({
                backdrop:'static',
                keyboard:false,
                show:true
            });
        });
        
    });
</script>

<?php include 'js_functions/retail_js.php';
