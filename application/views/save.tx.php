<div class="col-md-9">
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>


  <button onclick="calendar.prev();">prev</button> <button onclick="calendar.today();">Today</button> <button onclick="calendar.next();">next</button>
  <span id="renderRange" class="render-range"></span>
  <br>
  <div id="calendar" style="height: 700px" ></div> 

  <script>
    var Calendar = tui.Calendar;
    var calendar = new Calendar('#calendar', {
    defaultView: 'month',
    useCreationPopup: true,
    useDetailPopup: true,
    taskView: true,
    template: {
        monthGridHeader: function(model) {
        var date = new Date(model.date);
        var template = '<span class="tui-full-calendar-weekday-grid-date">' + date.getDate() + '</span>';
        return template;
        },
        
    }
    });

    var mois=calendar.getDateRangeStart().getMonth();
    console.log(mois);
    var annee=calendar.getDateRangeStart().getFullYear();
    console.log(annee);
    var daty=mois+'-'+annee;

    var event=[];

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var listcircuit=JSON.parse(this.responseText);
            console.log(listcircuit);
            
            listcircuit.forEach(circuit => {
                var eventobj={
                    id: '1',
                    calendarId: '1',
                    title:circuit.client,
                    category: 'time',
                    dueDateClass: '',
                    start: circuit.datedebut,
                    end: circuit.datefin,
                }
                event.push(eventobj);
            });
            
        }
    }
    var path="<?php echo base_url('ajax-listcircuit/')?>";
    xmlhttp.open("GET", path+daty, true);
    xmlhttp.send();

    console.log(event);

    calendar.createEvents(event);
    calendar.render();


    calendar.on({
        'clickSchedule': function(e) {
            console.log('clickSchedule', e);
        },
        'beforeCreateSchedule': function(e) {
            console.log('beforeCreateSchedule', e);
            // open a creation popup
        },
        'beforeUpdateSchedule': function(e) {
            console.log('beforeUpdateSchedule', e);
            e.schedule.start = e.start;
            e.schedule.end = e.end;
            cal.updateSchedule(e.schedule.id, e.schedule.calendarId, e.schedule);
        },
        'beforeDeleteSchedule': function(e) {
            console.log('beforeDeleteSchedule', e);
            cal.deleteSchedule(e.schedule.id, e.schedule.calendarId);
        }
    });

  </script>
</div>