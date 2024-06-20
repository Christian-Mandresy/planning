<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/add-vehiculepiece-post">
        <div class="card-body">
            <h4 class="card-title">Ajouter une entretien pour une véhicule</h4>
            <input type="hidden" name="identretien" value="<?php echo $identretien ?>" id="identretien"> 
            <div class="form-group row">
                <label
                    for="numero"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Numero</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="numero" id="numero" onchange="getPieceEntretien(this)">
                <?php foreach($vehicules as $vehicule) { ?> 
                    <option value="<?php echo $vehicule->numero?>" ><?php echo $vehicule->numero?></option>
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
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="piece" id="piece">
                <?php $i=1; foreach($pieces as $piece) { ?>
                    <option value="<?php echo $piece->idpiece?>" ><?php echo $piece->piece?></option>
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
                            <input type="date" class="form-control is-invalid" id="entretiendate" name="entretiendate"/>
                            <div class="invalid-feedback">
                            <?php echo form_error('entretiendate'); ?>
                            </div>
                        </div>
                    <?php } else {?>
                        <input
                        type="date"
                        class="form-control"
                        id="entretiendate" name="entretiendate"
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


    <div class="card">
    <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-success">
            <strong><span class="glyphicon glyphicon-ok"></span>   <?php echo $this->session->flashdata('success'); ?></strong>
        </div>
    <?php } ?>
        <?php if(!empty($vehiculesS)) {?>
            <div class="card-body">
                <h5 class="card-title mb-0">Liste des vehicules sans entretien</h5>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>SL No</th>
                    <th>numero</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php $i=1; foreach($vehiculesS as $vehicule) { ?>
                <tr>
                    <td> <?php echo $i; ?> </td>
                    <td>  <?php echo $vehicule->numero ?> </td>

                    <td>
                    <a href="<?php echo base_url()?>assign-entretien/<?php echo $vehicule->numero ?>" >
                    <button type="button" class="btn btn-info">Assigner</button>
                    </a>
                    </td>

                </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        <?php } else {?>
        <div class="alert alert-info" role="alert">
            <strong>No Vehicules Found!</strong>
        </div>
        <?php } ?>
    </div>
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
                console.log(listpiece[0]['id']);
                
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