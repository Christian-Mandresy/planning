<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>edit-prestataire-post">
        <div class="card-body">
            <h4 class="card-title">Modifier prestataire</h4>
            <div class="form-group row">
                <input type="hidden" value="<?php echo $prestataire[0]->id ?>"   name="prestataire_id">
                <label
                    for="nom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Nom</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="nom" name="nom"
                    placeholder="nom"
                    value="<?php echo $prestataire[0]->nom ?>"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Contact</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="prenom" name="contact"
                    placeholder="contact"
                    value="<?php echo $prestataire[0]->contact ?>"
                    />
                </div>
            </div>
        </div>
        <div class="border-top">
            <div class="card-body">
            <button type="submit" class="btn btn-primary">
                modifier
            </button>
            </div>
        </div>
        </form>
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des vehicules</h5>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>SL No</th>
                <th>numero</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach($vehicules as $vehicule) { ?>
            <tr>
                <td> <?php echo $i; ?> </td>
                <td> <a href="<?php echo base_url()?>edit-vehicule/<?php echo $vehicule->numero?>" > <?php echo $vehicule->numero ?> </a> </td>

                <td>
                <a href="<?php echo base_url()?>change-status-vehicule/<?php echo $vehicule->numero ?>?" > 
                <button type="button" class="btn btn-danger btn-sm text-white">
                <?php if($vehicule->status==0){ echo "Activate"; } else { echo "Deactivate"; } ?>
                </button></a>
                <a href="<?php echo base_url()?>edit-vehicule/<?php echo $vehicule->numero?>" >
                <button type="button" class="btn btn-secondary btn-sm">
                Edit
                  </button></a>
            
                </td>

            </tr>
            <?php $i++; } ?>
            </tbody>
        </table>
        <div class="card-body">
            <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-vehicule-prestataire/<?php echo $prestataire[0]->id ?>'">
                Ajout de voiture
            </button>
        </div>
    </div>
</div>