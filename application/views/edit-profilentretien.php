<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>edit-profilentretien-post">
        <div class="card-body">
            <h4 class="card-title">Modifier profilpiece</h4>
            <div class="form-group row">
                <input type="hidden" value="<?php echo $profilentretien[0]->id ?>"   name="profilpiece_id">
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
                    value="<?php echo $profilentretien[0]->nom ?>"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="prenom"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Description</label
                >
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" name="description"><?php echo $profilentretien[0]->description ?></textarea>
                    
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
        <div class="card-body">
            <h5 class="card-title mb-0">Liste des profilpiece</h5>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>piece</th>
                <th>kilometrage</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <?php $i=0; foreach($profilpieces as $profilpiece) { ?>
                    <tr>
                        <form action="<?php echo base_url()?>edit-entretienpiece" method="post">
                        <input type="hidden" value="<?php echo $profilentretien[0]->id ?>"   name="profilpiece_id">
                        <td>  
                        <select class="select2 form-select shadow-none" style="width: 100%; height: 36px" name="idpiece" id="idpiece<?php echo $i ?>">
                            <?php foreach($pieces as $piece) { ?>  
                                <?php if($piece->id == $profilpiece->idpiece) {?>
                                    <option value="<?php echo $piece->id?>" selected><?php echo $piece->nom?></option>
                                <?php } else {?>
                                    <option value="<?php echo $piece->id?>" ><?php echo $piece->nom?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                        </a> 
                    
                        </td>

                        <td> 
                            <input type="text" name="kilometrage" value="<?php echo $profilpiece->kilometrage?> ">
                        </td>
                        <td>
                        <button type="submit" class="btn btn-secondary btn-sm">
                        Edit
                        </button></a>
                    
                        </td>
                        </form>

                    </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
        <div class="card-body">
            <button type="button" class="btn btn-success margin-5 text-white" data-toggle="modal" data-target="#Modal1" onclick="window.location.href='<?php echo site_url(); ?>add-entretienpiece/<?php echo $profilentretien[0]->id ?>'">
                Ajout de pièces
            </button>
        </div>
    </div>
</div>