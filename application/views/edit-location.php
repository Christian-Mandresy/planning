<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>edit-location-post">
        <div class="card-body">
            <h4 class="card-title">Modifier vehicule de location</h4>
            <input
                    type="hidden"
                    class="form-control"
                    id="numero" name="location_id"
                    value="<?php echo $location[0]->id ?>"
                    />
            <div class="form-group row">
                <label
                    for="numero"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Numero</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="numero" name="numero"
                    placeholder="Numero  véhicule"
                    value="<?php echo $location[0]->numero ?>"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="datedebut"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de debut</label
                >
                <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                    <div class="col-lg-8 col-md-12">
                                <input type="date" class="form-control is-invalid" id="datedebut" name="datedebut" 
                                value="<?php echo $location[0]->datedebut ?>"/>
                                <div class="invalid-feedback">
                                <?php echo form_error('datedebut'); ?>
                                </div>
                    </div>
                        <?php } else {?>
                            <input
                            type="date"
                            class="form-control"
                            id="datedebut" name="datedebut"
                            value="<?php echo $location[0]->datedebut ?>"
                            />
                        <?php } ?>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="datefin"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date de fin</label
                >
                <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                            <input type="date" class="form-control is-invalid" id="datefin" name="datefin" 
                            value="<?php echo $location[0]->datefin ?>"/>
                            <div class="invalid-feedback">
                            <?php echo form_error('datefin'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input
                        type="date"
                        class="form-control"
                        id="datefin" name="datefin"
                        value="<?php echo $location[0]->datefin ?>"
                        />
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="border-top">
            <div class="card-body">
            <button type="submit" class="btn btn-primary">
                modifier
            </button>
            </div>
        </div>
        </form>     
    </div>
</div>