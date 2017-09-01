//Defaults
import   React from 'react';
import  SideMenubar from '../Componentes/menubar';
import  Header from '../Componentes/header';
import {Card, CardActions, CardHeader, CardText, CardTitle} from 'material-ui/Card';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';

import $ from 'jquery';

//Armo la vista
export default class Api extends  React.Component{

    constructor(props) {
        super(props);
        this.state={
            general: false,
            cuentas: false,
            query: false,
            metricas: false,
            reportes: false,
            alertas: false
        }
    }

    componentWillMount(){

    }


    adaptarHTML(){

        return (
            <div id="content">
                <section className="has-actions">
                    <div className="section-body">
                        <div className="row text-center">
                            <h3>API</h3>
                        </div>
                        <div>
                            <List>
                                <Subheader>Nested List Items</Subheader>
                                <ListItem
                                    primaryText="General"
                                    primaryTogglesNestedList={true}
                                    nestedItems={[
                                        <ListItem
                                          key={1}
                                          primaryText="Menú principal"
                                          nestedItems={[
                                            <ListItem
                                                key={1}
                                                primaryText="Seleccionar Cuenta"
                                                secondaryText={
                                                    <p>
                                                      El MultiSelect del Menú principal nos mostrara las cuentas que se encuentran en el sistema,
                                                      La cuenta que se seleccione será la cuenta con la que interactuara el sistema.<br/>
                                                      Se puede seleccionar con que cuenta se trabajara en cualquier vista
                                                    </p>
                                                }
                                            />,
                                            <ListItem
                                                key={1}
                                                primaryText="Usuario"
                                                secondaryText={
                                                    <p>
                                                      El MultiSelect del Menú principal nos mostrara las cuentas que se encuentran en el sistema,
                                                      La cuenta que se seleccione será la cuenta con la que interactuara el sistema.<br/>
                                                      Se puede seleccionar con que cuenta se trabajara en cualquier vista
                                                    </p>
                                                }
                                            />,
                                          ]}
                                        />,
                                        <ListItem
                                          key={2}
                                          primaryText="Menu lateral"
                                          leftIcon={<ContentSend />}
                                          disabled={true}
                                          nestedItems={[
                                            <ListItem key={1} primaryText="Drafts" leftIcon={<ContentDrafts />} />,
                                          ]}
                                        />
                                    ]}
                                />


                                <ListItem primaryText="Cuentas"/>
                                <ListItem primaryText="Query Explorer"/>
                                <ListItem primaryText="Metricas y Dimensiones"/>
                                <ListItem primaryText="Reportes"/>
                                <ListItem primaryText="Alertas y Notificaciones"/>

                                <ListItem
                                    primaryText="Inbox"
                                    leftIcon={<ContentInbox />}
                                    initiallyOpen={true}
                                    primaryTogglesNestedList={true}
                                    nestedItems={[
                                <ListItem
                                  key={1}
                                  primaryText="Starred"
                                />,
                                <ListItem
                                  key={2}
                                  primaryText="Sent Mail"
                                  leftIcon={<ContentSend />}
                                  disabled={true}
                                  nestedItems={[
                                    <ListItem key={1} primaryText="Drafts" leftIcon={<ContentDrafts />} />,
                                  ]}
                                />,
                                <ListItem
                                  key={3}
                                  primaryText="Inbox"
                                  leftIcon={<ContentInbox />}
                                  open={this.state.open}
                                  onNestedListToggle={this.handleNestedListToggle}
                                  nestedItems={[
                                    <ListItem key={1} primaryText="Drafts" leftIcon={<ContentDrafts />} />,
                                  ]}
                                />,
                              ]}
                                                />
                                            </List>
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