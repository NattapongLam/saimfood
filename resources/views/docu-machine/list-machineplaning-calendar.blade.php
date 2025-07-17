@extends('layouts.main')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
<style>
    #calendar {
        max-width: 100%;
        margin: 0 auto;
        padding: 10px;
    }

    .fc-event-title {
        font-weight: 500;
    }

    .fc-daygrid-event {
        padding: 4px;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="my-0"><i class="mdi mdi-calendar-clock me-2"></i> ปฏิทินแผนบำรุงรักษาเครื่องจักร (PM)</h5>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const events = {!! $events !!};

        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'th',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            height: 'auto',
            events: events,
            eventClick: function (info) {
                const id = info.event.id;
                const url = `{{ route('machine-planing-docus.edit', ':id') }}`.replace(':id', id);
                window.location.href = url;
            },
            eventDidMount: function(info) {
                if (info.event.extendedProps.description) {
                    const tooltip = document.createElement('div');
                    tooltip.innerHTML = `<small>${info.event.extendedProps.description}</small>`;
                    info.el.appendChild(tooltip);
                }
            }
        });

        calendar.render();
    });
</script>
@endsection
