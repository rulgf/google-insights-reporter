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
import {SimpleSelect, MultiSelect, ReactSelectize} from 'react-selectize';

import $ from 'jquery';


export default class Alertas extends  React.Component{

    constructor(props) {
        super(props);

        this.botonesRutas = this.botonesRutas.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
        this.handleOpenAgregar = this.handleOpenAgregar.bind(this);

        var condiciones= [
            {key: 1, label: "Menor que"},
            {key: 2, label: "Mayor que"},
            {key: 3, label: "Igual que"}
        ];

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
        }

        this.state = {
            //Metricas
            alertas: [],

            //Campos modal
            metricas: [],
            condicion: condiciones,
            parametro: null,
            selectedMetrica: {},
            selectedCondicion: {},

            //Modal Consultar/Modificar/Eliminar
            openModal: false,
            action: null,

            //Tabla
            datos: [],

            //Errores
            errors: [],
            erroropen:false,

            //success
            successopen:false,

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

            this.cargarMetricas(label);
            this.cargarAlertas();

        }
    }

    //Funcion para cargar las Alertas de la cuenta seleccionada
    cargarAlertas(){
        $.ajax({
            type: 'GET',
            url: 'alertas/'+this.state.selectedCuentaLbl,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos
                var alertas=[];
                for(var i =0; i<data.length; i++){
                    var cond = "";
                    if(data[i].condicion == 1){
                        cond = "Menor que";
                    }else if(data[i].condicion == 2){
                        cond = "Mayor que";
                    }else{
                        cond = "Igual que";
                    }
                    alertas.push({
                        id: data[i].id,
                        nombre: data[i].nombre,
                        metrica: data[i].metricas.nombre,
                        condicion: cond,
                        parametro: data[i].parametro,
                        rutas: data[i].id
                    });
                }
                this.setState({alertas: alertas},function () {

                });


            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    componentWillReceiveProps(nextProps) {
        // You don't have to do this check first, but it can help prevent an unneeded render
        if (nextProps.activeCount !== this.state.selectedCuenta && nextProps.activeCount != null) {
            this.setState({
                selectedCuenta: nextProps.activeCount,
                selectedCuentaObj: nextProps.activeCount,
                selectedCuentaLbl: nextProps.activeCount.label,
            }, function () {
                this.cargarAlertas();
                this.cargarMetricas();
            });
        }
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


    //Funcion para Crear, Modificar, o Eliminar una Alerta
    createUpdateAlertas(){

        var token = $('meta[name="csrf-token"]').attr('content');

        var action = this.state.action;
        var url = 'alerta';
        if(action == 'PUT' || action == 'DELETE'){
            url = url + '/' + this.state.id;
        }else if(action == 'POST'){
            url ='alerta';
        }
        $.ajax({
            type: action,
            url: url,
            context: this,
            dataType: 'json',
            cache: false,
            data:{
                id: this.state.id,
                cuenta_id: this.state.selectedCuentaLbl,
                nombre: this.state.nombre,
                condicion: this.state.selectedCondicion.key,
                metrica: this.state.selectedMetrica.value,
                parametro: this.state.parametro,
                _token: token
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
                        selectedCondicion: {},
                        parametro: null,
                        selectedMetrica: {},
                        openModal: false
                    });
                    this.setState({successopen: true});
                }
                this.cargarAlertas(this.state.selectedCuentaLbl);
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
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
            this.loadAlerta(id);
        });

    }

    handleOpenEliminar(id){
        this.setState({action: 'DELETE'}, function () {
            this.loadAlerta(id);
        });
    }

    //Handlers Componentes---------------------
    handleNombre(e){
        this.setState({
            nombre: e.target.value
        });
    }

    handleCondicion(e){
        this.setState({
            selectedCondicion: e
        });
    }

    handleParametro(e){

        this.setState({
            parametro: e.target.value
        });
    }
    
    handleMetrica(e){
        //console.log(e);
        this.setState({
            selectedMetrica: e
        });
    }

    handleCloseModal(){
        this.setState({
            openModal: false
        });
    }

    handleCloseError(){
        this.setState({erroropen: false});
    }

    handleCloseSuccess(){
        this.setState({successopen: false});
    }

    //Metodo para cargar los datos de una Alerta en especifico
    loadAlerta(id){
        $.ajax({
            type: 'GET',
            url: 'alerta/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                var condiciones = this.state.condicion;
                for(var i = 0; i<condiciones.length; i++){
                    if(condiciones[i].key == data.condicion){
                        var condicion = condiciones[i];
                    }
                }
                //console.log(condiciones);

                var metrica = {};
                if(data.metricas != null){
                    metrica = {
                        value: data.metricas.id,
                        label: data.metricas.clave,
                        name: data.metricas.nombre,
                        tipo: data.metricas.tipo
                    };

                }

                //Guardo los datos y cambio estados de la modal y de la accion
                this.setState({
                    id: data.id,
                    nombre: data.nombre,
                    selectedCondicion: condicion,
                    parametro: data.parametro,
                    selectedMetrica: metrica,
                    openModal: true,
                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Metodo que se activa cuando no hay resultados
    sinResultados(){
        return React.createElement("div", {className: "no-results-found"},
            !!self.req ? "Cargando ..." : "No se encontraron resultados"
        )
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

    render() {
        ///////////////////////////////////////////////////////
        //Modifico El contenido del modal en base a los estados
        ///////////////////////////////////////////////////////
        var titulo ='';
        var acciones=[];
        var contenido=[];
        var exito ='';

        if(this.state.action== 'POST'){
            titulo='Agregar Alerta';
            exito= 'El registro fue añadido exitosamente';
            contenido= [
                <div>
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
                            <SimpleSelect
                                className = "input-formMUI"
                                placeholder = "Métrica"
                                theme = "material"
                                options = {this.state.metricas}
                                style = {{ width: '100%'}}
                                renderNoResultsFound = {this.sinResultados.bind(this)}
                                renderOption = {this.customOption.bind(this)}
                                onValueChange={this.handleMetrica.bind(this)}
                            />
                        </div>
                        <div className="col-md-12">
                            <SimpleSelect
                                className = "input-formMUI"
                                placeholder = "Condición"
                                theme = "material"
                                options = {this.state.condicion}
                                style = {{ width: '100%'}}
                                renderNoResultsFound = {this.sinResultados.bind(this)}
                                onValueChange={this.handleCondicion.bind(this)}
                            />
                        </div>
                        <div className="col-md-12">
                            <TextField
                                hintText="Parametro"
                                floatingLabelText="Parametro"
                                type="number"
                                fullWidth={true}
                                onChange={this.handleParametro.bind(this)}
                            />
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
                    onTouchTap={this.createUpdateAlertas.bind(this)}
                />
            ];
        } else if(this.state.action== 'PUT'){
            titulo='Modificar Alerta';
            exito= 'El registro fue modificado exitosamente';
            contenido=[
                <div>
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
                            <SimpleSelect
                                className = "input-formMUI"
                                placeholder = "Métrica"
                                theme = "material"
                                options = {this.state.metricas}
                                style = {{ width: '100%'}}
                                renderNoResultsFound = {this.sinResultados.bind(this)}
                                renderOption = {this.customOption.bind(this)}
                                onValueChange={this.handleMetrica.bind(this)}
                                value={this.state.selectedMetrica}
                            />
                        </div>
                        <div className="col-md-12">
                            <SimpleSelect
                                className = "input-formMUI"
                                placeholder = "Condición"
                                theme = "material"
                                options = {this.state.condicion}
                                style = {{ width: '100%'}}
                                renderNoResultsFound = {this.sinResultados.bind(this)}
                                onValueChange={this.handleCondicion.bind(this)}
                                value={this.state.selectedCondicion}
                            />
                        </div>
                        <div className="col-md-12">
                            <TextField
                                hintText="Parametro"
                                floatingLabelText="Parametro"
                                type="number"
                                fullWidth={true}
                                onChange={this.handleParametro.bind(this)}
                                defaultValue={this.state.parametro}
                            />
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
                    onTouchTap={this.createUpdateAlertas.bind(this)}
                />
            ];
        } else if(this.state.action== 'DELETE'){
            titulo='Eliminar Alerta';
            exito= 'El registro fue eliminado exitosamente';
            contenido=[
                <div>
                    <div className="col-md-12">
                        <h2>¿Esta seguro que quiere eliminar la alerta "{this.state.nombre}" ?</h2>
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
                    onTouchTap={this.createUpdateAlertas.bind(this)}
                />
            ];
        }


        return(
            <div id="content">
                <section className="has-actions">
                    <div className="section-body">
                        <div className = "section-header">
                            <h2 className = "text-primary">Alertas</h2>
                        </div>
                        <BootstrapTable data={this.state.alertas}
                                        pagination={true}
                                        options={{ noDataText :"No hay alertas para esta cuenta"}}
                                        hover={true}
                                        search={true}>
                            <TableHeaderColumn hidden = "true" dataField="id" isKey = {true}>n.º</TableHeaderColumn>
                            <TableHeaderColumn dataField = "nombre" dataSort = {true}>Nombre</TableHeaderColumn>
                            <TableHeaderColumn dataField = "metrica" dataSort = {true}> Métrica</TableHeaderColumn>
                            <TableHeaderColumn dataField = "condicion" dataSort = {true}>Condición</TableHeaderColumn>
                            <TableHeaderColumn dataField = "parametro" dataSort = {true}>Parámetro</TableHeaderColumn>
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
/**
 * Created by SOFTAM03 on 9/11/16.
 */
