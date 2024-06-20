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

            <?php if( empty($apresadjacent[0]->circuitapres)) {?>
            <?php } else {?>
                <td><?php echo $trajet[0]->placeprise ?></td>
            <?php } ?>

            <div class="card">
                <form action="<?php echo base_url()?>enlever-post" method="POST">
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
                        <input type="hidden" name="numero" value="<?php echo $numero ?>">
                        <input type="hidden" name="idtrajetactu" value="<?php echo $trajet[0]->id ?>">
                        <input type="hidden" name="idtrajetavant" value="<?php echo $avantadjacent[0]->idapres ?>">
                        <input type="hidden" name="idpremiertrajet" value="<?php echo $avantadjacent[0]->idavant ?>">
                        
                    <?php if(empty($avantadjacent[0]->ldepartavant) && $avantadjacent[0]->departapres==21 ) { ?>
                            <!--cas 1 si depart parking sans trajet avant -->
                            <input type="hidden" name="suppression" value="cas1">
                            <?php if(!empty($apresadjacent[0]->circuitavant) && !empty($apresadjacent[0]->idapres)) {?>
                                <tr>
                                    <input type="hidden" name="idregiondepart" value="<?php echo $avantadjacent[0]->departapres ?>">
                                    <td><?php echo $avantadjacent[0]->ldepartapres ?></td>

                                    <!-- si le prochain trajet est principal ou trajet de liaison -->
                                    <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                        <input type="hidden" name="idregionarrive" value="<?php echo $apresadjacent[0]->departavant ?>">
                                        <td><?php echo $apresadjacent[0]->ldepartavant ?></td>
                                    <?php } else {?>
                                        <input type="hidden" name="idregionarrive" value="<?php echo $apresadjacent[0]->departapres ?>">
                                        <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                    <?php } ?>

                            
                                    <td><input type="datetime-local" name="depart" id=""></td>
                                    <!-- si le prochain trajet est principal ou trajet de liaison -->
                                    <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                        <input type="hidden" name="datefinarrive" value="<?php echo $apresadjacent[0]->debutavant ?>">
                                        <td><?php echo $apresadjacent[0]->debutavant ?></td>
                                    <?php } else {?>
                                        <input type="hidden" name="datefinarrive" value="<?php echo $apresadjacent[0]->debutapres ?>">
                                        <td><?php echo $apresadjacent[0]->debutapres ?></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

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
                    <?php } elseif(!empty($avantadjacent[0]->ldepartavant) && $avantadjacent[0]->departapres==21) {?>
                            <!--cas 2 si depart parking avec trajet avant -->
                            <input type="hidden" name="suppression" value="cas2">

                                <!-- trajet avant -->
                                <tr>
                                    <input type="hidden" name="adjavant" value="<?php echo $avantadjacent[0]->idavant ?>">
                                    <td><?php echo $avantadjacent[0]->ldepartavant ?></td>
                                    <td><?php echo $avantadjacent[0]->larriveavant ?></td>
                                    <td><?php echo $avantadjacent[0]->debutavant ?></td>
                                    <td><?php echo $avantadjacent[0]->finavant ?></td>
                                </tr>


                            <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                <?php if($avantadjacent[0]->arriveavant != $apresadjacent[0]->departavant) {?>
                                    <tr>
                                        <input type="hidden" name="idregiondepart" value="<?php echo $avantadjacent[0]->departapres ?>">
                                        <td><?php echo $avantadjacent[0]->ldepartapres ?></td>

                                        <!-- si le prochain trajet est principal ou trajet de liaison -->
                                        <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                            <input type="hidden" name="idregionarrive" value="<?php echo $apresadjacent[0]->departavant ?>">
                                            <td><?php echo $apresadjacent[0]->ldepartavant ?></td>
                                        <?php } else {?>
                                            <input type="hidden" name="idregionarrive" value="<?php echo $apresadjacent[0]->departapres ?>">
                                            <td><?php echo $apresadjacent[0]->ldepartapres ?></td>
                                        <?php } ?>

                                        
                                        <td><input type="datetime-local" name="depart" id=""></td>
                                        <!-- si le prochain trajet est principal ou trajet de liaison -->
                                        <?php if(!empty($apresadjacent[0]->circuitavant)) {?>
                                            <input type="hidden" name="datefinarrive" value="<?php echo $apresadjacent[0]->debutavant ?>">
                                            <td><?php echo $apresadjacent[0]->debutavant ?></td>
                                        <?php } else {?>
                                            <input type="hidden" name="datefinarrive" value="<?php echo $apresadjacent[0]->debutapres ?>">
                                            <td><?php echo $apresadjacent[0]->debutapres ?></td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>

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
                    <?php } ?>
                    
                </tbody>    
                    </table>

                    
                </div>
                <div class="card-body">
                        <button type="submit" class="btn btn-info">Valider</button>
                </div>
                </form>
            </div>

        </div>
</div>
