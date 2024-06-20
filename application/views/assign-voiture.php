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
                    <div class="row">
                    <div class="col-md-6 col-lg-2 col-xlg-3">
                      <a href="<?php echo base_url()?>edit-circuit/<?php echo $trajet[0]->idcircuit ?>">
                        <div class="card card-hover">
                            <div class="box bg-info text-center">
                              <h1 class="font-light text-white">
                                <i class="mdi mdi-relative-scale"></i>
                              </h1>
                              <h6 class="text-white"> <?php echo $trajet[0]->client ?></h6>
                            </div>
                        </div>
                      </a>
                    </div>
                      <div class="col-md-6 col-lg-2 col-xlg-3">
                          <a href="<?php echo base_url()?>planning-calendar/">
                            <div class="card card-hover">
                              <div class="box bg-success text-center">
                                <h1 class="font-light text-white">
                                  <i class="mdi mdi-calendar-check"></i>
                                </h1>
                                <h6 class="text-white">Calendrier</h6>
                              </div>
                            </div>
                        </a>
                      </div>
                    </div>
                  </div>
                
                
                <table class="table w-auto">
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
                    <tr>
                      <td><a href="#" class="link"><?php echo $trajet[0]->depart ?></a></td>
                      <td><?php echo $trajet[0]->arrive ?></td>
                      <td><?php echo $trajet[0]->datedebut ?></td>
                      <td><?php echo $trajet[0]->heuredebut ?></td>
                      <td><?php echo $trajet[0]->datefin ?></td>
                      <td><?php echo $trajet[0]->heurefin ?></td>
                      <?php if( is_null($trajet[0]->placeprise)) {?>
                          <td> 0 </td>
                      <?php } else {?>
                          <td><?php echo $trajet[0]->placeprise ?></td>
                      <?php } ?>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>


            
            <nav aria-label="...">
              <ul class="pagination">
                  <?php if(is_null($voisin[0])) {?>
                    <li class="page-item disabled">
                      <a class="page-link" href="#" tabindex="-1">Avant</a>
                    </li>
                <?php } else {?>
                  <li class="page-item">
                      <a class="page-link" href="<?php echo base_url();?>assignement-voiture/<?php echo $voisin[0];?>">Avant</a>
                  </li>
                <?php } ?>
                
                <?php if(is_null($voisin[1])) {?>
                    <li class="page-item disabled">
                      <a class="page-link" href="#" tabindex="-1">Après</a>
                    </li>
                <?php } else {?>
                    <li class="page-item">
                        <a class="page-link" href="<?php echo base_url();?>assignement-voiture/<?php echo $voisin[1];?>">Apres</a>
                    </li>
                <?php } ?>

              </ul>
            </nav>

            <?php if(!empty($vehiculesAssigner) && !empty($chauffeurs) && empty($voisin[0]) || $retAvant == 1) {?>
              <div class="col-md-12">
                  <div class="card-body">
                    <h5 class="card-title mb-0" style="color:black;">Assignement chauffeur</h5>
                  </div>
                
                  <table class="table w-auto">
                      <thead>
                      <tr>
                          <th>numero</th>
                          <th>chauffeur</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                    <tbody>
                  <?php foreach($vehiculesAssigner as $vehicule) { ?>
                    <?php if(empty($vehicule->idchauffeur)) {?>
                      <tr>
                        <form action="<?php echo base_url()?>assignchauffeur-post" method="post">
                          <td>
                          <input type="text" readonly="readonly" name="numero" value="<?php echo $vehicule->numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">
                          </td>
                          <td>
                            <input type="hidden" name="idavant" value="<?php echo $vehicule->lastid?>">
                            <input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">
                            <input type="hidden" name="datedebut" value="<?php echo $vehicule->lastdebut ?>">
                            <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 150px; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="idchauffeur">
                            <?php $i=1; foreach($chauffeurs as $chauffeur) { ?>  
                                    <?php if($chauffeur->id == $choix->id) {?>
                                        <option value="<?php echo $chauffeur->id?>" selected><?php echo $chauffeur->nom?></option>
                                    <?php } else {?>
                                        <option value="<?php echo $chauffeur->id?>" ><?php echo $chauffeur->nom?></option>
                                    <?php } ?>
                              <?php } ?>
                            </select>
                          </td>
                          <td><button type="submit" class="btn btn-info">Assigner</button></td>
                        </form>
                      </tr>
                    <?php } else {?>
                      <tr>
                        <form action="<?php echo base_url()?>assignchauffeur-post" method="post">
                          <td>
                          <input type="text" readonly="readonly" name="numero" value="<?php echo $vehicule->numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">
                          </td>
                          <td><?php echo $vehicule->chauffeur ?></td>
                          <td>
                            <input type="hidden" name="idavant" value="<?php echo $vehicule->lastid?>">
                            <input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">
                            <input type="hidden" name="datedebut" value="<?php echo $vehicule->lastdebut ?>">
                            <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 150px; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="idchauffeur">
                            <?php $i=1; foreach($chauffeurs as $chauffeur) { ?>  
                                    <?php if($chauffeur->id == $choix->id) {?>
                                        <option value="<?php echo $chauffeur->id?>" selected><?php echo $chauffeur->nom?></option>
                                    <?php } else {?>
                                        <option value="<?php echo $chauffeur->id?>" ><?php echo $chauffeur->nom?></option>
                                    <?php } ?>
                              <?php } ?>
                            </select>
                          </td>
                          <td><button type="submit" class="btn btn-info">Changer</button></td>
                        </form>
                      </tr>
                    <?php } ?>
                  <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } ?>

            <div class="col-md-12">
                <div class="card-body">
                  <h5 class="card-title mb-0" style="color:black;">Voitures assigner</h5>
                </div>
                <?php if(!empty($vehiculesAssigner)) {?>
                  <table class="table">
                      <thead>
                      <tr>
                          <th>numero</th>
                          <th>proprietaire</th>
                          <th>chauffeur</th>
						              <th>dernier depart</th>
                          <th>dernier trajet</th>
                          <th>prochain arriver </th>
                          <th>prochain depart</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach($vehiculesAssigner as $vehicule) { ?>
                      <tr>
                    <form action="<?php echo base_url()?>rentrer-post" method="post">
                      <td> <input type="text" readonly="readonly" name="numero" value="<?php echo $vehicule->numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">  </td>
                                <?php if( is_null($vehicule->prestataire)) {?>
                                    <td> Entreprise </td>
                                <?php } else {?>
                                    <td> <?php echo $vehicule->prestataire ?> </td>
                                <?php } ?>
                                <?php if( is_null($vehicule->chauffeur)) {?>
                                    <td> pas de chauffeur </td>
                                <?php } else {?>
                                    <td> <?php echo $vehicule->chauffeur ?> </td>
                                <?php } ?>
                      <td><span> <?php echo $vehicule->lastdebut ?> </span></td>
                      <td><?php echo $vehicule->lastdepart.' vers '.$vehicule->lastarrive ?></td>

                      <?php if( is_null($vehicule->nextfin)) {?>
                        <td>  <input type="datetime-local" name="arriveparking" class="form-control" style="width: 175px;" value="<?php echo date('Y-m-d\TH:i',strtotime($trajet[0]->tdatefin)) ?>"> </td>
                      <?php } else {?>
                        <td><span> <?php echo $vehicule->nextfin?> </span></td>
                      <?php } ?>
                      <input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">
                      <input type="hidden" name="datedepart" value="<?php echo $trajet[0]->datefin." ".$trajet[0]->heurefin ?>">
                      <?php if( is_null($vehicule->nextarrive)) {?>
                        <td> <button type="submit" class="btn btn-success">Rentrer</button> 
                        
                      </td>
                      <?php } else {?>
                        <td><?php echo $vehicule->nextdepart.' vers '.$vehicule->nextarrive ?>
                      </td>
                      <?php } ?>
                      <input type="hidden" name="idchauffeur" value="<?php echo $vehicule->idchauffeur ?>">
                    </form>
                    <form action="<?php echo base_url()?>enlever-post" method="post">
                      <input type="hidden" name="idavant" value="<?php echo $vehicule->lastid?>">
                      <input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">
                      <input type="hidden" name="idapres" value="<?php echo $vehicule->nextid?>">
                      <input type="hidden" name="numero" value="<?php echo $vehicule->numero ?>">
                      <input type="hidden" name="idchauffeur" value="<?php echo $vehicule->idchauffeur ?>">
                    <td><button type="submit" class="btn btn-danger">Enlever</button></td>
                    </form>
                      </tr>
                  <?php } ?>
                      </tbody>
                  </table>
              <?php } else {?>
                <div class="col-md-6">
                  <div class="alert alert-info" role="alert">
                      <strong>Pas de voiture assigner!</strong>
                  </div>
                </div>
              <?php } ?>
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
                              <td> <?php echo $vehicule->difference ?> min</td>
                            <?php } ?>
                            <input type="hidden" name="datedernier" value="<?php echo $vehicule->datefin ?>">
                            <input type="hidden" name="datedebut" value="<?php echo $trajet[0]->datedebut." ".$trajet[0]->heuredebut ?>">
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
                            <input type="hidden" name="idactuelle" value="<?php echo $trajet[0]->id ?>">
                            <input type="hidden" name="idregionactuelle" value="<?php echo $trajet[0]->iddepart ?>">
                            <input type="hidden" name="idprochain" value="<?php echo $vehicule->idapres ?>">
                            <input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">
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
            <div class="col-md-6">
              <div class="alert alert-info" role="alert">
                <strong>Pas de trajets à vide!</strong>
              </div>
            </div>
					<?php } ?>
                </div>

                <div class="card-body">
                    <h5 class="card-title mb-0">Liste des vehicules disponible</h5>
                </div>
          <?php if(!empty($vehicules)) {?>

                <div class="container-fluid mx-auto">
                <div class="table-responsive">
                  <table class="table">
                      <thead>
                      <tr>
                          <th>numero</th>
                          <th>proprietaire</th>
                          <th>dernier arret</th>
                          <th>durée avant ce trajet</th>
                          <th>depart parking</th>
                          <th>prochain trajet</th>
                          <th>arrivé parking</th>
                          <th>Actions</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach($vehicules as $vehicule) { ?>
                      <tr>
                        <form action="<?php echo base_url()?>assign-vehicule-post" method="post">
                            <td> <input type="text" readonly="readonly" name="numero" value="<?php echo $vehicule->numero ?>" style="background-color: #e6f3fa;border-radius: 15px;text-align: center;border-color:cadetblue;width: 80px;">  </td>
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
                              <td> ------ </td>
                            <?php } elseif($vehicule->difference>=60 && $vehicule->difference<=24*60 ) {?>
                              <td> <?php echo round($vehicule->difference/60) ?> h </td>
                            <?php } elseif($vehicule->difference >24*60  ) {?>
                              <td> <?php echo round($vehicule->difference/60/24) ?> j </td>
                            <?php } else {?>
                              <td> <?php echo $vehicule->difference ?> min </td>
                            <?php } ?>

                            <input type="hidden" name="datedernier" value="<?php echo $vehicule->datefin ?>">
                            <input type="hidden" name="datedebut" value="<?php echo $trajet[0]->datedebut." ".$trajet[0]->heuredebut ?>">
                            <?php if( is_null($vehicule->datefin)) {?>
                              <td> <input type="datetime-local" name="datedepart" class="form-control" style="width: 85%;" value="<?php echo date('Y-m-d\TH:i',strtotime($trajet[0]->tdatedebut)) ?>"> </td>
                            <?php } elseif($vehicule->lieuarrive == 21) {?>
                              <td> <input type="datetime-local" name="datedepart" class="form-control" style="width: 85%;" value="<?php echo date('Y-m-d\TH:i',strtotime($vehicule->datefin)) ?>"> </td>
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
                              <td> <input type="datetime-local" name="datefin" class="form-control" style="width: 85%;" value="<?php echo date('Y-m-d\TH:i',strtotime($vehicule->dateprochain)) ?>"> </td>
                            <?php } ?>
                            <input type="hidden" name="idregionavant" value="<?php echo $vehicule->lieuarrive ?>">
                            <input type="hidden" name="idavant" value="<?php echo $vehicule->idavant ?>">
                            <input type="hidden" name="idactuelle" value="<?php echo $trajet[0]->id ?>">
                            <input type="hidden" name="idregionactuelle" value="<?php echo $trajet[0]->iddepart ?>">
                            <input type="hidden" name="idprochain" value="<?php echo $vehicule->idapres ?>">
                            <input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">
                            <input type="hidden" name="idchauffeur" value="<?php echo $vehicule->idchauffeur ?>">
                        <td>
                          <button type="submit" class="btn btn-info">Assign</button>
                        </form> 
                        </td>
                      </tr>
                      <?php } ?>
                      </tbody>
                  </table>
                  </div>
                </div>
            <?php } else {?>
              <div class="col-md-6">
                <div class="alert alert-info" role="alert">
                  <strong>Ce trajet n'utilise pas de voiture!</strong>
                </div>
              </div>
          <?php } ?>
    </div>
</div>
