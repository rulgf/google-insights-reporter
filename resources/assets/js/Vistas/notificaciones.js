/**
 * Created by SOFTAM03 on 9/13/16.
 */

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


export default class Notificaciones extends  React.Component{

    constructor(props) {
        super(props);

        this.botonesRutas = this.botonesRutas.bind(this);

        var cuenta = null;
        var label = "";

        if(this.props.activeCount != null){
            cuenta = this.props.activeCount;
            label = this.props.activeCount.label;
        }

        this.state = {
            //Metricas
            notificaciones: [],

            //Campos modal
            id: 0,

            //Modal Consultar/Modificar/Eliminar
            openModal: false,
            action: null,

            //Tabla
            datos: [],

            //Errores
            errors: [],
            erroropen:false,

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
        
        this.cargarNotificaciones();
    }

    //Get Notificaciones
    cargarNotificaciones(){
        $.ajax({
            type: 'GET',
            url: 'notifications',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Guardo los datos
                var notificaciones=[];
                for(var i =0; i<data.length; i++){
                    notificaciones.push({
                        read: data[i].is_read,
                        id: data[i].id,
                        subject: data[i].subject,
                        content: data[i].body,
                        date: new Date(data[i].sent_at.replace(/-/g, "/")).toDateString(),
                        rutas: data[i].id
                    });
                }
                this.setState({notificaciones: notificaciones});


            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Handlers---------------

    //Handlers Componentes---------------------
    handleCloseError(){
        this.setState({erroropen: false});
    }

    handleResponse(data) {
        this.setState({
            selectedCuentaObj: data,
            selectedCuenta: data,
            selectedCuentaLbl: data.label
        });
    }

    //Leo la notificacion para cambiar su estado a "leida"
    readNotificacion(id){

        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'PUT',
            url: 'notifications/'+id,
            context: this,
            dataType: 'json',
            cache: false,
            data:{
                _token: token,
            },
            success: function (data) {
                //Guardo los datos y cambio estados de la modal y de la accion
                if(data.errors){
                    //Si hay errores guardarlos
                    this.setState({
                        errors: data.errors,
                        erroropen: true
                    }, function () {
                        this.cargarNotificaciones();
                    });
                }else{
                    this.cargarNotificaciones();
                    this.props.handlenotifications();//ejecuto la funcion del padre
                }

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
                //Leer notificacion
                React.createElement("button", {
                        className: "btn btn-icon-toggle",
                        "data-toggle": "tooltip",
                        "data-placement": "top",
                        "data-original-title": "Modificar",
                        onTouchTap:this.readNotificacion.bind(this, e)},
                    React.createElement("i", { className: "fa fa-check" })
                )
            )
        );
    }


    //Funcion para darle un nombre a los renglones
    trClassFormat(rowData,rIndex){
        return rowData.read==0?'unread':'';
    }

    render() {

        return(
            <div id="content">
                <section className="has-actions no-bottom">
                    <div className="section-body">
                        <div className = "section-header">
                            <h2 className = "text-primary">Notificaciones</h2>
                        </div>
                        <BootstrapTable data={this.state.notificaciones}
                                        trClassName={this.trClassFormat.bind(this)}
                                        pagination={true}
                                        options={{ noDataText :"No hay Notificaciones"}}
                                        hover={true}
                                        search={true}>
                            <TableHeaderColumn hidden = "true" dataField="read">read</TableHeaderColumn>
                            <TableHeaderColumn hidden = "true" dataField="id" isKey = {true}>n.º</TableHeaderColumn>
                            <TableHeaderColumn dataField = "subject" dataSort = {true}>Cuenta</TableHeaderColumn>
                            <TableHeaderColumn dataField = "content" dataSort = {true}>Evento</TableHeaderColumn>
                            <TableHeaderColumn dataField = "date" dataSort = {true}>Fecha</TableHeaderColumn>
                            <TableHeaderColumn dataField = "rutas"  dataFormat={this.botonesRutas} />
                        </BootstrapTable>
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
