<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-visite'">
        Ajout de visite technique
    </button>

    </div>

    <div class="card-body">
        <h5 class="card-title mb-0">Gestion de Visite technique</h2>
    </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>

<?php if(!empty($visites)) {?>
  <div class="col-lg-9">
  <div class="card">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>numero</th>
            <th>date de debut</th>
          <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($visites as $visite) { ?>
          <tr>
            <td> <a href="<?php echo site_url()?>edit-visite/<?php echo $visite->id?>" > <?php echo $visite->numero ?> </a> </td>
            <td> <?php echo $visite->datedebut ?> </td>
            <td>
            <a href="<?php echo site_url()?>edit-visite/<?php echo $visite->id?>" >
                <button type="button" class="btn btn-secondary btn-sm">
                    Edit
                </button>
            </a>
            <a href="<?php echo site_url()?>delete-visite/<?php echo $visite->id?>" onclick="return confirm('are you sure to delete')">
            <button type="button" class="btn btn-danger btn-sm text-white">
                delete
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
                    <strong>No Visites Found!</strong>
                </div>
  <?php } ?>
</div>