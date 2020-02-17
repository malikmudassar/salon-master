<div class="wrapper">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <h4 class="page-title">Supplier Payment:</h4>
            </div>
        </div>
        <div class="row" id="divselection">
            <div class="col-sm-12">
                <div class="card-box ">
                    <?php if ($this->session->flashdata('Success') && $this->session->flashdata('Success') != "") { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Success!</strong> <?php echo $this->session->flashdata('Success'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($this->session->flashdata('Error') && $this->session->flashdata('Error') != "") { ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Error!</strong> <?php echo $this->session->flashdata('Error'); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-md-12 m-t-20">
                            
                            <a href="<?php echo base_url().$return_path;?>" class="btn btn-primary" type="button">Back</a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>