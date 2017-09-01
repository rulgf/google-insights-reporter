<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Desglose</title>
</head>

<body>
<table>
    <tbody>
        <tr>
            <td width="20" height="50">Reporte: {{$reporte->nombre}}</td>
            <td colspan="2"><b>De: {{$date_range[0]}}</b></td>
            <td colspan="2"><b>A: {{$date_range[1]}}</b></td>
        </tr>
        <tr>
            <td width="10" height="50">Cuenta:</td>
            <td colspan="2"><b>{{$cuenta->nombre}}</b></td>
        </tr>
        <tr>
            <td colspan="{{(count($dates) *2)+1}}">&nbsp;</td>
        </tr>
        <tr>
            <td><b>Consulta</b></td>
            @foreach($dates as $date)
                <td colspan="2"><b>{{$date}}</b></td>
            @endforeach
        </tr>
    @foreach($total_d as $query)
        @if(count($query["values"][0]) < 2)
            <tr>
                <td width="15">{{$query["name"]}}</td>
                @foreach($query["values"] as $value)
                    <td colspan="2">{{$value}}</td>
                @endforeach
            </tr>
        @else
            <tr>
                <td rowspan={{count($query["values"][0]) + 1}}>{{$query["name"]}}</td>
            </tr>
            @for($i =0; $i < count($query["values"][0]); $i++)
                <tr>
                    <td>empty</td>
                    @foreach($query["values"] as $inner)
                        <td width="15">{{$inner[$i][0]}}</td>
                        <td>{{$inner[$i][1]}}</td>
                    @endforeach
                </tr>
            @endfor
        @endif
    @endforeach
    </tbody>
</table>
</body>

</html>