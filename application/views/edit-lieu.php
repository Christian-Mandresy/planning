<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>edit-lieu-post">
        <div class="card-body">
            <h4 class="card-title">Modifier Lieu</h4>
            <div class="form-group row">
                <input type="hidden" value="<?php echo $lieu[0]->id ?>"   name="lieu_id">
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
                    value="<?php echo $lieu[0]->nom ?>"
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