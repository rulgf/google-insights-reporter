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


export default class Cuentas extends  React.Component{

    constructor(props) {
        super(props);

        this.botonesRutas = this.botonesRutas.bind(this);
        this.handleCloseModal = this.handleCloseModal.bind(this);
        this.handleOpenAgregar = this.handleOpenAgregar.bind(this);

        var estados=[
            {value: 0, label: "Activa"},
            {value: 1, label: "En pausa"},
            {value: 2, label: "Inactiva"},
        ];

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
        }

        this.state = {
            //Cuentas
            cuentas: [],

            //Campos modal
            id: 0,
            nombre: "",
            siteId: "",
            clientemail: "",
            clientenombre: "",
            campaign_id: "",
            active: 0,

            estados: estados,
            selectedEstado : {},

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
        }

        this.cargarCuentas();
    }

    //Get Cuentas
    cargarCuentas(){
        $.ajax({
            type: 'GET',
            url: 'allcuentas',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos
                var cuentas=[];
                for(var i =0; i<data.length; i++){
                    cuentas.push({
                        id: data[i].id,
                        nombre: data[i].nombre,
                        siteId: data[i].siteId,
                        clientemail: data[i].email_cliente,
                        clientenombre: data[i].nombre_cliente,
                        active: data[i].active,
                        rutas: data[i].id
                    });
                }
                this.setState({cuentas: cuentas},function () {

                });


            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }


    //Funcion para Crear, Modificar, o Eliminar una Cuenta
    createUpdateCuentas(){

        var token = $('meta[name="csrf-token"]').attr('content');

        var action = this.state.action;
        var url = 'cuentas';
        if(action == 'PUT' || action == 'DELETE'){
            url = url + '/' + this.state.id;
        }else if(action == 'POST'){
            url ='cuentas';
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
                siteId: this.state.siteId,
                nombre_cliente: this.state.clientenombre,
                active: this.state.active,
                email_cliente: this.state.clientemail,
                campaign_id: this.state.campaign_id,
                _token: token
            },
            success: function (data) {
                if(data.errors){
                    //Si hay errores guardarlos
                    this.setState({errors: data.errors});
                    this.setState({erroropen: true});
                }else{
                    //Si fue exitoso guardar resetear los estados y cerrar modal
                    this.setState({
                        id: 0,
                        nombre: "",
                        siteId: "",
                        openModal: false
                    });
                    this.setState({successopen: true});
                }
                    this.cargarCuentas();
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(err.responseText);
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
            this.loadCuenta(id);
        });

    }

    handleOpenEliminar(id){
        this.setState({action: 'DELETE'}, function () {
            this.loadCuenta(id);
        });
    }

        //Handlers Componentes---------------------
    handleNombre(e){
        this.setState({
            nombre: e.target.value
        });
    }

    handleSiteId(e){
        this.setState({
            siteId: e.target.value
        });
    }
    
    handleClientenombre(e){
        this.setState({
            clientenombre: e.target.value
        });
    }

    handleClientemail(e){
        this.setState({
            clientemail: e.target.value
        });
    }
    
    handleEstado(e){
        this.setState({
            selectedEstado: e,
            active: e.value
        });
    }

    handleCampania(e){
        this.setState({
            campaign_id: e.target.value
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

    //Metodo para cargar los datos de una cuenta en especifico
    loadCuenta(id){
        $.ajax({
            type: 'GET',
            url: 'cuentas/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos y cambio estados de la modal y de la accion
                var estado={};
                if(data.active == 0){
                    estado={value: 0, label: 'Activa'}
                }else if(data.active == 1){
                    estado={value: 1, label: 'En pausa'}
                }else{
                    estado={value: 2, label: 'Inactiva'}
                }
                this.setState({
                    id: data.id,
                    nombre: data.nombre,
                    siteId: data.siteId.replace("ga:", ""),
                    active: data.active,
                    selectedEstado: estado,
                    clientenombre: data.nombre_cliente,
                    clientemail: data.mail_cliente,
                    campaign_id: data.campaign_id,
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

    //Formato de la columna Estado para desplegar activo, inactivo o pausa
    cellState(e){
        if(e == 0){
            //Activo
            return <div>Activa</div>
        }else if(e== 1){
            //En Pausa
            return <div>En Pausa</div>
        }else{
            //Inactivo
            return <div>Inactiva</div>
        }
    }

    render() {
        ///////////////////////////////////////////////////////
        //Modifico El contenido del modal en base a los estados
        ///////////////////////////////////////////////////////
        var titulo ='';
        var acciones=[];
        var contenido=[];
        var exito='';

        if(this.state.action== 'POST'){
            titulo='Agregar Cuenta';
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
                                hintText="ID de la Cuenta"
                                floatingLabelText="ID de la Cuenta"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleSiteId.bind(this)}
                            />
                        </div>
                    </div>

                    <div className="col-md-12">
                        <div className="col-md-6">
                            <TextField
                                hintText="Nombre del Cliente"
                                floatingLabelText="Nombre del Cliente"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleClientenombre.bind(this)}
                            />
                        </div>
                        <div className="col-md-6">
                            <TextField
                                hintText="Email del Cliente"
                                floatingLabelText="Email del Cliente"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleClientemail.bind(this)}
                            />
                        </div>
                    </div>
                    
                    <div className="col-md-12">
                        <div className="col-md-6">
                            <TextField
                                hintText="ID de Adwords"
                                floatingLabelText="ID de Adwords"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleCampania.bind(this)}
                            />
                        </div>
                        <div className="col-md-6">
                            <SimpleSelect
                                className = "input-formMUI"
                                placeholder = "Estado"
                                theme = "material"
                                options = {this.state.estados}
                                style = {{ width: '100%'}}
                                renderNoResultsFound = {this.sinResultados}
                                onValueChange={this.handleEstado.bind(this)}
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
                    onTouchTap={this.createUpdateCuentas.bind(this)}
                />
            ];
        } else if(this.state.action== 'PUT'){
            titulo='Modificar Cuenta';
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
                                hintText="ID de la Cuenta"
                                floatingLabelText="ID de la Cuenta"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleSiteId.bind(this)}
                                defaultValue={this.state.siteId}
                            />
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="col-md-6">
                            <TextField
                                hintText="Nombre del Cliente"
                                floatingLabelText="Nombre del Cliente"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleClientenombre.bind(this)}
                                defaultValue={this.state.clientenombre}
                            />
                        </div>
                        <div className="col-md-6">
                            <TextField
                                hintText="Email del Cliente"
                                floatingLabelText="Email del Cliente"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleClientemail.bind(this)}
                                defaultValue={this.state.clientemail}
                            />
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="col-md-6">
                            <TextField
                                hintText="ID de Campaña"
                                floatingLabelText="ID de Campaña"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleCampania.bind(this)}
                                defaultValue={this.state.campaign_id}
                            />
                        </div>
                        <div className="col-md-6">
                            <SimpleSelect
                                className = "input-formMUI"
                                placeholder = "Estado"
                                theme = "material"
                                options = {this.state.estados}
                                style = {{ width: '100%'}}
                                renderNoResultsFound = {this.sinResultados}
                                onValueChange={this.handleEstado.bind(this)}
                                value={this.state.selectedEstado}
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
                    onTouchTap={this.createUpdateCuentas.bind(this)}
                />
            ];
        } else if(this.state.action== 'DELETE'){
            titulo='Eliminar Cuenta';
            exito= 'El registro fue eliminado exitosamente';
            contenido=[
                <div>
                    <div className="col-md-12">
                        <h2>¿Esta seguro que quiere eliminar la cuenta {this.state.nombre}?</h2>
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
                    onTouchTap={this.createUpdateCuentas.bind(this)}
                />
            ];
        }


        return(
            <div id="content">
                <section className="has-actions">
                    <div className="section-body">
                        <div className = "section-header">
                            <h2 className = "text-primary">Cuentas</h2>
                        </div>
                        <BootstrapTable data={this.state.cuentas}
                                        pagination={true}
                                        options={{ noDataText :"No hay cuentas disponibles"}}
                                        hover={true}
                                        search={true}>
                            <TableHeaderColumn hidden = "true" dataField="id" isKey = {true}>n.º</TableHeaderColumn>
                            <TableHeaderColumn dataField = "nombre" dataSort = {true}>Nombre</TableHeaderColumn>
                            <TableHeaderColumn dataField = "siteId" dataSort = {true}>Id de Cuenta</TableHeaderColumn>
                            <TableHeaderColumn dataField = "clientenombre" dataSort = {true}>Cliente</TableHeaderColumn>
                            <TableHeaderColumn dataField = "active" dataSort = {true} dataFormat={this.cellState}>Estado</TableHeaderColumn>
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