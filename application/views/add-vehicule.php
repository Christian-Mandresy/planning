<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/add-vehicule-post">
        <div class="card-body">
            <h4 class="card-title">Ajout vehicule</h4>
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
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="place"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Nombre de place</label
                >
                <div class="col-sm-9">
                    <input
                    type="number"
                    class="form-control"
                    name="place"
                    id="place"
                    placeholder="nombre de place"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="entretien"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Profil entretien</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="identretien">
                    <option value="">-----</option>
                    <?php $i=1; foreach($entretiens as $entretien) { ?>  
                    <option value="<?php echo $entretien->id?>" ><?php echo $entretien->nom?></option>
                    <?php } ?>
                </select>
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

    


    
</div>