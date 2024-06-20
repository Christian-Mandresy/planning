<div class="card">
<?php if(!empty($trajets)) {?>
    <div class="card-body">
        <h5 class="card-title mb-0">Resultat de la recherche</h5>
    </div>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <table class="table mx-auto">
                <thead class="thead-light">
                <tr>
                    <th>numero</th>
                    <th>depart</th>
                    <th>arrive</th>
                    <th>date de debut</th>
                    <th>date de fin</th>
                    <th>client</th>
                    <th>chauffeur</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($trajets as $trajet) { ?>
                <tr>
                    <td><?php echo $trajet->numero ?></td>
                    <td><?php echo $trajet->depart ?></td>
                    <td><?php echo $trajet->arrive ?></td>
                    <td><?php echo $trajet->datedebut ?></td>
                    <td><?php echo $trajet->datefin ?></td>
                    <td><?php echo $trajet->client ?></td>
                    <td><?php echo $trajet->chauffeur ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    
<?php } else {?>
<div class="alert alert-info" role="alert">
    <strong>No Vehicules Found!</strong>
</div>
<?php } ?>
</div>