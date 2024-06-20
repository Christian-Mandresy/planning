<div class="card">
    <?php if(!empty($etatpiecevoitures)) {?>
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des vehicules et la maintenance des pieces</h5>
        </div>
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th>numero</th>
                <th>piece</th>
                <th>kilometrage pour la piece</th>
                <th>kilometrage dernier entretien</th>
                <th>date dernier entretien</th>
                <th>kilometrage apres trajet</th>
                <th>kilometre avant le prochain entretien</th>
                <th>kilometrage restant</th>
            </tr>
            </thead>
            <tbody>
            <?php  foreach($etatpiecevoitures as $etatpiecevoiture) { ?>
            <tr>
                <td> <?php echo $etatpiecevoiture->numero ?> </td>
                <td> <?php echo $etatpiecevoiture->piece ?> </td>
                <td> <?php echo $etatpiecevoiture->kilometrage ?> km</td>
                <td> <?php echo $etatpiecevoiture->kmentretien ?> km</td>
                <td> <?php echo $etatpiecevoiture->entretiendate ?> </td>
                <td> <?php echo $etatpiecevoiture->kmapres ?> km</td>
                <?php if($etatpiecevoiture->kmrestant < 0) {?>
                    <td> retard de <?php echo $etatpiecevoiture->kmrestant*-1 ?> km</td>
                <?php } else {?>
                    <td> <?php echo $etatpiecevoiture->kmrestant ?> km</td>
                <?php } ?>
                <td>
                    <style>
                        .progress {
                            border-radius: 3px;
                            height: 8px;
                            margin-top:7px;
                        }
                    </style>
                    <div class="progress">
                        <?php $pourcentage=($etatpiecevoiture->kmapres-$etatpiecevoiture->kmentretien)*100/$etatpiecevoiture->kilometrage; ?>
                    <?php if($pourcentage < 50) {?>
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $pourcentage ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                    <?php } else if($pourcentage>50 and $pourcentage < 75) {?>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $pourcentage ?>%" aria-valuemin="0" aria-valuemax="100"></div>

                    <?php } else {?>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $pourcentage ?>%" aria-valuemin="0" aria-valuemax="100"></div>
                    <?php } ?>
                        
                    </div>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else {?>
    <div class="alert alert-info" role="alert">
        <strong>Pas de maintenance piece!</strong>
    </div>
    <?php } ?>
</div>