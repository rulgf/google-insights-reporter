//Defaults
import   React from 'react';
import  SideMenubar from '../Componentes/menubar';
import  Header from '../Componentes/header';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

import $ from 'jquery';

import TextField from 'material-ui/TextField';
import IntlPolyfill from 'intl';
import DatePicker from 'material-ui/DatePicker';
import {SimpleSelect, MultiSelect, ReactSelectize} from 'react-selectize';
import Checkbox from 'material-ui/Checkbox';
import ReactDataGrid from 'react-data-grid';
import RaisedButton from 'material-ui/RaisedButton';
import Snackbar from 'material-ui/Snackbar';
import CircularProgress from 'material-ui/CircularProgress';


//Armo la vista
export default class QueryExplorer extends  React.Component{

    constructor(props) {
        super(props);

        //Traducción de idioma para datepicker
        require ('intl/locale-data/jsonp/es');

        //Multiselects
        this.cargarMetricas = this.cargarMetricas.bind(this);
        this.cargarDimensiones = this.cargarDimensiones.bind(this);
        this.cargarSegmentos = this.cargarSegmentos.bind(this);
        
        this.sinResultados = this.sinResultados.bind(this);

        var currency = [
            {value: 1, label: "USD"},
            {value: 2, label: "MXN"}
        ];

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
        }

        //Estados de la vista
        this.state = {
            //Multiselects
            metricas : [],
            dimensiones : [],
            sort : [],
            segmentos : [],

            //valores seleccionados de los multiselect
            selectedMetricas:[],
            selectedDimensions:[],
            selectedSort:[],
            selectedSegment:"",
            finalMet:[],
            finalDim:[],

            //DatePickers
            formato_fecha : IntlPolyfill.DateTimeFormat,
            fecha_inicial: null,
            fecha_final: null,

            //otros parametros
            filters: "",
            maxresults: null,
            currencybool: false,
            currencyMaster: currency,
            currencyfrom: currency,
            currencyto: currency,
            selectedCurrencyF:"",
            selectedCurrencyT:"",

            //headers
            dimHead:[],
            metHead:[],
            selectedHeaders:[],

            //runquery
            runbool: false,
            rows:[],
            columns: [],

            //otros
            errors: "",
            erroropen: false,

            //cuenta
            selectedCuenta: this.props.activeCount,
            selectedCuentaObj: cuenta,
            selectedCuentaLbl: label,

            //loader
            executing: false
        };

