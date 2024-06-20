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
        </div>

    <div class="card-body">
        <h5 class="card-title mb-0">Liste des vehicules disponible</h5>
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
	<table class="table">
		<thead>
		<tr>
			<th>numero</th>
			<th>lieu</th>
			<th>lieu</th>
			<th>lieu</th>
			<th>lieu</th>
			<th>lieu</th>
			<th>Actions</th>
		</tr>
		</thead>
		<tbody>

			<tr>
				<form action="<?php echo base_url()?>assign-vehicule-post" method="post">
					<td> <input type="text" readonly="readonly" name="numero" value="<?php echo $numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">  </td>
					<td><?php echo $avantadjacent[0]->larriveavant ?></td>
					<td><?php echo $trajet[0]->depart ?></td>
					<td><?php echo $trajet[0]->arrive ?></td>
					<td><?php echo $apresadjacent[0]->ldepartavant ?></td>
					<td><?php echo $apresadjacent[0]->ldepartapres ?></td>

					<input type="hidden" name="avideparking" value="cas1">
					<input type="hidden" name="idavantP1" value="<?php echo $avantadjacent[0]->idapres ?>">
					<input type="hidden" name="idavant" value="<?php echo $avantadjacent[0]->idavant ?>">

					<input type="hidden" name="idarriveavant" value="<?php echo $avantadjacent[0]->arriveavant ?>">
					<input type="hidden" name="iddepartactu" value="<?php echo $trajet[0]->iddepart ?>">
					

					<input type="hidden" name="idapresP1" value="<?php echo $apresadjacent[0]->idavant ?>">
					<input type="hidden" name="idapres" value="<?php echo $apresadjacent[0]->idapres ?>">
					<input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">

					<td>
						<button type="submit" class="btn btn-info">Assigner</button>
				</form>
				</td>
			</tr>
			<tr>
				<form action="<?php echo base_url()?>assign-vehicule-post" method="post">
					<td> <input type="text" readonly="readonly" name="numero" value="<?php echo $numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">  </td>
					<td><?php echo $avantadjacent[0]->larriveavant ?></td>
					<td><?php echo $trajet[0]->depart ?></td>
					<td><?php echo $trajet[0]->arrive ?></td>
					<td> ------> </td>
					<td><?php echo $apresadjacent[0]->ldepartapres ?></td>


					<input type="hidden" name="avideparking" value="cas3">
					<input type="hidden" name="idavantP1" value="<?php echo $avantadjacent[0]->idapres ?>">
					<input type="hidden" name="idavant" value="<?php echo $avantadjacent[0]->idavant ?>">

					<input type="hidden" name="idarriveavant" value="<?php echo $avantadjacent[0]->arriveavant ?>">
					<input type="hidden" name="iddepartactu" value="<?php echo $trajet[0]->iddepart ?>">


					<input type="hidden" name="idapresP1" value="<?php echo $apresadjacent[0]->idavant ?>">
					<input type="hidden" name="idapres" value="<?php echo $apresadjacent[0]->idapres ?>">
					<input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">

					<td>
						<button type="submit" class="btn btn-info">Assigner</button>
				</form>
				</td>
			</tr>

			<tr>
				<form action="<?php echo base_url()?>assign-vehicule-post" method="post">
					<td> <input type="text" readonly="readonly" name="numero" value="<?php echo $numero ?>" style="background-color: #e6f3fa;border-radius: 25px;text-align: center;border-color:cadetblue;width: 100px;">  </td>
					<td><?php echo $avantadjacent[0]->larriveavant ?></td>
					<td><?php echo $avantadjacent[0]->larriveapres ?></td>
					<td><?php echo $trajet[0]->depart ?></td>
					<td><?php echo $trajet[0]->arrive ?></td>
					<td><?php echo $apresadjacent[0]->ldepartapres ?></td>


					<input type="hidden" name="avideparking" value="cas2">
					<input type="hidden" name="idavantP1" value="<?php echo $avantadjacent[0]->idapres ?>">
					<input type="hidden" name="idavant" value="<?php echo $avantadjacent[0]->idavant ?>">

					<input type="hidden" name="idarriveavant" value="<?php echo $avantadjacent[0]->arriveavant ?>">
					<input type="hidden" name="iddepartactu" value="<?php echo $trajet[0]->iddepart ?>">


					<input type="hidden" name="idapresP1" value="<?php echo $apresadjacent[0]->idavant ?>">
					<input type="hidden" name="idapres" value="<?php echo $apresadjacent[0]->idapres ?>">
					<input type="hidden" name="idtrajet" value="<?php echo $trajet[0]->id ?>">
					<td>
						<button type="submit" class="btn btn-info">Assigner</button>
				</form>
				</td>
			</tr>
		</tbody>
	</table>
	</div>
	

</div>
