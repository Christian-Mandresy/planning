<div class="col-md-9">
    <div class="card">
        <style>
            .btno {
            background-color: #47bd3e;
            border: none;
            color: white;
            padding: 5px 16px;
            font-size: 16px;
            cursor: pointer;
            float: right;
            }

            .btnod {
            background-color: #ff5959;
            border: none;
            color: white;
            padding: 5px 16px;
            font-size: 16px;
            cursor: pointer;
            float: right;
            }

            .btnod:hover {
                background-color: #eb2f2f;
            }

            /* Darker background on mouse-over */
            .btno:hover {
            background-color: #27bd1c;
            }

            .trajet {
                color: #69c1f0;
            }

            .transport{
                margin-top: 30px;
                margin-bottom: 30px;
                border: 1px;
                border-color: #87d5ff;
                border-style: solid;
                border-radius: 25px;
                padding: 15px;
            }

        </style>

        <div class="card-body wizard-content" id="cardbody">

        <h4 class="card-title">Modifier Un Trajet</h4>
        <form class="form-horizontal" method="post" action="<?php echo base_url()?>/edit-trajet-post" id="form">
            <input type="hidden" name="verif" value="<?php echo $verif ?>">
            <input type="hidden" name="idavant" value="<?php echo $voisin[0] ?>">
            <input type="hidden" name="idapres" value="<?php echo $voisin[1] ?>">
            <input type="hidden" name="idtrajet" value="<?php echo $trajet_id ?>"> 
            <div class="form-group row">
                <?php if($verif == -1 || $verif == 1) {?>
                    <label
                    for="lieu"
                    class="col-md-2 text-end control-label col-form-label"
                    >lieu</label>

                    <div class="col-md-3">
                        <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="depart" disabled>
                            <?php foreach($lieus as $lieu) { ?>  
                                <?php if($lieu->id == $trajet[0]->iddepart) {?>
                                    <option value="<?php echo $lieu->id?>" selected ><?php echo $lieu->nom?></option>
                                <?php } else {?>
                                    <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <label
                    for="place"
                    class="col-md-2 text-end control-label col-form-label"
                    >Date</label>

                    <div class="col-md-5">
                        <?php if(validation_errors() != false ){ ?>
                            <div class="col-lg-8 col-md-12">
                            <input type="datetime-local" class="form-control is-invalid" id="datefin" name="datedebut" 
                            value="<?php  echo $trajet[0]->tdatedebut; ?>" disabled />
                            </div>
                        <?php } else {?>
                            <div class="col-lg-8 col-md-12">
                                <input
                                type="datetime-local"
                                class="form-control"
                                id="datedebut" name="datedebut"
                                value="<?php  echo $trajet[0]->tdatedebut; ?>"
                                disabled
                                />
                                <div class="invalid-feedback">
                                <?php echo form_error('datefin'); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else {?>
                    <label
                    for="lieu"
                    class="col-md-2 text-end control-label col-form-label"
                    >lieu</label>

                    <div class="col-md-3">
                        <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="depart">
                            <?php foreach($lieus as $lieu) { ?>  
                                <?php if($lieu->id == $trajet[0]->iddepart) {?>
                                    <option value="<?php echo $lieu->id?>" selected ><?php echo $lieu->nom?></option>
                                <?php } else {?>
                                    <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>

                    <label
                    for="place"
                    class="col-md-2 text-end control-label col-form-label"
                    >Date</label
                    >

                    <div class="col-md-5">
                        <?php if(validation_errors() != false ){ ?>
                            <div class="col-lg-8 col-md-12">
                            <input type="datetime-local" class="form-control is-invalid" id="datefin" name="datefin" 
                            value="<?php  echo $trajet[0]->tdatedebut; ?>" />
                            </div>
                        <?php } else {?>
                            <div class="col-lg-8 col-md-12">
                                <input
                                type="datetime-local"
                                class="form-control"
                                id="datefin" name="datedebut"
                                value="<?php  echo $trajet[0]->tdatedebut; ?>"
                                />
                                <div class="invalid-feedback">
                                <?php echo form_error('datefin'); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                  
            </div>

            <div class="form-group row transport">
                <label class="col-md-4 trajet">Gestion de transport</label>
                <div class="col-md-2">
                    <div class="form-check">
                        <?php if($trajet[0]->gestiontransport =='0') {?>
                            <input type="radio" class="form-check-input" id="customControlValidation1" name="gestiontransport" required="" value="0" checked>
                        <?php } else {?>
                            <input type="radio" class="form-check-input" id="customControlValidation1" name="gestiontransport" required="" value="0">
                        <?php } ?>
                        <label class="form-check-label mb-0" for="customControlValidation1">voitures</label>
                    </div>
                    <div class="form-check">
                        <?php if($trajet[0]->gestiontransport =='1') {?>
                            <input type="radio" class="form-check-input" id="customControlValidation2" name="gestiontransport" required=""
                            value="1" checked>
                        <?php } else {?>
                            <input type="radio" class="form-check-input" id="customControlValidation2" name="gestiontransport" required=""
                            value="1">
                        <?php } ?>
                        <label class="form-check-label mb-0" for="customControlValidation2">autres</label>
                    </div>
                </div>

                <label for="" class="col-md-2 text-end control-label col-form-label trajet">Place</label>
                <div class="col-md-2">
                    <input type="number" class="form-control" name="place" value="3">
                </div>
            </div>

            <div class="form-group row">
                <?php if($verif == -1 || $verif == 2) {?>
                    <label
                    for="lieu"
                    class="col-md-2 text-end control-label col-form-label"
                    >lieu</label>
                    
                    <div class="col-md-3">
                    <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="arrive" disabled>
                        <?php foreach($lieus as $lieu) { ?>  
                            <?php if($lieu->id == $trajet[0]->idarrive) {?>
                                <option value="<?php echo $lieu->id?>" selected ><?php echo $lieu->nom?></option>
                            <?php } else {?>
                                <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    </div>

                    <label
                        for="place"
                        class="col-md-2 text-end control-label col-form-label"
                        >Date</label
                    >

                    <div class="col-md-5">
                        <?php if(validation_errors() != false ){ ?>
                            <div class="col-lg-8 col-md-12">
                            <input type="datetime-local" class="form-control is-invalid" id="datefin" name="datedebut" 
                            value="<?php  echo $trajet[0]->tdatefin; ?>" 
                            disabled />
                            </div>
                        <?php } else {?>
                            <div class="col-lg-8 col-md-12">
                                <input
                                type="datetime-local"
                                class="form-control"
                                id="datefin" name="datefin"
                                value="<?php  echo $trajet[0]->tdatefin; ?>"
                                disabled
                                />
                                <div class="invalid-feedback">
                                <?php echo form_error('datefin'); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else {?>
                    <label
                    for="lieu"
                    class="col-md-2 text-end control-label col-form-label"
                    >lieu</label>

                    <div class="col-md-3">
                    <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="arrive">
                        <?php foreach($lieus as $lieu) { ?>  
                            <?php if($lieu->id == $trajet[0]->idarrive) {?>
                                <option value="<?php echo $lieu->id?>" selected ><?php echo $lieu->nom?></option>
                            <?php } else {?>
                                <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                    </div>

                    <label
                        for="place"
                        class="col-md-2 text-end control-label col-form-label"
                        >Date</label
                    >

                    <div class="col-md-5">
                        <?php if(validation_errors() != false ){ ?>
                            <div class="col-lg-8 col-md-12">
                            <input type="datetime-local" class="form-control is-invalid" id="datefin" name="datefin" 
                            value="<?php  echo $trajet[0]->tdatefin; ?>" />
                            </div>
                        <?php } else {?>
                            <div class="col-lg-8 col-md-12">
                                <input
                                type="datetime-local"
                                class="form-control"
                                id="datefin" name="datefin"
                                value="<?php  echo $trajet[0]->tdatefin; ?>"
                                />
                                <div class="invalid-feedback">
                                <?php echo form_error('datefin'); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                
            </div>

            </div>

            
            <div class="border-top">
                <div class="card-body">
                <button type="submit" class="btn btn-primary">
                    Modify
                </button>
                </div>
            </div>
        </form>

    </div>
</div>