<div class="col-md-12">
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des trajets</h5>
        </div>
        <?php if(!empty($trajets)) {?>
            <div class="card">
                <table class="table">
                    <thead>
                    <tr>
                        <th>id</th>
                        <th>depart</th>
                        <th>arrive</th>
                        <th>date de depart</th>
                        <th>date d' arrive</th>
                        <th>client</th>
                        <th>chauffeur</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($trajets as $trajet) { ?>
                    <tr>
                        <td><?php echo $trajet->id ?></td>
                        <td style="color: #0077b3;"> <?php echo $trajet->depart ?>  </td>
                        <td style="color: #d18d0f;"> <?php echo $trajet->arrive ?>  </td>
                        <td> <a href="<?php echo base_url()?>assignement-voiture/<?php echo $trajet->id?>" > <?php echo $trajet->datedebut ?>  </td>
                        <td> <?php echo $trajet->datefin ?>  </td>
                        <?php if(empty($trajet->client)) {?>
                            <td> trajet à vide  </td>
                        <?php } else {?>
                            <td> <?php echo $trajet->client ?>  </td>
                        <?php } ?>
                        <?php if(empty($trajet->chauffeur)) {?>
                            <td> pas de chauffeur  </td>
                        <?php } else {?>
                            <td> <?php echo $trajet->chauffeur ?>  </td>
                        <?php } ?>
                    </tr>
                    <?php  } ?>
                    </tbody>
                </table>
            </div>
        <?php } else {?>
            <div class="alert alert-info" role="alert">
                <strong>Pas de vehicule en attente!</strong>
            </div>
    <?php  } ?>
</div>