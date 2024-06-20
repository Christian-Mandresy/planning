<div class="col-md-8">
    <div class="card">

        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/edit-kilometragevoiture-post">
        <div class="card-body">
            <h4 class="card-title">Modifier un entretien vehicule</h4>
            <input
                    type="hidden"
                    class="form-control"
                    id="numero" name="kilometragevoiture_id"
                    value="<?php echo $kilometragevoiture[0]->id?>"
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
                        <?php if($kilometragevoiture[0]->numero == $vehicule->numero) {?>
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
                    >Date de rendue</label
                >

                <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                            <input type="date" class="form-control is-invalid" id="daterendu" 
                            name="daterendu"
                            value="<?php echo $kilometragevoiture[0]->daterendu ?>"
                            />
                            <div class="invalid-feedback">
                            <?php echo form_error('daterendu'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input
                        type="date"
                        class="form-control"
                        id="daterendu" name="daterendu"
                        value="<?php echo $kilometragevoiture[0]->daterendu ?>"
                        />
                    <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="place"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Kilometrage avant</label
                >

                <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                        <input type="number" value="<?php echo $kilometragevoiture[0]->kmavant ?>" class="form-control" id="kmavant" name="kmavant">
                            <div class="invalid-feedback">
                            <?php echo form_error('kmavant'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input type="number" value="<?php echo $kilometragevoiture[0]->kmavant ?>" class="form-control" id="kmavant" name="kmavant">
                    <?php } ?>

                </div>
            </div>

            <div class="form-group row">
                <label
                    for="place"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Kilometrage apres</label
                >

                <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                        <input type="number" value="<?php echo $kilometragevoiture[0]->kmapres ?>" class="form-control" id="kmapres" name="kmapres">
                            <div class="invalid-feedback">
                            <?php echo form_error('kmavant'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input type="number" value="<?php echo $kilometragevoiture[0]->kmapres ?>" class="form-control" id="kmapres" name="kmapres">
                    <?php } ?>

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