<div class="col-md-8">
    <div class="card">

        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/edit-entretien-post">
        <div class="card-body">
            <h4 class="card-title">Modifier un entretien vehicule</h4>
            <input
                    type="hidden"
                    class="form-control"
                    id="numero" name="entretien_id"
                    value="<?php echo $entretien[0]->id?>"
                    />
            <div class="form-group row">
                <label
                    for="numero"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Numero</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="numero">
                <?php $i=1; foreach($vehicules as $vehicule) { ?> 
                    <?php if($entretien[0]->numero == $vehicule->numero) {?>
                        <option value="<?php echo $vehicule->numero?>" selected><?php echo $vehicule->numero?></option>
                    <?php } else {?>
                        <option value="<?php echo $vehicule->numero?>" ><?php echo $vehicule->numero?></option>
                    <?php } ?>
    
                <?php } ?>
              </select>
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="place"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de debut</label
                >

                <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                            <input type="date" class="form-control is-invalid" id="datedebut" 
                            name="datedebut"
                            value="<?php echo $entretien[0]->datedebut ?>"
                            />
                            <div class="invalid-feedback">
                            <?php echo form_error('datedebut'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input
                        type="date"
                        class="form-control"
                        id="datedebut" name="datedebut"
                        value="<?php echo $entretien[0]->datedebut ?>"
                        />
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="place"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de fin</label
                >

                <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                            <input type="date" class="form-control is-invalid" id="datefin" 
                            name="datefin" value="<?php echo $entretien[0]->datefin ?>"/>
                            <div class="invalid-feedback">
                            <?php echo form_error('datefin'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input
                        type="date"
                        class="form-control"
                        id="datefin" name="datefin"
                        value="<?php echo $entretien[0]->datefin ?>"
                        />
                    <?php } ?>

                </div>
            </div>
            <div class="form-group row">
                <label for="cono1" class="col-sm-3 text-end control-label col-form-label">Description</label>
                <div class="col-sm-9">
                <textarea class="form-control" name="description" ><?php echo $entretien[0]->description ?></textarea>
                
                </div>
            </div>
        </div>
            <div class="border-top">
                <div class="card-body">
                <button type="submit" class="btn btn-primary">
                    Modifier
                </button>
                </div>
            </div>
        </form>     
    </div>
</div>