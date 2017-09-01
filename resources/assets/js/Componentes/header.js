//Defaults
import  React from 'react';
import { Router, Route, Link } from 'react-router';

import $ from 'jquery';

import {SimpleSelect, MultiSelect, ReactSelectize} from 'react-selectize';
import Badge from 'material-ui/Badge';
import IconButton from 'material-ui/IconButton';
import NotificationsIcon from 'material-ui/svg-icons/social/notifications'

class Header extends  React.Component{

    constructor(props) {
        super(props);

        this.cargarCuentas = this.cargarCuentas.bind(this);
        this.sinCuentas = this.sinCuentas.bind(this);
        
        this.state ={

            //Estados de cuentas
            cuentas: [],
            selectedCuenta:null,
            activeCount: {},

            user:'',
            avatar:'',

            unread:0,
        };
    }

    componentDidMount() {
        this.cargarCuentas();
        this.cargarCuentaActiva();
        this.getUser();
    }

    getUser(){
        $.ajax({
            type: 'GET',
            url: 'user',
            context: this,
            cache: false,
            success: function (data) {
                //console.log(data);
                this.setState({
                    user: data[0],
                    avatar: data[1]
                });
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    cargarCuentaActiva(){
        $.ajax({
            type: 'GET',
            url: 'cuenta/'+this.props.activeCount,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Obtener las opciones de la consulta
                this.setState({activeCount: data}, function () {
                    //console.log(this.state.activeCount);
                });
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }
    
    cargarCuentas(){
        $.ajax({
            type: 'GET',
            url: 'cuentas',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Obtener las opciones de la consulta
                this.setState({cuentas: data});

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    customCuenta(item){
        return <div className="simple-option">
            <div className="col-md-12 topOption">
                <div className="col-md-12 customname" style={{fontSize: "80%"}}>
                    {item.name}
                </div>
            </div>

            <div className="col-md-12 bottomOption">
                <div className="col-md-12 customlabel" style={{fontSize: "60%"}}>
                    {item.label}
                </div>
            </div>
        </div>
    }

    //Metodo que se activa cuando no hay resultados
    sinCuentas(){
        return React.createElement("div", {className: "no-results-found"},
            !!self.req ? "Cargando ..." : "No hay Cuentas"
        )
    }

    handleCuentas(e){
        this.setState({
            selectedCuenta: e,
            activeCount: e
        });
        this.props.handleResponse(e);
    }

    //Rendereo los objetos seleccionados del multiselect
    customValue(item){
        return <div>
            <span>
                {item.name}
            </span>
        </div>
    }

    render() {
        if(this.props.activeCount != null){
            if(this.props.activo ==false ){
                var selectCuenta = [<SimpleSelect
                    className = "input-formMUI principal-select"
                    placeholder = "Selecciona una cuenta"
                    theme = "material"
                    options = {this.state.cuentas}
                    style = {{ width: '100%'}}
                    renderNoResultsFound = {this.sinCuentas}
                    renderOption = {this.customCuenta.bind(this)}
                    onValueChange={this.handleCuentas.bind(this)}
                    renderValue={this.customValue.bind(this)}
                    value={this.state.activeCount}
                    disabled={true}
                />];
            }else{
                var selectCuenta = [<SimpleSelect
                    className = "input-formMUI principal-select"
                    placeholder = "Selecciona una cuenta"
                    theme = "material"
                    options = {this.state.cuentas}
                    style = {{ width: '100%'}}
                    renderNoResultsFound = {this.sinCuentas}
                    renderOption = {this.customCuenta.bind(this)}
                    onValueChange={this.handleCuentas.bind(this)}
                    renderValue={this.customValue.bind(this)}
                    value={this.state.activeCount}
                />];
            }

        }else{
            var selectCuenta = [<SimpleSelect
                className = "input-formMUI principal-select"
                placeholder = "Selecciona una cuenta"
                theme = "material"
                options = {this.state.cuentas}
                style = {{ width: '100%'}}
                renderNoResultsFound = {this.sinCuentas}
                renderOption = {this.customCuenta.bind(this)}
                renderValue={this.customValue.bind(this)}
                onValueChange={this.handleCuentas.bind(this)}
            />];
        }

        var numeronot = "0";

        if(this.state.unread > 9){
            numeronot = "9+";
        }else if(this.state.unread == 0){
            numeronot = "";
        }else{
            numeronot = this.state.unread;
        }

        var label= "";
        if(this.state.selectedCuenta){
            label = "/"+this.state.selectedCuenta.label;
        }else{
            label = "";
        }

        return(
            <header id="header" >
                <div className="headerbar">
                    <div className="headerbar-left">
                        <ul className="header-nav header-nav-options">
                            <li className="header-nav-brand" >
                                <div className="brand-holder">
                                    <Link to={"/"} id="dash-btn">
                                        <img src="./public/img/insights_logo.svg" alt="Logo"/>
                                    </Link>
                                </div>
                            </li>
                            <li>
                                <a className="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                                    <i className="fa fa-bars"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div className="headerbar-right">
                        <ul className="header-nav header-nav-options">
                            <li>
                                {selectCuenta}
                            </li>
                        </ul>
                        <ul className="header-nav header-nav-profile">
                            <li className="dropdown">
                                <a href="javascript:void(0);" className="dropdown-toggle ink-reaction" data-toggle="dropdown">
                                    <img src={this.state.avatar} alt="Usuario" />
								<span className="profile-info">
                                    {this.state.user}
								</span>
                                </a>
                                <ul className="dropdown-menu animation-dock">
                                    <li><a href="./logout"><i className="fa fa-fw fa-power-off text-danger"></i> Salir</a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul className="header-nav header-nav-options notify-ul">
                            <li className="notify-element">
                                <Link to={"/notificaciones" + label}>
                                    <Badge
                                        badgeContent={this.props.unRead}
                                        primary={true}
                                        badgeStyle={{top: 15, right: 20}}
                                    >
                                        <IconButton tooltip="Notificaciones">
                                            <NotificationsIcon />
                                        </IconButton>
                                    </Badge>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
        );
    }
}
export default Header;