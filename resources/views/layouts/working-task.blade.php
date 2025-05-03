<!DOCTYPE html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8">

    <script src="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler.js"></script>
    <link href="https://cdn.dhtmlx.com/scheduler/edge/dhtmlxscheduler.css" rel="stylesheet">

    <style type="text/css">
        html,
        body {
            height: 100%;
            padding: 0px;
            margin: 0px;
            overflow: hidden;
        }

        .dhx_cal_event {
            --dhx-scheduler-event-border: 1px solid #732d16;
            --dhx-scheduler-event-background: #041e49;
        }
    </style>
</head>

<body>
    <div id="scheduler" class="dhx_cal_container" style='width:100%; height:100%;'>
        <div class="dhx_cal_navline">
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>
            <div class="dhx_cal_tab" data-tab="day"></div>
            <div class="dhx_cal_tab" data-tab="week"></div>
            <div class="dhx_cal_tab" data-tab="month"></div>
        </div>
        <div class="dhx_cal_header"></div>
        <div class="dhx_cal_data"></div>
    </div>
    <script type="text/javascript">
        scheduler.config.xml_date = "%Y-%m-%d %H:%i:%s";
        scheduler.i18n.setLocale("es");
        scheduler.config.show_errors = false;
        scheduler.config.show_loading = true;
        scheduler.setLoadMode("day");
        scheduler.init("scheduler", new Date(2025, 05, 03), "day");

        scheduler.load("/api/events", "json");
        let dp = scheduler.createDataProcessor("/api/events");
        dp.init(scheduler);
        dp.setTransactionMode("REST");
    </script>
</body>
