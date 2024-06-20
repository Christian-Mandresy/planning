<div class="card">
    <div class="col-md-8">
    <div class="card-body">
    <h4 class="card-title">Ajouter une Pièce</h4>
    <form class="form-horizontal" role="form" method="post" action="<?php echo site_url()?>/add-piece-post" >
      <div class="form-group row">
          <label
              for="client"
              class="col-sm-3 text-end control-label col-form-label"
              >Nom </label
          >
          <div class="col-sm-5">
              <input
              type="text"
              class="form-control"
              id="client" name="nom"
              placeholder="nom"
              value=""
              />
          </div>
      </div>
      <div class="border-top">
            <div class="card-body">
            <button type="submit" class="btn btn-primary">
                Ajouter
            </button>
            </div>
        </div>
    </form>
    </div>
    </div>
    

    <div class="card-body">
        <h5 class="card-title mb-0">Manage Piece</h5>
    </div>
  <?php if($this->session->flashdata('success')){ ?>
  <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
  <?php } ?>


<?php if(!empty($pieces)) {?>
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
    <?php foreach($pieces as $piece) { ?>
      <tr>
        <td>  <?php echo $piece->nom ?> </td>
        <td>
        <a href="<?php echo site_url()?>edit-piece/<?php echo $piece->id?>" >
        <button type="button" class="btn btn-secondary btn-sm">
              Edit
          </button>
        </a>
        <a href="<?php echo site_url()?>delete-piece/<?php echo $piece->id?>" onclick="return confirm('are you sure to delete')">
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
        <strong>Pas de pieces!</strong>
    </div>
  <?php } ?>
</div>