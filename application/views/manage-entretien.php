<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-entretien'">
        Ajout d' entretien
    </button>

    </div>

    <div class="card-body">
        <h5 class="card-title mb-0">Manage Entretien</h5>
    </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>


<?php if(!empty($entretiens)) {?>
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
      <?php foreach($entretiens as $entretien) { ?>
        <tr>
          <td> <a href="<?php echo site_url()?>edit-entretien/<?php echo $entretien->id?>" > <?php echo $entretien->numero ?> </a> </td>

          <td> <?php echo $entretien->datedebut ?> </td>
          <td>
          <a href="<?php echo site_url()?>edit-entretien/<?php echo $entretien->id?>" >
          <button type="button" class="btn btn-secondary btn-sm">
              Edit
          </button>
          </a>
          <a href="<?php echo site_url()?>delete-entretien/<?php echo $entretien->id?>" onclick="return confirm('are you sure to delete')">
          <button type="button" class="btn btn-danger btn-sm text-white">
              delete
          </button>
          </a>
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
        <strong>No Entretiens Found!</strong>
    </div>
  <?php } ?>
</div>