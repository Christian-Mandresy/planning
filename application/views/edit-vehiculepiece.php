<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/edit-vehiculepiece-post">
        <div class="card-body">
            <h4 class="card-title">Ajouter une entretien pour une véhicule</h4>
            <input type="hidden" name="vehiculepiece_id" value="<?php echo $vehiculepiece_id ?>" id="identretien">
            <input type="hidden" name="identretien" value="<?php echo $identretien ?>" id="identretien"> 
            <div class="form-group row">
                <label
                    for="numero"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Numero</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="numero" id="numero" onchange="getPieceEntretien(this)">
                <?php $i=1; foreach($vehicules as $vehicule) { ?>
                    <?php if($vehiculepiece[0]->numero == $vehicule->numero) {?>
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
                    for="piece"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Piece</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="idpiece" id="piece">
                <?php $i=1; foreach($pieces as $piece) { ?>
                    <?php if($vehiculepiece[0]->idpiece == $piece->idpiece) {?>
                        <option value="<?php echo $piece->idpiece?>" selected><?php echo $piece->piece?></option>
                    <?php } else {?>
                        <option value="<?php echo $piece->idpiece?>" ><?php echo $piece->piece?></option>
                    <?php } ?>
                    
                <?php } ?>
                </select>
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Kilometrage</label
                >
                <div class="col-sm-9">
                    <input
                    type="number"
                    class="form-control"
                    id="kilometrage" name="kilometrage"
                    placeholder="kilometrage"
                    value="<?php echo $vehiculepiece[0]->kilometrage?>"
                    />
                </div>
            </div>

            <div class="form-group row">
                <label
                    for="entretiendate"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Date d' entretien</label
                >

                    <div class="col-sm-9">
                    <?php if(validation_errors() != false ){ ?>
                        <div class="col-lg-8 col-md-12">
                            <input type="date" class="form-control is-invalid" id="entretiendate" name="entretiendate" value="<?php echo $vehicule->entretiendate?>"/>
                            <div class="invalid-feedback">
                            <?php echo form_error('entretiendate'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input
                        type="date"
                        class="form-control"
                        id="entretiendate" name="entretiendate"
                        value="<?php echo $vehiculepiece[0]->entretiendate?>"
                        />
                    <?php } ?>

                </div>
            </div>

        </div>
        <div class="border-top">
            <div class="card-body">
            <button type="submit" class="btn btn-primary">
                ajouter
            </button>
            </div>
        </div>
        </form>
</div>

<script>
    var vehicule = document.getElementById("numero");
    var piece = document.getElementById("piece");

    //vehicule.addEventListener("onchange",getPieceEntretien(vehicule.nodeValue))

    function getPieceEntretien(selectobject)
    {
        var idx=selectobject.selectedIndex;
        console.log(selectobject.options[idx].value);
        // AJAX REQ
        var xmlhttp = new XMLHttpRequest();
        var numero=selectobject.options[idx].value;
        xmlhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                var listpiece=JSON.parse(this.responseText);
                console.log(listpiece);

                var child = piece.lastElementChild; 
                while (child) {
                    piece.removeChild(child);
                    child = piece.lastElementChild;
                }
                    
                var inputidentretien=document.getElementById('identretien');
                inputidentretien.value=listpiece[0]['id'];
                
                listpiece.forEach(pieces => {
                    var opt=document.createElement("option");
                    opt.value=pieces.idpiece;
                    opt.innerHTML=pieces.piece;
                    piece.appendChild(opt);
                });
            }
        }
        var path="<?php echo base_url('ajax-listpiece/')?>";
        xmlhttp.open("GET", path+numero, true);
        xmlhttp.send();
    }


</script>