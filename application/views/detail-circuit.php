<div class="col-md-12">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>edit-circuit-post">
        <div class="card-body">
            <h4 class="card-title">Detail circuit</h4>
            <div class="form-group row">
                <input type="hidden" value="<?php echo $circuit[0]->id ?>"   name="circuit_id">
                <label
                    for="nom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Nom</label
                >
                <div class="col-sm-4">
                    <input
                    type="text"
                    class="form-control"
                    id="nom" name="nom"
                    placeholder="nom"
                    value="<?php echo $circuit[0]->client ?>"
                    disabled
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de debut</label
                >
                <div class="col-sm-4">
                    <input
                    type="date"
                    class="form-control"
                    id="prenom" name="contact"
                    placeholder="contact"
                    value="<?php echo $circuit[0]->datedebut ?>"
                    disabled
                    />
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de fin</label
                >
                <div class="col-sm-4">
                    <input
                    type="date"
                    class="form-control"
                    id="prenom" name="contact"
                    placeholder="contact"
                    value="<?php echo $circuit[0]->datefin ?>"
                    disabled
                    />
                </div>
            </div>

        </div>
        
        </form>
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des trajets</h5>
        </div>
		<div class="card-body">
			<p>Assigner une voiture à plusieurs trajets</p>
			<input type="hidden" name="circuit" id="circuit" value="<?php echo $circuit[0]->id ?>">
			<button type="button" class="btn btn-info margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>choix-trajet/<?php echo $circuit[0]->id ?>'">
				Assigner
			</button>
		</div>

        <?php if($this->session->flashdata('success')){ ?>
            <div class="col-md-4">
                <div class="alert alert-success">
                    <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
                </div>
            </div>
        <?php } ?>

        <?php if($this->session->flashdata('error')){ ?>
            <div class="col-md-8">
            <div class="alert alert-danger">
                <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('error'); ?></strong>
            </div>
            </div>
        <?php } ?>
        <div class="container-fluid mx-auto">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>depart</th>
                    <th>arrive</th>
                    <th>date de depart</th>
                    <th>date d' arrive</th>
                    <th>place demander</th>
                    <th>place actuelle</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($trajets as $trajet) { ?>
                <tr role="row" class="odd">
                    <td style="color: #0077b3;"> <?php echo $trajet->depart ?>  </td>
                    <td style="color: #d18d0f;"> <?php echo $trajet->arrive ?>  </td>
                    <td> <input type="datetime-local" name="" id="" value="<?php echo $trajet->tdatedebut ?>" disabled>   </td>
                    <td> <input type="datetime-local" name="" id="" value="<?php echo $trajet->tdatefin ?>" disabled>  </td>
                    <td style="color: #0077b3;"> <?php echo $trajet->place ?> </a> </td>
                    
                    <?php if( is_null($trajet->placeprise)) {?>
                        <?php if( $trajet->gestiontransport ==0) {?>
                        <td> ------- </td>
                        <?php } else {?>
                        <td>Autre</td>
                        <?php } ?>
                    <?php } else {?>
                        <td> <?php echo $trajet->placeprise ?> </td>
                    <?php } ?>

                    <td>
                        <?php if( $trajet->gestiontransport ==0) {?>
                            <a href="<?php echo base_url()?>assignement-voiture/<?php echo $trajet->id ?> " >
                            <button type="button" class="btn btn-info btn-sm">
                            Assigner
                            </button></a>
                        <?php } else {?>
                            ----------- 
                        <?php } ?>
                        <a href="<?php echo base_url()?>edit-trajet/<?php echo $trajet->id ?>" >
                            <button type="button" class="btn btn-secondary btn-sm">
                            Modifier
                            </button>
                        </a>
                    </td>

                </tr>
                <?php  } ?>
                </tbody>
            </table>
        </div>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>assignement-voiture/<?php echo $circuit[0]->id ?>'">
                Ajout de Trajet
            </button>
        </div>
    </div>
</div>
