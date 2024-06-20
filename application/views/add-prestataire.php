<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/add-prestataire-post" id="form">
        <style>
            .btno {
            background-color: #47bd3e;
            border: none;
            color: white;
            padding: 5px 16px;
            font-size: 16px;
            cursor: pointer;
            float: right;
            }

            .btnod {
            background-color: #ff5959;
            border: none;
            color: white;
            padding: 5px 16px;
            font-size: 16px;
            cursor: pointer;
            float: right;
            }

            .btnod:hover {
                background-color: #eb2f2f;
            }

            /* Darker background on mouse-over */
            .btno:hover {
            background-color: #27bd1c;
            }
        </style>

        <div class="card-body" id="cardbody">
            <h4 class="card-title">Ajouter Prestataire</h4>
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

                <div class="form-group row">
                    <h6 style="margin-left:55%;color:#69c1f0">ajouter des voitures</h6>   
                </div>
            

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

        </div>

           
        <div class="border-top">
            <div class="card-body">
                <button class="btno"
                    type="button" id="ajout">
                    <i class="fa fa-plus"></i>
                </button>
                <button class="btnod"
                        type="button" id="delete">
                        <i class="fa fa-minus"></i>
                </button>
            </div>
            <div class="card-body">
            <button type="submit" class="btn btn-primary">
                Ajouter
            </button>
            </div>
        </div>
        </form>

        <script >
            //div contenant des les inputs
            var cardbody= document.getElementById("cardbody");
            //nombre des input deja creer
            //nbr - h4 - 2div (nom , contact) / 2(groupe d'input pour une voiture)
            var nombreChild=(cardbody.childElementCount - 4)/2;
            console.log(nombreChild);

            var bouton=document.getElementById("ajout");
            var boutondelete=document.getElementById("delete");


            bouton.addEventListener("click",function () {
                //creation des groupes d'input voiture pour l'ajout de nouvelle voiture
                    //numero
                var grouprow=document.createElement('div');
                grouprow.className="form-group row";
                var label=document.createElement('label');
                label.className='col-sm-3 text-end control-label col-form-label';
                label.innerText='Numero';
                label.htmlFor='Numero';
                var colsm9=document.createElement('div');
                colsm9.className='col-sm-9';
                var input=document.createElement('input');
                input.className='form-control';
                input.type='text';
                input.name='numero'+nombreChild;
                grouprow.appendChild(label);
                grouprow.appendChild(colsm9);
                colsm9.appendChild(input);
                    //place
                var grouprow1=document.createElement('div');
                grouprow1.className="form-group row";
                var label1=document.createElement('label');
                label1.className='col-sm-3 text-end control-label col-form-label';
                label1.innerText='Nombre de Place';
                label1.htmlFor='Numero';
                var colsm91=document.createElement('div');
                colsm91.className='col-sm-9';
                var input1=document.createElement('input');
                input1.className='form-control';
                input1.type='number';
                input1.name='place'+nombreChild;
                grouprow1.appendChild(label1);
                grouprow1.appendChild(colsm91);
                colsm91.appendChild(input1);
                cardbody.appendChild(grouprow);
                cardbody.appendChild(grouprow1);
                nombreChild+=1;

            },false)

            boutondelete.addEventListener("click",function () {
                if(nombreChild>1)
                {
                    cardbody.removeChild(cardbody.lastChild);
                    cardbody.removeChild(cardbody.lastChild);
                    nombreChild-=1;
                }
                
            },false)
        </script>

    </div>
</div>