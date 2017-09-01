<?php

use Illuminate\Database\Seeder;

class MetricaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('metrica')->truncate();

        //User Metricas-------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => 'Usuarios',
            'clave' => 'ga:users',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => 'Nuevos Usuarios',
            'clave' => 'ga:newUsers',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => '% Nuevas Sesiones',
            'clave' => 'ga:percentNewSessions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => '1 Día Usuarios Activos',
            'clave' => 'ga:1dayUsers',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => '7 Días Usuarios Activos',
            'clave' => 'ga:7dayUsers',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => '14 Días Usuarios Activos',
            'clave' => 'ga:14dayUsers',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => '30 Días Usuarios Activos',
            'clave' => 'ga:30dayUsers',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'1',
            'nombre' => 'Número de Sesiones por Usuario',
            'clave' => 'ga:sessionsPerUser',
        ]);

        // Session Metrics--------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'2',
            'nombre' => 'Sesiones',
            'clave' => 'ga:sessions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'2',
            'nombre' => 'Rebotes',
            'clave' => 'ga:bounces',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'2',
            'nombre' => '% de Rebote',
            'clave' => 'ga:bounceRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'2',
            'nombre' => 'Duración de la Sesión',
            'clave' => 'ga:sessionDuration',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'2',
            'nombre' => '% de Duración de la Sesión',
            'clave' => 'ga:avgSessionDuration',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'2',
            'nombre' => 'Hits',
            'clave' => 'ga:hits',
        ]);

        //Traffic Sources Metrics------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Búsquedas Orgánicas',
            'clave' => 'ga:organicSearches',
        ]);

        //Adwords Metrics---------------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Impresiones',
            'clave' => 'ga:impressions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Clicks',
            'clave' => 'ga:adClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Costo',
            'clave' => 'ga:adCost',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'CPM',
            'clave' => 'ga:CPM',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'CPC',
            'clave' => 'ga:CPC',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'CTR',
            'clave' => 'ga:CTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Costo por Transacción',
            'clave' => 'ga:costPerTransaction',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Costo por Conversión de Objetivos',
            'clave' => 'ga:costPerGoalConversion',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Costo por Conversión',
            'clave' => 'ga:costPerConversion',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'RPC',
            'clave' => 'ga:RPC',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'4',
            'nombre' => 'ROAS',
            'clave' => 'ga:ROAS',
        ]);

        //Goal Conversion Metrics---------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Objetivo XX Empieza',
            'clave' => 'ga:goalXXStarts',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Empieza Objetivos',
            'clave' => 'ga:goalStartsAll',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Goal XX Completions',
            'clave' => 'ga:goalXXCompletions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Consecución de Objetivos',
            'clave' => 'ga:goalCompletionsAll',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Objetivo XX Valor',
            'clave' => 'ga:goalXXValue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Valor de Objetivos',
            'clave' => 'ga:goalValueAll',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Valor del Objetivo por Sesión',
            'clave' => 'ga:goalValuePerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Objetivo XX Procentaje de Conversión',
            'clave' => 'ga:goalXXConversionRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Objetivo Porcentaje de Conversión',
            'clave' => 'ga:goalConversionRateAll',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Objetivo XX Abandoned Funnels',
            'clave' => 'ga:goalXXAbandons',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Abandoned Funnels',
            'clave' => 'ga:goalAbandonsAll',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Objetivo XX Porcentaje de Abandono',
            'clave' => 'ga:goalXXAbandonRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Porcentaje de Abandono Total',
            'clave' => 'ga:goalAbandonRateAll',
        ]);

        //Platform or Device Metrics-------------------------------------------------------------

        //Geo Network Metrics--------------------------------------------------------------------

        //System Metrics-------------------------------------------------------------------------

        //Social Activities Metrics--------------------------------------------------------------

        //Page Tracking Metrics------------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Valor de Página',
            'clave' => 'ga:pageValue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Entradas',
            'clave' => 'ga:entrances',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Entradas / Páginas Vistas',
            'clave' => 'ga:entranceRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Páginas Vistas',
            'clave' => 'ga:pageviews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Páginas / Sesión',
            'clave' => 'ga:pageviewsPerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Páginas Vistas Únicas',
            'clave' => 'ga:uniquePageviews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Tiempo en la página',
            'clave' => 'ga:timeOnPage',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Tiempo promedio en una Página',
            'clave' => 'ga:avgTimeOnPage',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Salidas',
            'clave' => 'ga:exits',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'10',
            'nombre' => '% de Salida',
            'clave' => 'ga:exitRate',
        ]);

        //Content Grouping Metrics-------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'11',
            'nombre' => 'Unicas Vistas XX',
            'clave' => 'ga:contentGroupUniqueViewsXX',
        ]);

        //Internal Search Metrics---------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Páginas Vistas por Resultados',
            'clave' => 'ga:searchResultViews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Total de Búsquedas Unicas',
            'clave' => 'ga:searchUniques',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Resultados de Páginas Vistas / Búsqueda',
            'clave' => 'ga:avgSearchResultViews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Sesiones con Búsqueda',
            'clave' => 'ga:searchSessions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => '% de Sesiones con Búsqueda',
            'clave' => 'ga:percentSessionsWithSearch',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Búsqueda en Profundidad',
            'clave' => 'ga:searchDepth',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Promedio de Búsqueda en Profundidad',
            'clave' => 'ga:avgSearchDepth',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Search Refinements',
            'clave' => 'ga:searchRefinements',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => '% Search Refinements',
            'clave' => 'ga:percentSearchRefinements',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Time after Search',
            'clave' => 'ga:searchDuration',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Tiempo despúes de Búsqueda',
            'clave' => 'ga:avgSearchDuration',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Salidas de Búsqueda',
            'clave' => 'ga:searchExits',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => '% de Salidas de Búsqueda',
            'clave' => 'ga:searchExitRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Site Search Goal XX Conversion Rate',
            'clave' => 'ga:searchGoalXXConversionRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Site Search Goal Conversion Rate',
            'clave' => 'ga:searchGoalConversionRateAll',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Per Search Goal Value',
            'clave' => 'ga:goalValueAllPerSearch',
        ]);

        //Site Speed Metrics-----------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo de Carga de la Página (ms)',
            'clave' => 'ga:pageLoadTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Carga de la Página de Muestra',
            'clave' => 'ga:pageLoadSample',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio de Carga de la Página de Muestra (sec)',
            'clave' => 'ga:avgPageLoadTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo de Búsqueda del Dominio (ms)',
            'clave' => 'ga:domainLookupTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio del Tiempo de Búsqueda del Dominio (sec)',
            'clave' => 'ga:avgDomainLookupTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo de Descarga de la Página(ms)',
            'clave' => 'ga:pageDownloadTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio de Tiempo de Descarga de la Página (sec)',
            'clave' => 'ga:avgPageDownloadTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo de Redirección (ms)',
            'clave' => 'ga:redirectionTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio del Tiempo de Redirección (sec)',
            'clave' => 'ga:avgRedirectionTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo de Conexión al Servidor (ms)',
            'clave' => 'ga:serverConnectionTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio del Tiempo de Conexión al Servidor(sec)',
            'clave' => 'ga:avgServerConnectionTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo de Respuesta del Servidor (ms)',
            'clave' => 'ga:serverResponseTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio del Tiempo de Respuesta del Servidor (sec)',
            'clave' => 'ga:avgServerResponseTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Velocidad de Metricas Muestra',
            'clave' => 'ga:speedMetricsSample',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo Documento Interactivo (ms)',
            'clave' => 'ga:domInteractiveTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio del Tiempo Documento Interactivo (sec)',
            'clave' => 'ga:avgDomInteractiveTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Tiempo de Descarga del Documento (ms)',
            'clave' => 'ga:domContentLoadedTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'Promedio del Tiempo de Descarga del Documento (sec)',
            'clave' => 'ga:avgDomContentLoadedTime',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'13',
            'nombre' => 'DOM Latency Metrics Sample',
            'clave' => 'ga:domLatencyMetricsSample',
        ]);

        //App Tracking Metrics------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Vistas de Pantalla',
            'clave' => 'ga:screenviews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Vista de Pantallas Unicas',
            'clave' => 'ga:uniqueScreenviews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Pantallas / Sesión',
            'clave' => 'ga:screenviewsPerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Tiempo en Pantalla',
            'clave' => 'ga:timeOnScreen',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Promedio del Tiempo en Pantalla',
            'clave' => 'ga:avgScreenviewDuration',
        ]);

        //Event Tracking Metrics-----------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Eventos Totales',
            'clave' => 'ga:totalEvents',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Eventos Unicos',
            'clave' => 'ga:uniqueEvents',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Valor de Evento',
            'clave' => 'ga:eventValue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Valor Promedio',
            'clave' => 'ga:avgEventValue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Sesiones con Evento',
            'clave' => 'ga:sessionsWithEvent',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Eventos / Sesiones con Evento',
            'clave' => 'ga:eventsPerSessionWithEvent',
        ]);

        //Ecommerce Metrics-------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Transacciones',
            'clave' => 'ga:transactions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Porcentaje de Conversión Ecommerce',
            'clave' => 'ga:transactionsPerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Ingresos',
            'clave' => 'ga:transactionRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Promedio de Ingresos en Pedidos',
            'clave' => 'ga:revenuePerTransaction',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Ingresos por Sesión',
            'clave' => 'ga:transactionRevenuePerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Envío',
            'clave' => 'ga:transactionShipping',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Impuesto',
            'clave' => 'ga:transactionTax',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Valor Total',
            'clave' => 'ga:totalValue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Cantidad',
            'clave' => 'ga:itemQuantity',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Compras Unicas',
            'clave' => 'ga:uniquePurchases',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Precio Promedio',
            'clave' => 'ga:revenuePerItem',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Ingresos de Producto',
            'clave' => 'ga:itemRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Average QTY',
            'clave' => 'ga:itemsPerPurchase',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Ingreso Local',
            'clave' => 'ga:localTransactionRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Envío Local',
            'clave' => 'ga:localTransactionShipping',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Impuesto Local',
            'clave' => 'ga:localTransactionTax',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Ingresos de Productos Locales',
            'clave' => 'ga:localItemRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Buy-to-Detail Rate',
            'clave' => 'ga:buyToDetailRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Cart-to-Detail Rate',
            'clave' => 'ga:cartToDetailRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'CTR de Promoción Interna',
            'clave' => 'ga:internalPromotionCTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Clicks de Promociones Internas',
            'clave' => 'ga:internalPromotionClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Vista de Promoción Interna',
            'clave' => 'ga:internalPromotionViews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Cantidad de Reembolso del Producto Local',
            'clave' => 'ga:localProductRefundAmount',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Cantidad de Devolución Total',
            'clave' => 'ga:localRefundAmount',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Productos Añadidos al Carro',
            'clave' => 'ga:productAddsToCart',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Checkouts de Producto',
            'clave' => 'ga:productCheckouts',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Product Detail Views',
            'clave' => 'ga:productDetailViews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'CTR de Producto de Lista',
            'clave' => 'ga:productListCTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Clicks de Producto de Lista',
            'clave' => 'ga:productListClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Vistas de Producto de Lista',
            'clave' => 'ga:productListViews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Importe de Devolución del Producto',
            'clave' => 'ga:productRefundAmount',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Devolución de Productos',
            'clave' => 'ga:productRefunds',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Product Removes From Cart',
            'clave' => 'ga:productRemovesFromCart',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Product Revenue per Purchase',
            'clave' => 'ga:productRevenuePerPurchase',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Quantity Added To Cart',
            'clave' => 'ga:quantityAddedToCart',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Quantity Checked Out',
            'clave' => 'ga:quantityCheckedOut',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Quantity Refunded',
            'clave' => 'ga:quantityRefunded',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Quantity Removed From Cart',
            'clave' => 'ga:quantityRemovedFromCart',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Refund Amount',
            'clave' => 'ga:refundAmount',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Revenue per User',
            'clave' => 'ga:revenuePerUser',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Refunds',
            'clave' => 'ga:totalRefunds',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Transactions per User',
            'clave' => 'ga:transactionsPerUser',
        ]);

        //Social Interactions Metrics-----------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Social Actions',
            'clave' => 'ga:socialInteractions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Unique Social Actions',
            'clave' => 'ga:uniqueSocialInteractions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Actions Per Social Session',
            'clave' => 'ga:socialInteractionsPerSession',
        ]);

        //User Timings Metrics------------------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'18',
            'nombre' => 'User Timing (ms)',
            'clave' => 'ga:userTimingValue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'18',
            'nombre' => 'User Timing Sample',
            'clave' => 'ga:userTimingSample',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'18',
            'nombre' => 'Avg. User Timing (sec)',
            'clave' => 'ga:avgUserTimingValue',
        ]);

        //Exceptions Metrics----------------------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'19',
            'nombre' => 'Exceptions',
            'clave' => 'ga:exceptions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'19',
            'nombre' => 'Exceptions / Screen',
            'clave' => 'ga:exceptionsPerScreenview',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'19',
            'nombre' => 'Crashes',
            'clave' => 'ga:fatalExceptions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'19',
            'nombre' => 'Crashes / Screen',
            'clave' => 'ga:fatalExceptionsPerScreenview',
        ]);

        //Content Experiment Metrics -------------------------------------------------------------------

        //Custom Variables or Columns Metrics-----------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'21',
            'nombre' => 'Custom Metric XX Value',
            'clave' => 'ga:metricXX',
        ]);

        //Time Metrics-----------------------------------------------------------------------------------

        //DoubleClick Campaign Manager-------------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Conversions',
            'clave' => 'ga:dcmFloodlightQuantity',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Revenue',
            'clave' => 'ga:dcmFloodlightRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA CPC',
            'clave' => 'ga:dcmCPC',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA CTR',
            'clave' => 'ga:dcmCTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Clicks',
            'clave' => 'ga:dcmClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Cost',
            'clave' => 'ga:dcmCost',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Impressions',
            'clave' => 'ga:dcmImpressions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA ROAS',
            'clave' => 'ga:dcmROAS',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA RPC',
            'clave' => 'ga:dcmRPC',
        ]);

        //Audience Metrics----------------------------------------------------------------

        //AdSense Metrics-----------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'Devolución de AdSense',
            'clave' => 'ga:adsenseRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'Bloques de Anuncio Vistos de AdSense',
            'clave' => 'ga:adsenseAdUnitsViewed',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'Impresiones AdSense',
            'clave' => 'ga:adsenseAdsViewed',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'AdSense Ads Clicked',
            'clave' => 'ga:adsenseAdsClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'Impresiones de Página AdSense',
            'clave' => 'ga:adsensePageImpressions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'AdSense CTR',
            'clave' => 'ga:adsenseCTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'AdSense eCPM',
            'clave' => 'ga:adsenseECPM',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'Salidas AdSense',
            'clave' => 'ga:adsenseExits',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'AdSense Viewable Impression %',
            'clave' => 'ga:adsenseViewableImpressionPercent',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'25',
            'nombre' => 'AdSense Coverage',
            'clave' => 'ga:adsenseCoverage',
        ]);

        //Ad Exchange Metrics-----------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Impressions',
            'clave' => 'ga:adxImpressions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Coverage',
            'clave' => 'ga:adxCoverage',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Monetized Pageviews',
            'clave' => 'ga:adxMonetizedPageviews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Impressions / Session',
            'clave' => 'ga:adxImpressionsPerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Viewable Impressions %',
            'clave' => 'ga:adxViewableImpressionsPercent',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Clicks',
            'clave' => 'ga:adxClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX CTR',
            'clave' => 'ga:adxCTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Revenue',
            'clave' => 'ga:adxRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX Revenue / 1000 Sessions',
            'clave' => 'ga:adxRevenuePer1000Sessions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'26',
            'nombre' => 'AdX eCPM',
            'clave' => 'ga:adxECPM',
        ]);

        //DoubleClick for Publishers Metrics-------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'Impresiones DFP',
            'clave' => 'ga:dfpImpressions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'Cobertura DFP',
            'clave' => 'ga:dfpCoverage',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP Monetized Pageviews',
            'clave' => 'ga:dfpMonetizedPageviews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP Impressions / Session',
            'clave' => 'ga:dfpImpressionsPerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP Viewable Impressions %',
            'clave' => 'ga:dfpViewableImpressionsPercent',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP Clicks',
            'clave' => 'ga:dfpClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP CTR',
            'clave' => 'ga:dfpCTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP Revenue',
            'clave' => 'ga:dfpRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP Revenue / 1000 Sessions',
            'clave' => 'ga:dfpRevenuePer1000Sessions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'27',
            'nombre' => 'DFP eCPM',
            'clave' => 'ga:dfpECPM',
        ]);

        //DoubleClick for Publishers Backfill Metrics-------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Impressions',
            'clave' => 'ga:backfillImpressions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Coverage',
            'clave' => 'ga:backfillCoverage',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Monetized Pageviews',
            'clave' => 'ga:backfillMonetizedPageviews',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Impressions / Session',
            'clave' => 'ga:backfillImpressionsPerSession',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Viewable Impressions %',
            'clave' => 'ga:backfillViewableImpressionsPercent',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Clicks',
            'clave' => 'ga:backfillClicks',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill CTR',
            'clave' => 'ga:backfillCTR',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Revenue',
            'clave' => 'ga:backfillRevenue',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill Revenue / 1000 Sessions',
            'clave' => 'ga:backfillRevenuePer1000Sessions',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'28',
            'nombre' => 'DFP Backfill eCPM',
            'clave' => 'ga:backfillECPM',
        ]);

        //Lifetime Value and Cohorts Metrics-----------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Usuarios',
            'clave' => 'ga:cohortActiveUsers',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Appviews per User',
            'clave' => 'ga:cohortAppviewsPerUser',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Appviews Per User (LTV)',
            'clave' => 'ga:cohortAppviewsPerUserWithLifetimeCriteria',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Goal Completions per User',
            'clave' => 'ga:cohortGoalCompletionsPerUser',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Goal Completions Per User (LTV)',
            'clave' => 'ga:cohortGoalCompletionsPerUserWithLifetimeCriteria',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Pageviews per User',
            'clave' => 'ga:cohortPageviewsPerUser',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Pageviews Per User (LTV)',
            'clave' => 'ga:cohortPageviewsPerUserWithLifetimeCriteria',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'User Retention',
            'clave' => 'ga:cohortRetentionRate',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Revenue per User',
            'clave' => 'ga:cohortRevenuePerUser',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Revenue Per User (LTV)',
            'clave' => 'ga:cohortRevenuePerUserWithLifetimeCriteria',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Session Duration per User',
            'clave' => 'ga:cohortSessionDurationPerUser',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Session Duration Per User (LTV)',
            'clave' => 'ga:cohortSessionDurationPerUserWithLifetimeCriteria',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Sessions per User',
            'clave' => 'ga:cohortSessionsPerUser',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Sessions Per User (LTV)',
            'clave' => 'ga:cohortSessionsPerUserWithLifetimeCriteria',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Total Users',
            'clave' => 'ga:cohortTotalUsers',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Users',
            'clave' => 'ga:cohortTotalUsersWithLifetimeCriteria',
        ]);

        //Channel Grouping Metrics--------------------------------------------------------------

        //Related Products Metrics--------------------------------------------------------------

        DB::table('metrica')->insert([
            'tipo_id' =>'31',
            'nombre' => 'Correlation Score',
            'clave' => 'ga:correlationScore',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'31',
            'nombre' => 'Queried Product Quantity',
            'clave' => 'ga:queryProductQuantity',
        ]);

        DB::table('metrica')->insert([
            'tipo_id' =>'31',
            'nombre' => 'Related Product Quantity',
            'clave' => 'ga:relatedProductQuantity',
        ]);

    }
}
