<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/add-chauffeur-post">
        <div class="card-body">
            <h4 class="card-title">Ajouter Chauffeur</h4>
            <div class="form-group row">
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
                    
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="contact"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Contact</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="prenom" name="contact"
                    placeholder="contact"
                    
                    />
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