<div class="col-md-12">
        <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-0" style="color:black;">Description du trajet</h5>
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

            <div class="card-body">
                <h5 class="card-title mb-0">Trajets de la voiture</h5>
            </div>
        
            <div class="card">
                <div class="container-fluid">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>depart</th>
                            <th>arrive</th>
                            <th>date de depart</th>
                            <th>date d' arrive</th>
                        </tr>
                        </thead>
                        <tbody>
                            <!---- trajet adjacent au trajet avant --->
                            <tr>
                                <td><?php echo $avantadjacent[0]->circuitavant ?></td>
                                <td><?php echo $avantadjacent[0]->ldepartavant ?></td>
                                <td><?php echo $avantadjacent[0]->larriveavant ?></td>
                                <td><?php echo $avantadjacent[0]->debutavant ?></td>
                                <td><?php echo $avantadjacent[0]->finavant ?></td>
                            </tr>

                            <!---- trajet avant --->
                            <tr>
                                <td><?php echo $avantadjacent[0]->circuitapres ?></td>
                                <td><?php echo $avantadjacent[0]->ldepartapres ?></td>
                                <td><?php echo $avantadjacent[0]->larriveapres ?></td>
                                <td><?php echo $avantadjacent[0]->debutapres ?></td>
                                <td><?php echo $avantadjacent[0]->finapres ?></td>
                            </tr>
                        

                            <!---- trajet à enlever --->
                            <tr style="border-color:aqua;border-width:2px;border-radius: 35px;">
                                <td><?php echo $trajet[0]->id ?></td>
                                <td><?php echo $trajet[0]->depart ?></td>
                                <td><?php echo $trajet[0]->arrive ?></td>
                                <td><?php echo $trajet[0]->datedebut.' '.$trajet[0]->heuredebut ?></td>
                                <td><?php echo $trajet[0]->datefin.' '.$trajet[0]->heurefin ?></td>
                            </tr>

                            <!---- trajet apres --->
                            <tr>
                                <td><?php echo $apresadjacent[0]->circuitavant ?></td>
                                <td><?php echo $apresadjacent[0]->ldepartavant ?></td>
                                <td><?php echo $apresadjacent[0]->larriveavant ?></td>
                                <td><?php echo $apresadjacent[0]->debutavant ?></td>
                                <td><?php echo $apresadjacent[0]->finavant ?></td>
                            </tr>

                            <!---- trajet adjacent au trajet apres --->
                            <tr>
                                <td><?php echo $apresadjacent[0]->circuitapres ?></td>
                                <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                <td><?php echo $apresadjacent[0]->larriveapres ?></td>
                                <td><?php echo $apresadjacent[0]->debutapres ?></td>
                                <td><?php echo $apresadjacent[0]->finapres ?></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title mb-0">Nouveaux trajets</h5>
                        </div>
                        <table class="table">
                        <thead>
                            <tr>
                            <th scope="col">depart</th>
                            <th scope="col">arrive</th>
                            <th scope="col">date de depart</th>
                            <th scope="col">date d' arrive</th>
                            </tr>
                        </thead>
                    <tbody> 
                    <form action="<?php echo base_url()?>enlever-post" method="POST">
                        <input type="hidden" name="numero" value="<?php echo $numero ?>">
                        <input type="hidden" name="idtrajetactu" value="<?php echo $trajet[0]->id ?>">
                        <input type="hidden" name="idtrajetavant" value="<?php echo $avantadjacent[0]->idapres ?>">
                        <input type="hidden" name="idpremiertrajet" value="<?php echo $avantadjacent[0]->idavant ?>">
                    
                            <?php if(!empty($avantadjacent[0]->ldepartavant) && $avantadjacent[0]->departapres!=21) {?>
                                <!--cas 3 si depart  avec trajet avant -->
                                <input type="hidden" name="suppression" value="cas3-1">
                                <!-- trajet avant -->
                                <tr>
                                    <input type="hidden" name="adjavant" value="<?php echo $avantadjacent[0]->idavant ?>">
                                    <td><?php echo $avantadjacent[0]->ldepartavant ?></td>
                                    <td><?php echo $avantadjacent[0]->larriveavant ?></td>
                                    <td><?php echo $avantadjacent[0]->debutavant ?></td>
                                    <td><?php echo $avantadjacent[0]->finavant ?></td>
                                </tr>


                                <?php if(!empty($avantadjacent[0]->circuitapres)) {?>
                                    <!-- trajet avant -->
                                    <tr>
                                        <input type="hidden" name="adjavant" value="<?php echo $avantadjacent[0]->idavant ?>">
                                        <td><?php echo $avantadjacent[0]->ldepartapres ?></td>
                                        <td><?php echo $avantadjacent[0]->larriveapres ?></td>
                                        <td><?php echo $avantadjacent[0]->debutapres ?></td>
                                        <td><?php echo $avantadjacent[0]->finapres ?></td>
                                    </tr>
                                <?php } else {?>
                                        <input type="hidden" name="liaisonavant" value="<?php echo $avantadjacent[0]->idavant ?>">
                                        <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                <?php } ?>


                                <?php if(!empty($apresadjacent[0]->circuitavant)) {?>

                                    
                                    <tr>   
                                    <!-- si le  trajet avant est principal ou trajet de liaison -->
                                        <?php if(!empty($avantadjacent[0]->circuitapres)) {?>
                                            <input type="hidden" name="idregiondepart1" value="<?php echo $avantadjacent[0]->arriveapres ?>">
                                            <td><?php echo $avantadjacent[0]->larriveapres ?></td>
                                        <?php } else {?>
                                            <input type="hidden" name="idregiondepart1" value="<?php echo $avantadjacent[0]->arriveavant ?>">
                                            <td><?php echo $avantadjacent[0]->larriveavant ?></td>
                                        <?php } ?>
                                        <td>Parking</td>

                                        <!-- si le  trajet avant est principal ou trajet de liaison -->
                                        <?php if(!empty($avantadjacent[0]->circuitapres)) {?>
                                            <input type="hidden" name="datedebut1" value="<?php echo $avantadjacent[0]->finapres ?>">
                                            <td><?php echo $avantadjacent[0]->finapres ?></td>
                                        <?php } else {?>
                                            <input type="hidden" name="datedebut1" value="<?php echo $avantadjacent[0]->finavant ?>">
                                            <td><?php echo $avantadjacent[0]->finavant ?></td>
                                        <?php } ?>
                                        
                                        <td><input type="datetime-local" name="datearrive1" id=""></td>
                                        
                                    </tr>

                                    <tr>
                                        <td>Parking</td>
                                        <!-- si le prochain trajet est principal ou trajet de liaison -->
                                        <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                            <input type="hidden" name="idregionarrive2" value="<?php echo $apresadjacent[0]->departavant ?>">
                                            <td><?php echo $apresadjacent[0]->ldepartavant ?></td>
                                        <?php } else {?>
                                            <input type="hidden" name="idregionarrive2" value="<?php echo $apresadjacent[0]->departapres ?>">
                                            <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                        <?php } ?>

                                        <td><input type="datetime-local" name="datedepart2" id=""></td>

                                        <!-- si le prochain trajet est principal ou trajet de liaison -->
                                        <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                            <input type="hidden" name="datearrive2" value="<?php echo $apresadjacent[0]->debutavant ?>">
                                            <td><?php echo $apresadjacent[0]->debutavant ?></td>
                                        <?php } else {?>
                                            <input type="hidden" name="datearrive2" value="<?php echo $apresadjacent[0]->debutapres ?>">
                                            <td><?php echo $apresadjacent[0]->debutapres ?></td>
                                        <?php } ?> 
                                    </tr>

                                    <!---- trajet apres --->
                                    <tr>
                                        <input type="hidden" name="idcircuitapres" value="<?php echo $apresadjacent[0]->circuitavant ?>">
                                        <input type="hidden" name="idderniertrajet2" value="<?php echo $apresadjacent[0]->idavant ?>">
                                        <td><?php echo $apresadjacent[0]->ldepartavant ?></td>
                                        <td><?php echo $apresadjacent[0]->larriveavant ?></td>
                                        <td><?php echo $apresadjacent[0]->debutavant ?></td>
                                        <td><?php echo $apresadjacent[0]->finavant ?></td>
                                    </tr>

                                    
                                <?php } else {?>
                                <!-- si avide donc id du trajet à supprimer -->
                                <input type="hidden" name="idtrajetliaison2" value="<?php echo $apresadjacent[0]->idavant ?>">
                                <!-- le trajet sera le prochain -->
                                <input type="hidden" name="idderniertrajet2" value="<?php echo $apresadjacent[0]->idapres ?>">
                                <?php } ?>

                                    
                                    <!---- trajet adjacent au trajet apres --->
                                <tr>
                                    <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                    <td><?php echo $apresadjacent[0]->larriveapres ?></td>
                                    <td><?php echo $apresadjacent[0]->debutapres ?></td>
                                    <td><?php echo $apresadjacent[0]->finapres ?></td>
                                </tr>
                                

                                <tr>
                                    <td><button type="submit" class="btn btn-info">Valider</button></td>
                                </tr>
                    </form>

                            <?php if(!empty($apresadjacent[0]->circuitapres)) {?>
                                    <form action="<?php echo base_url()?>enlever-post" method="POST">
                                    <input type="hidden" name="numero" value="<?php echo $numero ?>">
                                    <input type="hidden" name="idtrajetactu" value="<?php echo $trajet[0]->id ?>">
                                    <input type="hidden" name="idtrajetavant" value="<?php echo $avantadjacent[0]->idapres ?>">
                                    <input type="hidden" name="idpremiertrajet" value="<?php echo $avantadjacent[0]->idavant ?>">
                                

                                            <tr>
                                                <td>-------------------------------</td>
                                            </tr>
                                            
                                            <input type="hidden" name="suppression" value="cas3-2">
                                            <!-- trajet avant -->
                                            <tr>
                                                <input type="hidden" name="adjavant" value="<?php echo $avantadjacent[0]->idavant ?>">
                                                <td><?php echo $avantadjacent[0]->ldepartavant ?></td>
                                                <td><?php echo $avantadjacent[0]->larriveavant ?></td>
                                                <td><?php echo $avantadjacent[0]->debutavant ?></td>
                                                <td><?php echo $avantadjacent[0]->finavant ?></td>
                                            </tr>


                                            <?php if(!empty($avantadjacent[0]->circuitapres)) {?>
                                                <!-- trajet avant -->
                                                <tr>
                                                    <input type="hidden" name="adjavant" value="<?php echo $avantadjacent[0]->idapres ?>">
                                                    <td><?php echo $avantadjacent[0]->ldepartapres ?></td>
                                                    <td><?php echo $avantadjacent[0]->larriveapres ?></td>
                                                    <td><?php echo $avantadjacent[0]->debutapres ?></td>
                                                    <td><?php echo $avantadjacent[0]->finapres ?></td>
                                                </tr>
                                            <?php } else {?>
                                                <input type="hidden" name="liaisonavant" value="<?php echo $avantadjacent[0]->idavant ?>">
                                                <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                            <?php } ?>


                                            <tr>
                                                <?php if(!empty($avantadjacent[0]->circuitapres)) {?>
                                                    <input type="hidden" name="idregiondepart" value="<?php echo $avantadjacent[0]->arriveapres ?>">
                                                    <td><?php echo $avantadjacent[0]->larriveapres ?></td>
                                                <?php } else {?>
                                                    <input type="hidden" name="idregiondepart" value="<?php echo $avantadjacent[0]->arriveavant ?>">
                                                    <td><?php echo $avantadjacent[0]->larriveavant ?></td>
                                                <?php } ?>

                                                <!-- si le prochain trajet est principal ou trajet de liaison -->
                                                <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                                    <input type="hidden" name="idregionarrive" value="<?php echo $apresadjacent[0]->departavant ?>">
                                                    <td><?php echo $apresadjacent[0]->ldepartavant ?></td>
                                                <?php } else {?>
                                                    <input type="hidden" name="idregionarrive" value="<?php echo $apresadjacent[0]->departapres ?>">
                                                    <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                                <?php } ?>

                                                <?php if(!empty($avantadjacent[0]->circuitapres)) {?>
                                                    <input type="hidden" name="datedepart" value="<?php echo $avantadjacent[0]->debutapres ?>">
                                                    <td><?php echo $avantadjacent[0]->debutapres ?></td>
                                                <?php } else {?>
                                                    <input type="hidden" name="datedepart" value="<?php echo $avantadjacent[0]->debutavant ?>">
                                                    <td><?php echo $avantadjacent[0]->debutavant ?></td>
                                                <?php } ?>
                                                
                                                <!-- si le prochain trajet est principal ou trajet de liaison -->
                                                <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                                    <input type="hidden" name="datefinarrive" value="<?php echo $apresadjacent[0]->debutavant ?>">
                                                    <td><?php echo $apresadjacent[0]->debutavant ?></td>
                                                <?php } else {?>
                                                    <input type="hidden" name="datefinarrive" value="<?php echo $apresadjacent[0]->debutapres ?>">
                                                    <td><?php echo $apresadjacent[0]->debutapres ?></td>
                                                <?php } ?>
                                            </tr>
                                            

                                            <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                                <!---- trajet apres --->
                                                <tr>
                                                    <input type="hidden" name="idcircuitapres" value="<?php echo $apresadjacent[0]->circuitavant ?>">
                                                    <input type="hidden" name="idderniertrajet" value="<?php echo $apresadjacent[0]->idavant ?>">
                                                    <td><?php echo $apresadjacent[0]->ldepartavant ?></td>
                                                    <td><?php echo $apresadjacent[0]->larriveavant ?></td>
                                                    <td><?php echo $apresadjacent[0]->debutavant ?></td>
                                                    <td><?php echo $apresadjacent[0]->finavant ?></td>
                                                </tr>
                                            <?php } else {?>
                                                <!-- si avide donc id du trajet à supprimer -->
                                                <input type="hidden" name="idtrajetliaison" value="<?php echo $apresadjacent[0]->idavant ?>">
                                                <!-- le trajet sera le prochain -->
                                                <input type="hidden" name="idderniertrajet" value="<?php echo $apresadjacent[0]->idapres ?>">
                                            <?php } ?>

                                            <!---- trajet adjacent au trajet apres --->
                                            <tr>
                                                <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                                <td><?php echo $apresadjacent[0]->larriveapres ?></td>
                                                <td><?php echo $apresadjacent[0]->debutapres ?></td>
                                                <td><?php echo $apresadjacent[0]->finapres ?></td>
                                            </tr>


                                   
                                </tbody>
                                
                                </table>

                        
                                </div>
                                <div class="card-body">
                                        <button type="submit" class="btn btn-info">Valider</button>
                                </div>
                                </form>
                        <?php } ?>
                <?php } ?>
                
            </div>

        </div>
</div>
