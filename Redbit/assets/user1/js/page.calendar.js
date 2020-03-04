$(document).ready(function(){

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        defaultDate: '2019-02-12',
        navLinks: true,
        editable: true,
        eventLimit: true,
        events: [
            {
                title: 'All Day Event',
                start: '2019-02-01'
            },
            {
                title: 'Long Event',
                start: '2019-02-07',
                end: '2019-02-07',
                backgroundColor: '#3498DBB',
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2019-02-09',
                backgroundColor: '#ad0af9',
            },
            {
                id: 999,
                title: 'Repeating Event',
                start: '2019-02-16',
                backgroundColor: '#ad0af9',
            },
            {
                title: 'Conference',
                start: '2019-02-04',
                end: '2019-02-06',
                backgroundColor: '#67daff',
            },
            {
                title: 'Meeting',
                start: '2019-02-12T10:30:00',
                end: '2019-02-12T12:30:00',
            },
            {
                title: 'Lunch',
                start: '2019-02-12T12:00:00'
            },
            {
                title: 'Meeting',
                start: '2019-02-12T14:30:00'
            },
            {
                title: 'Happy Hour',
                start: '2019-02-12T17:30:00'
            },
            {
                title: 'Dinner',
                start: '2019-02-12T20:00:00'
            },
            {
                title: 'Birthday Party',
                start: '2019-02-13T07:00:00'
            },
            {
                title: 'Click for Google',
                url: 'http://google.com/',
                start: '2019-02-28',
                backgroundColor: '#00e676',
            }
        ]
    });

});
