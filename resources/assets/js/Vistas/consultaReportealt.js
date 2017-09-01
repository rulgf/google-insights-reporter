//Defaults
import  React from 'react';
import   ReactDOM from 'react-dom';
import  SideMenubar from '../Componentes/menubar';
import  Header from '../Componentes/header';
import  MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import  {Tabs, Tab} from 'material-ui/Tabs'
import  DatePicker from 'material-ui/DatePicker';
import  {Line, Bar, Radar, Pie} from 'react-chartjs'
import  FlatButton from 'material-ui/FlatButton';
import  ReactHighcharts from 'react-highcharts';
import  CircularProgress from 'material-ui/CircularProgress';

import $ from 'jquery';
import IntlPolyfill from 'intl';


//Armo la vista
export default class consultaReportealt extends  React.Component{

    constructor(props) {
        super(props);

        //Traducción de idioma para datepicker
        require ('intl/locale-data/jsonp/es');

        this.state = {
            reporteId : this.props.params.reporteId,
            reporteXls: "",
            content: [],
            rownames:  [],
            headers: [],
            totalrow: [],

            //Fechas y tipo para ejecutar el reporte
            tipo: 1,
            formato_fecha : IntlPolyfill.DateTimeFormat,
            fecha_inicial: null,
            fecha_final: null,

            //bool para saber si ya ejecuto el reporte
            runbool : false,

            //Elementos Reporte
            totales:[],
            desglose: [],
            graficas: [],

            //executing
            running: false,

            //Cuenta Activa
            selectedCuenta: this.props.activeCount,
            selectedCuentaObj: {},
        }
    }

    componentWillMount(){
        this.setState({selectedCuenta: this.props.activeCount});
    }

