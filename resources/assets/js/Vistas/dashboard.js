//Defaults
import   React from 'react';
import  SideMenubar from '../Componentes/menubar';
import  Header from '../Componentes/header';
import {Card, CardActions, CardHeader, CardText, CardTitle} from 'material-ui/Card';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import FlatButton from 'material-ui/FlatButton';

import $ from 'jquery';

//Armo la vista
export default class Dashboard extends  React.Component{

    constructor(props) {
        super(props);

        this.state = {
            selectedCuenta: this.props.activeCount,
            reports: [],
            cards: [],
            counts: [],
            counts_i: [],
            countcards: [],

            refresh: false
        };

    }

    componentWillMount(){
        this.loadActiveRecords();
        this.loadActiveCounts();
        this.loadInactiveCounts();
    }

    handleResponse(data) {
        this.setState({selectedCuenta: data});
    }

    loadActiveRecords(){
        $.ajax({
            type: 'GET',
            url: 'reportesactives',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Obtener los reportes activos
                var reports=[];
                for(var i =0; i < data.length; i++){
                    reports.push(
                        {
                            key: data[i].id,
                            id: data[i].id,
                            nombre: data[i].nombre,
                            descripcion: data[i].descripcion,
                            cuenta: data[i].cuenta.nombre,
                            cliente: data[i].cuenta.nombre_cliente,
                            mail: data[i].cuenta.mail_cliente,
                        }
                    );
                }
                this.setState({reports: reports}, function(){
                    this.loadCards()
                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    loadActiveCounts(){
        $.ajax({
            type: 'GET',
            url: 'cuentasactives',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Obtener las cuentas activas
                var counts=[];
                for(var i =0; i < data.length; i++){
                    counts.push(
                        {
                            key: data[i].id,
                            id: data[i].id,
                            nombre: data[i].nombre,
                            siteId: data[i].siteId,
                            cliente: data[i].nombre_cliente,
                            semaforo: data[i].semaforo_state,
                            semaforos: data[i].semaforo,
                            mail: data[i].mail_cliente
                        }
                    );
                }
                this.setState({counts: counts}, function(){
                    this.loadCuentas()
                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    loadInactiveCounts(){
        $.ajax({
            type: 'GET',
            url: 'cuentasinactives',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                console.log(data);
                //Obtener las cuentas inactivas
                var counts=[];
                for(var i =0; i < data.length; i++){
                    counts.push(
                        {
                            key: data[i].id,
                            id: data[i].id,
                            nombre: data[i].nombre,
                            siteId: data[i].siteId,
                            cliente: data[i].nombre_cliente,
                            semaforo: data[i].semaforo_state,
                            semaforos: data[i].semaforo,
                            mail: data[i].mail_cliente
                        }
                    );
                }
                this.setState({counts_i: counts}, function(){
                    this.loadCuentasIn();
                });

            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    handleUpdate(e, id){
        
        $.ajax({
            type: 'GET',
            url: 'execsemaforos/' + e,
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Cargar de nuevo las cuentas
                this.loadActiveCounts();
                this.loadInactiveCounts();
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }

    handleSemaforos(){

        $.ajax({
            type: 'GET',
            url: 'execall',
            context: this,
            dataType: 'json',
            cache: false,
            success: function (data) {
                //Cargar de nuevo las cuentas
                this.loadActiveCounts();
                this.loadInactiveCounts();
            }.bind(this),
            error: function (xhr, status, err) {
                //Error
                console.error(this.props.url, status, err.toString());
            }.bind(this)
        });
    }


    loadCards(){
        var reports = this.state.reports;
        var cards =[];
        for(var i =0; i < reports.length; i++){
            cards.push(
                <div className="col-md-4">
                    <Card>
                        <CardHeader
                            title={reports[i].nombre}
                            subtitle={reports[i].cuenta}
                            actAsExpander={true}
                            showExpandableButton={true}
                        />
                        <CardText>
                           {reports[i].descripcion}
                        </CardText>
                        <CardText expandable={true}>
                            <div className="col-md-6"><strong>{reports[i].cliente}</strong></div>
                            <div className="col-md-6">{reports[i].mail}</div>
                            <br/>
                        </CardText>

                    </Card>
                </div>
            )
        }
        return cards;

    }

    loadCuentas(){
        var counts = this.state.counts;
        var cards =[];
        for(var i =0; i < counts.length; i++){
            //Creo la lista de semaforos
            var sems = [];
            for(var s =0; s < counts[i].semaforos.length; s++){
                var cond = '';
                if(counts[i].semaforos[s].condicion == 1){
                    cond = '>';
                }else if(counts[i].semaforos[s].condicion == 2){
                    cond = '<';
                }else if(counts[i].semaforos[s].condicion == 3){
                    cond = '!=';
                }

                if(counts[i].semaforos[s].estado == 0){
                    sems.push(
                        <div className="checked col-md-12"><i className="fa fa-check"/>{
                            counts[i].semaforos[s].nombre + ': ' + counts[i].semaforos[s].obtained
                        }</div>
                    );
                }else{
                    sems.push(
                        <div className="unchecked col-md-12"><i className="fa fa-times"/>{
                            counts[i].semaforos[s].nombre + ': ' + counts[i].semaforos[s].obtained + ' ' + cond + ' ' + counts[i].semaforos[s].parametro
                        }</div>
                    );
                }
            }

            var imagen ='';
            var card_class = '';
            if(counts[i].semaforo==0){
                card_class ='alert alert-callout alert-success no-margin';
            } else if(counts[i].semaforo==1){
                card_class ='alert alert-callout alert-warning no-margin';
            } else if(counts[i].semaforo==2){
                card_class ='alert alert-callout alert-danger no-margin';
            }

            if(sems.length == 0){
                sems.push(<div className="col-md-12">No hay resumen disponible</div>);
            }

            cards.push(
                <div className="col-md-4 count-card">
                    <Card className={card_class}>
                        <CardHeader
                            title={counts[i].nombre}
                            subtitle={counts[i].siteId}
                            actAsExpander={true}
                            showExpandableButton={true}
                        />
                        <CardHeader
                            title="Resumen semanal:"
                            expandable={true}
                        />
                        <CardText expandable={true}>
                            {sems}
                            <br/>
                        </CardText>
                        <CardActions expandable={true}>
                            <div className="update-btn">
                                <FlatButton
                                    label="Refresh"
                                    primary={true}
                                    icon={<i className="fa fa-refresh"/>}
                                    onTouchTap={this.handleUpdate.bind(this, counts[i].id)}
                                />
                            </div>
                        </CardActions>
                    </Card>
                </div>
            )
        }
        return cards;
    }

    loadCuentasIn(){
        var counts = this.state.counts_i;
        var cards =[];

        //console.log(counts);

        for(var i =0; i < counts.length; i++){
            //Creo la lista de semaforos
            var sems = [];
            for(var s =0; s < counts[i].semaforos.length; s++){
                var cond = '';
                if(counts[i].semaforos[s].condicion == 1){
                    cond = '>';
                }else if(counts[i].semaforos[s].condicion == 2){
                    cond = '<';
                }else if(counts[i].semaforos[s].condicion == 3){
                    cond = '!=';
                }

                if(counts[i].semaforos[s].estado == 0){
                    sems.push(
                        <div className="checked col-md-12"><i className="fa fa-check"/>{
                            counts[i].semaforos[s].nombre + ': ' + counts[i].semaforos[s].obtained
                        }</div>
                    );
                }else{
                    sems.push(
                        <div className="unchecked col-md-12"><i className="fa fa-times"/>{
                            counts[i].semaforos[s].nombre + ': ' + counts[i].semaforos[s].obtained + ' ' + cond + ' ' + counts[i].semaforos[s].parametro
                        }</div>
                    );
                }
            }

            var imagen ='';
            var card_class = 'alert alert-callout alert-inactive no-margin';

            if(sems.length == 0){
                sems.push(<div className="col-md-12">No hay resumen disponible</div>);
            }

            cards.push(
                <div className="col-md-4 count-card">
                    <Card className={card_class}>
                        <CardHeader
                            title={counts[i].nombre}
                            subtitle={counts[i].siteId}
                            actAsExpander={true}
                            showExpandableButton={true}
                        />
                        <CardHeader
                            title="Resumen semanal:"
                            expandable={true}
                        />
                        <CardText expandable={true}>
                            {sems}
                            <br/>
                        </CardText>
                        <CardActions expandable={true}>
                            <div className="update-btn">
                                <FlatButton
                                    label="Refresh"
                                    primary={true}
                                    icon={<i className="fa fa-refresh"/>}
                                    onTouchTap={this.handleUpdate.bind(this, counts[i].id)}
                                />
                            </div>
                        </CardActions>
                    </Card>
                </div>
            )
        }
        return cards;
    }

    adaptarHTML(){

        if(this.props.activeCount != null){
            var cuenta = this.props.activeCount.name
        }else{
            var cuenta ='';
        }

        return (
        <div id="content">
            <section className="has-actions no-bottom">
                <div className="section-body">
                    <div className = "section-header col-md-12">
                        <div className="col-md-12" style={{textAlign: "right"}}>
                            <FlatButton
                                label="Refresh"
                                primary={true}
                                icon={<i className="fa fa-refresh"/>}
                                onTouchTap={this.handleSemaforos.bind(this)}
                            />
                        </div>
                    </div>
                    <div className="row text-center">
                        <h3>Cuentas</h3>
                    </div>
                    <div className="row">
                        {this.loadCuentas()}
                    </div>
                    <div className="row text-center">
                        <h3>Cuentas Inactivas</h3>
                    </div>
                    <div className="row">
                        {this.loadCuentasIn()}
                    </div>
                </div>
            </section>
        </div>
        );
    }

    render() {
        return(
            this.adaptarHTML()
        );
    }
}