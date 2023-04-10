$(function () {
    $("#calenda_week").hide()
    $("#calenda_day").hide()
    $("#calenda_month").show()
    var datet=$("#date_start").val();
    function selectDate(date) {
        $('#calendar-wrapper').updateCalendarOptions({
            date: date
        });
        //  console.log(calendar.getSelectedDate());
        const datev = new Date(calendar.getSelectedDate());
        console.log(formatDate(datev))
        $('#fixturedate').val(formatDate(datev))
        datet=formatDate(datev);
        window.location=configs.routes.index+"?date_start="+datet;
    }

    var defaultConfig = {
        weekDayLength: 1,
        date: datet,
        onClickDate: selectDate,
        showYearDropdown: true,
        startOnMonday: true,
        min:new Date()
    };

    var calendar = $('#calendar-wrapper').calendar(defaultConfig);
    function formatDate(date) {
        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + d.getDate(),
            year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
    $('#btn_day').click(function () {
        $(this).addClass('btn-active');
       // $(this).removeClass('btn-success');
        $('#btn_week').removeClass('btn-active');
        $('#btn_month').removeClass('btn-active');
        $("#calenda_week").hide()
        $("#calenda_day").show()
        $("#calenda_month").hide()

    })
    $('#btn_week').click(function () {
        $(this).addClass('btn-active');
        $('#btn_day').removeClass('btn-active');
        $('#btn_month').removeClass('btn-active');
        $("#calenda_week").show()
        $("#calenda_day").hide()
        $("#calenda_month").hide()
    })
    $('#btn_month').addClass('btn-active');
    $('#btn_month').click(function () {
        $(this).addClass('btn-active');
        $('#btn_week').removeClass('btn-active');
        $('#btn_day').removeClass('btn-active');
        $("#calenda_week").hide()
        $("#calenda_day").hide()
        $("#calenda_month").show()

    })
    $('#groupsalle').change(function () {
        $.ajax({
            url: configs.routes.reservation_getsalle,
            data: {
                groupe: $(this).val(),
                periode: $('#periode').val(),
                typejour: $('#typejour').val(),
                horaire_reservation: $(this).val(),
                mode: 'getsalle'
            },
            type: "GET",
            success: function (data) {
                $('#salle_select').html("")
                $('#salle_select').append("<option> Choisir une salle</option>");
                $.each(data.locals, function (index, item) {
                    $('#salle_select').append("<option value="+item.id+">"+item.libelle+"</option>")

                })
            },
            error: function (error) {

            }
        })
    })

})
if (document.querySelectorAll('#calendar_month').length) {
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar_month');
        let calendar1 = new FullCalendar.Calendar(calendarEl, {
            selectable: true,
            plugins: ["timeGrid", "dayGrid", "list", "interaction"],
            timeZone: "UTC",
            defaultView: "dayGridMonth",
            contentHeight: "auto",
            eventLimit: true,
            dayMaxEvents: 4,
            header: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
            },
            dateClick: function (info) {
                $('#schedule-start-date').val(info.dateStr)
                $('#schedule-end-date').val(info.dateStr)
                //  $('#date-event').modal('show')
                var SITE_URL="{{ url('/'}} ";
                console.log(info.dateStr)
                window.location=configs.routes.startreservation+"?date="+info.dateStr;
            },
            events:configs.routes.calendarevent+"?local="+$('#salle_id').val()
        });
        calendar1.render();
    });

}