        //Cargar datos multiselect
        this.cargarSegmentos();
    }

    componentDidMount(){

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
        }

        this.cargarMetricas();
        this.cargarDimensiones();
    }

    componentWillReceiveProps(nextProps) {
        // You don't have to do this check first, but it can help prevent an unneeded render
        if (nextProps.activeCount !== this.state.selectedCuenta && nextProps.activeCount != null) {
            this.setState({
                selectedCuenta: nextProps.activeCount,
                selectedCuentaObj: nextProps.activeCount,
                selectedCuentaLbl: nextProps.activeCount.label,
            }, function () {
                this.cargarMetricas();
                this.cargarDimensiones();
            });
        }
    }

    //Handlers--------------------------------------

        //Handlers Fechas
    handleChangeFecha_inicial(event, date) {
        this.setState({fecha_inicial: date});


        if (this.state.fecha_final != null) {
            if (this.state.fecha_inicial >= this.state.fecha_final) {
                this.setState({
                    fecha_final: this.state.fecha_inicial
                });
            }
        }
    }


    handleChangeFecha_final(event, date) {
        this.setState({fecha_final: date});

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

        //Otros Handlers
    handleMultiDimensiones(e){

        var arr = [];
        var final =[];
        var head = [];
        for(var i = 0; i < e.length; i++) {
            arr.push({value: e[i].value, label: e[i].label, name: e[i].name, type: e[i].tipo.nombre});
            head.push(e[i].name);
            final.push(e[i].label);
        }
        this.setState({dimHead: head}, function () {
            this.cargarHeads();
        });

        this.setState({selectedDimensions: arr}, function(){
            this.cargarSort();
        });

        this.setState({finalDim: final});
    }

    handleMultiMetricas(e){
        var arr = [];
        var final = [];
        var head =[];
        for(var i = 0; i < e.length; i++) {
            arr.push({value: e[i].value, label: e[i].label, name: e[i].name, type: e[i].tipo.nombre});
            head.push(e[i].name);
            final.push(e[i].label);
        }

        this.setState({metHead: head}, function () {
            this.cargarHeads();
        });

        this.setState({selectedMetricas: arr}, function () {
            this.cargarSort();
        });

        this.setState({finalMet: final});
    }

    handleMultiSort(e){
        var arr = [];
        for(var i = 0; i < e.length; i++) {
            arr.push(e[i].label);
        }
        this.setState({selectedSort: arr});
    }

    handleSegmentos(e){
        if(e){
            this.setState({selectedSegment: e.label});
        }else{
            this.setState({selectedSegment: null});
        }

    }

    handleFilters(e){
        this.setState({filters: e.target.value});
    }

    handleMaxResults(e){
        this.setState({maxresults: e.target.value});
    }

    handleCurrencyBool(){
        if(this.state.currencybool== false){
            this.setState({currencybool: true});
            this.cargarCurrencyFrom();
            this.cargarCurrencyTo();
        } else {
            this.setState({currencybool: false});
        }

    }

    handleCurrencyfrom(e){
        if(e){
            this.setState({selectedCurrencyF: e.label}, function () {
                this.loadCurrencyT(e.value);
            })
        }else{
            this.setState({selectedCurrencyF: ""}, function () {
                this.cargarCurrencyTo();
            })
        }
    }

    handleCurrencyTo(e){
        if(e){
            this.setState({selectedCurrencyT: e.label}, function (){
                this.loadCurrencyF(e.value);
            })
        }else{
            this.setState({selectedCurrencyT: ""}, function (){
                this.cargarCurrencyFrom();
            })
        }

    }

    handleCloseError(){
        this.setState({erroropen: false});
    }

    loadCurrencyT(idx){
        var currT = this.state.currencyMaster;
        var final = [];
        for(var i =0; i < currT.length; i++){
            if(currT[i].value != idx){
                final.push({value: currT[i].value, label: currT[i].label});
            }
        }
        this.setState({currencyto: final});
    }

    loadCurrencyF(idx){
        var currF = this.state.currencyMaster;
        var final = [];
        for(var i =0; i < currF.length; i++){
            if(currF[i].value != idx){
                final.push({value: currF[i].value, label: currF[i].label});
            }
        }
        this.setState({currencyfrom: final});
    }

    //Cargo Metricas ---------------------------------------
    cargarMetricas() {
        $.ajax({
            type: 'GET',
            url: 'metricas/' + this.state.selectedCuentaLbl,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {

                //Obtener las opciones de la consulta
                this.setState({metricas: data});

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Cargo Dimensiones
    cargarDimensiones() {
        $.ajax({
            type: 'GET',
            url: 'dimensiones/'+ this.state.selectedCuentaLbl,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {

                //Obtener las opciones de la consulta
                this.setState({dimensiones: data});

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Cargo Segmentos
    cargarSegmentos(){
        $.ajax({
            type: 'GET',
            url: 'segmentos',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {

                //Obtener las opciones de la consulta
                this.setState({segmentos: data});

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Metodo que carga las opciones del sort en base a las opciones de Metricas y Dimensiones
    cargarSort(){
        //Variables para agregar opciones
        var oDesc = "-";
        var asc = " (ascending)";
        var dsc = " (descending)";

        //Se carga el sort en base a las metricas y dimensiones seleccionadas
        var metDim = this.state.selectedMetricas.concat(this.state.selectedDimensions);
        var sortMD =[];
        if(metDim.length > 0){
            var val =0;
            for(var i = 0; i < metDim.length; i++){
                sortMD.push({value: val, label: oDesc.concat(metDim[i].label), name: metDim[i].name.concat(dsc), type: metDim[i].type});
                val++;
                sortMD.push({value: val, label:metDim[i].label, name: metDim[i].name.concat(asc), type: metDim[i].type});
                val++;
            }
        }
        this.setState({sort: [] });
        this.setState({sort: sortMD});
    }

    cargarHeads(){
        var heads = this.state.dimHead.concat(this.state.metHead);
        this.setState({selectedHeaders: heads});
    }

    cargarCurrencyFrom(){
        var currency = this.state.currencyMaster;

        this.setState({currencyfrom: currency});
    }

    cargarCurrencyTo(){
        var currency = this.state.currencyMaster;

        this.setState({currencyto: currency});
    }

    //Metodo que se activa cuando no hay resultados
    sinResultados(){
        return React.createElement("div", {className: "no-results-found"},
            !!self.req ? "Cargando ..." : "No se encontraron resultados"
        )
    }

    sinSort(){
        return React.createElement("div", {className: "no-results-found"},
            !!self.req ? "Cargando ..." : "Selecciona metricas y/o dimensiones"
        )
    }
    
    queryExplorerForm(){
        return(
            <div>
                <TextField
                    hintText="Nombre del proyecto"
                    floatingLabelText="Nombre"
                    type="text"
                    fullWidth={true}
                />
            </div>
        );
    }
    
    //Rendereo el cada objeto del multiselect
    customOption(item){
        return <div className="simple-option">
            <div className="col-md-12 topOption">
                <div className="col-md-7 customname" style={{fontSize: "80%"}}>
                    {item.name}
                </div>
                <div className="col-md-5 customtipo" style={{fontSize: "70%", textAlign: "rigth"}}>
                    {item.tipo.nombre}
                </div>
            </div>

            <div className="col-md-12 bottomOption">
                <div className="col-md-9 customlabel" style={{fontSize: "60%"}}>
                    {item.label}
                </div>
            </div>
        </div>
    }

    customOptionSort(item){
        return <div className="simple-option">
            <div className="col-md-12 topOption">
                <div className="col-md-7 customname" style={{fontSize: "80%"}}>
                    {item.name}
                </div>
                <div className="col-md-5 customtipo" style={{fontSize: "70%", textAlign: "rigth"}}>
                    {item.type}
                </div>
            </div>

            <div className="col-md-12 bottomOption">
                <div className="col-md-9 customlabel" style={{fontSize: "60%"}}>
                    {item.label}
                </div>
            </div>
        </div>
    }

    customOptionSegmento(item){
        return <div className="simple-option">
            <div className="col-md-12 topOption">
                <div className=" col-md-9 customname" style={{fontSize: "80%"}}>
                    {item.name}
                </div>
            </div>

            <div className="col-md-12 bottomOption">
                <div className=" col-md-9 customlabel" style={{fontSize: "60%"}}>
                    {item.label}
                </div>
            </div>
        </div>
    }

    //Rendereo los objetos seleccionados del multiselect
    customValue(item){
        return <div>
            <span>item.label
            </span>
            <span onClick = {function(){
                        self.setState({
                            selectedMetricas: this.reject(self.state.selectedMetricas, function(selected){
                                return selected.value == item.value;
                            r})
                        });
                    }}>x</span>
        </div>
    }

    //RUN QUERY ------------------------------------------------------------------------

    runQuery(){
        this.setState({
            executing: true,
        }, function () {
            $.ajax({
                type: 'GET',
                url: 'query',
                dataType: 'json',
                context: this,
                data:{
                    startDate: this.state.fecha_inicial,
                    endDate: this.state.fecha_final,
                    metrics: this.state.finalMet,
                    dimensions: this.state.finalDim,
                    sort: this.state.selectedSort,
                    filters: this.state.filters,
                    segment: this.state.selectedSegment,
                    changeCurrency: this.state.currencybool,
                    currencyFrom: this.state.selectedCurrencyF,
                    currencyTo: this.state.selectedCurrencyT,
                    maxResult: this.state.maxresults,
                    siteId: this.state.selectedCuentaLbl,
                },
                success: function (data) {
                    this.setState({executing: false});
                    if(data.errors){
                        //Si hubo error guardarlos
                        var index = data.errors.indexOf(false);
                        if (index > -1) {
                            data.errors.splice(index, 1)
                        }
                        this.setState({errors: data.errors});
                        this.setState({erroropen: true});
                    }else{
                        //Guardo el resultado del query
                        this.setState({finalquery: data},function () {
                            this.cargarTabla();
                        });
                        this.setState({runbool: false},function () {
                            this.setState({runbool: true});
                        });
                    }


                }.bind(this),
                error: function (xhr, status, err) {
                    //Error
                    console.log(this.props.url, status, err.toString());
                }.bind(this)
            });
        });
    }

    cargarTabla(){
        //Armo las columnas y los renglones para la tabla
        var columns=[];
        for(var i = 0; i< this.state.selectedHeaders.length; i++){
            columns.push({key: i, name: this.state.selectedHeaders[i]});
        }

        var rows=[];

        for(var i= 0; i<this.state.finalquery.length; i++){
            var innerRow={};
            for(var z= 0; z<this.state.finalquery[i].length; z++){
                innerRow[z]= this.state.finalquery[i][z];
            }
            rows.push(innerRow);
        }

        this.setState({columns: columns});
        this.setState({rows: rows});
    }

    tableRender(){
        var _rows = this.state.rows;

        var rowGetter = function(i){
            return _rows[i];
        };

        var columns = this.state.columns;

        var height= 500;

        if(this.state.rows.length < 10){
            if(this.state.rows.length < 2){
                height= this.state.rows.length * 72;
            }else{
                height= (this.state.rows.length * 35) + 35;
            }

        }

        return(
            <div>
                <ReactDataGrid
                    columns={columns}
                    rowGetter={rowGetter}
                    rowsCount={_rows.length}
                    minHeight={height}
                />
            </div>
        );
    }

    disableFutureDays(date) {
        var today = new Date();
        return date > today;
    }

    loading(){
        return(
                <CircularProgress />
        );
    }


    render() {
        //Rendereo Currency selcts si el checkbox esta activo
        if(this.state.currencybool == true){
            var currencyF=(
                <div className="col-md-3">
                    <SimpleSelect
                        placeholder = "De:"
                        className = "input-formMUI"
                        theme = "material"
                        options = {this.state.currencyfrom}
                        style = {{ width: '100%'}}
                        renderNoResultsFound = {this.sinResultados}
                        onValueChange={this.handleCurrencyfrom.bind(this)}
                    />
                </div>
            );

            var currencyT=(
                <div className="col-md-3">
                    <SimpleSelect
                        className = "input-formMUI"
                        placeholder = "A:"
                        theme = "material"
                        options = {this.state.currencyto}
                        style = {{ width: '100%'}}
                        renderNoResultsFound = {this.sinResultados}
                        onValueChange={this.handleCurrencyTo.bind(this)}
                    />
                </div>
            );
        }

        //Rendereo el query sí se ejecuto correctamente
        if(this.state.runbool == true){
            var queryResult = this.tableRender();
        }

        if(this.state.executing == true){
            var loader = this.loading();
        }else{
            var loader = [];
        }

        return(
            <div id="content">
                <section className="has-actions no-bottom">
                    <div className="section-body">
                        <div className="row">
                            <h2>Query Explorer</h2>
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
                            <div className="col-md-6">
                                <MultiSelect
                                    className = "hola"
                                    placeholder = "Métricas"
                                    theme = "material"
                                    options = {this.state.metricas}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinResultados}
                                    renderOption = {this.customOption.bind(this)}
                                    onValuesChange = {this.handleMultiMetricas.bind(this)}
                                />
                            </div>
                            <div className="col-md-6">
                                <MultiSelect
                                    className = "input-formMUI"
                                    placeholder = "Dimensiones"
                                    theme = "material"
                                    options = {this.state.dimensiones}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinResultados}
                                    renderOption = {this.customOption.bind(this)}
                                    onValuesChange={this.handleMultiDimensiones.bind(this)}
                                />
                            </div>
                            <div className="col-md-6">
                                <MultiSelect
                                    className = "input-formMUI"
                                    placeholder = "Sort"
                                    theme = "material"
                                    options = {this.state.sort}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinSort}
                                    onValuesChange={this.handleMultiSort.bind(this)}
                                    renderOption={this.customOptionSort.bind(this)}
                                />
                            </div>
                            <div className="col-md-6">
                                <SimpleSelect
                                    className = "input-formMUI"
                                    placeholder = "Segments"
                                    theme = "material"
                                    options = {this.state.segmentos}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinResultados}
                                    renderOption = {this.customOptionSegmento.bind(this)}
                                    onValueChange={this.handleSegmentos.bind(this)}
                                />
                            </div>
                            <div className="col-md-6">
                                <TextField
                                    hintText="Filters"
                                    floatingLabelText="Filters"
                                    type="text"
                                    fullWidth={true}
                                    onChange={this.handleFilters.bind(this)}
                                />
                            </div>
                            <div className="col-md-6">
                                <TextField
                                    hintText="Max Results"
                                    floatingLabelText="Max Results"
                                    type="number"
                                    fullWidth={true}
                                    onChange={this.handleMaxResults.bind(this)}
                                />
                            </div>
                            <div className="col-md-6">
                                <Checkbox
                                    label="Cambiar Moneda"
                                    checked={this.state.currencybool}
                                    onCheck={this.handleCurrencyBool.bind(this)}
                                />
                            </div>
                            {currencyF}
                            {currencyT}

                            <div className="col-md-12">
                                <RaisedButton
                                    label="Run Query"
                                    style={{margin: "12"}}
                                    onTouchTap={this.runQuery.bind(this)}
                                />
                                {loader}
                            </div>
                            <div className="col-md-12 queryTable">
                                {queryResult}
                            </div>
                        </div>
                        <Snackbar
                            open={this.state.erroropen}
                            message={this.state.errors[0]}
                            autoHideDuration={4000}
                            onRequestClose={this.handleCloseError.bind(this)}
                        />
                    </div>
                </section>
            </div>
        );
    }
}