/**
* @name {FullCalendar} APP.JS
* @author Isaiah Robinson
* @organization CANSA Centre For Community and Cultural Development
* @date 06-02-2021
*
* Purpose:
* This script controls the calendar that shows on the sidebar of most pages
* as well as the calendar page at http://www.cansacentre.com/calendar
*/

// on document load
document.addEventListener('DOMContentLoaded', function() {
  // Side Bar Calendar
  let sideCalendarEl = document.getElementById('sideBarCalendar');
  let timeZoneSelectorEl = document.getElementById('time-zone-selector');
  let loadingEl = document.getElementById('loading');
  let sideCalendar = new FullCalendar.Calendar(sideCalendarEl, {
    timeZone: 'local',
    initialView: 'listMonth',
    googleCalendarApiKey: 'AIzaSyCbrP4zdc7-dBQBa6Qa4Hqzwy3WntgwoM4',
    eventSources: [{
        googleCalendarId: 'en.canadian#holiday@group.v.calendar.google.com',
        className: 'holidays'
      },
      {
        googleCalendarId: 'cansacentre@gmail.com',
        className: 'CANSA-Centre'
      }
    ],
    headerToolbar: {
      left: '',
      center: 'Upcoming Events',
      right: ''
    },
    height: 400
  });

  sideCalendar.render();
  // Calendar Page Calendar
  let calendarEl = document.getElementById('calendar');
  if (calendarEl) {
    let calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      googleCalendarApiKey: 'AIzaSyCbrP4zdc7-dBQBa6Qa4Hqzwy3WntgwoM4',
      themeSystem: 'standard',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },
      dayMaxEvents: true, // allow "more" link when too many events
      views: {
        timeGrid: {
          dayMaxEventRows: 2 // adjust to 6 only for timeGridWeek/timeGridDay
        }
      },
      eventSources: [{
          googleCalendarId: 'en.canadian#holiday@group.v.calendar.google.com',
          className: 'holidays'
        },
        {
          googleCalendarId: 'cansacentre@gmail.com',
          className: 'CANSA-Centre',
          color: '#4279bb',
          backgroundColor: '#f2f1f1'
        }
      ],
      loading: function(bool) {
        if (bool) {
          loadingEl.style.display = 'inline'; // show
        } else {
          loadingEl.style.display = 'none'; // hide
        }
      }
    });

    calendar.render();

    // load the list of available timezones, build the <select> options
    // it's highly encouraged to use your own AJAX lib instead of using FullCalendar's internal util
    FullCalendar.requestJson('GET', 'https://fullcalendar.io/demo-timezones.json', {}, function(timeZones) {
      timeZones.forEach(function(timeZone) {
        var optionEl;

        if (timeZone !== 'UTC') { // UTC is already in the list
          optionEl = document.createElement('option');
          optionEl.value = timeZone;
          optionEl.innerText = timeZone;
          timeZoneSelectorEl.appendChild(optionEl);
        }
      });
    }, function() {
      // failure
    });

    // when the timezone selector changes, dynamically change the calendar option
    timeZoneSelectorEl.addEventListener('change', function() {
      calendar.setOption('timeZone', this.value);
    });
  } else {
    return;
  }

});
