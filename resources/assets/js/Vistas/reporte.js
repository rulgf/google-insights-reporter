//Defaults
import   React from 'react';
import  SideMenubar from '../Componentes/menubar';
import  Header from '../Componentes/header';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

import  Componente_Footer from '../Componentes/footer';
import Dialog from 'material-ui/Dialog';
import FlatButton from 'material-ui/FlatButton';
import { BootstrapTable, TableHeaderColumn } from 'react-bootstrap-table';
import TextField from 'material-ui/TextField';
import Snackbar from 'material-ui/Snackbar';
import { Router, Route, Link } from 'react-router';
import {SimpleSelect, MultiSelect, ReactSelectize} from 'react-selectize';
import ReactDataGrid from 'react-data-grid';

import $ from 'jquery';


export default class Reporte extends  React.Component{

    constructor(props) {
        super(props);

        this.botonesRutas = this.botonesRutas.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
        this.handleOpenAgregar = this.handleOpenAgregar.bind(this);

        this.state = {
            //Queries
            queries: [],

            //Campos Reporte
            reporte_id: 0, // obtener con el nombre
            reporte_nombre: this.props.params.reporte,
            reporte_descripcion:"", //obtener con el nombre

            //Modal Consultar/Modificar/Eliminar
            openModal: false,
            action: null,

            //Campos Modal Query
            id: 0,
            tipo: 0,
            nombre: "",
            filters: "",
            operando_metrcias: 0,
            operando_total: 0,
            maxresults: null,
            selectedSort:[],

                //Columnas a ignorar
            columnasignore: [],
            columnasignore_id: 0,
            selectedColumnsignore: [],
            posicion:0,

                //Segmentos
            segmentos: [],
            segmento_id:0,
            segmento_nombre: "",
            segmento_clave: "",
            selectedSegment:[],

                //Dimensiones
            dimensiones: [],
            dimension_id: 0,
            selectedDimensions: [],

                //Metrica
            metricas: [],
            metrica_id: 0,
            selectedMetricas: [],

            //Headers
            dimHead:[],
            metHead:[],
            selectedHeaders:[],
            finalMet:[],
            finalDim:[],

            //Tabla
            datos: [],

            //Errores
            errors: [],
            erroropen:false,

            //success
            successopen:false,

            //cuenta
            selectedCuenta: this.props.params.siteId,
            selectedCuentaObj: {},
            selectedCuentaLbl: "",

            //Date
            actualDate: new Date(),
            headerDate: "",
            
            //inner Query
            finalquery: [],

            //runquery
            runbool: false,
            rows:[],
            columns: [],

            //
            newcolumns: [],
            newrows: [],
        };

    }

    componentDidMount() {
        this.cargarQueries(this.state.selectedCuenta);
        this.setState({selectedCuenta: this.props.params.siteId});
        this.cargarCuentaActiva();
        this.setState({selectedCuentaLbl: this.props.params.siteId}, function () {
            this.cargarMetricas();
            this.cargarDimensiones();
            this.cargarSegmentos();
        });
        var date= this.state.actualDate.toDateString();
        this.cargarIdReporte();
    }

