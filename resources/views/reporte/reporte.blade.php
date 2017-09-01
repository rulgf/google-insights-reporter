<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dood Insights</title>
    <link rel="stylesheet" href="../css/pdf.css" media="all">
    <link type="text/css" rel="stylesheet" media="print" href="../css/theme-default/bootstrap.css" />
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <style>
        @font-face {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 200;
            src: local('Roboto Regular'),
            local('Roboto-Regular'),
            url(http://themes.googleusercontent.com/static/fonts/roboto/v11/2UX7WLTfW3W8TclTUvlFyQ.woff)
            format('woff');
        }
        body{
            font-family: Roboto !important;
        }
        #tables{
            text-align: center;
        }
    </style>
</head>

<body>
    <div>
        <div>
            <div id="tables">
                <div id="totales" class="col-md-12">
                    <h1>Totales</h1>
                </div>
                <div id="desglose" class="col-md-12">
                    <h1>Desglose</h1>
                </div>
            </div>

            <div id="graphs" class="col-md-12"></div>
        </div>
    </div>
</body>

<script>
    //Funcion para adaptar el contenido
    function adaptarContent(){
        var result= window.contentQueries;
        var rownames = window.namesQueries;
        var headers = window.datesQueries;
        var rowSpan = 1;
        var tablas = [];//principal

        //Obtengo el maximo RowSpan
        for(var a = 0; a<result.length; a++){
            if(result[a][0].length > rowSpan){
                rowSpan = result[a][0].length;
            }
        }

        //Recorro i = columnas (queries)
        for(var i = 0; i < result.length; i++){
            var query =[];//contenido de una tabla

            //creo el header
            var heads = [];
            var name = document.createElement('th');
            name.colSpan = "3";
            var text = document.createTextNode(rownames[i]);
            name.appendChild(text);

            var nameRow = document.createElement('tr');
            nameRow.appendChild(name);
            query.push(nameRow);

            //Creo el contenido
            if(result[i][0].length == 1 ){
                //Query sencillo
                for(var j = 0; j<result[i].length; j++){
                    var row =[];
                    //Nombre del renglon (fecha)
                    var date = document.createElement('th');
                    var textdate = document.createTextNode(headers[j]);
                    date.appendChild(textdate);

                    var content = document.createElement('td');
                    content.colSpan = "2";
                    var textcontent = document.createTextNode(result[i][j][0][0]);
                    content.appendChild(textcontent);

                    //row.push(date);
                    //row.push(content);
                    var contentRow = document.createElement('tr');
                    contentRow.appendChild(date);
                    contentRow.appendChild(content);

                    query.push(contentRow);
                }
            }else {
                //Query complejo
                for(var j = 0; j<result[i].length; j++){
                    var row=[];
                    for(var k = 0; k<result[i][j].length; k++){
                        if(k==0){
                            var date = document.createElement('th');
                            date.rowSpan = rowSpan;
                            var textHead = document.createTextNode(headers[j]);
                            date.appendChild(textHead);

                            row.push(date)
                        }
                        for(var l = 0; l<result[i][j][k].length; l++){
                            var subRenglon = document.createElement('td');
                            var textSub = document.createTextNode(result[i][j][k][l]);
                            subRenglon.appendChild(textSub);

                            row.push(subRenglon);
                        }
                        var contentRow = document.createElement('tr');
                        for (var r = 0; r < row.length; r++){
                            contentRow.appendChild(row[r]);
                        }
                        query.push(contentRow);
                        row=[];
                    }
                }

            }

            var queryTable = document.createElement('table');
            queryTable.className = "responstable";
            for(var q = 0; q<query.length; q++){
                queryTable.appendChild(query[q]);
            }

            var divTabla = document.createElement('div');
            divTabla.className = "col-md-3";
            divTabla.appendChild(queryTable);
            tablas.push(divTabla);
        }

        for(var d=0; d<tablas.length; d++){
            document.getElementById("desglose").appendChild(tablas[d]);
        }
    }

    //Funcion para adaptar el contenido de los resumenes
    function adaptarContentTotal(){
        var result= window.totalQueries;
        var rownames = window.namesQueries;
        //var headers = datesQueries;
        var rowSpan = 1;
        var tablas = [];//principal

        //Obtengo el maximo RowSpan
        for(var a = 0; a<result.length; a++){
            if(result[a][0].length > rowSpan){
                rowSpan = result[a][0].length;
            }
        }

        //Recorro i = columnas (queries)
        for(var i = 0; i < result.length; i++){
            var query =[];//contenido de una tabla

            //creo el header
            var heads = [];
            var name = document.createElement('th');
            name.colSpan = "2";
            var textName = document.createTextNode(rownames[i]);
            name.appendChild(textName);

            var nameRow = document.createElement('tr');
            nameRow.appendChild(name);
            query.push(nameRow);

            //Creo el contenido
            if(result[i][0].length == 1 ){
                //Query sencillo
                for(var j = 0; j<result[i].length; j++){
                    //var row =[];
                    //Nombre del renglon (fecha)
                    var content = document.createElement('td');
                    content.colSpan = "2";
                    var textContent = document.createTextNode(result[i][j][0]);
                    content.appendChild(textContent);
                    //row.push(content);

                    var contentRow = document.createElement('tr');
                    contentRow.appendChild(content);
                    query.push(contentRow);
                }
            }else {
                //Query complejo
                for(var j = 0; j<result[i].length; j++){
                    var row=[];
                    for(var k = 0; k<result[i][j].length; k++){
                        var subRenglon = document.createElement('td');
                        var textSub = document.createTextNode(result[i][j][k]);
                        subRenglon.appendChild(textSub);

                        row.push(subRenglon);
                    }
                    var contentRow = document.createElement('tr');
                    for (var r = 0; r < row.length; r++){
                        contentRow.appendChild(row[r]);
                    }
                    query.push(contentRow);
                    row=[];
                }
            }

            var queryTable = document.createElement('table');
            queryTable.className = "responstable";

            for(var q = 0; q<query.length; q++){
                queryTable.id="tabla-total-" + i;
                queryTable.appendChild(query[q]);
            }

            var divTabla = document.createElement('div');
            divTabla.className = "col-md-3";
            divTabla.appendChild(queryTable);
            tablas.push(divTabla);
        }

        for(var d=0; d<tablas.length; d++){
            document.getElementById("totales").appendChild(tablas[d]);
        }
    }

    //Funcion para ejecutar Highcharts
    function adaptarCharts(){
        var charts = window.chartsQueries;
        var divs = [];

        for(var i =0; i <charts.length; i++){
            var div = document.createElement('div');
            div.id = "chart-" + i;
            div.className = "col-md-6";
            divs.push(div);
        }

        for(var d =0; d<divs.length; d++){
            document.getElementById("graphs").appendChild(divs[d]);
        }

        for(var c= 0; c<charts.length; c++){
            eval(charts[c]);
        }
    }

    adaptarContent();
    adaptarContentTotal();
    adaptarCharts();
</script>

</html>
