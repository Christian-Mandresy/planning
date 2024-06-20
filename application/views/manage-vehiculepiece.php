<div class="card">
<?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>
    <?php if(!empty($vehicules)) {?>
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des vehicules</h5>
        </div>
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
                <td> <a href="<?php echo base_url()?>list-vehiculepiece/<?php echo $vehicule->numero?>" > <?php echo $vehicule->numero ?> </a> </td>

                <td>
                <a href="<?php echo base_url()?>list-vehiculepiece/<?php echo $vehicule->numero?>" >
                <button type="button" class="btn btn-secondary btn-sm">
                entretien
                  </button></a>
                  <a href="<?php echo base_url()?>etat-piece/<?php echo $vehicule->numero?>" >
                <button type="button" class="btn btn-info btn-sm">
                Etat des Pieces
                  </button></a>
                </td>

            </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else {?>
    <div class="alert alert-info" role="alert">
        <strong>No Vehicules Found!</strong>
    </div>
    <?php } ?>
</div>