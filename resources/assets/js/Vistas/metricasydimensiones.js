//Defaults
import   React from 'react';
import  SideMenubar from '../Componentes/menubar';
import  Header from '../Componentes/header';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import {Tabs, Tab} from 'material-ui/Tabs';

const styles = {
    headline: {
        fontSize: 24,
        paddingTop: 16,
        marginBottom: 12,
        fontWeight: 400,
    },
};


//Armo la vista
export default class MetDim extends  React.Component{

    constructor(props) {
        super(props);

        this.state = {

            //Tabs
            value: 'a',

            //Cuenta seleccionada
            selectedCuenta: this.props.params.siteId,
            selectedCuentaObj: {},
            selectedCuentaLbl: ""
        }
    }

    //Handler obligatorio para la cuenta global
    handleResponse(data) {
        this.setState({selectedCuenta: data});
    }

    handleChangeTabs(e){
        this.setState({
            value: e,
        })
    }

    render() {
        return(
            <MuiThemeProvider>
                <div>
                    <Header handleResponse={this.handleResponse.bind(this)} activeCount={this.state.selectedCuenta}/>
                    <div id="base">
                        <div className="offcanvas"></div>
                        <div id="content">
                            <section className="has-actions">
                                <div className="section-body">
                                    <div className = "section-header">
                                        <h2 className = "text-primary">Metricas y Dimensiones</h2>
                                    </div>
                                    <Tabs
                                        value={this.state.value}
                                        onChange={this.handleChangeTabs.bind(this)}
                                    >
                                        <Tab label="Tab A" value="a" >
                                            <div>
                                                <h2 style={styles.headline}>Controllable Tab A</h2>
                                                <p>
                                                    Tabs are also controllable if you want to programmatically pass them their values.
                                                    This allows for more functionality in Tabs such as not
                                                    having any Tab selected or assigning them different values.
                                                </p>
                                            </div>
                                        </Tab>
                                        <Tab label="Tab B" value="b">
                                            <div>
                                                <h2 style={styles.headline}>Controllable Tab B</h2>
                                                <p>
                                                    This is another example of a controllable tab. Remember, if you
                                                    use controllable Tabs, you need to give all of your tabs values or else
                                                    you wont be able to select them.
                                                </p>
                                            </div>
                                        </Tab>
                                    </Tabs>
                                </div>
                            </section>
                        </div>
                        <SideMenubar activeCount={this.state.selectedCuentaObj}/>
                    </div>
                </div>
            </MuiThemeProvider>
        );
    }
}