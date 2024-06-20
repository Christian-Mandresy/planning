<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/find-circuit-post">
        <div class="card-body">
            <h4 class="card-title">Recherche de circuit</h4>


            <div class="form-group row">
                <label
                    for="numero"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Numero</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" name="numero[]" id="numero" multiple multiselect-search="true">
                    <?php $i=1; foreach($vehicules as $vehicule) { ?> 
                        <option value="<?php echo $vehicule->numero?>" ><?php echo $vehicule->numero?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="chauffeur"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Chauffeur</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" name="chauffeur[]" id="chauffeur" multiple multiselect-search="true">
                    <?php foreach($chauffeurs as $chauffeur) { ?> 
                        <option value="<?php echo $chauffeur->id?>" ><?php echo $chauffeur->nom?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="piece"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Depart</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" multiple multiselect-search="true" name="depart[]" id="depart">
                    <?php $i=1; foreach($lieus as $lieu) { ?>
                        <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="piece"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Arriver</label
                >
                <div class="col-sm-9">
                    <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" multiple multiselect-search="true" name="arrive[]" id="arrive">
                        <?php $i=1; foreach($lieus as $lieu) { ?>
                            <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>


            <div class="form-group row">
                <label
                    for="entretiendate"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de debut</label
                >

                <div class="col-sm-9">
                    <input
                    type="datetime-local"
                    class="form-control"
                    id="entretiendate" name="datedebut" />
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="entretiendate"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de fin</label
                >

                <div class="col-sm-9">
                    <input
                    type="datetime-local"
                    class="form-control"
                    id="entretiendate" name="datefin" />
                </div>
            </div>

            </div>
            <div class="border-top">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">
                        rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>