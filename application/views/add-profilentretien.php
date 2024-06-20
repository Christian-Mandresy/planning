<div class="col-md-8">
    <div class="card">
        <form class="form-horizontal" method="post" action="<?php echo site_url()?>/add-profilentretien-post" id="form">
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
            <h4 class="card-title">Ajouter Un type d'entretien</h4>
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
                    for="description"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Description</label
                >
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
            </div>

                <div class="form-group row">
                    <h6 style="margin-left:55%;color:#69c1f0">ajouter des pièces</h6>   
                </div>
            

            <div class="form-group row">
                <label
                    for="piece"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Pièces</label
                >
                <div class="col-sm-9">
                <select class="select2 form-select shadow-none select2-hidden-accessible" style="width: 100%; height: 36px" data-select2-id="1" tabindex="-1" aria-hidden="true" name="idpiece">
                    <?php $i=1; foreach($pieces as $piece) { ?>  
                    <option value="<?php echo $piece->id?>" ><?php echo $piece->nom?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <div class="form-group row">
                <label
                    for="kilometrage"
                    class="col-sm-3 text-end control-label col-form-label"
                    >Kilometrage avant entretien</label
                >
                <div class="col-sm-9">
                    <input
                    type="number"
                    class="form-control"
                    name="kilometrage"
                    id="kilometrage"
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
            var listpiece=<?php echo json_encode($pieces); ?>;

            console.log(listpiece);


            bouton.addEventListener("click",function () {
                //creation des groupes d'input voiture pour l'ajout de nouvelle voiture
                    //piece
                var grouprow=document.createElement('div');
                grouprow.className="form-group row";
                var label=document.createElement('label');
                label.className='col-sm-3 text-end control-label col-form-label';
                label.innerText='Piece';
                label.htmlFor='Piece';
                var colsm9=document.createElement('div');
                colsm9.className='col-sm-9';
                var input=document.createElement('select');
                input.className='select2 form-select shadow-none';
                input.style='width: 100%; height: 36px';
                input.tabindex="-1";
                input.name='idpiece'+nombreChild;
                input.id='idpiece'+nombreChild;

                for (const piece of listpiece)
                {
                    var option = document.createElement("option");
                    option.value = piece.id;
                    option.text = piece.nom;
                    input.appendChild(option);
                }

                grouprow.appendChild(label);
                grouprow.appendChild(colsm9);
                colsm9.appendChild(input);
                    //place
                var grouprow1=document.createElement('div');
                grouprow1.className="form-group row";
                var label1=document.createElement('label');
                label1.className='col-sm-3 text-end control-label col-form-label';
                label1.innerText='Kilometrage avant entretien';
                label1.htmlFor='Kilometrage';
                var colsm91=document.createElement('div');
                colsm91.className='col-sm-9';
                var input1=document.createElement('input');
                input1.className='form-control';
                input1.type='number';
                input1.name='kilometrage'+nombreChild;
                grouprow1.appendChild(label1);
                grouprow1.appendChild(colsm91);
                colsm91.appendChild(input1);
                cardbody.appendChild(grouprow);
                cardbody.appendChild(grouprow1);
                nombreChild+=1;
                $('.select2').select2();

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