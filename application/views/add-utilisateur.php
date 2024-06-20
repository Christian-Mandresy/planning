<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>add-utilisateur-post">
        <div class="card-body">
            <h4 class="card-title">Ajouter Utilisateur</h4>
            <div class="form-group row">
                <label
                    for="username"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Username</label
                >
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username" placeholder="username">
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="mdp"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Mot de passe : </label
                >
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="mdp" name="mdp">
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="role"
                    class="col-sm-3 text-end control-label col-form-label"
                    >role</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="idrole">
                <?php $i=1; foreach($roles as $role) { ?>  
                  <option value="<?php echo $role->id?>" ><?php echo $role->role?></option>
                <?php } ?>
                </select>
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