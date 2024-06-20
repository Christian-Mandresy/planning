
<!-- Modal: modalCart -->
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!--Header-->
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Trajet</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="cl">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <!--Body-->
      <div class="modal-body">
	  <h4 class="modal-title" id="chauffeur">Chauffeur</h4>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>lieu</th>
              <th>date</th>
              <th>numero</th>
              <th>client</th>
            </tr>
          </thead>
          <tbody id="tbody">
            <tr>
              <th scope="row">1</th>
              <td>Product 1</td>
              <td>100$</td>
              <td><a><i class="fas fa-times"></i></a></td>
            </tr>
            
          </tbody>
        </table>

      </div>
      <!--Footer-->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
        <button class="btn btn-info" id="detail">Detail</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal: modalCart -->

<div class="card" >
	<div class="row">
		<div class="col-lg-12">
			<div class="card-body b-l calender-sidebar">
			<div id="calendar" class="fc fc-unthemed fc-ltr">
				
			</div>
		</div>
	</div>
</div>



<script>


	function padTo2Digits(num) {
		return num.toString().padStart(2, '0');
	}

	function formatDate(date) {
		return (
				[
					date.year(),
					padTo2Digits(date.month() + 1),
					padTo2Digits(date.date()),
				].join('-') +
				' ' +
				[
					padTo2Digits(date.hours()),
					padTo2Digits(date.minutes()),
					padTo2Digits(date.seconds()),
				].join(':')
		);
	}

    var even=[];

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var listcircuit=JSON.parse(this.responseText);

			var colorcli=[];
            listcircuit.forEach(circuit => {

            	var titre=circuit.numero+'/ '+circuit.client+' /'+circuit.depart+'-'+circuit.arrive
				if(circuit.numero == null)
				{
					titre=circuit.client+' /'+circuit.depart+'-'+circuit.arrive
				}
				
				if(typeof colorcli[circuit.client] === 'undefined')
				{
					colorcli[circuit.client]="hsl(" + Math.random() * 360 + ", 100%, 75%)";
				}

				 
                var eventobj={
                    id:circuit.id,
                    title: titre,
                    start: circuit.datedebut,
                    end: circuit.datefin,
                    color: '#0092e0' //colorcli[circuit.client]
                }
                even.push(eventobj);



            });

			var calendar = $('#calendar').fullCalendar({
				defaultView: 'month',
				timeZone: 'local',
				header: {
				left: "prev,next today",
				center: "title",
				right: "month,listWeek,listDay",
				},
				buttonText: {
					month: 'Mois', 
					listWeek: 'semaine', 
					listDay: 'jour',
					today: 'Aujourd\'hui'
				},
				monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aôut','Septembre','Octobre','Novembre','Decembre'],
				monthNamesShort: ['Jan','Feb','Mar','Avr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
				dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
				dayNamesShort: ['Dim','Lun','Mar','Mer','jeu','ven','sam'],
				editable: false,
				selectable: true,
				selectHelper: true,
        		lang: 'fr', 
				events: even,
				displayEventTime: false,
				select: function(start, end) {
					//alert(start);
					//alert(end);
					$('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
					$('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
					$('#event_entry_modal').modal('show');
				},
				eventRender: function(event, element, view) {
					element.bind('click', function() {
						var tableaumodal=document.getElementById('tbody');
						var modal=document.getElementById('modalCart');
						var tr1=document.createElement('tr');

						var depart=document.createElement('td');
						depart.innerText=event.depart;
						var datedepart=document.createElement('td');
						datedepart.innerText=formatDate(event.start);
						var numero=document.createElement('td');
						numero.innerText=event.numero;
						var client=document.createElement('td');
						client.innerText=event.client;
						tr1.appendChild(depart);
						tr1.appendChild(datedepart);
						tr1.appendChild(numero);
						tr1.appendChild(client);

						var tr2=document.createElement('tr');
						var depart2=document.createElement('td');
						depart2.innerText=event.arrive;
						var datedepart2=document.createElement('td');
						datedepart2.innerText=formatDate(event.end);
						var numero2=document.createElement('td');
						numero2.innerText=event.numero;
						var client2=document.createElement('td');
						client2.innerText=event.client;
						var chauffeur=document.getElementById('chauffeur');
						chauffeur.innerText=event.chauffeur;
						tr2.appendChild(depart2);
						tr2.appendChild(datedepart2);
						tr2.appendChild(numero2);
						tr2.appendChild(client2);

						while (tableaumodal.firstChild) {
							tableaumodal.removeChild(tableaumodal.lastChild);
						}
						tableaumodal.appendChild(tr1);
						tableaumodal.appendChild(tr2);

						var close=document.getElementById('close');
						var cl=document.getElementById('cl');
						var detail=document.getElementById('detail');
						var base_url = window.location.origin;
						detail.addEventListener('click',function () {
							location.href=base_url+'/planningProduction/'+'assignement-voiture/'+event.id;
						})
						close.addEventListener('click',function () {
							$('#modalCart').modal('hide');
						});
						cl.addEventListener('click',function () {
							$('#modalCart').modal('hide');
						});
						$('#modalCart').modal('show');

					});
				},
				viewRender: function(view, element) {
					var cal=$('#calendar');
					var b = cal.fullCalendar('getDate');
					var mois=b.month()+1;
					var annee=b.year();
					var daty=mois+'-'+annee;
					var evenement=[];
					evenement.push(even[0]);
					$('#calendar').fullCalendar('removeEvents');
					var xmlhttp1 = new XMLHttpRequest();
					xmlhttp1.onreadystatechange = function(){
						if(this.readyState == 4 && this.status == 200){
							var listcircuit1=JSON.parse(this.responseText);
							//var colorcli=[];
							listcircuit1.forEach(circuit => {

								var titre=circuit.numero+'/ '+circuit.client+' /'+circuit.depart+'-'+circuit.arrive
								if(circuit.numero == null)
								{
									titre=circuit.client+' /'+circuit.depart+'-'+circuit.arrive
								}
								
								if(typeof colorcli[circuit.client] === 'undefined')
								{
									colorcli[circuit.client]="hsl(" + Math.random() * 360 + ", 100%, 75%)";
								}

								 
								var eventobj1={
									id:circuit.id,
									title: titre,
									start: circuit.datedebut,
									end: circuit.datefin,
									depart: circuit.depart,
									arrive: circuit.arrive,
									chauffeur: circuit.chauffeur,
									numero: circuit.numero,
									client: circuit.client,
									color:  '#0092e0' //colorcli[circuit.client]
								}

								evenement.push(eventobj1);
								var evey=[];
								evey.push(eventobj1);
								$('#calendar').fullCalendar('addEventSource',evey);
							});


						}

					}
					var path="<?php echo base_url('ajax-listcircuit/')?>";
					xmlhttp1.open("GET", path+daty, true);
					xmlhttp1.send();


				}
			});

        }


    }
    var path="<?php echo base_url('ajax-listcircuit/')?>";
	var d = new Date();
	var month = d.getMonth()+1;
	var year = d.getFullYear();
	var daty=month+'-'+year;
    xmlhttp.open("GET", path+daty, true);
    xmlhttp.send();


    
    //end fullCalendar block
    
    

   
</script>
