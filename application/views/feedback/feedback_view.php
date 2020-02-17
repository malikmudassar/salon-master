<div class="wrapper">
    <div class="container">
        

        <div class="row">
            <div class="col-sm-4">
                <button type="button" onclick="forcefetch('none');" class="btn btn-purple btn-rounded w-md waves-effect waves-light m-b-20">Refresh </button>
            </div>
            
            <!---------Invoiced Services--------->
            <div class="col-sm-8">
                <div class="project-sort pull-right">
                    <div class="project-sort-item">
                        <form class="form-inline">
                            <div class="form-group">
                                <label>Date :</label>
                                <input class="form-control input-sm" id="txtdate" placeholder="mm/dd/yyyy" name="txtdate" value="<?php if(isset($date)){echo $date;}?>" />
                                    
                            </div>
                            
                            <div class="form-group">
                                <label>Filter : </label>
                                <select id='txtstatus' class="form-control input-sm">
                                    <option <?php if($status=='none'){echo "selected='seleted'";} ?> value='none'>Not Entered</option>
                                    <option <?php if($status=='entered'){echo "selected='seleted'";} ?> value='entered'>Entered</option>
                                    <option <?php if($status=='not required'){echo "selected='seleted'";} ?> value='not required'>Not Required</option>
                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" onclick="forcefetch();" id="btnsearchcustomer" class="btn btn-sm btn-pink">Go</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end col-->
        </div>

       
        
        <div class="row">
        
            <div class="col-lg-12">
                <div class="card-box">
                   


                    <table class="table m-b-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Services</th>
                                <th>Staff</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $maxid= isset($invoices[0]['id_invoice'])?$invoices[0]['id_invoice']:0; $x=1; $class="success"; $invoiceid=0; foreach($invoices as $invoice){ ?>
                            <?php if(null!==$invoice['service']){?>
                            <?php if($invoiceid !== $invoice['id_invoice']){
                                 if($class==="active"){
                                    $class="success";

                                }else if($class==="success"){
                                    $class="info";

                                }else if($class==="info"){
                                    $class="warning";

                                }else if($class=="info"){
                                    $class="danger";
                                }else {
                                    $class="active";
                                }
                                ?>
                            <tr class="<?php echo $class;?>">
                                <th scope="row"><?php  echo $invoice['id_invoice'];;?></th>
                                <th scope="row" ><?php echo $invoice['customer_name'];?></th>
                                <td ><?php echo $invoice['service'];?></td>
                                <td ><?php echo $invoice['staff'];?></td>
                                <td><?php echo $invoice['visit_date']." ".$invoice['visit_time'];?></td>
                                <td>
                                    <?php if($invoice['feedback_status']=="none" && null!==$invoice['service']){?>
                                    <a href="<?php echo base_url()."feedback_form/".$invoice['id_invoice']; ?>" class="btn-pink btn-rounded w-md waves-effect waves-light"  id="btnfeedback" name="btnfeedback">Feed Back</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php 

                                $x++;
                            } else{?>
                                <tr class="<?php echo $class;?>">
                                <th scope="row"></th>
                                <th scope="row"></th>
                                <td><?php echo $invoice['service'];?></td>
                                <td><?php echo $invoice['staff'];?></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php } 
                                }
                                $invoiceid=$invoice['id_invoice'];
                            } ?>

                        </tbody>
                    </table>

                </div>
            </div>      
        </div> <!--Row End-->

    <script>
    
    $(document).ready(function () {
      
        $('#txtdate').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
        
        setInterval(function(){
            if($("#txtstatus option:selected").val()==='none'){
                getmore();
            }
        }, 15000); 
        
    });
    
    
    function getmore(){
        
        var today = "<?php echo date('Y-m-d');?>";
        
        $.ajax({
                url: '<?php echo base_url()?>invoice_controller/getmaxinvoice',
                type: "POST",
                data: {id: "1"},
                dataType: "json",
                cache: false,
                async: true,
                success: function(data) {
                 // console.log(data['maxid']);
                    if(data['maxid'] !== '<?php echo $maxid;?>' || $("#txtstatus option:selected").val()!=='<?php echo $status;?>'){
                        var url="<?php echo base_url()?>feedback/"+$("#txtstatus option:selected").val();
                        if($("#txtdate").val()!==""){
                            url = url+"/"+$("#txtdate").val()+"/service";
                        }else{
                             url = url+"/"+today+"/service";
                        }
                        location.assign(url);
                    }
                },
                error: function(jXHR, textStatus, errorThrown) {
                    
                    alert(jXHR + textStatus + errorThrown);
                
                }
            });
        }
    
    function forcefetch(status=null){
        var url='';
        if(status!==null){
            url="<?php echo base_url()?>feedback/"+status;
        }else{
            url="<?php echo base_url()?>feedback/"+$("#txtstatus option:selected").val();
        }
        if($("#txtdate").val()!==""){
            url = url+"/"+$("#txtdate").val();
        }else{
            url = url+"<?php date('Y-m-d');?>";
        }
        url= url + "/service";
        
        location.assign(url);
    }
    
    </script>