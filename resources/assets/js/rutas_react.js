// ES6 transpiler babel


//Librerias
import   React from 'react';
import   ReactDOM from 'react-dom';
import { Router, Route, IndexRoute, hashHistory, Link } from 'react-router'

//Componentes
import  Dashboard from './Vistas/dashboard';
import  QueryExplorer from './Vistas/queryexplorer';
import  Cuentas from './Vistas/cuentas';
import  Metricas from './Vistas/metricas';
import  Dimensiones from './Vistas/dimensiones';
import  MetDim from './Vistas/metricasydimensiones';
import  Reportes from './Vistas/reportes';
import  Reporte from './Vistas/reporte';
import  alertas from './Vistas/alertas';
import  Notificaciones from './Vistas/notificaciones';
import  consultaReportealt from './Vistas/consultaReportealt';
import  Layout from './Componentes/layout';
import  Api from './Vistas/api.js';
import  Semaforos from './Vistas/semaforos';
import  palabras from './Vistas/palabras';

// Needed for onTouchTap
// http://stackoverflow.com/a/34015469/988941

import injectTapEventPlugin from 'react-tap-event-plugin';
injectTapEventPlugin();


ReactDOM.render((
    <Router history={hashHistory}>
        <Route path="/" component={Layout}>
                <IndexRoute component={Dashboard}/>
                <Route path="queryexplorer(/:siteId)" component={QueryExplorer}/>
                <Route path="Cuentas(/:siteId)" component={Cuentas}/>
                <Route path="metricas(/:siteId)" component={Metricas}/>
                <Route path="dimensiones(/:siteId)" component={Dimensiones}/>
                <Route path="metdim(/:siteId)" component={MetDim}/>
                <Route path="reportes(/:siteId)" component={Reportes}/>
                <Route path="reporte/:siteId/:reporte" component={Reporte}/>
                <Route path="alertas(/:siteId)" component={alertas}/>
                <Route path="notificaciones(/:siteId)" component={Notificaciones}/>
                <Route path="consultalt/:siteId/:reporteId" component={consultaReportealt}/>
                <Route path="semaforos(/:siteId)" component={Semaforos}/>
                <Route path="api(/:siteId)" component={Api}/>
                <Route path="palabras(/:siteId)" component={palabras}/>
        </Route>
    </Router>
), document.getElementById('app'))