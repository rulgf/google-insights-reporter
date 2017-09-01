

//Defaults
import   React from 'react';
import { Router, Route, Link } from 'react-router';

import TextField from 'material-ui/TextField';

export default class SideMenubar extends  React.Component{

    constructor(props) {
        super(props);
        this.adaptarHTML = this.adaptarHTML.bind(this);

        this.state = {
            id: this.props.activeCount
        }
    }

    adaptarHTML(){
        var label= "";
        if(this.props.activeCount && this.props.activeCount != "undefined"){
            label = "/"+this.props.activeCount.label;
        }else{
            label = "";
        }

        //console.log(this.props.activeCount);



        return (
            <div id="menubar" className="menubar-inverse ">
                <div className="menubar-fixed-panel">
                    <div>
                        <a className="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
                            <i className="fa fa-bars"></i>
                        </a>
                    </div>
                    <div className="expanded">
                        <a href="">
                            <span className="text-lg text-bold text-primary ">DOOD</span>
                        </a>
                    </div>
                </div>
                <div className="menubar-scroll-panel">

                    <ul id="main-menu" className="gui-controls">
                        <li>
                            <Link to={"/"}>
                                <div className="gui-icon"><i className="fa fa-home"></i></div>
                                <span className="title">Dashboard</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/cuentas"}>
                                <div className="gui-icon"><i className="md md-work"></i></div>
                                <span className="title">Cuentas</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/queryexplorer"+label}>
                                <div className="gui-icon"><i className="md md-search"></i></div>
                                <span className="title">Query Explorer</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/metricas"+label}>
                                <div className="gui-icon"><i className="fa fa-calculator"></i></div>
                                <span className="title">Metricas</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/dimensiones"+label}>
                                <div className="gui-icon"><i className="fa fa-columns"></i></div>
                                <span className="title">Dimensiones</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/reportes"+label}>
                                <div className="gui-icon"><i className="fa fa-line-chart"></i></div>
                                <span className="title">Reportes</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/alertas"+label}>
                                <div className="gui-icon"><i className="fa fa-bell-o"></i></div>
                                <span className="title">Alertas</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/semaforos"+label}>
                                <div className="gui-icon"><i className="fa fa-bullhorn"></i></div>
                                <span className="title">Semaforos</span>
                            </Link>
                        </li>
                        <li>
                            <Link to={"/palabras"+label}>
                                <div className="gui-icon"><i className="fa fa-font"></i></div>
                                <span className="title">Palabras</span>
                            </Link>
                        </li>
                    </ul>

                    <div className="menubar-foot-panel">
                        <small className="no-linebreak hidden-folded">
                            <span className="opacity-75">Copyright &copy; 2016</span><strong> DOOD</strong>
                        </small>
                    </div>
                </div>
            </div>
        );
    }

    render() {
        //console.log(this.props.activeCount);
        return(
            this.adaptarHTML()
        );
    }
}