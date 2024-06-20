<div class="card">
    <div class="card-body">
    <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-kilometragevoiture'">
        Ajout de compte rendue
    </button>

    </div>

    <div class="card-body">
        <h5 class="card-title mb-0">Compte rendue</h5>
    </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
          </div>
  <?php } ?>


<?php if(!empty($kilometragevoitures)) {?>
  <div class="col-lg-9 ">
    <div class="card">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>numero</th>
            <th>Date de rendue</th>
            <th>Kilometrage avant</th>
            <th>Kilometrage apres</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($kilometragevoitures as $kilometragevoiture) { ?>
          <tr>
            <td> <a href="<?php echo site_url()?>edit-kilometragevoiture/<?php echo $kilometragevoiture->id?>" > <?php echo $kilometragevoiture->numero ?> </a> </td>
            <td> <?php echo $kilometragevoiture->daterendu ?> </td>
            <td> <?php echo $kilometragevoiture->kmavant ?> km </td>
            <td> <?php echo $kilometragevoiture->kmapres ?> km </td>
            <td>
            <a href="<?php echo site_url()?>edit-kilometragevoiture/<?php echo $kilometragevoiture->id?>" >
            <button type="button" class="btn btn-secondary btn-sm">
                Edit
            </button>
            </a>
            <a href="<?php echo site_url()?>delete-kilometragevoiture/<?php echo $kilometragevoiture->id?>" onclick="return confirm('are you sure to delete')">
            <button type="button" class="btn btn-danger btn-sm text-white">
                delete
            </button>
            </a>
            </td>

          </tr>
        <?php } ?>
        </tbody>
      </table>
      <div class="col-md-4">
        <nav aria-label="Page navigation example">
            <?php echo $links; ?>
        </nav>
      </div>
      <?php } else {?>
        <div class="alert alert-info" role="alert">
            <strong>Pas de compte rendue!</strong>
        </div>
      <?php } ?>
    </div>
  </div>
</div>