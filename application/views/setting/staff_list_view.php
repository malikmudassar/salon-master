<link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet" />
<style>
    .b{
        color: black !important;
        font-size: 16px;
        text-transform: capitalize;
        padding: 5px;
        margin-bottom: 5px;
    }
</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class=" pull-right m-t-15">
                    <button type="button"  onclick="openaddnew();" class="btn btn-custom waves-effect waves-light" >Add Staff<span class="m-l-5"><i class="fa fa-plus"></i></span></button>
                    <button onclick="orderplugin();" class="btn btn-pink waves-effect waves-light "> <span>Change Order</span> <i class="fa fa-sort m-l-5"></i> </button>
                                       
                    <div class="btn-group">
                            <button type="button" class="btn btn-warning dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">Staff Payments<span class="m-l-5"><i class="fa fa-money"></i></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="javascript:void(0);" onclick="paysalaries();" >Pay Salaries</a></li>
                                <li><a href="javascript:void(0);" onclick="paycommissions();">Pay Commissions</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php base_url();?>staff_controller/paymentslips">Payment Slips</a></li>
                            </ul>
                        </div>
                </div>
                <h4 class="page-title">Staff</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <h4 class="header-title m-t-0 m-b-30">&nbsp;</h4>

                    <table id="tblstaff" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Status</th>
                                <th>Action</th>
                                <th>Image</th>
                                <th>Display Order</th>
                                <th>Scheduler</th>
                                <th>Emp. ID</th>
                                <th>Name</th>
                                <th>Cell</th>
                                <th>Phone1</th>
                                <th>NIC</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Comments</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($staffs as $staff) { ?>
                                <?php $businessname = $business[0]['business_name']; ?>
                                <tr data-toggle="tooltip" title="<?php echo $staff['staff_active'] == "N" ? $staff['staff_fullname'] . " Left " . $businessname : $staff['staff_fullname'] . " Current " . $businessname . " Staff "; ?>" >
                                    <td><?php echo $staff['id_staff']; ?></td>
                                   <td>
                                       <button class="form-control <?php echo $staff['staff_active'] == "N" ? "btn btn-danger" : "btn btn-primary"; ?>" name="staffactive" id="staffactive" onclick="statusForm('<?php echo $staff['id_staff']; ?>','<?php echo $staff['staff_active'] == "Y" ? "Y" : "N"; ?>');"><?php echo $staff['staff_active'] == "Y" ? "Active" : "Inactive"; ?> </button>
                                    </td>
                                    <td class='noprint'>
                                        <button <?php echo $staff['staff_active'] == "N" ? "disabled" : ""; ?> id='btnedit' onclick="openupdate(<?php echo $staff['id_staff']; ?>);" class="btn btn-icon waves-effect waves-light btn-info m-b-5"> <i class="fa fa-keyboard-o"></i> </button>  
                                        <a href="<?php echo base_url(); ?>staff_account/<?php echo $staff['id_staff']; ?>" class="btn btn-icon waves-effect waves-light btn-warning m-b-5"> <i class="fa fa-money"></i> </a>  
                                    </td>
                                    <td>
                                        <a onclick="upload_image('<?php echo $staff['id_staff']; ?>', '<?php echo $staff['staff_image'] ? $staff['staff_image'] : NULL; ?>')" href="javascript:void()">
                                            <img width="70px;" src="<?php echo base_url() . 'assets/images/staff/'; ?><?php echo $staff['staff_image'] ? $staff['staff_image'] : "nu.png"; ?>" alt="<?php echo $staff['staff_fullname'] ?>"/>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <input readonly class="form-control" size="2" type="text" name="orderid" id="orderid" onblur="orderservicetype('<?php echo $staff['id_staff']; ?>', this.value);" value="<?php echo $staff['staff_order']; ?>" />
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <input id="<?php echo $staff['id_staff']; ?>" class="showscheduler" type="checkbox" <?php if($staff['staff_scheduler']=="On"){echo 'checked';} ?> data-plugin="switchery" data-color="#00b19d" data-size="small"/>
                                    </td>
                                    <td><?php echo $staff['staff_eid']; ?></td>
                                    <td><?php echo $staff['staff_fullname']; ?></td>
                                    <td><?php echo $staff['staff_cell']; ?></td>
                                    <td><?php echo $staff['staff_phone1']; ?></td>
                                    <td><?php echo $staff['staff_phone2']; ?></td>
                                    <td><?php echo $staff['staff_address']; ?></td>
                                    <td><?php echo $staff['staff_email']; ?></td>
                                    <td><?php echo $staff['staff_comment']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div><!-- end col -->
        </div>
        <!-- end row -->

        <!--Modals-->

        <!--Add Staff Modal-->
        <div id="addstaff" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addstaff" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Add a new Staff</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstafffirstname" class="control-label">First Name</label>
                                            <input type="text" class="form-control" placeholder="Staff First Name" id="txtstafffirstname" name="txtstafffirstname" tabindex=1>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstafffullname" class="control-label">Full Name</label>
                                            <input type="text" class="form-control" placeholder="Staff Full Name" id="txtstafffullname" name="txtstafffullname" tabindex=3>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstaffphone1" class="control-label">Phone 1</label>
                                            <input type="text" class="form-control numeric" placeholder="Staff Phone 1" id="txtstaffphone1" name="txtstaffphone1" tabindex=5>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstaffaddress" class="control-label">Address</label>
                                            <input type="text" class="form-control" placeholder="Staff Address" id="txtstaffaddress" name="txtstaffaddress" tabindex=7>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstaffemail" class="control-label">Email</label>
                                            <input type="text" class="form-control" placeholder="Staff Email" id="txtstaffemail" name="txtstaffemail" tabindex=9>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstafflastname" class="control-label">Last Name</label>
                                            <input type="text" class="form-control" placeholder="Staff Last Name" id="txtstafflastname" name="txtstafflastname" tabindex=2>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstaffcell" class="control-label">Cell</label>
                                            <input type="text" class="form-control numeric" placeholder="Staff Cell" id="txtstaffcell" name="txtstaffcell" tabindex=4>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstaffphone2" class="control-label">NIC</label>
                                            <input type="text" class="form-control numeric" placeholder="NIC" id="txtstaffphone2" name="txtstaffphone2" tabindex=6>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtstaffeid" class="control-label">Employee Id</label>
                                            <input type="text" class="form-control" placeholder="Staff Employee Id" id="txtstaffeid" name="txtstaffeid" tabindex=8>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txtsalary" class="control-label">Salary</label>
                                            <input type="text" class="form-control numeric" placeholder="Salary" id="txtsalary"  name="txtsalary" tabindex=9>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" tabindex=11>Close</button>
                        <button onclick="addnew();" type="button" class="btn btn-custom waves-effect waves-light" tabindex=10>Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Add Modal-->

        <!--Edit Staff Modal-->
        <div id="editsupplier" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="editsupplier" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Edit Staff</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstafffirstname" class="control-label">First Name</label>
                                            <input type="text" class="form-control" placeholder="Staff First Name" id="txteditstafffirstname" name="txteditstafffirstname" tabindex=1>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstafffullname" class="control-label">Full Name</label>
                                            <input type="text" class="form-control" placeholder="Staff Full Name" id="txteditstafffullname" name="txteditstafffullname" tabindex=3>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffphone1" class="control-label">Phone 1</label>
                                            <input type="text" class="form-control numeric" placeholder="Staff Phone 1" id="txteditstaffphone1" name="txteditstaffphone1" tabindex=5>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffaddress" class="control-label">Address</label>
                                            <input type="text" class="form-control" placeholder="Staff Address" id="txteditstaffaddress" name="txteditstaffaddress" tabindex=7>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffemail" class="control-label">Email</label>
                                            <input type="text" class="form-control" placeholder="Staff Email" id="txteditstaffemail" name="txteditstaffemail" tabindex=9>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstafflastname" class="control-label">Last Name</label>
                                            <input type="text" class="form-control" placeholder="Staff Last Name" id="txteditstafflastname" name="txteditstafflastname" tabindex=2>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffcell" class="control-label">Cell</label>
                                            <input type="text" class="form-control numeric" placeholder="Staff Cell" id="txteditstaffcell" name="txteditstaffcell" tabindex=4>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffphone2" class="control-label">NIC</label>
                                            <input type="text" class="form-control numeric" placeholder="NIC" id="txteditstaffphone2" name="txteditstaffphone2" tabindex=6>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffeid" class="control-label">Employee Id</label>
                                            <input type="text" class="form-control" placeholder="Staff Employee Id" id="txteditstaffeid" name="txteditstaffeid" tabindex=8>
                                        </div> 
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="txteditstaffsalary" class="control-label">Staff Salary</label>
                                            <input type="text" class="form-control numeric" placeholder="Staff Salary" id="txteditstaffsalary" name="txteditstaffsalary" tabindex=9>
                                        </div> 
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="txteditstaffid" id="txteditstaffid" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal" tabindex=11>Close</button>
                        <button onclick="update();" type="button" class="btn btn-custom waves-effect waves-light" tabindex=10>Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--End Edit Service Category Modal-->

        <!--start upload image-->
        <div id="addstaffimage" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="addstaffimage" aria-hidden="true" style="display: none;">
            <form action="<?php echo base_url('staffimage'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h4 class="modal-title" id="custom-width-modalLabel">Add Staff Image</h4>
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
                                                <label for="txtstaffimage" class="control-label">Staff Image</label>
                                                <input class="form-control" type="file" id="staff_image" name="staff_image" />
                                                <input type="hidden" name="org_image" id="org_image" />
                                                <input type="hidden" name="id_image_staff" id="id_image_staff" />
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

        <!--Staff Status Remove Start-->
        <div id="remove" class="modal fade bs-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="panelt panel-default">
                        <div class="panel-heading">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="panel-title">Action Confirmation</h3>
                            <p id="p1"></p>
                        </div>
                        <div class="panel-body" >
                            <span id="p2"></span>
                            <div class="form-group">
                                <label for="staff_comments" class="control-label">Reason</label>
                                <input class="form-control" name="staff_comments" id="staff_comments"  />
                            </div>
                            <div class="btn-list ">
                                <button class="btn btn-success pull-right" data-dismiss="modal" class="close"  >No</button>
                                <button class="btn btn-danger pull-right" id="btndel"  >Yes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Staff Sratus Remove End-->

        <!--ORDER PLUGIN MODAL START-->
        <div id="orderplugin" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="orderplugin" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="custom-width-modalLabel">Display Order</h4>
                    </div>
                    <div class="modal-body">
                        
                        <ul id="sortable" class=" list-unstyled">
                            <?php foreach ($staffs as $staff) { ?>

                                <li id="<?php echo $staff['id_staff']; ?>" class="ui-state-default">
                                    <div class="alert alert-warning b">
                                        <a href="#" class="close"><i class="glyphicon glyphicon-move m-l-5" style="padding-top:13px;"></i></a>
                                        <img height="50px;" width="50px;" src="<?php echo base_url() . 'assets/images/staff/'; ?><?php echo $staff['staff_image'] ? $staff['staff_image'] : "nu.png"; ?>" alt="<?php echo $staff['staff_fullname'] ?>"/>
                                        <?php echo $staff['staff_fullname']; ?>
                                    </div>
                                </li>

                            <?php } ?>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="neworder" id="neworder" value="" />
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button onclick="changeorder();" class="btn btn-custom waves-effect waves-light orderloader"><span>Save</span></button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!--ORDER PLUGIN MODAL END-->

        <!---Salaries Modal Start-->
        <div id="paysalaries" class="modal fade in " tabindex="-1" role="dialog" aria-labelledby="paysalaries" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <div class="modal-title">
                                <div class="col-md-3">
                                    <h4 class="modal-title" id="custom-width-modalLabel">Pay Salaries for Month: </h4>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control col-md-4" id="salarymonth">
                                        <?php $month = $lastmonthyear[0]['Month']; ?>
                                            <option value="January" <?php if ($month === '1') {
                                                echo "selected";
                                            } ?> >January</option>
                                            <option value="February" <?php if ($month === '2') {
                                                echo "selected";
                                            } ?>>February</option>
                                                <option value="March" <?php if ($month === '3') {
                                                echo "selected";
                                            } ?>>March</option>
                                                <option value="April" <?php if ($month === '4') {
                                                echo "selected";
                                            } ?>>April</option>
                                                <option value="May" <?php if ($month === '5') {
                                                echo "selected";
                                            } ?>>May</option>
                                                <option value="June" <?php if ($month === '6') {
                                                echo "selected";
                                            } ?>>June</option>
                                                <option value="July" <?php if ($month === '7') {
                                                echo "selected";
                                            } ?>>July</option>
                                                <option value="August" <?php if ($month === '8') {
                                                echo "selected";
                                            } ?>>August</option>
                                                <option value="September" <?php if ($month === '9') {
                                                echo "selected";
                                            } ?>>September</option>
                                                <option value="October" <?php if ($month === '10') {
                                                echo "selected";
                                            } ?>>October</option>
                                                <option value="November" <?php if ($month === '11') {
                                                echo "selected";
                                            } ?>>November</option>
                                                <option value="December" <?php if ($month === '12') {
                                                echo "selected";
                                            } ?>>December</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="salaryyear">
                                        <?php $year=$lastmonthyear[0]['Year']; for($x=1; $x<=4; $x++){?>
                                        <option value="<?php echo $year;?>" <?php if($year===$lastmonthyear[0]['Year']){ echo "selected";} ?>><?php echo $year;?></option>
                                        <?php $year=$year-1; }?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="salarymode">
                                        <option value="cash" >Cash</option>
                                        <option value="cash" >Bank</option>
                                    </select>
                                </div>
                                 <?php if(isset($bank_accounts)){?>

                                   <div class="col-md-2">
                                       
                                        <select type="text" id="bank_accounts" name="bank_accounts" class="form-control" >
                                            <?php foreach ($bank_accounts as $bank_account){ ?>
                                            <option value="<?php echo $bank_account['id_account_heads']; ?>"><?php echo $bank_account['account_head_number']."-".$bank_account['account_head'];?></option>
                                            <?php } ?>
                                        </select>    

                                   </div>
                               
                               <?php } ?>
                               
                            </div>
                    </div>
                    <div class="modal-body">
                        <div class="row m-b-10">
                            <div class="col-sm-12">
                                <div class=" pull-right m-t-15">
                                    <button onclick="unselectall();" type="button" class="btn btn-custom waves-effect waves-light" >Un Select</button>
                                    <button onclick="selectall();" type="button" class="btn btn-primary waves-effect waves-light ">Select All</button>
                                    <button onclick="updatesalaryselected();" type="button" class="btn btn-warning waves-effect waves-light ">Mark Paid</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-bordered" id="salarieslist">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Salary</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($staffs as $staff) { if($staff['staff_active']!=="N"){?>
                                    <tr>
                                        <td><?php echo $staff['id_staff'];?></td>
                                        <td><?php echo $staff['staff_fullname'];?></td>
                                        <td><input class="form-control" name="salaryamount" value="<?php echo $staff['staff_salary'];?>" /></td>
                                        <td><input class="checkbox valid" name="salarycheck" type="checkbox" checked="checked " /></td>
                                    </tr>
                                    <?php }} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!---Salaries Modal End-->

        <!---Commissions Modal Start-->
        <div id="paycommissions" class="modal fade in " tabindex="-1" role="dialog" aria-labelledby="paycommissions" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <div class="modal-title">
                                <div class="col-md-3">
                                    <h4 class="modal-title" id="custom-width-modalLabel">Pay Commissions for Month: </h4>
                                </div>
                                <div class="col-md-2">
                                    <select onchange="getcommissions();" class="form-control col-md-4" id="commissionsmonth">
                                        <?php $month = $lastmonthyear[0]['Month']; ?>
                                            <option value="1 January" <?php if ($month === '1') {
                                                echo "selected";
                                            } ?> >January</option>
                                            <option value="2 February" <?php if ($month === '2') {
                                                echo "selected";
                                            } ?>>February</option>
                                                <option value="3 March" <?php if ($month === '3') {
                                                echo "selected";
                                            } ?>>March</option>
                                                <option value="4 April" <?php if ($month === '4') {
                                                echo "selected";
                                            } ?>>April</option>
                                                <option value="5 May" <?php if ($month === '5') {
                                                echo "selected";
                                            } ?>>May</option>
                                                <option value="6 June" <?php if ($month === '6') {
                                                echo "selected";
                                            } ?>>June</option>
                                                <option value="7 July" <?php if ($month === '7') {
                                                echo "selected";
                                            } ?>>July</option>
                                                <option value="8 August" <?php if ($month === '8') {
                                                echo "selected";
                                            } ?>>August</option>
                                                <option value="9 September" <?php if ($month === '9') {
                                                echo "selected";
                                            } ?>>September</option>
                                                <option value="10 October" <?php if ($month === '10') {
                                                echo "selected";
                                            } ?>>October</option>
                                                <option value="11 November" <?php if ($month === '11') {
                                                echo "selected";
                                            } ?>>November</option>
                                                <option value="12 December" <?php if ($month === '12') {
                                                echo "selected";
                                            } ?>>December</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select onchange="getcommissions();" class="form-control" id="commissionsyear">
                                        <?php $year=$lastmonthyear[0]['Year']; for($x=1; $x<=4; $x++){?>
                                        <option value="<?php echo $year;?>" <?php if($year===$lastmonthyear[0]['Year']){ echo "selected";} ?>><?php echo $year;?></option>
                                        <?php $year=$year-1; }?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="commissionsmode">
                                        <option value="cash" >Cash</option>
                                        <option value="cash" >Bank</option>
                                    </select>
                                </div>
                               
                            </div>
                    </div>
                    <div class="modal-body">
                        <div class="row m-b-10">
                            <div class="col-sm-12">
                                <div class=" pull-right m-t-15">
                                    <button onclick="unselectcommissions();" type="button" class="btn btn-custom waves-effect waves-light" >Un Select</button>
                                    <button onclick="selectcommissions();" type="button" class="btn btn-primary waves-effect waves-light ">Select All</button>
                                    <button onclick="updatecommissionselected();" type="button" class="btn btn-warning waves-effect waves-light ">Mark Paid</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-bordered" id="commissionslist">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Name</td>
                                        <td>Services</td>
                                        <td>Commission</td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($commissions as $commission) { ?>
                                    <tr>
                                        <td><?php echo $commission['staff_id'];?></td>
                                        <td><?php echo $commission['staff_name'];?></td>
                                        <td><?php echo $commission['Total Services'];?></td>
                                        <td><input class="form-control" name="commissionamount" value="<?php echo $commission['Commission'];?>" /></td>
                                        <td><input class="checkbox valid" name="commissioncheck" type="checkbox" checked="checked " /></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!---Commissions Modal End-->
        
        <!--Payments Modal Start-->
        <div id="paymentsmodal" class="modal fade in " tabindex="-1" role="dialog" aria-labelledby="paymentsmodal" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <div class="modal-title">
                                <div class="col-md-3">
                                    <h4 class="modal-title" id="custom-width-modalLabel">Other Payments: </h4>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payments Modal End-->
        
        <script type="text/javascript">
            $(document).ready(function() {

                $('#tblstaff').DataTable({
                    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    stateSave: true,
                    dom: "Bfrtlip",
                    buttons: [{extend: "copy", className: "btn-sm btn-custom btn-trans"}, {extend: "csv", className: "btn-sm btn-pink btn-trans"}, {
                            extend: "excel",
                            className: "btn-sm btn-warning btn-trans"
                        }, {extend: "pdf", className: "btn-sm btn-purple btn-trans"}],
                    responsive: 0,
                    "order": [[ 0, "asc" ]]
                    
                });
                
                $('[data-toggle="tooltip"]').tooltip();


                $('#salarieslist').DataTable({
                    paging:false
                });
                
                $('#commissionslist').DataTable({
                    paging:false
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

                //Add form concat function......start
                $('#txtstafffirstname').keyup(function() {
                    var firstname = $(this).val();
                    var lastname = $('#txtstafflastname').val();
                    $('#txtstafffullname').val('');
                    $('#txtstafffullname').val(firstname + ' ' + lastname);
                });

                $('#txtstafflastname').keyup(function() {
                    var lastname = $(this).val();
                    var firstname = $('#txtstafffirstname').val();
                    var concatname = firstname + ' ' + lastname;
                    $('#txtstafffullname').val('');
                    $('#txtstafffullname').val(concatname);
                });
                //Add form concat function......end

                //Edit form concat function......start
                $('#txteditstafffirstname').keyup(function() {
                    var firstname = $(this).val();
                    var lastname = $('#txteditstafflastname').val();
                    $('#txteditstafffullname').val('');
                    $('#txteditstafffullname').val(firstname + ' ' + lastname);
                });

                $('#txteditstafflastname').keyup(function() {
                    var lastname = $(this).val();
                    var firstname = $('#txteditstafffirstname').val();
                    var concatname = firstname + ' ' + lastname;
                    $('#txteditstafffullname').val('');
                    $('#txteditstafffullname').val(concatname);
                });
                //Edit form concat function......end


                $(".showscheduler").change(function (){
                    console.log($(this).prop("checked"));
                    console.log($(this).attr("id"));
                    scheduler_on($(this).attr("id"), $(this).prop("checked"));
                    
                });

            });
            
            function scheduler_on(id, val){
                if(val===true){
                    val="On";
                } else {val="Off";}
                $.ajax({
                        type: 'POST',
                        url: 'staff_controller/update_staff_scheduler',
                        data: {id_staff: id, staff_scheduler: val},
                        success: function(data) {
                            //console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Staff Updated');
                                //location.reload();
                            }
                        }
                    });
                
                
            }
            function openupdate(id) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>staff_controller/edit_staff',
                    data: {id_staff: id},
                    dataType: "json",
                    cache: false,
                    async: true,
                    success: function(data){
                        $("#txteditstaffid").val(id);
                        $("#txteditstafffullname").val(data.staff_fullname);
                        $("#txteditstafffirstname").val(data.staff_firstname);
                        $("#txteditstafflastname").val(data.staff_lastname);
                        $("#txteditstaffcell").val(data.staff_cell);
                        $("#txteditstaffphone1").val(data.staff_phone1);
                        $("#txteditstaffphone2").val(data.staff_phone2);
                        $("#txteditstaffeid").val(data.staff_eid);
                        $("#txteditstaffaddress").val(data.staff_address);
                        $("#txteditstaffemail").val(data.staff_email);
                        $("#txteditstaffsalary").val(data.staff_salary);
                        $("#editsupplier").modal('show');
                    }
                });
            }
            function update() {
                if ($("#txteditstafffirstname").val() !== "" && $("#txteditstafflastname").val() !== "" && $("#txteditstafffullname").val() !== "") {
                    var fullname = $("#txteditstafffirstname").val() + ' ' + $("#txteditstafflastname").val();
                    $.ajax({
                        type: 'POST',
                        url: 'staff_controller/update_staff',
                        data: {id_staff: $("#txteditstaffid").val(), staff_firstname: $("#txteditstafffirstname").val(), staff_lastname: $("#txteditstafflastname").val(), staff_fullname: fullname, staff_cell: $("#txteditstaffcell").val(), staff_phone1: $("#txteditstaffphone1").val(), staff_phone2: $("#txteditstaffphone2").val(), staff_eid: $("#txteditstaffeid").val(), staff_email: $("#txteditstaffemail").val(), staff_address: $("#txteditstaffaddress").val(), staff_salary: $("#txteditstaffsalary").val()},
                        success: function(data) {
                            //console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'Staff Updated');
                                location.reload();
                            }
                        }
                    });
                } else {
                    swal({
                        title: "Required!",
                        text: 'First/last/full name should not be empty!',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function openaddnew() {
                $("#addstaff").modal('show');
            }
            function addnew() {
                if ($("#txtstafffirstname").val() !== "" && $("#txtstafflastname").val() !== "" && $("#txtstafffullname").val() !== "" && $("#txtsalary").val() !== "") {
                    var fullname = $("#txtstafffirstname").val() + ' ' + $("#txtstafflastname").val();
                    $.ajax({
                        type: 'POST',
                        url: 'staff_controller/add_staff',
                        data: {staff_firstname: $("#txtstafffirstname").val(), staff_lastname: $("#txtstafflastname").val(), staff_fullname: fullname, staff_cell: $("#txtstaffcell").val(), staff_phone1: $("#txtstaffphone1").val(), staff_phone2: $("#txtstaffphone2").val(), staff_address: $("#txtstaffaddress").val(), staff_eid: $("#txtstaffeid").val(), staff_email: $("#txtstaffemail").val(), staff_salary: $("#txtsalary").val()},
                        success: function(data) {
                            //console.log(data);
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(data, 'New Staff Added');
                                location.reload();
                            }
                        }
                    });
                } else {
                    swal({
                        title: "Required!",
                        text: 'First/last/full name/salary should not be empty!',
                        type: "info",
                        confirmButtonText: 'OK!'
                    });
                }
            }

            function upload_image(id_staff, image) { //previously image = null
                if (id_staff && id_staff != null) {
                    $("#org_image").val('');
                    $("#id_image_staff").val('');
                    $("#id_image_staff").val(id_staff);
                    if (image && image != null) {
                        $("#org_image").val(image);
                        $("#msg #img").attr('src', 'assets/images/staff/' + image);
                    } else {
                        $("#msg #img").attr('src', 'assets/images/staff/nu.png');
                    }
                    $("#addstaffimage").modal("show");
                }
            }

            function statusForm(id, status) {
                console.log (status);
                if (status === "Y") {
                    $("#p1").html('');
                    $("#p1").html("You are about to deactivate this staff!");
                    $("#p2").html('');
                    $("#p2").html("Are you sure ?");
                     $("#staff_comments").val('');
                    status="N";
                } else if (status === "N") {
                    $("#p1").html('');
                    $("#p1").html("You are about to activate this Staff!");
                    $("#p2").html('');
                    $("#p2").html("Are you sure ?");
                     $("#staff_comments").val('');
                    status="Y";
                }

                $('#btndel').attr('onclick', 'status_active("' + status + '","' + id + '")');
                $('#remove').modal({
                    keyboard: false,
                    backdrop: 'static'
                });
            }

            function status_active(status, id) {
               // console.log(status + id);
                $.ajax({
                    url: "<?php echo base_url('staff_status'); ?>",
                    type: "POST",
                    //data: "staffactive=" + status + "&id_staff_status=" + id,
                    data: {staffactive: status, id_staff_status: id, staff_comment: $("#staff_comments").val()},
                    success: function(data) {
                        if (data === "success") {
                            toastr.success(data, 'Staff Status Changed');
                            location.reload();
                        }
                    },
                    error: function(jXHR, textStatus, errorThrown) {
                        alert(errorThrown);
                    }
                });
            }

            function orderservicetype(id, orderid) {
                return false;
                var type = "packagetype";

                if (id && orderid) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url(); ?>staff_controller/order_function',
                        data: {id: id, orderid: orderid, type: type},
                        success: function(data) {
                            toastr.success(data, 'Display Order has been updated!');
                            //location.reload();
                        }
                    });
                }
            }

            function orderplugin() {
                $('#orderplugin').modal('show');
            }

            $(function() {
                $("#sortable").sortable({
                    update: function(event, ui) {
                        getOrder();
                    }

                });
            });
            function getOrder() {
                var order = $("#sortable .ui-state-default").map(function() {
                    return this.id;
                }).get();

                $('#neworder').val(order);
            }
            function changeorder() {
                $('.orderloader span').text('');
                $('.orderloader span').addClass('fa fa-spin fa-spinner');
                var ordernew = $('#neworder').val();

                $.ajax({
                    type: 'POST',
                    url: 'staff_controller/changelistorder',
                    data: {staff_order: ordernew},
                    success: function(data) {
                        //console.log(data);return false;
                        var result = data.split("|");
                        if (result[0] === "success") {
                            toastr.success(data, 'Staff Order Changed');
                            setTimeout(function() {
                                location.reload();
                            }, 3000);

                        }
                    }
                });
                
            }

            
            function selectall(){
                $('#salarieslist tr').each(function(row, tr) {
                    $(tr).find('td:eq(3)').find('input[name=salarycheck]').prop('checked', true);
                });
            }
            
            function unselectall(){
                $('#salarieslist tr').each(function(row, tr) {
                   $(tr).find('td:eq(3)').find('input[name=salarycheck]').prop('checked', false);
                });
            }
            
            function paysalaries(){
                $("#paysalaries").modal('show');
            }
            
            function updatesalaryselected(){
                var TableData;
                TableData = storeSalaryTblValues();
                TableData = $.toJSON(TableData);
                if (TableData.length > 2) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url().'staff_controller/updatesalaries'; ?>',
                        data: {
                            salarydata:TableData, month:$("#salarymonth :selected").val(), year:$("#salaryyear :selected").val()
                            , salarymode:$("#salarymode :selected").val(), bank_accounts:$("#bank_accounts option:selected").val()
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(result[1]+' Salaries updated!', 'Done!');
                                $("#paysalaries").modal('hide');
                            } else {
                                swal({
                                    title: "Error",
                                    text: result[1],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });
                            }
                        }
                    });
                    
                }
            }
            
            
            function storeSalaryTblValues() {
                var TableData = new Array();
                var x=1;
                $('#salarieslist tr').each(function(row, tr) {
                    
                    if($(tr).find('td:eq(3)').find('input[name=salarycheck]').prop('checked')==true){
                        TableData[x] = {
                            "staff_id": $(tr).find('td:eq(0)').text()
                            , "staff_name": $(tr).find('td:eq(1)').text()
                            , "payment_amount": $(tr).find('td:eq(2)').find('input[name=salaryamount]').val()
                            , "payment_type":'Salary'                            
                            , "payment_remarks": 'Monthly Salary'
                        }
                        x++;
                    }
                });
                TableData.shift();  // first row will be empty - so remove
                return TableData;
            }
            
            //commissions
            function selectcommissions(){
                $('#commissionslist tr').each(function(row, tr) {
                    $(tr).find('td:eq(4)').find('input[name=commissioncheck]').prop('checked', true);
                });
            }
            
            function unselectcommissions(){
                console.log('here');
                $('#commissionslist tr').each(function(row, tr) {
                   $(tr).find('td:eq(4)').find('input[name=commissioncheck]').prop('checked', false);
                });
            }
            
            function paycommissions(){
                $("#paycommissions").modal('show');
            }
            
            
            function getcommissions(){
                
                var x  = $("#commissionsmonth :selected").val().split(" ");
                var month= x[0];
                var year = $("#commissionsyear :selected").val();
                $.ajax({
                        type: "POST",
                        url: '<?php echo base_url().'staff_controller/get_commissions'; ?>',
                        data: {month: month, year:year},
                        dataType: "json",
                        success: function(data) {
                            
                            $('#commissionslist').DataTable().destroy;
                            $("#commissionslist tbody").html("");
                            mhtml="";
                            for (x = 0; x < data.length; x++) {
                                mhtml += "<tr>";
                                mhtml += "<td>"+ data[x]['staff_id'] +"</td><td>"+ data[x]['staff_name'] +"</td><td>"+ data[x]['Total Services'] +"</td>";
                                mhtml += '<td><input class="form-control" name="commissionamount" value="'+ data[x]['Commission'] +'" /></td>';
                                mhtml += '<td><input class="checkbox valid" name="commissioncheck" type="checkbox" checked="checked " /></td>';
                                mhtml += "</tr>";
                            }
                            $("#commissionslist tbody").html(mhtml);
                        }
                    });
                
            }
            
            function updatecommissionselected(){
                
                var month=$("#commissionsmonth :selected").val().split(" ");
                
                
                var TableData;
                TableData = storeCommissionsTblValues();
                TableData = $.toJSON(TableData);
                if (TableData.length > 2) {
                    $.ajax({
                        type: "POST",
                        url: '<?php echo base_url().'staff_controller/updatecommissions'; ?>',
                        data: {
                            commissionsdata:TableData, 
                            month:month[1], 
                            year:$("#commissionsyear :selected").val(),
                            paymentmode:$("#commissionsmode :selected").val()
                        },
                        success: function(data) {
                            var result = data.split("|");
                            if (result[0] === "success") {
                                toastr.success(result[1]+' Commissions updated!', 'Done!');
                                $("#paycommissions").modal('hide');
                            } else {
                                swal({
                                    title: "Error",
                                    text: result[1],
                                    type: "error",
                                    confirmButtonText: 'OK!'
                                });
                            }
                        }
                    });
                    
                }
            }
            
            
            function storeCommissionsTblValues() {
                var TableData = new Array();
                var x=1;
                $('#commissionslist tr').each(function(row, tr) {
                    if($(tr).find('td:eq(4)').find('input[name=commissioncheck]').prop('checked')==true){
                        TableData[x] = {
                            "staff_id": $(tr).find('td:eq(0)').text()
                            , "staff_name": $(tr).find('td:eq(1)').text()
                            , "payment_amount": $(tr).find('td:eq(3)').find('input[name=commissionamount]').val()
                            , "payment_type": 'Commission'                            
                            , "payment_remarks": 'Monthly Commission'
                        }
                        x++;
                    }
                });
                TableData.shift();  // first row will be empty - so remove
                //console.log(TableData);
                return TableData;
            }
            
        </script>
<script src="assets/plugins/switchery/switchery.min.js"></script>