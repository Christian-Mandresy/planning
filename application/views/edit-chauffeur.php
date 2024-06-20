<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>edit-chauffeur-post">
        <div class="card-body">
            <h4 class="card-title">Modifier Chauffeur</h4>
            <div class="form-group row">
                <input type="hidden" value="<?php echo $chauffeur[0]->id ?>"   name="chauffeur_id">
                <label
                    for="nom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Nom</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="nom" name="nom"
                    placeholder="nom"
                    value="<?php echo $chauffeur[0]->nom ?>"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Prenom</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="prenom" name="prenom"
                    placeholder="prenom"
                    value="<?php echo $chauffeur[0]->prenom ?>"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Contact</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="prenom" name="contact"
                    placeholder="contact"
                    value="<?php echo $chauffeur[0]->contact ?>"
                    />
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