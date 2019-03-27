var Calendar = function () {
    //function to initiate Full CAlendar
    var runCalendar = function () {
        $('#event-categories div.event-category').each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text() + " Novo") // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 50 //  original position after the drag
            });
        });
        /* initialize the calendar
				 -----------------------------------------------------------------*/
        //VARIÁVEL GLOBAL
        var dados = constantes();

        var home = dados['HOME'];
        var urlCarregaTarefa = home + 'admin/Controller/AgendaCarrega.Controller.php';
        var urlValida = home + 'admin/Controller/Ajax.Controller.php';

        var calendar = $('#calendar').fullCalendar({
            buttonText: {
                prev: '<i class="fa fa-chevron-left"></i>',
                next: '<i class="fa fa-chevron-right"></i>'
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: urlCarregaTarefa,
            editable: true,
            selectable: true,
            timeFormat: 'H:mm',
            selectHelper: true,
            select: function (start) {
                var dia = start.getDate();
                var mes = (start.getMonth() + 1);
                var hora_inicio = '20-00';
                var dt_inicio;
                var hora = start.getHours();
                var minuto = start.getMinutes();

                if (dia < 10) {
                    dia = '0' + dia;
                }
                if (mes < 10) {
                    mes = '0' + mes;
                }

                if (hora < 10) {
                    hora = '0' + hora;
                }
                if (minuto < 10) {
                    minuto = '0' + minuto;
                }
                if (hora > 0) {
                    hora_inicio = hora + '-' + minuto;
                }
                dt_inicio = dia + '-' + mes + '-' + start.getFullYear();
                $.get(urlValida, {valida: 'cadastro_agenda', dt_inicio: dt_inicio, hr_inicio: hora_inicio},
                    function (retorno) {
                        window.location.href = home + retorno;
                    });

            },
            eventClick: function (calEvent) {
                if (calEvent.id) {
                    $.get(urlValida, {valida: 'pesquisa_agenda', co_agenda: calEvent.id},
                        function (retorno) {
                            window.location.href = home + retorno;
                        });
                } else {
                    var time = calEvent.start;
                    var dia = time.getDate();
                    var mes = (time.getMonth() + 1);
                    var hora_inicio = '20-00';
                    var dt_inicio;
                    if (dia < 10) {
                        dia = '0' + dia;
                    }
                    if (mes < 10) {
                        mes = '0' + mes;
                    }
                    dt_inicio = dia + '-' + mes + '-' + time.getFullYear();

                    $.get(urlValida, {valida: 'cadastro_agenda', dt_inicio: dt_inicio, hr_inicio: hora_inicio},
                        function (retorno) {
                            window.location.href = home + retorno;
                        });
                }
            }
        });
    };
    return {
        init: function () {
            runCalendar();
        }
    };
}();