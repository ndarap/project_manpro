<?php
$this->title = 'Task Calendar';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- FullCalendar CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<div class="card shadow-lg border-0 rounded-4 p-4">
    <h3 class="fw-bold mb-3 text-primary">📅 Task Calendar</h3>
    <div id="calendar"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let calendarEl = document.getElementById('calendar');

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '<?= Yii::$app->urlManager->createUrl(['calendar/events']) ?>',
            eventClick: function (info) {
                window.location.href =
                    '<?= Yii::$app->urlManager->createUrl(['task/view']) ?>&task_id=' + info.event.id;
            }
        });

        calendar.render();
    });
</script>