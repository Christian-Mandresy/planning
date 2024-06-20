<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-circuit'">
        Ajout de circuit
    </button>

    </div>

    <div class="card-body">
        <h5 class="card-title mb-0">Gestion de circuits</h2>
    </div>
    
  <?php if($this->session->flashdata('success')){ ?>
    <div class="col-md-4">
      <div class="alert alert-success">
          <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
      </div>
    </div>
  <?php } ?>

  <?php if($this->session->flashdata('error')){ ?>
    <div class="col-md-4">
      <div class="alert alert-danger">
          <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('error'); ?></strong>
      </div>
    </div>
  <?php } ?>

<?php if(!empty($circuits)) {?>
  <div class="col-lg-9">
  <div class="card">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>client</th>
            <th>date de début</th>
            <th>date fin</th>
          <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($circuits as $circuit) { ?>
          <tr>
            <td> <a href="<?php echo site_url()?>edit-circuit/<?php echo $circuit->id?>" > <?php echo $circuit->client ?> </a> </td>
            <td> <?php echo $circuit->datedebut ?> </td>
            <td> <?php echo $circuit->datefin ?> </td>
            <td>
            <a href="<?php echo site_url()?>edit-circuit/<?php echo $circuit->id?>" >
            <button type="button" class="btn btn-info btn-sm">
                detail
            </button></a>
            <a href="<?php echo site_url()?>modify-circuit/<?php echo $circuit->id?>" >
            <button type="button" class="btn btn-secondary btn-sm text-white">
                edit
            </button></a>
            <a href="<?php echo site_url()?>delete-circuit/<?php echo $circuit->id?>" >
            <button type="button" class="btn btn-danger btn-sm text-white" onclick="return confirm('ête vous sure de supprimer ce circuit')">
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
      <strong>No circuits Found!</strong>
  </div>
  <?php } ?>
</div>