<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-vehicule'">
        Ajouter un vehicule
    </button>

    </div>

<?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>
    <?php if(!empty($vehicules)) {?>
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des vehicules</h5>
        </div>
        <div class="col-lg-9 ">
          <div class="card">
            <table class="table">
                <thead>
                <tr>
                    <th>numero</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($vehicules as $vehicule) { ?>
                <tr>
                    <td> <a href="<?php echo base_url()?>edit-vehicule/<?php echo $vehicule->numero?>" > <?php echo $vehicule->numero ?> </a> </td>

                    <td>
                    <a href="<?php echo base_url()?>change-status-vehicule/<?php echo $vehicule->numero ?>" > 
                    <button type="button" class="btn btn-danger btn-sm text-white">
                    <?php if($vehicule->status==0){ echo "Activer"; } else { echo "Desactiver"; } ?>
                    </button></a>
                    <a href="<?php echo base_url()?>edit-vehicule/<?php echo $vehicule->numero?>" >
                    <button type="button" class="btn btn-secondary btn-sm">
                    Edit
                      </button></a>
                
                    </td>

                </tr>
                <?php } ?>
                </tbody>
            </table>
          </div>
        </div>
    <?php } else {?>
    <div class="alert alert-info" role="alert">
        <strong>No Vehicules Found!</strong>
    </div>
    <?php } ?>
</div>
