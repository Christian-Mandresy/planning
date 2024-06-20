<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/add-kilometragevoiture-post">
        <div class="card-body">
            <h4 class="card-title">Compte Rendue</h4>
            <div class="form-group row">
                <label
                    for="numero"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Numero</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="numero">
                <?php $i=1; foreach($vehicules as $vehicule) { ?>  
                  <option value="<?php echo $vehicule->numero?>" ><?php echo $vehicule->numero?></option>
                <?php } ?>
              </select>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="place"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Kilometre avant</label
                >

                    <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                        <input type="text" class="form-control" id="kmavant" name="kmavant">
                            <div class="invalid-feedback">
                            <?php echo form_error('kmavant'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input type="text" class="form-control" id="kmavant" name="kmavant">
                    <?php } ?>

                </div>
            </div>

            <div class="form-group row">
                <label
                    for="place"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Kilometre apres</label
                >

                    <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                        <input type="text" class="form-control" id="kmapres" name="kmapres">
                            <div class="invalid-feedback">
                            <?php echo form_error('kmapres'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input type="text" class="form-control" id="kmapres" name="kmapres">
                    <?php } ?>

                </div>
            </div>

        </div>
        <div class="border-top">
            <div class="card-body">
            <button type="submit" class="btn btn-primary">
                Ajouter
            </button>
            </div>
        </div>
        </form>     
    </div>
</div>