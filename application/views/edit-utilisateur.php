<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo base_url()?>edit-utilisateur-post">
        <div class="card-body">
            <h4 class="card-title">Modifier Utilisateur</h4>
            <div class="form-group row">
                <input type="hidden" value="<?php echo $utilisateur[0]->id ?>"   name="utilisateur_id">
                <label
                    for="nom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >nom d'utilisateur</label
                >
                <div class="col-sm-9">
                    <input
                    type="text"
                    class="form-control"
                    id="nom" name="username"
                    placeholder="nom d' utilisateur"
                    value="<?php echo $utilisateur[0]->username ?>"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="Mot de passe"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Mot de Passe</label
                >
                <div class="col-sm-9">
                    <input
                    type="password"
                    class="form-control"
                    id="Mot de passe" name="mdp"
                    placeholder="mot de passe"
                    />
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
                <?php foreach($roles as $role) { ?>
                    <?php if($role->id == $utilisateur[0]->idrole) {?>
                        <option value="<?php echo $role->id?>" selected><?php echo $role->role?></option>
                    <?php } else {?>
                        <option value="<?php echo $role->id?>" ><?php echo $role->role?></option>
                    <?php } ?>
                <?php } ?>
              </select>
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