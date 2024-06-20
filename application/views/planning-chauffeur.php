<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-chauffeur'">
        Ajout de chauffeur
    </button>

    </div>

    <div class="card-body">
        <h5 class="card-title mb-0">Gestion de Chauffeurs</h2>
    </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($chauffeurs)) {?>
  <div class="col-lg-9">
  <div class="card">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>nom</th>
        <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($chauffeurs as $chauffeur) { ?>
        <tr>
          <td> <a href="<?php echo site_url()?>edit-chauffeur/<?php echo $chauffeur->id?>" > <?php echo $chauffeur->nom ?> </a> </td>

          <td>
          <a href="<?php echo site_url()?>planning-parchauffeur/<?php echo $chauffeur->id?>" >
          <button type="button" class="btn btn-info btn-sm">
              planning
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
                    <strong>No Chauffeurs Found!</strong>
                </div>
  <?php } ?>
</div>