    ejecutaReporte(){
        $.ajax({
            type: 'GET',
            url: 'executealt/'+this.props.params.reporteId,
            context: this,
            dataType: 'json',
            cache: false,
            data: {
                startDate: this.state.fecha_inicial,
                endDate: this.state.fecha_final,
                tipo: this.state.tipo,
            },
            success: function (data) {
                //Obtener las opciones de la consulta
                this.setState({
                    content : data[0],
                    rownames : data[1],
                    headers: data[2],
                    totalrow: data[3],
                    graficas: [],
                }, function () {
                    this.adaptarContent();
                    this.adaptarContentTotal();
                    this.highcharts();

                    this.setState({
                        runbool: true,
                        running: false
                    })
                });
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Handlers Fechas
    handleChangeFecha_inicial(event, date) {
        this.setState({fecha_inicial: date}, function () {
            if(this.state.fecha_final && this.state.fecha_final){
                this.setState({running: true}, function () {
                    this.ejecutaReporte();
                });
            }
        });


        if (this.state.fecha_final != null) {
            if (this.state.fecha_inicial >= this.state.fecha_final) {
                this.setState({
                    fecha_final: this.state.fecha_inicial
                });
            }
        }
    }


    handleChangeFecha_final(event, date) {
        this.setState({fecha_final: date}, function () {
            if(this.state.fecha_final && this.state.fecha_final){
                this.setState({running: true}, function () {
                    this.ejecutaReporte();
                });
            }
        });

        if ( this.state.fecha_inicial == null) {
            this.setState({
                fecha_inicial: this.state.fecha_final
            });
        }

        if (this.state.fecha_final <  this.state.fecha_inicial){
            this.setState({
                fecha_inicial: this.state.fecha_final
            });
        }
    }

    handleActiveDia(tab) {
        this.setState({tipo: 1}, function () {
            if(this.state.fecha_final && this.state.fecha_final){
                this.setState({
                    content: [],
                    rownames:  [],
                    headers: [],
                    totalrow: [],
                }, function () {
                    this.setState({running: true}, function () {
                        this.ejecutaReporte();
                    });
                });
            }
        });
    }

    handleActiveSemana(tab) {
        this.setState({tipo: 2}, function () {
            if(this.state.fecha_final && this.state.fecha_final){
                this.setState({
                    content: [],
                    rownames:  [],
                    headers: [],
                    totalrow: [],
                }, function () {
                    this.setState({running: true}, function () {
                        this.ejecutaReporte();
                    });
                });
            }
        });
    }

    handleActiveMes(tab) {
        this.setState({tipo: 3}, function () {
            if(this.state.fecha_final && this.state.fecha_final){
                this.setState({
                    content: [],
                    rownames:  [],
                    headers: [],
                    totalrow: [],
                }, function () {
                    this.setState({running: true}, function () {
                        this.ejecutaReporte();
                    });
                });

            }
        });
    }

    //Función para adaptar el contenido de la tabla
    adaptarContent(){
        var result= this.state.content;
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
            var name = React.createElement('th', {colSpan: "3", nobr: "true"}, this.state.rownames[i]);
            heads.push(name);
            var rowNames = React.createElement('tr', {nobr: "true"}, heads);
            query.push(rowNames);

            //Creo el contenido
            if(result[i][0].length == 1 ){
                //Query sencillo
                for(var j = 0; j<result[i].length; j++){
                    var row =[];
                    //Nombre del renglon (fecha)
                    var date = React.createElement('th', {nobr: "true"}, this.state.headers[j]);
                    var content = React.createElement('td', {colSpan: "2"}, parseFloat(result[i][j][0][0]).toFixed(2));
                    row.push(date);
                    row.push(content);
                    var contentRow = React.createElement('tr', {nobr: "true"}, row);
                    query.push(contentRow);
                }
            }else {
                //Query complejo
                for(var j = 0; j<result[i].length; j++){
                    var row=[];
                    for(var k = 0; k<result[i][j].length; k++){
                        if(k==0){
                            var date = React.createElement('th', { rowSpan: rowSpan, nobr: "true"}, this.state.headers[j]);
                            row.push(date)
                        }
                        for(var l = 0; l<result[i][j][k].length; l++){
                            var subRenglon = React.createElement('td', {nobr: "true"}, result[i][j][k][l]);
                            row.push(subRenglon);
                        }
                        var contentRow = React.createElement('tr', {nobr: "true"}, row);
                        query.push(contentRow);
                        row=[];
                    }
                }

            }

            var queryTable = React.createElement('table', {className: "responstable"}, query);
            var divTabla = React.createElement('div' ,{className: "col-md-3"}, queryTable);
            tablas.push(divTabla);
        }

        this.setState({desglose: tablas});

    }

    //Funcion para adaptar el contenido de los resumenes
    adaptarContentTotal(){
        var result= this.state.totalrow;
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
            var name = React.createElement('th', {colSpan: "2", nobr: "true"}, this.state.rownames[i]);
            heads.push(name);
            var rowNames = React.createElement('tr', {nobr: "true"}, heads);
            query.push(rowNames);

            //Creo el contenido
            if(result[i][0].length == 1 ){
                //Query sencillo
                for(var j = 0; j<result[i].length; j++){
                    var row =[];
                    //Nombre del renglon (fecha)
                    if(Number(result[i][j][0])){
                        var c_value = parseFloat(result[i][j][0]).toFixed(2)
                    }else{
                        var c_value = result[i][j][0];
                    }
                    var content = React.createElement('td', {colSpan: "2", nobr: "true"}, c_value);
                    row.push(content);
                    var contentRow = React.createElement('tr', {nobr: "true"}, row);
                    query.push(contentRow);
                }
            }else {
                //Query complejo
                for(var j = 0; j<result[i].length; j++){
                    var row=[];
                    for(var k = 0; k<result[i][j].length; k++){
                        if(Number(result[i][j][0])){
                            var c_value = parseFloat(result[i][j][k]).toFixed(2)
                        }else{
                            var c_value = result[i][j][k];
                        }
                        var subRenglon = React.createElement('td', {nobr: "true"}, c_value);
                        row.push(subRenglon);
                    }
                    var contentRow = React.createElement('tr', {nobr: "true"}, row);
                    query.push(contentRow);
                    row=[];
                }

            }

            var queryTable = React.createElement('table', {className: "responstable"}, query);
            var divTabla = React.createElement('div' ,{className: "col-md-3"}, queryTable);
            tablas.push(divTabla);
        }
        this.setState({totales: tablas});
    }

    /*grafica(){

        var charts=[];

        var labels= this.state.headers;
        var result= this.state.content;

        var LineChart = require("react-chartjs").Line;

        //adapto los datos
        for(var i =0; i<result.length; i++){
            var total=[];

            if(result[i][0].length == 1){
                //Query sencilla
                for(var j=0; j<result[i].length; j++){
                    total.push(result[i][j][0][0]);
                }

                //Creo el chart ----- Query sencillo
                var data = {
                    labels: this.state.headers,
                    datasets: [
                        {
                            label: this.state.rownames[i],
                            fillColor: "rgba(220,220,220,0.2)",
                            strokeColor: "rgba(220,220,220,1)",
                            pointColor: "rgba(220,220,220,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: total
                        }
                    ]
                };

                charts.push(
                    <div className="col-md-6">
                    <h2>{this.state.rownames[i]}</h2>
                    <LineChart name="chartjs" data={data} options={{scales: {
                        xAxes: [{
                            type: 'linear',
                            position: 'bottom',
                            responsive: true,
                        }]
                    }}} height="300" width="450" />
                        </div>
                );

            }else{
                //Query compleja
                for(var k=0; k<result[i][0].length; k++){
                    var subdata = [];
                    for(var j=0; j<result[i].length; j++){
                        subdata.push(result[i][j][k][1]);
                    }
                    total.push(subdata);
                }

                //Creo el chart
                var sets = [];
                for(var x=0; x<total.length; x++){
                    //creo el array de datasets
                    sets.push(
                        {
                            label:result[i][0][x][0],
                            fillColor: "rgba(220,220,220,0.2)",
                            strokeColor: "rgba(220,220,220,1)",
                            pointColor: "rgba(220,220,220,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: total[x]
                        }
                    );
                }

                var data = {
                    labels: this.state.headers,
                    datasets: sets
                };

                charts.push(
                    <div className="col-md-6">
                        <h2>{this.state.rownames[i]}</h2>
                    <LineChart name="chartjs" data={data} options={{scales: {
                        xAxes: [{
                            type: 'linear',
                            position: 'bottom',
                            responsive: true,
                            multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>"
                        }]
                    }}} height="300" width="450" />
                    </div>
                );
            }

        }

        this.setState({graficas: charts});
    }*/

    highcharts(){

        var charts=[];

        var labels= this.state.headers;
        var result= this.state.content;

        //adapto los datos
        for(var i =0; i<result.length; i++){
            var total=[];

            if(result[i][0].length == 1){
                //Query sencilla
                for(var j=0; j<result[i].length; j++){
                    total.push(parseFloat(parseFloat(result[i][j][0][0]).toFixed(2)));
                }

                //Creo el chart ----- Query sencillo
                var config = {
                    title: {
                        text: this.state.rownames[i],
                    },
                    xAxis: {
                        categories: labels
                    },
                    yAxis: {
                        title: {
                            text: 'Total'
                        }
                    },
                    series: [{
                        name: this.state.rownames[i],
                        data: total
                    }],
                    tooltip: {
                        enabled: false
                    },
                    plotOptions: {
                        line:{
                            dataLabels:{
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    }
                };

                charts.push(
                    <div className="col-md-6">
                        <ReactHighcharts name="chart" config = {config}/>
                    </div>
                );

            }else{
                //Query compleja
                for(var k=0; k<result[i][0].length; k++){
                    var subdata = [];
                    for(var j=0; j<result[i].length; j++){
                        //subdata.push(result[i][j][k][1]);
                        subdata.push(parseFloat(parseFloat(result[i][j][k][1]).toFixed(2)))
                    }
                    total.push(subdata);
                }

                //Creo el chart
                var sets = [];
                for(var x=0; x<total.length; x++){
                    //creo el array de datasets
                    sets.push(
                        {
                        name: result[i][0][x][0],
                        data: total[x]
                        }
                    );
                }

                console.log(sets);

                var config = {
                    title: {
                        text: this.state.rownames[i],
                    },
                    xAxis: {
                        categories: labels
                    },
                    yAxis: {
                        title: {
                            text: 'Total'
                        }
                    },
                    series: sets,
                    tooltip: {
                        enabled: false
                    },
                    plotOptions: {
                        line:{
                            dataLabels:{
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    }
                };

                charts.push(
                    <div className="col-md-6">
                        <ReactHighcharts name="chart" config = {config}/>
                    </div>
                    
                );
            }

        }

        this.setState({graficas: charts});
    }

    downloadPDF(){
        var token = $('meta[name="csrf-token"]').attr('content');

        var tables = null;

        if(this.state.tipo==1){
            tables = $("#reporteDia").html();
        }else if (this.state.tipo==2){
            tables = $("#reporteSemana").html();
        }else if (this.state.tipo==3){
            tables = $("#reporteMes").html();
        }

        /*var table = [];

        $( "#reporteDia .responstable" ).each(function( index ) {
            table.push($( this ).parent().html() );
        });*/

        var charts=[];
        //var charts = document.querySelectorAll(".highcharts-container > svg");

        $( ".highcharts-container" ).each(function( index ) {
            charts.push($( this ).html() );
        });

        $.ajax({
            type: 'POST',
            url: 'createpdf',
            context: this,
            dataType: 'json',
            cache: false,
            data: {
                id: this.state.reporteId,
                fecha_inicial: this.state.fecha_inicial,
                fecha_final: this.state.fecha_final,
                tables: tables,
                graphs: charts,
                _token: token
            },
            success: function (response, status, xhr) {
                //Obtener las opciones de la consulta
                console.log('generoPDF')
                this.downloadme();
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    svgTobase(){
        var charts = document.querySelectorAll(".highcharts-container > svg");
        console.log(charts);
    }

    createPDF(){

        var token = $('meta[name="csrf-token"]').attr('content');

        //Recupero las graficas, las transformo en DataURL y las guardo en un array
        var canvas = document.getElementsByName('chartjs');
        var pdfgraficas = [];
        for(var i = 0; i<canvas.length; i++){
            pdfgraficas.push(canvas[i].toDataURL());
        }

        var tables = null;

        if(this.state.tipo==1){
            tables = $("#reporteDia").html();
        }else if (this.state.tipo==2){
            tables = $("#reporteSemana").html();
        }else if (this.state.tipo==3){
            tables = $("#reporteMes").html();
        }

        //Mando los datos al controlador
        $.ajax({
            type: 'POST',
            url: 'createpdf',
            context: this,
            dataType: 'json',
            cache: false,
            data: {
                id: this.state.reporteId,
                tables: tables,
                graphs: pdfgraficas,
                _token: token
            },
            success: function (response, status, xhr) {
                //Obtener las opciones de la consulta
                console.log('generoPDF')
                this.downloadme();
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });

        
    }

    downloadme(){
        window.open(
            'public/temp/reporte.pdf',
            '_blank' // <- This is what makes it open in a new window.
        );
    }

    disableFutureDays(date) {
        var today = new Date();
        return date > today;
    }

    loading(){
        return(
            <div className="col-md-12 report-loader">
                <CircularProgress size={120} thickness={5}/>
            </div>
        );
    }

    getExcel(){
        //adapto los datos a mandar:
            //fechas:arreglo sencillo
            //total_report: arreglo con 2 propiedades:
                //name(nombre de la consulta) y values(resultado o  arrelo con parametro y valor)
            //content_report: desglose

        var dates = this.state.headers;
        var headers = this.state.rownames;
        var total_row = this.state.totalrow;
        var content = this.state.content;
        var total_report = [];
        var content_report = [];

        //Totales
        for(var i =0; i<total_row.length; i++ ){
            if(total_row[i].length < 2){
                //Sencillo
                var total_v = {name: headers[i], values: total_row[i][0][0]};
                total_report.push(total_v);
            }else{
                var total_v = {name: headers[i], values:total_row[i]};
                total_report.push(total_v);
            }
        }

        //Desglose
        for(var j = 0; j < content.length; j++){
            if(content[j][0].length < 2){
                //Sencillo
                var values = [];
                for(var k = 0; k < content[j].length; k++){
                    values.push(content[j][k][0][0]);
                }
                var content_v = {name: headers[j], values: values};
                content_report.push(content_v);
            }else{
                //Complejo
                var values=[];
                for(var c=0; c <content[j].length; c++){
                    values.push(content[j][c]);
                }
                var content_v = {name: headers[j], values: values};
                content_report.push(content_v);
            }
        }

        var token = $('meta[name="csrf-token"]').attr('content');
        
        $.ajax({
            type: 'POST',
            url: 'excel',
            context: this,
            dataType: 'json',
            cache: false,
            data:{
                id: this.state.reporteId,
                dates: dates,
                total_report: total_report,
                content_report: content_report,
                _token: token
            },
            success: function (data) {
                console.log("excel creado");
                this.setState({
                    reporteXls: data[0],
                }, function () {
                    this.downloadExc();
                });
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(err.responseText);
            }.bind(this)
        });

    }

    downloadExc(){
        var archivo = this.state.reporteXls;
        window.open(
            'storage/exports/'+ archivo + '.xls',
            '_blank' // <- This is what makes it open in a new window.
        );
    }

    render() {
        var reporte = [];
        var total =[];
        var graficas1=[];
        var graficas2=[];
        var graficas3=[];

        if(this.state.running == true){
            var loader = this.loading();
        }else{
            var loader = [];
        }

        //var loader = this.loading();

        if(this.state.runbool == true){
            reporte = [
                <h2>Desglose</h2>,
                <div className="col-md-12">
                    {this.state.desglose}
                </div>
            ];

            total = [
                <h2>Total</h2>,
                <div className="col-md-12">
                    {this.state.totales}
                </div>
            ];
        }

        if(this.state.tipo == 1 && this.state.runbool == true){
            graficas1=[
                <h2>Gráficas</h2>,
                <div>
                    <div className="col-md-12">
                        {this.state.graficas}
                    </div>
                    <div className="downloads col-md-12" style={{textAlign: 'right'}}>
                        <FlatButton
                            label="Descargar PDF"
                            primary={true}
                            keyboardFocused={true}
                            onTouchTap={this.downloadPDF.bind(this)}
                        />
                        <FlatButton
                            label="Descargar Excel"
                            primary={true}
                            keyboardFocused={true}
                            onTouchTap={this.getExcel.bind(this)}
                        />
                    </div>
                </div>
            ];
        } else if(this.state.tipo == 2 && this.state.runbool == true){
            graficas2=[
                <h2>Gráficas</h2>,
                <div>
                    <div className="col-md-12">
                        {this.state.graficas}
                    </div>
                    <div className="downloads col-md-12" style={{textAlign: 'right'}}>
                        <FlatButton
                            label="Descargar PDF"
                            primary={true}
                            keyboardFocused={true}
                            onTouchTap={this.downloadPDF.bind(this)}
                        />
                        <FlatButton
                            label="Descargar Excel"
                            primary={true}
                            keyboardFocused={true}
                            onTouchTap={this.getExcel.bind(this)}
                        />
                    </div>
                </div>
            ];
        } else if(this.state.tipo == 3 && this.state.runbool == true){
            graficas3=[
                <h2>Gráficas</h2>,
                <div>
                    <div className="col-md-12">
                        {this.state.graficas}
                    </div>
                    <div className="downloads col-md-12" style={{textAlign: 'right'}}>
                        <FlatButton
                            label="Descargar PDF"
                            primary={true}
                            keyboardFocused={true}
                            onTouchTap={this.downloadPDF.bind(this)}
                        />
                        <FlatButton
                            label="Descargar Excel"
                            primary={true}
                            keyboardFocused={true}
                            onTouchTap={this.getExcel.bind(this)}
                        />
                    </div>
                </div>
            ];
        }



        return(
            <div id="content">
                <section className="has-actions no-bottom">
                    <div className="section-body">
                        <div className="row">
                            <div className="col-md-6">
                                <DatePicker
                                    className = "input-formMUI"
                                    hintText="Fecha inicial"
                                    floatingLabelText="Fecha inicial"
                                    autoOk={true}
                                    value={this.state.fecha_inicial}
                                    DateTimeFormat={this.state.formato_fecha}
                                    shouldDisableDate={this.disableFutureDays}
                                    fullWidth={true}
                                    formatDate={new IntlPolyfill.DateTimeFormat (this.state.formato_fecha, {
                                            day: 'numeric',
                                            month: 'numeric',
                                            year: 'numeric'
                                         }).format}
                                    onChange={this.handleChangeFecha_inicial.bind(this)}
                                />
                            </div>
                            <div className="col-md-6">
                                <DatePicker
                                    className = "input-formMUI"
                                    hintText="Fecha final"
                                    floatingLabelText="Fecha final"
                                    autoOk={true}
                                    value={this.state.fecha_final}
                                    DateTimeFormat={this.state.formato_fecha}
                                    shouldDisableDate={this.disableFutureDays}
                                    fullWidth={true}
                                    formatDate={new IntlPolyfill.DateTimeFormat (this.state.formato_fecha, {
                                            day: 'numeric',
                                            month: 'numeric',
                                            year: 'numeric'
                                         }).format}
                                    onChange={this.handleChangeFecha_final.bind(this)}
                                />
                            </div>
                        </div>
                        <div className="row">
                            <Tabs className="reporte-tabs">
                                <Tab label="Día" onActive={this.handleActiveDia.bind(this)}>
                                    <div className="all-report">
                                        <div id="reporteDia">
                                            {loader}
                                            <div className="row">
                                                {total}
                                            </div>
                                            <div className="row">
                                                {reporte}
                                            </div>
                                        </div>
                                        <div className="row">
                                            {graficas1}
                                        </div>
                                    </div>
                                </Tab>
                                <Tab label="Semana" onActive={this.handleActiveSemana.bind(this)} value='3'>
                                    <div className="all-report">
                                        <div id="reporteSemana">
                                            {loader}
                                            <div className="row">
                                                {total}
                                            </div>
                                            <div className="row">
                                                {reporte}
                                            </div>
                                        </div>
                                        <div className="row">
                                            {graficas2}
                                        </div>
                                    </div>
                                </Tab>
                                <Tab label="Mes" onActive={this.handleActiveMes.bind(this)}>
                                    <div className="all-report">
                                        <div id="reporteMes">
                                            {loader}
                                            <div className="row">
                                                {total}
                                            </div>
                                            <div className="row">
                                                {reporte}
                                            </div>
                                        </div>
                                        <div className="row">
                                            {graficas3}
                                        </div>
                                    </div>
                                </Tab>
                            </Tabs>
                        </div>
                    </div>
                </section>
            </div>
        );
    }
}