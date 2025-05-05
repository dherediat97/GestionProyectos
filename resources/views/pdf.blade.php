<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informe PDF Tareas Realizadas</title>
    <link rel="stylesheet" href="pdf.css" type="text/css">
</head>

<body>
    <table class="headerReport">
        <tr>
            <td> <img src="logo_blue.jpg" alt="logo" width="100" height="100" /></td>
            <td class="headerTitle">
                <h1>1 - {{ env('APP_COMPANY_NAME') }} S.C.A.</h1>
                <table>
                    <tr class="row">
                        <td class="label">DESDE FECHA</td>
                        <td>{{ $startDate }}</td>
                        <td class="label right">PROYECTO</td>
                        <td>{{ $project->name }}</td>
                    </tr>

                    <tr class="row">
                        <td class="label">HASTA FECHA</td>
                        <td>{{ $endDate }}</td>
                        <td class="label right">USUARIO</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="title">
        INFORME DE TAREAS REALIZADAS
    </div>

    <div class="margin-top">
        <table class="products">
            <tr class="header">
                <th colspan="6">{{ $project->name }}</th>
            </tr>
            <tr>
                <th>ID</th>
                <th>INICIO</th>
                <th>FIN</th>
                <th>MIN</th>
                <th>USUARIO</th>
                <th>TAREA REALIZADA</th>
            </tr>
            @foreach ($events as $event)
                <tr class="items">
                    <td class="left">
                        {{ $event->id }}
                    </td>
                    <td class="center">
                        {{ $event->start_date }}
                    </td>
                    <td class="center">
                        {{ $event->end_date }}
                    </td>
                    <td class="right">
                        {{ $event->minutes }}
                    </td>
                    <td class="left">
                        {{ $event->user_name }}
                    </td>
                    <td class="left">
                        {{ $event->text }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="total">
        TOTAL MINS: <span class="value">{{ $totalMins }}</span>
    </div>

    <div class="footer margin-top">
        <div>Página 1 de 1</div>
    </div>
</body>

</html>
