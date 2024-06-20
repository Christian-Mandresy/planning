<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" action="<?php echo site_url()?>assign-vehicule-entretien" method="post">
            <div class="card-body">
                <h4 class="card-title">Assigner un entretien à une voiture</h4>
                <div class="form-group row">
                    <input type="hidden" value="<?php echo $voiture ?>"   name="numero">
                    <label
                        for="nom"
                        class="col-sm-3 text-end control-label col-form-label"
                        ><?php echo $voiture ?></label
                    >
                </div>

                <div class="form-group row">
                    <label
                        for="entretien"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Profil entretien</label
                    >
                    <div class="col-sm-9">
                    <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="identretien" id="identretien" onchange="getDetailEntretien(this)">
                        <?php foreach($entretiens as $entretien) { ?>  
                        <option value="<?php echo $entretien->id?>" ><?php echo $entretien->nom?></option>
                        <?php } ?>
                    </select>
                    </div>
                </div>

            </div>
            <div class="border-top">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">
                        assigner
                    </button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <h5 class="card-title mb-0">Liste des pieces</h5>
        </div>
        <?php if(!empty($profilpieces)) {?>
            <table class="table">
                <thead>
                <tr>
                    <th>piece</th>
                    <th>kilometrage</th>
                </tr>
                </thead>
                <tbody id="table">
                    <?php foreach($profilpieces as $profilpiece) { ?>
                        <tr>
                            <td>  
                            <?php echo $profilpiece->piece?>
                            </td>
                            <td> 
                                <?php echo $profilpiece->kilometrage ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else {?>
            <div class="alert alert-info" role="alert">
                <strong>Pas de profil entretien !</strong>
            </div>
            <div class="card-body">
            <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-profilentretien'">
                Ajout de profilentretien
            </button>

            </div>
        <?php } ?>
    </div>

    <script>
        var entretien = document.getElementById("identretien");

        var table=document.getElementById("table");
        function getDetailEntretien(selectobject)
        {
            var idx=selectobject.selectedIndex;
            console.log(selectobject.options[idx].value);
            // AJAX REQ
            var xmlhttp = new XMLHttpRequest();
            var entretien=selectobject.options[idx].value;
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    var listpiece=JSON.parse(this.responseText);
                    console.log(listpiece);
                    var child = table.lastElementChild; 
                    while (child) {
                        table.removeChild(child);
                        child = table.lastElementChild;
                    }

                    listpiece.forEach(pieces => {
                        var tr=document.createElement("tr");
                        var tdnom=document.createElement("td");
                        var tdkilometrage=document.createElement("td");
                        tdnom.innerText=pieces.piece;
                        tdkilometrage.innerText=pieces.kilometrage;
                        tr.appendChild(tdnom);
                        tr.appendChild(tdkilometrage)
                        table.appendChild(tr);
                    });
                    
                }
            }
            var path="<?php echo base_url('ajax-listpiece-entretien/')?>";
            xmlhttp.open("GET", path+entretien, true);
            xmlhttp.send();
        }
    </script>
</div>