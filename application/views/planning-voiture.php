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
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <table class="table mx-auto">
                    <thead class="thead-light">
                    <tr>
                        <th>numero</th>
                        <th>Propriétaire</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($vehicules as $vehicule) { ?>
                    <tr>
                        <td> <a href="<?php echo base_url()?>edit-vehicule/<?php echo $vehicule->numero?>" > <?php echo $vehicule->numero ?> </a> </td>
                        <?php if( is_null($vehicule->idprestataire)) {?>
                            <td>Entreprise</td>
                        <?php } else {?>
                            <td> <a href="<?php echo base_url()?>edit-prestataire/<?php echo $vehicule->idprestataire?>" > <?php echo $vehicule->prestataire ?> </a> </td>
                        <?php } ?>
                        
                        <td>
                        <a href="<?php echo base_url()?>planning-parvoiture/<?php echo $vehicule->numero?>" >
                        <button type="button" class="btn btn-secondary btn-sm">
                        Planning
                        </button></a>
                    
                        </td>

                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="col-md-4">
            <nav aria-label="Page navigation example">
                <?php echo $links; ?>
            </nav>
        </div>
    <?php } else {?>
    <div class="alert alert-info" role="alert">
        <strong>No Vehicules Found!</strong>
    </div>
    <?php } ?>
</div>