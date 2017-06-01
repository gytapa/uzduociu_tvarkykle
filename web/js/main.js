$(function(){
    $('#calendar').fullCalendar({
        eventSources:[
            'js/tasks.json'
        ]
    });
});