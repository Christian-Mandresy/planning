<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Ajouter une voiture</h4>
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title mb-0" style="color:black;">Description du trajet</h5>
                </div>
                <div class="card-body">
                  <h6 class="card-title mb-0" style="color:black;"><?php echo $trajets[0]->client ?></h6>
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">depart</th>
                      <th scope="col">arrive</th>
                      <th scope="col">date de depart</th>
                      <th scope="col">heure</th>
                      <th scope="col">date d'arrive</th>
                      <th scope="col">heure</th>
                      <th scope="col">place disponible</th>
                    </tr>
                  </thead>
                  <tbody>
				  <?php foreach($trajets as $trajet) { ?>
                    <tr>
                      <td><a href="#" class="link"><?php echo $trajet->depart ?></a></td>
                      <td><?php echo $trajet->arrive ?></td>
                      <td><?php echo $trajet->datedebut ?></td>
                      <td><?php echo $trajet->heuredebut ?></td>
                      <td><?php echo $trajet->datefin ?></td>
                      <td><?php echo $trajet->heurefin ?></td>
                      <?php if( is_null($trajet->placeprise)) {?>
                          <td> 0 </td>
                      <?php } else {?>
                          <td><?php echo $trajet->placeprise ?></td>
                      <?php } ?>
                    </tr>
				  <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
		</div>

        <div class="card-body">
                    <h5 class="card-title mb-0">Liste des vehicules avec trajets à vide</h5>
                </div>
                <div class="container-fluid">
					<?php if(!empty($avides)) {?>
                  <table class="table">
                      <thead>
                      <tr>
                          <th>numero</th>
                          <th>proprietaire</th>
                          <th>dernier arret</th>
                          <th>durée avant ce trajet</th>
                          <th>date dernier trajet</th>
                          <th>prochain trajet</th>
                          <th>date du prochain trajet</th>
                          <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>

                      <?php foreach($avides as $vehicule) { ?>
                      <tr>
                        <form action="<?php echo base_url()?>assign-vehicule-post" method="post">
							<input type="hidden" name="iddebut" value="<?php echo $trajets[0]->id ?>">
							<input type="hidden" name="datedebut1" value="<?php echo $trajets[0]->tdatedebut ?>">
							<input type="hidden" name="datefin1" value="<?php echo $trajets[0]->tdatefin ?>">
							<input type="hidden" name="idregionactuelle" value="<?php echo $trajets[0]->iddepart ?>">
							<input type="hidden" name="datedebut2" value="<?php echo end($trajets)->tdatedebut ?>">
							<input type="hidden" name="idfin" value="<?php echo end($trajets)->id ?>">
							<input type="hidden" name="idcircuit" value="<?php echo $trajets[0]->idcircuit ?>">
                            <td> <input type="text" readonly="readonly" name="numero" value="<?php echo $vehicule->numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">  </td>
                            <?php if( is_null($vehicule->nom)) {?>
                                <td> Entreprise </td>
                            <?php } else {?>
                                <td> <?php echo $vehicule->nom ?> </td>
                            <?php } ?>

                            <?php if( is_null($vehicule->depart)) {?>
                              <td> Parking </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->depart ?> </td>
                            <?php } ?>
                            <?php if( is_null($vehicule->difference)) {?>
                              <td> -------- </td>
                            <?php } elseif($vehicule->difference>=60 && $vehicule->difference<=24*60 ) {?>
                              <td> <?php echo round($vehicule->difference/60) ?> heures </td>
                            <?php } elseif($vehicule->difference >24*60  ) {?>
                              <td> <?php echo round($vehicule->difference/60/24) ?> jours </td>
                            <?php } elseif($vehicule->difference>=0 && $vehicule->difference < 60 ) {?>
                              <td> <?php echo $vehicule->difference ?> minutes</td>
                            <?php } ?>
                            <input type="hidden" name="datedernier" value="<?php echo $vehicule->datefin ?>">
                            <input type="hidden" name="datedebut" value="<?php echo $trajets[0]->datedebut." ".$trajets[0]->heuredebut ?>">
                            <?php if( is_null($vehicule->datedebut)) {?>
                              <td> <input type="datetime-local" name="datedepart" class="form-control" style="width: 150px;"> </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->datedebut ?> </td>
                            <?php } ?>

                            <?php if( is_null($vehicule->departprochain)) {?>
                              <td> -------- </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->departprochain ?> </td>
                            <?php } ?>

                            <?php if( is_null($vehicule->dateprochain)) {?>
                              <td> -------- </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->dateprochain ?> </td>
                            <?php } ?>
                            <input type="hidden" name="avide" value="1">
                            <input type="hidden" name="idregionavant" value="<?php echo $vehicule->lieuarrive ?>">
                            <input type="hidden" name="idregionapres" value="<?php echo $vehicule->lieuprochain ?>">
                            <input type="hidden" name="idavant" value="<?php echo $vehicule->idavant ?>">
                            <input type="hidden" name="idprochain" value="<?php echo $vehicule->idapres ?>">
                            <input type="hidden" name="idchauffeur" value="<?php echo $vehicule->idchauffeur ?>">
                        <td>
                          <button type="submit" class="btn btn-info">Assigner</button>
                        </form> 
                    </td>
                      </tr>
                      <?php } ?>
                      </tbody>
                  </table>
					<?php } else {?>
						<div class="alert alert-info" role="alert">
							<strong>Pas de trajets à vide!</strong>
						</div>
					<?php } ?>
                </div>

                <div class="card-body">
                    <h5 class="card-title mb-0">Liste des vehicules disponible</h5>
                </div>
                <div class="container-fluid">
                  <table class="table">
                      <thead>
                      <tr>
                          <th>numero</th>
                          <th>proprietaire</th>
                          <th>dernier arret</th>
                          <th>durée avant ce trajet</th>
                          <th>date dernier trajet</th>
                          <th>prochain trajet</th>
                          <th>date du prochain trajet</th>
                          <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach($vehicules as $vehicule) { ?>
                      <tr>
                        <form action="<?php echo base_url()?>assign-vehicule-post" method="post">
                          <input type="hidden" name="iddebut" value="<?php echo $trajets[0]->id ?>">
                          <input type="hidden" name="datedebut1" value="<?php echo $trajets[0]->tdatedebut ?>">
                          <input type="hidden" name="idregionactuelle" value="<?php echo $trajets[0]->iddepart ?>">
                          <input type="hidden" name="datedebut2" value="<?php echo end($trajets)->tdatedebut ?>">
                          <input type="hidden" name="idfin" value="<?php echo end($trajets)->id ?>">
                          <input type="hidden" name="idcircuit" value="<?php echo $trajets[0]->idcircuit ?>">
                            <td> <input type="text" readonly="readonly" name="numero" value="<?php echo $vehicule->numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">  </td>
                            <?php if( is_null($vehicule->nom)) {?>
                                <td> Entreprise </td>
                            <?php } else {?>
                                <td> <?php echo $vehicule->nom ?> </td>
                            <?php } ?>

                            <?php if( is_null($vehicule->arrive)) {?>
                              <td> Parking </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->arrive ?> </td>
                            <?php } ?>

                            <?php if( is_null($vehicule->difference)) {?>
                              <td> -------- </td>
                            <?php } elseif($vehicule->difference>=60 && $vehicule->difference<=24*60 ) {?>
                              <td> <?php echo round($vehicule->difference/60) ?> heures </td>
                            <?php } elseif($vehicule->difference >24*60  ) {?>
                              <td> <?php echo round($vehicule->difference/60/24) ?> jours </td>
                            <?php } ?>

                            <input type="hidden" name="datedernier" value="<?php echo $vehicule->datefin ?>">
                            <input type="hidden" name="datedebut" value="<?php echo $trajets[0]->datedebut." ".$trajets[0]->heuredebut ?>">
                            <?php if( is_null($vehicule->datefin)) {?>
                              <td> <input type="datetime-local" name="datedepart" class="form-control" style="width: 200px;" value="<?php echo $trajets[0]->datedebut." ".$trajets[0]->heuredebut ?>"> </td>
                            <?php } elseif($vehicule->lieuarrive == 21) {?>
                              <td> <input type="datetime-local" name="datedepart" class="form-control" style="width: 200px;" value="<?php echo $vehicule->datefin ?>"> </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->datefin ?> </td>
                            <?php } ?>

                            <?php if( is_null($vehicule->departprochain)) {?>
                              <td> -------- </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->departprochain ?> </td>
                            <?php } ?>

                            <?php if( is_null($vehicule->dateprochain)) {?>
                              <td> -------- </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->dateprochain ?> </td>
                            <?php } ?>
                            <input type="hidden" name="idregionavant" value="<?php echo $vehicule->lieuarrive ?>">
                            <input type="hidden" name="idavant" value="<?php echo $vehicule->idavant ?>">
                            <input type="hidden" name="idprochain" value="<?php echo $vehicule->idapres ?>">
                        <td>
                          <button type="submit" class="btn btn-info">Assigner</button>
                        </form> 
                    </td>
                      </tr>
                      <?php } ?>
                      </tbody>
                  </table>
                </div>
    </div>
</div>
