<div class="card">
<h2>Manage Utilisateur</h2> 
    <div class="card-body">
        <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-utilisateur'">
            Ajouter un utilisateur
        </button>
    </div>
    <?php if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
    <?php } ?>
    <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-danger">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('error'); ?></strong>
                </div>
    <?php } ?>
    <?php if(!empty($utilisateurs)) {?>
    <?php foreach($utilisateurs as $utilisateur) { ?>
        <div class="comment-widgets scrollable ps-container ps-theme-default" data-ps-id="c73227a9-966d-0243-83f9-2d325be8d4a1">       
            <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row mt-0">
                        <div class="p-2">
                            <img src="<?php echo base_url();?>assets/images/users/user.png" alt="user" width="50" class="rounded-circle">
                        </div>
                        <div class="comment-text w-100">
                            <h6 class="font-medium"><?php echo $utilisateur->username ?></h6>
                            <div class="comment-footer">
                                <a href="<?php echo site_url()?>edit-utilisateur/<?php echo $utilisateur->id?>" >
                                <button type="button" class="btn btn-cyan btn-sm text-white">
                                    Edit
                                </button>
                                </a>
                                <a href="<?php echo site_url()?>delete-utilisateur/<?php echo $utilisateur->id?>" onclick="return confirm('are you sure to delete')">
                                    <button type="button" class="btn btn-danger btn-sm text-white">
                                        Delete
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
            </div> 

            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"> </div>
            </div>
            <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
    <?php } ?>
    <?php } else {?>
        <div class="alert alert-info" role="alert">
            <strong>No Utilisateurs Found!</strong>
        </div>
    <?php } ?> 
</div>