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
import Toggle from 'material-ui/Toggle';

import $ from 'jquery';

const styles = {
    block: {
        maxWidth: 250,
    },
    toggle: {
        marginBottom: 16,
    },
};


export default class Reportes extends  React.Component{

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
            //Reportes
            reportes: [],

            //Campos modal
            id: 0,
            nombre: "",
            descripcion: "",
            mailing: false,

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

        this.cargarReportes(label)
    }

    componentWillReceiveProps(nextProps) {
        // You don't have to do this check first, but it can help prevent an unneeded render
        if (nextProps.activeCount !== this.state.selectedCuenta && nextProps.activeCount != null) {
            this.setState({
                selectedCuenta: nextProps.activeCount,
                selectedCuentaObj: nextProps.activeCount,
                selectedCuentaLbl: nextProps.activeCount.label,
            }, function () {
                this.cargarReportes(this.state.selectedCuentaLbl);
            });
        }
    }

    //Get Reportes de una cuenta
    cargarReportes(id){
        $.ajax({
            type: 'GET',
            url: 'reportes/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos
                var reportes=[];
                for(var i =0; i<data.length; i++){
                    reportes.push({
                        id: data[i].id,
                        nombre: data[i].nombre,
                        descripcion: data[i].descripcion,
                        mailing: data[i].mail_active,
                        rutas: data[i].id
                    });
                }
                this.setState({reportes: reportes},function () {
                    //console.log(this.state.reportes);
                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }


    //Funcion para Crear, Modificar, o Eliminar un reporte
    createUpdateReportes(){

        var token = $('meta[name="csrf-token"]').attr('content');

        var action = this.state.action;
        var url = 'reportes';
        if(action == 'PUT' || action == 'DELETE'){
            url = url + '/' + this.state.id;
        }else if(action == 'POST'){
            url = 'reportes';
        }

        if(this.state.mailing == true){
            var mail = 1;
        }else{
            var mail = 0;
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
                descripcion: this.state.descripcion,
                cuenta_id: this.state.selectedCuentaLbl,
                mail_active: mail,
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
                        descripcion: "",
                        openModal: false
                    });
                    this.setState({successopen: true});
                }
                this.cargarReportes(this.state.selectedCuentaLbl);
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
            this.loadReporte(id);
        });

    }

    handleOpenEliminar(id){
        this.setState({action: 'DELETE'}, function () {
            this.loadReporte(id);
        });
    }

    //Handlers Componentes---------------------
    handleNombre(e){
        this.setState({
            nombre: e.target.value
        });
    }

    handleDescripcion(e){
        this.setState({
            descripcion: e.target.value
        });
    }

    handleMailing(e){
        this.setState({
           mailing: !this.state.mailing
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

    //Metodo para cargar los datos de un Reporte en especifico
    loadReporte(id){
        $.ajax({
            type: 'GET',
            url: 'reporte/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                if(data.mail_active==0){
                    var mail=false;
                }else{
                    var mail =true;
                }
                //Guardo los datos y cambio estados de la modal y de la accion
                this.setState({
                    id: data.id,
                    nombre: data.nombre,
                    descripcion: data.descripcion,
                    mailing: mail,
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

    //Formato de la columna Nombre para que contenga un link
    cellLink(e){
        return <Link className="reporte-link" to={"/reporte/"+this.state.selectedCuentaLbl+"/"+ e}>
                    {e}
                </Link>
    }

    //Formato de la columna Mailing para desplegar activo o inactivo
    cellMail(e){
        if(e == 1){
            //Activo
            return <div>Activo</div>
        }else{
            //Inactio
            return <div>Inactivo</div>
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
            titulo='Agregar Reporte';
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
                                hintText="Descripción"
                                floatingLabelText="Descripción"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleDescripcion.bind(this)}
                            />
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="col-md-4">
                            <Toggle
                                label="Mailing"
                                defaultToggled={this.state.mailing}
                                style={styles.toggle}
                                onToggle={this.handleMailing.bind(this)}
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
                    onTouchTap={this.createUpdateReportes.bind(this)}
                />
            ];
        } else if(this.state.action== 'PUT'){
            titulo='Modificar Reporte';
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
                                hintText="Descripción"
                                floatingLabelText="Descripción"
                                type="text"
                                fullWidth={true}
                                onChange={this.handleDescripcion.bind(this)}
                                defaultValue={this.state.descripcion}
                            />
                        </div>
                    </div>
                    <div className="col-md-12">
                        <div className="col-md-4">
                            <Toggle
                                label="Mailing"
                                defaultToggled={this.state.mailing}
                                style={styles.toggle}
                                onToggle={this.handleMailing.bind(this)}
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
                    onTouchTap={this.createUpdateReportes.bind(this)}
                />
            ];
        } else if(this.state.action== 'DELETE'){
            titulo='Eliminar Reporte';
            exito= 'El registro fue eliminado exitosamente';
            contenido=[
                <div>
                    <div className="col-md-12">
                        <h2>¿Esta seguro que quiere eliminar el reporte {"\""+ this.state.nombre+ "\""}?</h2>
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
                    onTouchTap={this.createUpdateReportes.bind(this)}
                />
            ];
        }


        return(
            <div id="content">
                <section className="has-actions">
                    <div className="section-body">
                        <div className = "section-header">
                            <h2 className = "text-primary">Reportes</h2>
                        </div>
                        <BootstrapTable data={this.state.reportes}
                                        pagination={true}
                                        options={{ noDataText :"No hay Reportes Disponibles"}}
                                        hover={true}
                                        search={true}>
                            <TableHeaderColumn hidden = "true" dataField="id" isKey = {true}>n.º</TableHeaderColumn>
                            <TableHeaderColumn
                                dataField = "nombre"
                                dataFormat={this.cellLink.bind(this)}
                                dataSort={true}>
                                    Nombre
                            </TableHeaderColumn>
                            <TableHeaderColumn dataField = "descripcion" dataSort = {true}>Descripción</TableHeaderColumn>
                            <TableHeaderColumn
                                dataField = "mailing"
                                dataFormat = {this.cellMail.bind(this)}
                                dataSort = {true}>
                                    Mailing
                            </TableHeaderColumn>
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
