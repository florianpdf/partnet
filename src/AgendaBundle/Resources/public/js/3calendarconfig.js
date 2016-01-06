$(document).ready(function() {

console.log(user);
    console.log(admin);

    $('#calendar').fullCalendar({
        header: { // Contenu du header
            left: 'month, agendaWeek',
            center: 'title',
            right: 'today prev, next'
        },
        lang: 'fr',
        defaultView: 'agendaWeek', // vue par default
        views: { // format d'affichage de la date en fonction des vue
            month: {
                titleFormat: 'MMMM YYYY'
            },
            agenda:{
                titleFormat: 'D MMM YYYY'
            }
        },
        firstDay: 1, // jour ou l'agenda commentce 1 = lundi, 2 = mardi , etc...
        weekNumbers: true, // affichage du numéro de la semaine en cour
        businessHours: { // heure de travail
            start: '09:00',
            end: '18:00',
            dow: [1, 2, 3, 4, 5]
        },
        handleWindowResize: true, // redimenssionne auto du calendrier en fonction de la width du navigateur
        weekends: false, // affichage des weekends
        allDaySlot: false, // recapitulatif de la journée en haut du calendar
        slotLabelFormat: 'HH:mm', // format de l'heure sur les slots
        timeFormat: 'HH:mm',
        minTime: "08:00:00", // heure de début du calendar
        maxTime: '20:00:00', // heure de fin du calendar
        scrollTime: '09:00:00', // heure sur laquelle le calendar pointe par default
        slotEventOverlap: false, // Les évènements ne se chevauchent pas
        height: 'auto',
        forceEventDuration: true, // on oblige le user à mettre une heure de fin à l'evenement

        events: Routing.generate('events'),

        dayClick: function(date) {
            if (admin != null){
                window.location = Routing.generate('events') + date.format() + '/new';
            }
        },

        eventRender: function(event, element) {
            element.each(function() {
                element.append('<strong>' + event.titre + '</strong>');
            })
        },

        eventClick: function(calEvent) {
            console.log(calEvent.idUser.username);
            if (user == calEvent.idUser.username) {
                window.location = Routing.generate('events') + calEvent.id + '/edit';
            }
        }
    });
});