/**
 * Created by SOFTAM03 on 1/30/17.
 */
import   React from 'react';

import FlatButton from 'material-ui/FlatButton';
import { BootstrapTable, TableHeaderColumn } from 'react-bootstrap-table';
import DatePicker from 'material-ui/DatePicker';
import ReactHighcharts from 'react-highcharts';
import CircularProgress from 'material-ui/CircularProgress';
import Snackbar from 'material-ui/Snackbar';

import $ from 'jquery';
import IntlPolyfill from 'intl';

export default class palabras extends  React.Component{

    constructor(props) {
        super(props);

        //Traducción de idioma para datepicker
        require ('intl/locale-data/jsonp/es');

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
        }

        this.state = {
            //Metricas
            all_palabras: [],

            //Charts and Tables
            table_all: [],
            top_palabras: [],
            top_impresiones: [],
            top_clicks: [],
            top_cpc: [],
            last_palabras: [],
            last_impresiones: [],
            last_clicks: [],
            last_cpc: [],

            //Fechas
            formato_fecha : IntlPolyfill.DateTimeFormat,
            fecha_inicial: null,
            fecha_final: null,

            //Errores
            errors: [],
            erroropen:false,

            //success
            success:false,

            //executing
            running: false,

            //cuenta
            selectedCuenta: this.props.activeCount,
            selectedCuentaObj: cuenta,
            selectedCuentaLbl: label,
        };

    }

    componentDidMount() {
        var label = "";
        var cuenta = null;

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
            this.setState({
                selectedCuentaLbl :  label
            }, function () {
                //console.log(this.state.selectedCuentaLbl);
            });
        }
    }

    componentWillReceiveProps(nextProps) {
        // You don't have to do this check first, but it can help prevent an unneeded render
        if (nextProps.activeCount !== this.state.selectedCuenta && nextProps.activeCount != null) {
            this.setState({
                selectedCuenta: nextProps.activeCount,
                selectedCuentaObj: nextProps.activeCount,
                selectedCuentaLbl: nextProps.activeCount.label,
            }, function () {
                //console.log(this.state.selectedCuentaLbl);
            });
        }
    }

    //Handlers---------------

    //Handlers Fechas
    handleChangeFecha_inicial(event, date) {
        this.setState({fecha_inicial: date}, function () {
            if(this.state.fecha_final && this.state.fecha_final){

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

    disableFutureDays(date) {
        var today = new Date();
        return date > today;
    }

    handleConsulta(event){
        this.setState({running: true}, function () {
            if(this.state.selectedCuentaLbl != null
                && this.state.fecha_inicial != null && this.state.fecha_final != null){
                this.loadPalabras();
                this.topPalabras();
                this.lastPalabras();
            }else{
                this.setState({errors: ["No se puede realizar la consulta"], erroropen: true}, function () {
                    this.setState({running: false});
                });
            }
        });
    }

    handleCloseError(){
        this.setState({erroropen: false});
    }

    //Metodo para cargar todas las palabras !!!
    loadPalabras(){
        $.ajax({
            type: 'GET',
            url: 'palabras/'+this.state.selectedCuentaLbl,
            context: this,
            dataType: 'json',
            cache: false,
            data: {
                fecha_inicial: this.state.fecha_inicial,
                fecha_final: this.state.fecha_final,
            },
            success: function (data) {
                //Guardo los datos y cambio estados de la modal y de la accion
                if(data.errors){
                    //Si hay errores guardarlos
                    this.setState({errors: data.errors, erroropen: true}, function () {
                        this.setState({running: false});
                    });
                }else{
                    //Si fue exitoso guardar resetear los estados y cerrar modal
                    var all = [];
                    var i = 0;
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            all.push({
                                id: i,
                                palabra: data[key].palabra,
                                impresiones: data[key].impresiones,
                                clicks: data[key].clicks,
                                avg: parseFloat(data[key].avg).toFixed(3),
                                costo: parseFloat(data[key].costo).toFixed(3)
                            });
                            i++;
                        }
                    }
                    this.setState({all_palabras: all}, function () {
                        this.setState({success: true, running: false});
                    });
                }
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Metodo para cargar las 10 primeras
    topPalabras(){
        $.ajax({
            type: 'GET',
            url: 'topten/'+this.state.selectedCuentaLbl,
            context: this,
            dataType: 'json',
            cache: false,
            data: {
                fecha_inicial: this.state.fecha_inicial,
                fecha_final: this.state.fecha_final,
            },
            success: function (data) {
                //Guardo los datos y cambio estados de la modal y de la accion
                if(data.errors){
                    //Si hay errores guardarlos
                    this.setState({errors: data.errors, erroropen: true}, function () {
                        this.setState({running: false});
                    });
                }else{
                    //Si fue exitoso guardar en estado
                    var palabras = [];
                    var impresiones = [];
                    var clicks = [];
                    var cpc = [];
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            palabras.push(data[key].palabra);
                            impresiones.push(data[key].impresiones);
                            clicks.push(data[key].clicks);
                            cpc.push(data[key].avg);
                        }
                    }
                    this.setState({
                        top_palabras: palabras,
                        top_impresiones: impresiones,
                        top_clicks: clicks,
                        top_cpc: cpc,
                    }, function () {
                        this.setState({success: true});
                    });
                }

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }
    //Metodo para cargar las 10 menos populares
    lastPalabras(){
        $.ajax({
            type: 'GET',
            url: 'worstten/'+this.state.selectedCuentaLbl,
            context: this,
            dataType: 'json',
            cache: false,
            data: {
                fecha_inicial: this.state.fecha_inicial,
                fecha_final: this.state.fecha_final,
            },
            success: function (data) {
                //Guardo los datos y cambio estados de la modal y de la accion
                if(data.errors){
                    //Si hay errores guardarlos
                    this.setState({errors: data.errors, erroropen: true}, function () {
                        this.setState({running: false});
                    });
                }else {
                    //Si fue exitoso guardar resetear los estados y cerrar modal
                    var palabras = [];
                    var impresiones = [];
                    var clicks = [];
                    var cpc = [];
                    for (var key in data) {
                        if (data.hasOwnProperty(key)) {
                            palabras.push(data[key].palabra);
                            impresiones.push(data[key].impresiones);
                            clicks.push(data[key].clicks);
                            cpc.push(data[key].avg);
                        }
                    }
                    this.setState({
                        last_palabras: palabras,
                        last_impresiones: impresiones,
                        last_clicks: clicks,
                        last_cpc: cpc,
                    }, function () {
                        this.setState({success: true});
                    });
                }

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    loading(){
        return(
            <div className="col-md-12 report-loader">
                <CircularProgress size={120} thickness={5}/>
            </div>
        );
    }
    
    
    render() {

        var table_all=[];
        var graph_top=[];
        var graph_last=[];

        if(this.state.success==true){
            table_all = [
                <BootstrapTable data={this.state.all_palabras}
                                pagination={true}
                                options={{ noDataText :"No hay palabras disponibles"}}
                                hover={true}
                                search={true}>
                    <TableHeaderColumn hidden = "true" dataField="id" isKey = {true}>n.º</TableHeaderColumn>
                    <TableHeaderColumn dataField = "palabra" dataSort = {true}>Palabra</TableHeaderColumn>
                    <TableHeaderColumn dataField = "impresiones" dataSort = {true}>Impresiones</TableHeaderColumn>
                    <TableHeaderColumn dataField = "clicks" dataSort = {true}>Clicks</TableHeaderColumn>
                    <TableHeaderColumn dataField = "avg" dataSort = {true}>Promedio CPC</TableHeaderColumn>
                    <TableHeaderColumn dataField = "costo" dataSort = {true}>Costo Total</TableHeaderColumn>
                </BootstrapTable>
            ];
            var config = {
                chart:{
                    type: 'column'
                },
                title: {
                    text: 'Top Palabras',
                },
                xAxis: {
                    categories: this.state.top_palabras
                },
                yAxis: {
                    title: {
                        text: 'Total'
                    }
                },
                series: [{
                    name: 'Impresiones',
                    data: this.state.top_impresiones
                },{
                    name: 'Clicks',
                    data: this.state.top_clicks
                }],
                tooltip: {
                    enabled: true
                },
                plotOptions: {
                    line:{
                        dataLabels:{
                            enabled: true
                        },
                        enableMouseTracking: true
                    }
                }
            };
            
            graph_top = [
                <ReactHighcharts name="chart" config = {config}/>
            ];

            var config_l = {
                chart:{
                    type: 'column'
                },
                title: {
                    text: 'Last Palabras',
                },
                xAxis: {
                    categories: this.state.last_palabras
                },
                yAxis: {
                    title: {
                        text: 'Total'
                    }
                },
                series: [{
                    name: 'Impresiones',
                    data: this.state.last_impresiones
                },{
                    name: 'Clicks',
                    data: this.state.last_clicks
                }],
                tooltip: {
                    enabled: true
                },
                plotOptions: {
                    line:{
                        dataLabels:{
                            enabled: true
                        },
                        enableMouseTracking: true
                    }
                }
            };

            graph_last = [
                <ReactHighcharts name="chart-l" config = {config_l}/>
            ];
        }

        if(this.state.running == true){
            var loader = this.loading();
        }else{
            var loader = [];
        }

        return(
            <div id="content">
                <section className="has-actions">
                    <div className="section-body">
                        <div className = "section-header col-md-12">
                            <div className="col-md-6">
                                <h2 className = "text-primary">Reporte Palabras</h2>
                            </div>
                            <div className="col-md-6" style={{textAlign: "right"}}>
                                <FlatButton
                                    label="Consultar Palabras"
                                    primary={true}
                                    onTouchTap={this.handleConsulta.bind(this)}
                                />
                            </div>
                        </div>
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
                        <div className="row" style={{paddingTop: '30px'}}>
                            {loader}
                        </div>
                        <div className="row">
                            <div className="col-md-6">
                                {graph_top}
                            </div>
                            <div className="col-md-6">
                                {graph_last}
                            </div>
                        </div>
                        <div className="row">
                            <div className="col-md-12">
                                {table_all}
                            </div>
                        </div>
                    </div>
                    <Snackbar
                        open={this.state.erroropen}
                        message={this.state.errors[0]}
                        autoHideDuration={4000}
                        onRequestClose={this.handleCloseError.bind(this)}
                    />
                </section>
            </div>
        );
    }
}