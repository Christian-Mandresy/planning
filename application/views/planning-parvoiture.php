<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des trajets</h5>
        </div>
        <div class="card">
            <table class="table">
                <thead>
                <tr>
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
                    <td style="color: #0077b3;"> <?php echo $trajet->depart ?>  </td>
                    <td style="color: #d18d0f;"> <?php echo $trajet->arrive ?>  </td>
                    <td> <a href="<?php echo base_url()?>edit-trajet/<?php echo $trajet->id?>" > <?php echo $trajet->datedebut ?>  </td>
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
            <div class="col-md-4">
                <nav aria-label="Page navigation example">
                    <?php echo $links; ?>
                </nav>
            </div>
        </div>
    </div>
    </div>
</div>