    //Funcion para cargar el id del reporte seleccionado
    cargarIdReporte(){
        $.ajax({
            type: 'GET',
            url: 'idreporte/'+this.props.params.siteId + '/'+this.props.params.reporte,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Obtener las opciones de la consulta
                this.setState({reporte_id: data.id}, function () {
                    //console.log(this.state.reporte_id);
                });
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Funcion para cargar la cuenta activa
    cargarCuentaActiva(){
        $.ajax({
            type: 'GET',
            url: 'cuenta/'+this.props.params.siteId,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Obtener las opciones de la consulta
                this.setState({selectedCuentaObj: data});
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Get Reportes de una cuenta
    cargarQueries(){
        $.ajax({
            type: 'GET',
            url: 'queries/'+this.props.params.siteId+'/'+this.props.params.reporte,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos
                var queries=[];
                for(var i =0; i<data.length; i++){
                    var metricas = "";
                    var dimensiones = "";
                    for(var m =0; m<data[i].metrica.length; m++){
                        metricas= metricas + data[i].metrica[m].clave + ', ';
                    }

                    for(var d =0; d<data[i].dimension.length; d++){
                        dimensiones= dimensiones + data[i].dimension[d].clave + ', ';
                    }

                    queries.push({
                        id: data[i].id,
                        nombre: data[i].nombre,
                        parametros: metricas + dimensiones,
                        rutas: data[i].id
                    });
                }
                this.setState({queries: queries});

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Cargar selects-----------------------------------------------------
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

    cargarColumnsIgnore(){
        var columnsIgnore =  this.state.selectedDimensions.concat(this.state.selectedMetricas);
        this.setState({columnasignore: columnsIgnore});
    }

    //Funcion para Crear, Modificar, o Eliminar un reporte
    createUpdateQueries(){

        var token = $('meta[name="csrf-token"]').attr('content');

        var action = this.state.action;
        var url = 'queries';
        if(action == 'PUT' || action == 'DELETE'){
            url = url + '/' + this.state.id;
        }else if(action == 'POST'){
            url = 'queries/'+ this.state.selectedCuenta + '/' + this.state.reporte_nombre;
        }

        var totalcolumnas = this.state.selectedHeaders.length - this.state.selectedColumnsignore.length;

        if((action=='POST' || action=='PUT') && totalcolumnas > 2){
            //Si el numero de columnas es mayor a 2 no se debe guardar la query
            this.setState({errors: ["El número de columnas debe ser menor o igual a 2"]});
            this.setState({erroropen: true});
        }else{
            //Si es menor o igual a 2 si se puede guardar
            $.ajax({
                type: action,
                url: url,
                context: this,
                dataType: 'json',
                cache: false,
                data:{
                    id: this.state.id,
                    nombre: this.state.nombre,
                    metrics: this.state.selectedMetricas,
                    dimensions: this.state.selectedDimensions,
                    sort: this.state.selectedSort,
                    filters: this.state.filters,
                    segment: this.state.selectedSegment,
                    max_result: this.state.maxresults,
                    siteId: this.state.selectedCuentaLbl,
                    columnasignore: this.state.selectedColumnsignore,
                    reporte_id:this.state.reporte_id,
                    _token: token,
                },
                success: function (data) {
                    if(data.errors){
                        //Si hay errores guardarlos
                        this.setState({errors: data.errors});
                        this.setState({erroropen: true});
                    }else{
                        //Si fue exitoso resetear los estados y cerrar modal
                        this.setState({
                            id: 0,
                            nombre: "",
                            selectedMetricas: [],
                            finalMet: [],
                            finalDim: [],
                            selectedDimensions:[],
                            selectedSort:[],
                            filters:[],
                            selectedSegment:[],
                            maxresults:null,
                            selectedColumnsignore:[],
                            selectedHeaders: []
                        }, function () {
                            this.setState({openModal: false});
                            this.setState({successopen: true});
                        });
                    }
                    this.cargarQueries(this.state.selectedCuentaLbl);
                }.bind(this),
                error: function (xhr, status, err) {
                    //Error
                    console.error(this.props.url, status, err.toString());
                }.bind(this)
            });
        }
    }

    //Handlers---------------

    //Handlers Modales------------------------
    handleOpenAgregar(){
        this.setState({
            openModal: true,
            action: 'POST'
        });
    }

    handleOpenModificar(id){
        this.setState({action: 'PUT'}, function () {
            this.loadQuery(id);
        });

    }

    handleOpenEliminar(id){
        this.setState({action: 'DELETE'}, function () {
            this.loadQuery(id);
        });
    }

    handleCloseSuccess(){
        this.setState({successopen: false});
    }

    //Handlers Componentes---------------------
    handleNombre(e){
        this.setState({
            nombre: e.target.value
        });
    }

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

        this.setState({selectedDimensions: arr, selectedColumnsignore: []}, function(){
            this.cargarSort();
            this.cargarColumnsIgnore();
        });

        this.setState({finalDim: final}, function () {
            if (this.state.selectedMetricas.length>0){
                this.executeQuery();
            }
        });
    }

    handleMultiMetricas(e){
        //console.log(e);
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

        this.setState({selectedMetricas: arr, selectedColumnsignore: []}, function () {
            //console.log(this.state.selectedMetricas);
            this.cargarSort();
            this.cargarColumnsIgnore();
        });

        this.setState({finalMet: final}, function () {
            if(this.state.selectedMetricas.length>0){
                this.executeQuery();
            }
        });
    }

    handleMultiSort(e){
        var arr = [];
        arr.push({
            value: e.value,
            label: e.label

        });

        this.setState({selectedSort: arr},function () {
            if (this.state.selectedMetricas.length>0){
                this.executeQuery();
            }
        });
    }

    handleSegmentos(e){
        var arr = [];
        if(e){
            arr.push({
                value: e.value,
                label: e.label

            });

            this.setState({selectedSegment: arr}, function () {
                if (this.state.selectedMetricas.length>0){
                    this.executeQuery();
                }
            });
        }else{
            this.setState({selectedSegment: []}, function () {
                if (this.state.selectedMetricas.length>0){
                    this.executeQuery();
                }
            });
        }

    }

    handleFilters(e){
        this.setState({filters: e.target.value}, function () {
            if (this.state.selectedMetricas.length>0){
                this.executeQuery();
            }
        });
    }

    handleMaxResults(e){
        this.setState({maxresults: e.target.value}, function () {
            if (this.state.selectedMetricas.length>0){
                this.executeQuery();
            }
        });
    }
    

    handleCloseModal(){
        this.setState({
            id: 0,
            nombre: "",
            filters: "",
            max_result: null,
            selectedMetricas: [],
            selectedDimensions: [],
            selectedSort: [],
            selectedSegment: [],
            selectedColumnsignore: [],
            finalMet: [],
            finalDim: [],
            metHead: [],
            dimHead: []
        },function () {
            this.setState({openModal: false,});
        });
    }

    handleCloseError(){
        this.setState({erroropen: false});
    }

    handleResponse(data) {
        this.setState({
            selectedCuentaObj: data,
            selectedCuenta: data,
            selectedCuentaLbl: data.label
        }, function () {
            this.cargarQueries(data.label)
        });
    }

    handleMultiColumns(e){

        if(e.length > 0){
            var arr = [];
            var columnas = [];
            var rows = [];
            for(var c=0; c<this.state.columns.length; c++){
                columnas.push(this.state.columns[c]);
            }
            for(var r=0; r<this.state.rows.length; r++){
                rows.push(this.state.rows[r]);
            }
            if(e.length > 0){
                for(var i = 0; i < e.length; i++) {
                    arr.push({label: e[i].label, nombre: e[i].name});
                    for(var j =0; j< columnas.length; j++){
                        if(e[i].name == columnas[j].name){
                            var index = columnas.indexOf(columnas[j]);
                            columnas.splice(index, 1);
                            for(var k=0; k<rows.length; k++){
                                delete rows[k][index];
                            }
                        }
                    }
                }
            }

            this.setState({
                newcolumns: columnas,
                newrows: rows,
                selectedColumnsignore: arr,
            }, function () {
            });
        }else {
            this.setState({selectedColumnsignore: [] }, function () {
                this.cargarTabla();
            });

        }

    }

    //Metodo para cargar los datos de un Query en especifico
    loadQuery(id){
        $.ajax({
            type: 'GET',
            url: 'query/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {

                var metricas = [];
                var finalmet = [];
                var metH = [];
                if(data.metrica != null){
                    for(var i=0; i<data.metrica.length; i++){
                        metricas.push({
                            value: data.metrica[i].id,
                            label: data.metrica[i].clave,
                            name: data.metrica[i].nombre,
                            tipo: data.metrica[i].tipo
                        });
                        finalmet.push(data.metrica[i].clave);
                        metH.push(data.metrica[i].nombre);
                    }
                }

                var finaldim =[];
                var dimension = [];
                var dimH = [];
                if(data.dimension.length > 0){
                    for(var i=0; i<data.dimension.length; i++){
                        dimension.push({
                            value: data.dimension[i].id,
                            label: data.dimension[i].clave,
                            name: data.dimension[i].nombre,
                            tipo: data.dimension[i].tipo
                        });
                        finaldim.push(data.dimension[i].clave);
                        dimH.push(data.dimension[i].nombre);
                    }
                }

                var segmento = [];
                if(data.segmentos.length > 0){
                    for(var i=0; i<data.segmentos.length; i++){
                        segmento.push({
                            value: data.segmentos[i].id,
                            label: data.segmentos[i].clave,
                            name: data.segmentos[i].nombre,
                        })
                    }
                }

                var columnig = [];
                if(data.columns_ignore){
                    for(var i=0; i<data.columns_ignore.length; i++){
                        columnig.push({
                            nombre: data.columns_ignore[i].nombre,
                            label: data.columns_ignore[i].label
                        })
                    }
                }

                var sort = [];
                if (data.sort){
                    sort.push({
                        label: data.sort,
                    });
                }

                //Guardo los datos y cambio estados de la modal y de la accion
                this.setState({
                    id: data.id,
                    nombre: data.nombre,
                    filters: data.filtro,
                    maxresults: data.max_results,
                    siteId: this.state.selectedCuentaLbl,
                    reporte_id:data.reporte_id,
                    selectedMetricas: metricas,
                    selectedDimensions: dimension,
                    selectedSort: sort,
                    selectedSegment: segmento,
                    selectedColumnsignore: columnig,
                    finalMet: finalmet,
                    finalDim: finaldim,
                    openModal: true,
                    metHead: metH,
                    dimHead: dimH
                }, function () {
                    this.cargarSort();
                    this.cargarColumnsIgnore();
                    this.loadTableQuery();

                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    loadTableQuery(){
        var heads = this.state.dimHead.concat(this.state.metHead);
        this.setState({selectedHeaders: heads}, function () {
            this.executeQuery();
        });
    }

    loadIgnoreQuery(){
        if(this.state.selectedColumnsignore.length > 0){
            var arr = [];
            var columnas = [];
            var rows = [];
            for(var c=0; c<this.state.columns.length; c++){
                columnas.push(this.state.columns[c]);
            }
            for(var r=0; r<this.state.rows.length; r++){
                rows.push(this.state.rows[r]);
            }

                for(var i = 0; i < this.state.selectedColumnsignore.length; i++) {
                    arr.push({label:this.state.selectedColumnsignore[i].label, nombre: this.state.selectedColumnsignore[i].nombre});
                    for(var j =0; j< columnas.length; j++){
                        if(this.state.selectedColumnsignore[i].nombre == columnas[j].name){
                            var index = columnas.indexOf(columnas[j]);
                            columnas.splice(index, 1);
                            for(var k=0; k<rows.length; k++){
                                delete rows[k][index];
                            }
                        }
                    }
                }

            this.setState({
                newcolumns: columnas,
                newrows: rows,
                selectedColumnsignore: arr,
            }, function () {
                //this.cargarTabla();
            });
        }else{
            this.setState({selectedColumnsignore: []});
        }

    }

    //Ejecuto el query cuando ya selecciono metricas
    executeQuery(){
        $.ajax({
            type: 'GET',
            url: 'innerquery',
            dataType: 'json',
            context: this,
            data:{
                metrics: this.state.finalMet,
                dimensions: this.state.finalDim,
                sort: this.state.selectedSort,
                filters: this.state.filters,
                segment: this.state.selectedSegment,
                maxResult: this.state.maxresults,
                siteId: this.state.selectedCuentaLbl,
            },
            success: function (data) {
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

    }


    //Metodo para estructura de botones en tabla
    botonesRutas(e){
        return (

            React.createElement(
                "div",
                {className: "text-right"},
                //Modificar
                React.createElement("button", {
                        className: "btn btn-icon-toggle",
                        "data-toggle": "tooltip",
                        "data-placement": "top",
                        "data-original-title": "Modificar",
                        onTouchTap:this.handleOpenModificar.bind(this, e)},
                    React.createElement("i", { className: "fa fa-pencil" })
                ),

                //Eliminar
                React.createElement("button", {
                        className: "btn btn-icon-toggle",
                        "data-toggle": "tooltip",
                        "data-placement": "top",
                        "data-original-title": "Eliminar",
                        onTouchTap:this.handleOpenEliminar.bind(this, e)},
                    React.createElement("i", { className: "fa fa-trash-o" })
                )
            )
        );
    }

    //Rendereo el cada objeto de los select de metricas y Dimensiones
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


        this.setState({
            columns: columns,
            rows: rows
        },function () {
            this.loadIgnoreQuery();
        });
    }

    tableRender() {
        var _rows = [];

        if(this.state.selectedColumnsignore.length > 0){
            _rows= this.state.newrows;
        } else {
            _rows = this.state.rows;
        }
        //_rows = this.state.rows;

        var rowGetter = function (i) {
            return _rows[i];
        };


        if(this.state.selectedColumnsignore.length > 0){
            var columns = this.state.newcolumns
        } else {
            var columns = this.state.columns;
        }

        //var columns = this.state.columns;

        var height = 500;

        if (_rows.length < 10) {
            if (_rows.length < 2) {
                height = _rows.length * 72;
            } else {
                height = (_rows.length * 35) + 35;
            }

        }

        return(
            <div>
                Vista Previa:
                <ReactDataGrid
                    columns={columns}
                    rowGetter={rowGetter}
                    rowsCount={_rows.length}
                    minHeight={height}
                />
            </div>
        );
    }

    render() {

        //Cargo el Inner Query---------------------------
        var innerQuery = [];
        if(this.state.selectedMetricas.length > 0){
                //Se seleccionaron metricas -> se puede ejecutar el query
            innerQuery = this.tableRender();

        }else{
                //No se han seleccionado metricas no se puede ejecutar
            innerQuery = [
                <div>
                    <span>Selecciona metricas y otros campos para despleguar la vista previa del Query</span>
                </div>
            ]
            
        }

        ///////////////////////////////////////////////////////
        //Modifico El contenido del modal en base a los estados
        ///////////////////////////////////////////////////////
        var titulo ='';
        var acciones=[];
        var contenido=[];
        var exito='--';

        if(this.state.action== 'POST'){
            titulo='Agregar Query';
            exito= 'El registro fue añadido exitosamente';
            contenido= [
                <div>
                    <div className="col-md-12">
                        <div className="col-md-6">
                            <div className="col-md-12">
                                <TextField
                                    hintText="Nombre"
                                    floatingLabelText="Nombre"
                                    type="text"
                                    fullWidth={true}
                                    onChange={this.handleNombre.bind(this)}
                                />
                            </div>
                            <div className="col-md-12">
                                <MultiSelect
                                    className = "input-formMUI"
                                    placeholder = "Metricas"
                                    theme = "material"
                                    options = {this.state.metricas}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinResultados}
                                    renderOption = {this.customOption.bind(this)}
                                    onValuesChange={this.handleMultiMetricas.bind(this)}
                                />
                            </div>
                            <div className="col-md-12">
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
                            <div className="col-md-12">
                                <SimpleSelect
                                    className = "input-formMUI"
                                    placeholder = "Sort"
                                    theme = "material"
                                    options = {this.state.sort}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinSort}
                                    onValueChange={this.handleMultiSort.bind(this)}
                                    renderOption={this.customOptionSort.bind(this)}
                                />
                            </div>
                            <div className="col-md-12">
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
                            <div className="col-md-12">
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
                            <div className="col-md-12">
                                <MultiSelect
                                    className = "input-formMUI"
                                    placeholder = "Ignorar Columnas"
                                    theme = "material"
                                    options = {this.state.columnasignore}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinSort}
                                    onValuesChange={this.handleMultiColumns.bind(this)}
                                    renderOption={this.customOptionSort.bind(this)}
                                />
                            </div>
                        </div>
                        <div className="col-md-6">
                            {innerQuery}
                        </div>
                    </div>
                </div>
            ];
            acciones = [
                <FlatButton
                    label="Cancelar"
                    primary={true}
                    onTouchTap={this.handleCloseModal}
                />,
                <FlatButton
                    label="Guardar"
                    primary={true}
                    keyboardFocused={true}
                    onTouchTap={this.createUpdateQueries.bind(this)}
                />
            ];
        } else if(this.state.action== 'PUT'){
            titulo='Modificar Query';
            exito= 'El registro fue modificado exitosamente';
            contenido=[
                <div>
                    <div className="col-md-12">
                        <div className="col-md-6">
                            <div className="col-md-12">
                                <TextField
                                    hintText="Nombre"
                                    floatingLabelText="Nombre"
                                    type="text"
                                    fullWidth={true}
                                    onChange={this.handleNombre.bind(this)}
                                    defaultValue={this.state.nombre}
                                />
                            </div>
                            <div className="col-md-12">
                                <MultiSelect
                                    className = "input-formMUI"
                                    placeholder = "Metricas"
                                    theme = "material"
                                    options = {this.state.metricas}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinResultados}
                                    renderOption = {this.customOption.bind(this)}
                                    onValuesChange={this.handleMultiMetricas.bind(this)}
                                    values={this.state.selectedMetricas}
                                />
                            </div>
                            <div className="col-md-12">
                                <MultiSelect
                                    className = "input-formMUI"
                                    placeholder = "Dimensiones"
                                    theme = "material"
                                    options = {this.state.dimensiones}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinResultados}
                                    renderOption = {this.customOption.bind(this)}
                                    onValuesChange={this.handleMultiDimensiones.bind(this)}
                                    values={this.state.selectedDimensions}
                                />
                            </div>
                            <div className="col-md-12">
                                <SimpleSelect
                                    className = "input-formMUI"
                                    placeholder = "Sort"
                                    theme = "material"
                                    options = {this.state.sort}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinSort}
                                    onValueChange={this.handleMultiSort.bind(this)}
                                    renderOption={this.customOptionSort.bind(this)}
                                    value={this.state.selectedSort[0]}
                                />
                            </div>
                            <div className="col-md-12">
                                <SimpleSelect
                                    className = "input-formMUI"
                                    placeholder = "Segments"
                                    theme = "material"
                                    options = {this.state.segmentos}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinResultados}
                                    renderOption = {this.customOptionSegmento.bind(this)}
                                    onValueChange={this.handleSegmentos.bind(this)}
                                    value={this.state.selectedSegment[0]}
                                />
                            </div>
                            <div className="col-md-12">
                                <TextField
                                    hintText="Filters"
                                    floatingLabelText="Filters"
                                    type="text"
                                    fullWidth={true}
                                    onChange={this.handleFilters.bind(this)}
                                    defaultValue={this.state.filters}
                                />
                            </div>
                            <div className="col-md-6">
                                <TextField
                                    hintText="Max Results"
                                    floatingLabelText="Max Results"
                                    type="number"
                                    fullWidth={true}
                                    onChange={this.handleMaxResults.bind(this)}
                                    defaultValue={this.state.maxresults}
                                />
                            </div>
                            <div className="col-md-12">
                                <MultiSelect
                                    className = "input-formMUI"
                                    placeholder = "Ignorar Columnas"
                                    theme = "material"
                                    options = {this.state.columnasignore}
                                    style = {{ width: '100%'}}
                                    renderNoResultsFound = {this.sinSort}
                                    onValuesChange={this.handleMultiColumns.bind(this)}
                                    renderOption={this.customOptionSort.bind(this)}
                                    values={this.state.selectedColumnsignore}
                                />
                            </div>
                        </div>
                        <div className="col-md-6">
                            {innerQuery}
                        </div>
                    </div>
                </div>
            ];
            acciones = [
                <FlatButton
                    label="Cancelar"
                    primary={true}
                    onTouchTap={this.handleCloseModal}
                />,
                <FlatButton
                    label="Guardar"
                    primary={true}
                    keyboardFocused={true}
                    onTouchTap={this.createUpdateQueries.bind(this)}
                />
            ];
        } else if(this.state.action== 'DELETE'){
            titulo='Eliminar Query';
            exito= 'El registro fue eliminado exitosamente';
            contenido=[
                <div>
                    <div className="col-md-12">
                        <h2>¿Esta seguro que quiere eliminar la query {"\""+ this.state.nombre+ "\""}?</h2>
                    </div>
                </div>
            ];
            acciones = [
                <FlatButton
                    label="Cancelar"
                    primary={true}
                    onTouchTap={this.handleCloseModal}
                />,
                <FlatButton
                    label="Aceptar"
                    primary={true}
                    keyboardFocused={true}
                    onTouchTap={this.createUpdateQueries.bind(this)}
                />
            ];
        }


        return(
            <div id="content">
                <section className="has-actions">
                    <div className="section-body">
                        <div className = "section-header col-md-12">
                            <div className="col-md-6">
                                <h2 className = "text-primary">Reporte: {this.state.reporte_nombre}</h2>
                                <span>{this.state.selectedCuentaObj.name}</span>
                            </div>

                            <div className="col-md-6" style={{textAlign: "right"}}>
                                <Link to={"/consultalt/" + this.state.selectedCuentaLbl + "/" + this.state.reporte_id}>
                                    <FlatButton label="Consultar Reporte" primary={true}/>
                                </Link>
                            </div>
                        </div>
                        <BootstrapTable data={this.state.queries}
                                        pagination={true}
                                        options={{ noDataText :"No hay Consultas para este Reporte"}}
                                        hover={true}
                                        search={true}>
                            <TableHeaderColumn hidden = {true} dataField="id" isKey = {true}>n.º</TableHeaderColumn>
                            <TableHeaderColumn dataField = "nombre" dataSort={true}>Nombre</TableHeaderColumn>
                            <TableHeaderColumn dataField = "parametros" dataSort = {true}>Parámetros</TableHeaderColumn>
                            <TableHeaderColumn dataField = "rutas"  dataFormat={this.botonesRutas} />
                        </BootstrapTable>
                        <Dialog
                            titleClassName="form_background"
                            title = {titulo}
                            titleStyle = {{ color:'#ffffff'}}
                            actions = {acciones}
                            modal = {false}
                            open = {this.state.openModal}
                            onRequestClose={this.handleClose}
                            autoDetectWindowHeight={true}
                            autoScrollBodyContent={true} >
                            {contenido}
                        </Dialog>
                    </div>
                    <Componente_Footer  agregar={this.handleOpenAgregar}/>
                    <Snackbar
                        open={this.state.erroropen}
                        message={this.state.errors[0]}
                        autoHideDuration={4000}
                        onRequestClose={this.handleCloseError.bind(this)}
                    />
                    <Snackbar
                        open={this.state.successopen}
                        message={exito}
                        autoHideDuration={4000}
                        onRequestClose={this.handleCloseSuccess.bind(this)}
                    />
                </section>
            </div>
        );
    }
}