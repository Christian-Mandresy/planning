<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-prestataire'">
        Ajout de prestataire
    </button>

    </div>

    <div class="card-body">
        <h5 class="card-title mb-0">Gestion de prestataires</h2>
    </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($prestataires)) {?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>nom</th>
       <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach($prestataires as $prestataire) { ?>
      <tr>
        <td> <a href="<?php echo site_url()?>edit-prestataire/<?php echo $prestataire->id?>" > <?php echo $prestataire->nom ?> </a> </td>

        <td>
        <a href="<?php echo site_url()?>edit-prestataire/<?php echo $prestataire->id?>" >
        <button type="button" class="btn btn-secondary btn-sm">
            Edit
        </button></a>
        <a href="<?php echo site_url()?>delete-prestataire/<?php echo $prestataire->id?>" onclick="return confirm('are you sure to delete')">
        <button type="button" class="btn btn-danger btn-sm text-white">
                    delete
        </button></a>
        </td>

      </tr>
    <?php $i++; } ?>
    </tbody>
  </table>
  <?php } else {?>
  <div class="alert alert-info" role="alert">
                    <strong>No prestataires Found!</strong>
                </div>
  <?php } ?>
</div>