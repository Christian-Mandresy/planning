 <?php if(!empty($visites[0]->dernierdate)) {?>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-0">visite technique</h5>
        </div>
        
          <table class="table table-hover">
            <thead>
              <tr>
                <th>numero</th>
                <th>dernier visite</th>
                <th>duree </th>
                <th>Date du jour</th>
                <th>Date de fin</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($visites as $visite) { ?>
              <tr>
                <td>  <?php echo $visite->numero ?> </td>
                <td> <?php echo $visite->dernierdate ?> </td>
                <td> <?php echo $visite->duree ?> mois </td>
                <td> <?php echo $visite->maintenant ?> </td>
                <td> <?php echo $visite->datefin ?> </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
          <?php } else {?>
          <div class="alert alert-info" role="alert">
                            <strong>No Visites Found!</strong>
                        </div>
          <?php } ?>

        <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-success">
            <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="col-md-12">
  <div class="card">
  <?php if(!empty($vehiculepieces)) {?>
    <div class="card-body">
          <h5 class="card-title mb-0">Entretien Pieces</h5>
    </div>
    <table class="table table-hover">
    <thead>
      <tr>
        <th>piece</th>
        <th>kilometrage</th>
        <th>date d'entretien</th>
       <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($vehiculepieces as $vehiculepiece) { ?>
      <tr>
        <td> <a href="<?php echo site_url()?>edit-vehiculepiece/<?php echo $vehiculepiece->id?>" > <?php echo $vehiculepiece->piece ?> </a> </td>
        <td><?php echo $vehiculepiece->kilometrage ?></td>
        <td><?php echo $vehiculepiece->entretiendate ?></td>
        <td>
        <a href="<?php echo site_url()?>edit-vehiculepiece/<?php echo $vehiculepiece->id?>" ><button type="button" class="btn btn-secondary btn-sm text-white">
                edit
            </button></a>
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
                    <strong>No Vehiculepieces Found!</strong>
                </div>
  <?php } ?>
</div>
</div>