<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Desglose</title>
</head>

<body>
<table>
    <tbody>
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