//Defaults
import  React from 'react';
import { Router, Route, Link } from 'react-router';


class Componente_Footer extends  React.Component{

    constructor(props) {
        super(props);
        this.adaptarHTML = this.adaptarHTML.bind(this);
        this.state ={
            agregar : this.props.agregar
        };
    }

    adaptarHTML(){
        return (

            <div className="section-action style-primary">
                <div className="section-action-row">
                    
                </div>
                <div className="section-floating-action-row">
                    <a className="btn ink-reaction btn-floating-action btn-lg btn-accent" onTouchTap={this.state.agregar} data-toggle="tooltip" data-placement="top" data-original-title="Agregar">
                        <i className="md md-add"></i>
                    </a>
                </div>
            </div>
        );
    }

    render() {
        return(
            this.adaptarHTML()
        );
    }
}

export default Componente_Footer;