<link href="<?php echo base_url();?>assets/extra-libs/multicheck/multicheck.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
<script src="<?php echo base_url();?>assets/extra-libs/multicheck/jquery.multicheck.js"></script>
<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Circuit</h4>
            <div class="form-group row">
                <label
                    for="nom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Nom</label
                >
                <div class="col-sm-3">
					<p><?php echo $circuit[0]->client ?></p>
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de debut</label
                >
                <div class="col-sm-3">
					<p><?php echo $circuit[0]->datedebut ?></p>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="datefin"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de fin</label
                >
                <div class="col-sm-3">
					<p id="datefin"><?php echo $circuit[0]->datefin ?></p>
                </div>
            </div>

        </div>

        <div class="card-body">
            <h5 class="card-title mb-0">Choix des trajets</h5>
        </div>
		<div class="table-responsive">
			<table class="table">
				<thead class="thead-light">
				<tr>
					<th>depart</th>
					<th>arrive</th>
					<th>date de depart</th>
					<th>heure</th>
					<th>date d' arrive</th>
					<th>heure</th>
					<th>
						debut
					</th>
					<th>
						fin
					</th>
				</tr>
				</thead>
				<tbody class="customtable">
				<form action="<?php echo base_url()?>CircuitController/VoitureDispoMultiple" method="post">
					<input type="hidden" name="idcircuit" value="<?php echo $circuit[0]->id ?>">
						<?php $i=1; foreach($trajets as $trajet) { ?>
					<tr>
						<td style="color: #0077b3;"> <?php echo $trajet->depart ?>  </td>
						<td style="color: #d18d0f;"> <?php echo $trajet->arrive ?>  </td>
						<td> <a href="<?php echo base_url()?>edit-trajet/<?php echo $trajet->id?>" > <?php echo $trajet->datedebut ?>  </td>
						<td> <?php echo $trajet->heuredebut ?>  </td>
						<td> <?php echo $trajet->datefin ?>  </td>
						<td> <?php echo $trajet->heurefin ?>  </td>
						<th>
						<?php if( $trajet->gestiontransport ==0) {?>
							<label class="customcheckbox">
								<input type="radio" class="listCheckbox" name="debut" value="<?php echo $i ?>">
								<input type="hidden" name="datedebut<?php echo $i ?>" value="<?php echo $trajet->datedebut.' '.$trajet->heuredebut ?>">
								<input type="hidden" name="datefin<?php echo $i ?>" value="<?php echo $trajet->datefin.' '.$trajet->heurefin ?>">
								<span class="checkmark"></span>
							</label>
						<?php } else {?>
							----
						<?php } ?>
						</th>
						<th>
						<?php if( $trajet->gestiontransport ==0) {?>
							<label class="customcheckbox">
								<input type="radio" class="listCheckbox" name="fin" value="<?php echo $i ?>">
								<span class="checkmark"></span>
							</label>
						<?php } else {?>
							----
						<?php } ?>
						</th>
					</tr>
					<?php $i++; } ?>
				</tbody>
			</table>
			<div class="card-body">
				<button type="submit" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" >
					Voiture Disponible
				</button>
			</div>
			</form>
		</div>
    </div>
</div>
