/**
 * Created by SOFTAM03 on 10/10/16.
 */
import   React from 'react';
import  SideMenubar from '../Componentes/menubar';
import  Header from '../Componentes/header';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import getMuiTheme from 'material-ui/styles/getMuiTheme';

import  Componente_Footer from '../Componentes/footer';
import Dialog from 'material-ui/Dialog';
import FlatButton from 'material-ui/FlatButton';
import { BootstrapTable, TableHeaderColumn } from 'react-bootstrap-table';
import TextField from 'material-ui/TextField';
import Snackbar from 'material-ui/Snackbar';
import {SimpleSelect, MultiSelect, ReactSelectize} from 'react-selectize';
import Drawer from 'material-ui/Drawer';

import $ from 'jquery';

import {
    cyan500, cyan700,
    pinkA200, blue500,
    grey100, grey300, grey400, grey500,
    white, darkBlack, fullBlack, lightBlue600
} from 'material-ui/styles/colors';

const muiTheme = getMuiTheme({
    palette: {
        pickerHeaderColor: lightBlue600,

    },
    datePicker: {
        selectColor: lightBlue600,
    },
    flatButton: {
        primaryTextColor: lightBlue600,
    },
    textField: {
        floatingLabelColor: lightBlue600,
        focusColor: lightBlue600,
    },
    tabs: {
        backgroundColor: lightBlue600,
    },
    fontFamily: 'QanelasRegular',
});

export default class Layout extends  React.Component{
    constructor(props){
        super(props);

        this.state ={
            selectedCuenta: null,
            open: false,

            //notifications
            unread:0,
        };

        this.handlenotifications = this.handlenotifications.bind(this)
    }

    componentDidMount(){
        this.notificacionesUnread();
    }

    handleResponse(data) {
        this.setState({selectedCuenta: data});
    }

    handleToggle(){
        this.setState({open: !this.state.open});
    }

    /*drawerInfo(){
        return(
            <div>
                <RaisedButton
                    label="Toggle Drawer"
                    onTouchTap={this.handleToggle}
                />
                <Drawer width={200} openSecondary={true} open={this.state.open} >
                    
                </Drawer>
            </div>
        );
    }*/

    //Obtengo el numero de notificaciones sin leer
    notificacionesUnread(){
        $.ajax({
            type: 'GET',
            url: 'unread',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Obtener las opciones de la consulta
                this.setState({unread: data}, function () {
                    //console.log(this.state.unread);
                });
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    //Funcion para mandar al hijo
    handlenotifications(){
        this.notificacionesUnread();
    }
    
    render(){
        return(
            <MuiThemeProvider muiTheme={muiTheme}>
                <div>
                    <Header
                        handleResponse={this.handleResponse.bind(this)}
                        activeCount={this.state.selectedCuenta}
                        unRead={this.state.unread}
                    />
                    <div id="base">
                        <div className="offcanvas"></div>
                            {React.cloneElement(this.props.children, { activeCount: this.state.selectedCuenta, handlenotifications: this.handlenotifications})}
                        <SideMenubar/>
                    </div>
                </div>
            </MuiThemeProvider>
        );
    }
}