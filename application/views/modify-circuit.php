<div class="col-md-9">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/edit-circuit-post" id="form">
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

        <input type="hidden" name="idcircuit" value="<?php echo $circuit_id ?>"> 
        <div class="card-body wizard-content" id="cardbody">

                <?php if(!empty($dataTrajet) ){ ?>
                    <h4 class="card-title">Modifier Un Circuit</h4>
                    <div class="form-group row">
                        <label
                            for="client"
                            class="col-sm-3 text-end control-label col-form-label"
                            >Client</label
                        >
                        <div class="col-sm-9">
                            <input
                            type="text"
                            class="form-control"
                            id="client" name="client"
                            placeholder="client"
                            value="<?php echo $circuit['client'] ?>"
                            />
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
                                    <input type="datetime-local" class="form-control is-invalid" id="datedebut" 
                                    name="datedebut"
                                    value="<?php echo $dataTrajet[0]['tdatedebut'] ?>"
                                    />
                                    <div class="invalid-feedback">
                                    <?php echo form_error('datedebut'); ?>
                                    </div>
                                </div>
                            <?php } else {?>
                                <input
                                type="datetime-local"
                                class="form-control"
                                id="datedebut" name="datedebut"
                                value="<?php echo $dataTrajet[0]['tdatedebut'] ?>"
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
                                    <input type="date" class="form-control is-invalid" id="datefin" name="datefinc"
                                    value="<?php echo $circuit['datefin'] ?>"
                                    />
                                    <div class="invalid-feedback">
                                    <?php echo form_error('datefin'); ?>
                                    </div>
                                </div>
                            <?php } else {?>
                                <input
                                type="date"
                                class="form-control"
                                id="datefin" name="datefinc"
                                value="<?php echo $circuit['datefin'] ?>"
                                />
                            <?php } ?>
                        </div>
                    </div>

                        <div class="form-group row">
                            <h6 style="margin-left:55%;color:#69c1f0">ajouter des trajets</h6>   
                        </div>
                    <?php $i=-1;$indice=''; foreach($dataTrajet as $trajet) { ?>
                        <div class="form-group row">
                            <?php if($i < 1) {?>
                                <?php $indice=''; ?>
                            <?php } else {?>
                                <?php $indice=$i; ?>
                            <?php } ?>
                            <label
                                for="lieu"
                                class="col-md-2 text-end control-label col-form-label"
                                >lieu</label
                            >
                            <div class="col-md-3">
                                <?php if($i == -1) {?>
                                    <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="depart">
                                        <?php foreach($lieus as $lieu) { ?>
                                            <?php if($lieu->id == $trajet['iddepart']) {?>
                                                <option value="<?php echo $lieu->id?>" selected ><?php echo $lieu->nom?></option>
                                            <?php } else {?>
                                                <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                                            <?php } ?>  
                                        <?php } ?>
                                    </select>
                                <?php } else {?>
                                    <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="arrive<?php  echo $indice; ?>">
                                        <?php foreach($lieus as $lieu) { ?>
                                            <?php if($lieu->id == $trajet['iddepart']) {?>
                                                <option value="<?php echo $lieu->id?>" selected ><?php echo $lieu->nom?></option>
                                            <?php } else {?>
                                                <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                                            <?php } ?>  
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                                
                            </div>
                            <?php if($i < 0) {?>

                            <?php } else {?>
                                <label
                                for="place"
                                class="col-md-2 text-end control-label col-form-label"
                                >Date</label
                                >
                                <div class="col-md-5">
                                    <?php if(validation_errors() != false ){ ?>
                                        <div class="col-lg-8 col-md-12">
                                            <input type="datetime-local" class="form-control is-invalid" id="datefin" name="datefin<?php  echo $indice; ?>" 
                                            value="<?php  echo $trajet['tdatedebut']; ?>" />
                                        </div>
                                    <?php } else {?>
                                        <div class="col-lg-8 col-md-12">
                                            <input
                                            type="datetime-local"
                                            class="form-control"
                                            id="datefin" name="datefin<?php  echo $indice; ?>"
                                            value="<?php  echo $trajet['tdatedebut']; ?>"
                                            />
                                            <div class="invalid-feedback">
                                                <?php echo form_error('datefin'); ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if($i == count($dataTrajet)-2) {?>
                            <div class="form-group row transport">
                                <label class="col-md-4 trajet">Gestion de transport</label>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <?php if($trajet['gestiontransport']=='0') {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation1" name="gestiontransport<?php  if($indice!=''){echo $indice+1;}else{echo $indice;} ?>" required="" value="0" checked>
                                        <?php } else {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation1" name="gestiontransport<?php  if($indice!=''){echo $indice+1;}else{echo $indice;} ?>" required="" value="0">
                                        <?php } ?>
                                        <label class="form-check-label mb-0" for="customControlValidation1">voitures</label>
                                    </div>

                                    <div class="form-check">
                                        <?php if($trajet['gestiontransport']=='1') {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation2" name="gestiontransport<?php if($indice!=''){echo $indice+1;}else{echo $indice;} ?>" required=""
                                            value="1" checked>
                                        <?php } else {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation2" name="gestiontransport<?php  if($indice!=''){echo $indice+1;}else{echo $indice;} ?>" required=""
                                            value="1" >
                                        <?php } ?>
                                        <label class="form-check-label mb-0" for="customControlValidation2">autres</label>
                                    </div>  
                                </div>
                                <label for="" class="col-md-2 text-end control-label col-form-label trajet">Place</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="place<?php  if($indice!=''){echo $indice+1;}else{echo $indice;} ?>" value="<?php  echo $trajet['place']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    for="lieu"
                                    class="col-md-2 text-end control-label col-form-label"
                                    >lieu</label
                                >
                                <div class="col-md-3">
                                    <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="arrive<?php  if($indice!=''){echo $indice+1;}else{echo $indice;} ?>">
                                        <?php foreach($lieus as $lieu) { ?>
                                            <?php if($lieu->id == $trajet['idarrive']) {?>
                                                <option value="<?php echo $lieu->id?>" selected ><?php echo $lieu->nom?></option>
                                            <?php } else {?>
                                                <option value="<?php echo $lieu->id?>" ><?php echo $lieu->nom?></option>
                                            <?php } ?>  
                                        
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php if($i == 0) {?>

                                <?php } else {?>
                                    <label
                                    for="place"
                                    class="col-md-2 text-end control-label col-form-label"
                                    >Date</label
                                    >
                                    <div class="col-md-5">
                                        <?php if(validation_errors() != false ){ ?>
                                            <div class="col-lg-8 col-md-12">
                                                <input type="datetime-local" class="form-control is-invalid" id="datefin" name="datefin<?php  echo $indice+1; ?>" 
                                                value="<?php  echo $trajet['tdatefin']; ?>" />
                                            </div>
                                        <?php } else {?>
                                            <div class="col-lg-8 col-md-12">
                                                <input
                                                type="datetime-local"
                                                class="form-control"
                                                id="datefin" name="datefin<?php  if($indice!=''){echo $indice+1;}else{echo $indice;} ?>"
                                                value="<?php  echo $trajet['tdatefin']; ?>"
                                                />
                                                <div class="invalid-feedback">
                                                <?php echo form_error('datefin'); ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } else {?>
                            <?php if($i < 0) {?>
                                <?php $indice=''; ?>
                            <?php } else {?>
                                <?php $indice=$i+1; ?>
                            <?php } ?>
                            <div class="form-group row transport">
                                <label class="col-md-4 trajet">Gestion de transport</label>
                                <div class="col-md-2">
                                    <div class="form-check">
                                        <?php if($trajet['gestiontransport']=='0') {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation1" name="gestiontransport<?php  echo $indice; ?>" required="" value="0" checked>
                                        <?php } else {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation1" name="gestiontransport<?php  echo $indice; ?>" required="" value="0">
                                        <?php } ?>
                                        <label class="form-check-label mb-0" for="customControlValidation1">voitures</label>
                                    </div>
                                    <div class="form-check">
                                        <?php if($trajet['gestiontransport']=='1') {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation2" name="gestiontransport<?php  echo $indice; ?>" required=""
                                            value="1" checked>
                                        <?php } else {?>
                                            <input type="radio" class="form-check-input" id="customControlValidation2" name="gestiontransport<?php  echo $indice; ?>" required=""
                                            value="1">
                                        <?php } ?>
                                        <label class="form-check-label mb-0" for="customControlValidation2">autres</label>
                                    </div>  
                                </div>
                                <label for="" class="col-md-2 text-end control-label col-form-label trajet">Place</label>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="place<?php  echo $indice; ?>" value="<?php  echo $trajet['place']; ?>">
                                </div>
                            </div>
                        <?php } ?>
                    <?php $i++; } ?>
                    
                
                <?php } ?>

            


        </div>

           
        <div class="border-top">
            <div class="card-body">
                <button class="btno"
                    type="button" id="ajout">
                    <i class="fa fa-plus"></i>
                </button>
                <button class="btnod"
                        type="button" id="delete">
                        <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="card-body">
            <button type="submit" class="btn btn-primary">
                Modify
            </button>
            </div>
        </div>
        </form>

        <script >
            //div contenant des les inputs
            var cardbody= document.getElementById("cardbody");
            //nombre des input deja creer
            //nbr - h4 - 2div (nom , contact) / 3(groupe d'input pour un trajet)
            var nombreChild=(cardbody.childElementCount - 6)/2;
            console.log(nombreChild);

            var bouton=document.getElementById("ajout");
            var boutondelete=document.getElementById("delete");
            var listlieu=<?php echo json_encode($lieus); ?>;


            bouton.addEventListener("click",function () {
                //creation des groupes d'input voiture pour l'ajout de nouveau trajet
                    //gestion de transport
                var grouprow0=document.createElement('div');
                grouprow0.className="form-group row transport";
                var label=document.createElement('label');
                label.className='col-md-4 trajet';
                label.innerText='Gestion de transport';

                var colmd9=document.createElement('div');
                colmd9.className='col-md-2';

                var formcheck1=document.createElement('div');
                formcheck1.className='form-check';
                var input1=document.createElement('input');
                input1.className='form-check-input';
                input1.type='radio';
                input1.name='gestiontransport'+nombreChild;
                input1.value=0;
                input1.checked=true;
                var label1=document.createElement('label');
                label1.className='form-check-label mb-0';
                label1.innerText='voitures';
                formcheck1.appendChild(label1);
                formcheck1.appendChild(input1);

                var formcheck2=document.createElement('div');
                formcheck2.className='form-check';
                var input2=document.createElement('input');
                input2.className='form-check-input';
                input2.type='radio';
                input2.name='gestiontransport'+nombreChild;
                input2.value=0;
                var label2=document.createElement('label');
                label2.className='form-check-label mb-0';
                label2.innerText='autres';
                formcheck2.appendChild(label2);
                formcheck2.appendChild(input2);

                colmd9.appendChild(formcheck1);
                colmd9.appendChild(formcheck2);

                grouprow0.appendChild(label);
                grouprow0.appendChild(colmd9);

                var labelplace=document.createElement('label');
                labelplace.innerText='Place';
                labelplace.className='col-md-2 text-end control-label col-form-label trajet';
                var placemd4=document.createElement('div');
                placemd4.className='col-md-2';
                var inputplace=document.createElement('input');
                inputplace.className='form-control';
                inputplace.type='number';
                inputplace.name='place'+nombreChild;
                inputplace.value='3';
                placemd4.appendChild(inputplace);

                grouprow0.appendChild(labelplace);
                grouprow0.appendChild(placemd4);

                //places

                /*<div class="form-group row">
                    <label for="" class="col-md-2 text-end control-label col-form-label">Place</label>
                    <div class="col-md-4">
                        <input type="number" class="form-control">
                    </div>
                </div>*/


                    //lieu
                //piece
                var grouprow=document.createElement('div');
                grouprow.className="form-group row";
                var label=document.createElement('label');
                label.className='col-md-2 text-end control-label col-form-label';
                label.innerText='Lieu';
                label.htmlFor='Lieu'+nombreChild;

                //col md4 date
                var colmd4=document.createElement('div');
                colmd4.className='col-md-5';

                //col-lg-8 col-md-12 date
                var coldate=document.createElement('div');
                coldate.className='col-lg-8 col-md-12';

                //col md4 lieu
                var lieumd4=document.createElement('div');
                lieumd4.className='col-md-3';
                var input=document.createElement('select');
                input.className='select2 form-select shadow-none';
                input.style='width: 100%; height: 36px';
                input.tabindex="-1";
                input.name='arrive'+nombreChild;

                for (const lieu of listlieu)
                {
                    var option = document.createElement("option");
                    option.value = lieu.id;
                    option.text = lieu.nom;
                    input.appendChild(option);
                }

                lieumd4.appendChild(input);

                var labeldate=document.createElement('label');
                labeldate.innerText='Date';
                labeldate.className='col-md-2 text-end control-label col-form-label';

                var inputdate=document.createElement('input');
                inputdate.type='datetime-local';
                inputdate.className='form-control';
                inputdate.name='datefin'+nombreChild;

                coldate.appendChild(inputdate);

                grouprow.appendChild(label);
                grouprow.appendChild(lieumd4);
                grouprow.appendChild(labeldate);
                grouprow.appendChild(colmd4);
                colmd4.appendChild(coldate);
                

                cardbody.appendChild(grouprow0);
                cardbody.appendChild(grouprow);
                nombreChild+=1;
                $('.select2').select2();

            },false)

            boutondelete.addEventListener("click",function () {
                if(nombreChild>1)
                {
                    cardbody.removeChild(cardbody.lastElementChild);
                    cardbody.removeChild(cardbody.lastElementChild);
                    nombreChild-=1;
                    
                }
                
            },false)
        </script>

    </div>
</div>