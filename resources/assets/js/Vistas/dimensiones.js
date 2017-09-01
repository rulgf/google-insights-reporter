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

import $ from 'jquery';


export default class Dimensiones extends  React.Component{

    constructor(props) {
        super(props);

        this.botonesRutas = this.botonesRutas.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
        this.handleOpenAgregar = this.handleOpenAgregar.bind(this);

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
        }

        this.state = {
            //Dimensiones
            dimensiones: [],

            //Campos modal
            id: 0,
            nombre: "",
            clave: "",

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

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;

            this.cargarDimensiones(label);
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
                this.cargarDimensiones(nextProps.activeCount.label);
            });
        }
    }

    //Get Dimensiones
    cargarDimensiones(id){
        $.ajax({
            type: 'GET',
            url: 'sitedimensiones/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos
                var dimensiones=[];
                for(var i =0; i<data.length; i++){
                    dimensiones.push({
                        id: data[i].id,
                        nombre: data[i].nombre,
                        clave: data[i].clave,
                        rutas: data[i].id
                    });
                }
                this.setState({dimensiones: dimensiones},function () {

                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }


    //Funcion para Crear, Modificar, o Eliminar una Dimension
    createUpdateDimensiones(){

        var token = $('meta[name="csrf-token"]').attr('content');

        var action = this.state.action;
        var url = 'dimensiones';
        if(action == 'PUT' || action == 'DELETE'){
            url = url + '/' + this.state.id;
        }else if(action == 'POST'){
            url = 'dimensiones';
        }
        $.ajax({
            type: action,
            url: url,
            context: this,
            dataType: 'json',
            cache: false,
            data:{
                id: this.state.id,
                nombre: this.state.nombre,
                clave: this.state.clave,
                cuenta_id: this.state.selectedCuentaLbl,
                tipo_id: 32,
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
                        clave: "",
                        openModal: false
                    });
                    this.setState({successopen: true});
                }
                this.cargarDimensiones(this.state.selectedCuentaLbl);
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
            this.loadDimension(id);
        });

    }

    handleOpenEliminar(id){
        this.setState({action: 'DELETE'}, function () {
            this.loadDimension(id);
        });
    }

    //Handlers Componentes---------------------
    handleNombre(e){
        this.setState({
            nombre: e.target.value
        });
    }

    handleClave(e){
        this.setState({
            clave: e.target.value
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

    //Metodo para cargar los datos de una dimension en especifico
    loadDimension(id){
        $.ajax({
            type: 'GET',
            url: 'dimension/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos y cambio estados de la modal y de la accion
                this.setState({
                    id: data.id,
                    nombre: data.nombre,
                    clave: data.clave,
                    openModal: true,
                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
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

    render() {
        ///////////////////////////////////////////////////////
        //Modifico El contenido del modal en base a los estados
        ///////////////////////////////////////////////////////
        var titulo ='';
        var acciones=[];
        var contenido=[];
        var exito ='';

        if(this.state.action== 'POST'){
            titulo='Agregar Dimension';
            exito= 'El registro fue añadido exitosamente';
            contenido= [
                <div>
                    <div className="col-md-12">
                        <div className="col-md-6">
                            <TextField
                                hintText="Nombre"
                                floatingLabelText="Nombre"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleNombre.bind(this)}
                            />
                        </div>
                        <div className="col-md-6">
                            <TextField
                                hintText="Clave"
                                floatingLabelText="Clave"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleClave.bind(this)}
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
                    onTouchTap={this.createUpdateDimensiones.bind(this)}
                />
            ];
        } else if(this.state.action== 'PUT'){
            titulo='Modificar Dimension';
            exito= 'El registro fue modificado exitosamente';
            contenido=[
                <div>
                    <div className="col-md-12">
                        <div className="col-md-6">
                            <TextField
                                hintText="Nombre"
                                floatingLabelText="Nombre"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleNombre.bind(this)}
                                defaultValue={this.state.nombre}
                            />
                        </div>
                        <div className="col-md-6">
                            <TextField
                                hintText="Clave"
                                floatingLabelText="Clave"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleClave.bind(this)}
                                defaultValue={this.state.clave}
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
                    onTouchTap={this.createUpdateDimensiones.bind(this)}
                />
            ];
        } else if(this.state.action== 'DELETE'){
            titulo='Eliminar Dimensión';
            exito= 'El registro fue eliminado exitosamente';
            contenido=[
                <div>
                    <div className="col-md-12">
                        <h2>¿Esta seguro que quiere eliminar la dimension {"\""+ this.state.nombre+ "\""}?</h2>
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
                    onTouchTap={this.createUpdateDimensiones.bind(this)}
                />
            ];
        }


        return(
                <div id="content">
                    <section className="has-actions">
                        <div className="section-body">
                            <div className = "section-header">
                                <h2 className = "text-primary">Dimensiones</h2>
                            </div>
                            <BootstrapTable data={this.state.dimensiones}
                                            pagination={true}
                                            options={{ noDataText :"No hay Dimensiones para esta cuenta"}}
                                            hover={true}
                                            search={true}>
                                <TableHeaderColumn hidden = "true" dataField="id" isKey = {true}>n.º</TableHeaderColumn>
                                <TableHeaderColumn dataField = "nombre" dataSort = {true}>Nombre</TableHeaderColumn>
                                <TableHeaderColumn dataField = "clave" dataSort = {true}>Clave</TableHeaderColumn>
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
