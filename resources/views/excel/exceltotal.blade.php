<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Total</title>
</head>

<body>
<table>
    <tbody>
        <tr>
            <td width="10" height="50">Reporte: {{$reporte->nombre}}</td>
            <td colspan="2"><b>De: {{$date_range[0]}}</b></td>
            <td colspan="2"><b>A: {{$date_range[1]}}</b></td>
        </tr>
        <tr>
            <td width="10" height="50">Cuenta:</td>
            <td colspan="3"><b>{{$cuenta->nombre}}</b></td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <tr>
            <td><b>Consulta</b></td>
            <td colspan="2"><b>Total</b></td>
        </tr>
        @foreach($total as $query)
            @if(count($query["values"]) < 2)
                <tr>
                    <td>{{$query["name"]}}</td>
                    <td colspan="2">{{$query["values"]}}</td>
                </tr>
                {{$var =true}}
            @else
                <tr>
                    <td rowspan={{count($query["values"]) + 1}}>{{$query["name"]}}</td>
                </tr>
                @foreach($query["values"] as $inner_value)
                    <tr>
                        <td>empty</td>
                        <td width="15">{{$inner_value[0]}}</td>
                        <td>{{$inner_value[1]}}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    </tbody>
</table>
</body>

</html>