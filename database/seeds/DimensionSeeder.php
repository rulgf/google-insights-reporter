<?php

use Illuminate\Database\Seeder;

class DimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dimension')->truncate();
        
        //User Dimensions-------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'1',
            'nombre' => 'Tipo de Usuario',
            'clave' => 'ga:userType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'1',
            'nombre' => 'Número de Sesiones',
            'clave' => 'ga:sessionCount',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'1',
            'nombre' => 'Días desde la Última Sesión',
            'clave' => 'ga:daysSinceLastSession',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'1',
            'nombre' => 'Valor Definido de Usuario',
            'clave' => 'ga:userDefinedValue',
        ]);

        //Session Dimensions----------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'2',
            'nombre' => 'Duración de Sesión',
            'clave' => 'ga:sessionDurationBucket',
        ]);

        //Traffic Sources Dimensions--------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Ruta de Referencia',
            'clave' => 'ga:referralPath',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Referencia Completa',
            'clave' => 'ga:fullReferrer',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Campaña',
            'clave' => 'ga:campaign',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Fuente',
            'clave' => 'ga:source',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Medio',
            'clave' => 'ga:medium',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Fuente / Medio',
            'clave' => 'ga:sourceMedium',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Palabra Clave',
            'clave' => 'ga:keyword',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Contenido del Anuncio',
            'clave' => 'ga:adContent',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Red Social',
            'clave' => 'ga:socialNetwork',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Fuente de Referencia de Red Social',
            'clave' => 'ga:hasSocialSourceReferral',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'3',
            'nombre' => 'Código de Campaña',
            'clave' => 'ga:campaignCode',
        ]);

        //Adwords Dimensions-------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Grupo Publicitario',
            'clave' => 'ga:adGroup',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Espacio Publicitario',
            'clave' => 'ga:adSlot',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Distribución de Red Publiciatria',
            'clave' => 'ga:adDistributionNetwork',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Tipo de Concordancia de la Consulta',
            'clave' => 'ga:adMatchType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Palabra Clave tipo',
            'clave' => 'ga:adKeywordMatchType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Consulta de Búsqueda',
            'clave' => 'ga:adMatchedQuery',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Dominio de Ubicación',
            'clave' => 'ga:adPlacementDomain',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'URL de Ubicación',
            'clave' => 'ga:adPlacementUrl',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Formato Publicitario',
            'clave' => 'ga:adFormat',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Tipo de Orientación',
            'clave' => 'ga:adTargetingType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Tipo de Emplazamiento',
            'clave' => 'ga:adTargetingOption',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'URL Visible',
            'clave' => 'ga:adDisplayUrl',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'URL de Destino',
            'clave' => 'ga:adDestinationUrl',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'ID de Cliente de Adwords',
            'clave' => 'ga:adwordsCustomerID',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'ID de Campaña de Adwords',
            'clave' => 'ga:adwordsCampaignID',

        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'ID de Grupo de anuncios de AdWords',
            'clave' => 'ga:adwordsAdGroupID',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'ID de creatividad de Adwords',
            'clave' => 'ga:adwordsCreativeID',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Criterio ID de Adwords',
            'clave' => 'ga:adwordsCriteriaID',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'Query Word Count',
            'clave' => 'ga:adQueryWordCount',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'4',
            'nombre' => 'TrueView Video Ad',
            'clave' => 'ga:isTrueViewVideoAd',
        ]);

        //Goal Conversions Dimensions----------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Goal Completion Location',
            'clave' => 'ga:goalCompletionLocation',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Goal Previous Step - 1',
            'clave' => 'ga:goalPreviousStep1',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Goal Previous Step - 2',
            'clave' => 'ga:goalPreviousStep2',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'5',
            'nombre' => 'Goal Previous Step - 3',
            'clave' => 'ga:goalPreviousStep3',
        ]);

        //Platform or Device Dimensions---------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Navegador',
            'clave' => 'ga:browser',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Versión del Navegador',
            'clave' => 'ga:browserVersion',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Sistema Oprativo',
            'clave' => 'ga:operatingSystem',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Versión del Sistema Operativo',
            'clave' => 'ga:operatingSystemVersion',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Marca del Dispositivo Móvil',
            'clave' => 'ga:mobileDeviceBranding',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Modelo del Dispositivo Móvil',
            'clave' => 'ga:mobileDeviceModel',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Selector de Entrada Móvil',
            'clave' => 'ga:mobileInputSelector',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Información del Dispositivo Móvil',
            'clave' => 'ga:mobileDeviceInfo',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Nombre del Dispositivo Móvil en el Mercado',
            'clave' => 'ga:mobileDeviceMarketingName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Categoría del Dispositivo',
            'clave' => 'ga:deviceCategory',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Tamaño del Navegador',
            'clave' => 'ga:browserSize',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'6',
            'nombre' => 'Fuente de Datos',
            'clave' => 'ga:dataSource',
        ]);

        //Geo Network Dimensions---------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Continente',
            'clave' => 'ga:continent',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Sub Continente',
            'clave' => 'ga:subContinent',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'País',
            'clave' => 'ga:country',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Region',
            'clave' => 'ga:region',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Metro',
            'clave' => 'ga:metro',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Ciudad',
            'clave' => 'ga:city',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Latitud',
            'clave' => 'ga:latitude',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Longitud',
            'clave' => 'ga:longitude',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Dominio de Red',
            'clave' => 'ga:networkDomain',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Proveedor del Servicio',
            'clave' => 'ga:networkLocation',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'ID de la Ciudad',
            'clave' => 'ga:cityId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Código ISO del País',
            'clave' => 'ga:countryIsoCode',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Metro Id',
            'clave' => 'ga:metroId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'ID de la Región',
            'clave' => 'ga:regionId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Código ISO de la Región',
            'clave' => 'ga:regionIsoCode',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'7',
            'nombre' => 'Sub Continent Code',
            'clave' => 'ga:subContinentCode',
        ]);

        //System Dimensions----------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'8',
            'nombre' => 'Versión de Flash',
            'clave' => 'ga:flashVersion',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'8',
            'nombre' => 'Soporte de Java',
            'clave' => 'ga:javaEnabled',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'8',
            'nombre' => 'Languaje',
            'clave' => 'ga:language',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'8',
            'nombre' => 'Colores de la Pantalla',
            'clave' => 'ga:screenColors',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'8',
            'nombre' => 'Nombre de la Propiedad de la Fuente de Pantalla',
            'clave' => 'ga:sourcePropertyDisplayName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'8',
            'nombre' => 'ID  de la Propiedad de Rastreo',
            'clave' => 'ga:sourcePropertyTrackingId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'8',
            'nombre' => 'Resolución de la Pantalla',
            'clave' => 'ga:screenResolution',
        ]);

        //Social Activities Dimensions-------------------------------------------------------------------

        //Page Tracking Dimensions-----------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Nombre del Host',
            'clave' => 'ga:hostname',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Página',
            'clave' => 'ga:pagePath',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Ruta de la Página nivel 1',
            'clave' => 'ga:pagePathLevel1',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Ruta de la Página nivel 2',
            'clave' => 'ga:pagePathLevel2',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Ruta de la Página nivel 3',
            'clave' => 'ga:pagePathLevel3',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Ruta de la Página nivel 4',
            'clave' => 'ga:pagePathLevel4',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Título de la Página',
            'clave' => 'ga:pageTitle',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Página de Destino',
            'clave' => 'ga:landingPagePath',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Segunda Página',
            'clave' => 'ga:secondPagePath',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Página de Salida',
            'clave' => 'ga:exitPagePath',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Ruta de la Página Anterior',
            'clave' => 'ga:previousPagePath',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'10',
            'nombre' => 'Ruta de la Página',
            'clave' => 'ga:pageDepth',
        ]);

        //Content Grouping Dimensions--------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'11',
            'nombre' => 'Grupo XX de la Página de Destino',
            'clave' => 'ga:landingContentGroupXX',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'11',
            'nombre' => 'Grupo XX de la Página Anterior',
            'clave' => 'ga:previousContentGroupXX',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'11',
            'nombre' => 'Groupo XX de la Página',
            'clave' => 'ga:contentGroupXX',
        ]);

        //Internal Search Dimensions-----------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Estado de las Búsquedas del Sitio',
            'clave' => 'ga:searchUsed',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Término de Búsqueda',
            'clave' => 'ga:searchKeyword',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Palabra Clave Refinada',
            'clave' => 'ga:searchKeywordRefinement',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Site Search Category',
            'clave' => 'ga:searchCategory',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Página de Inicio',
            'clave' => 'ga:searchStartPage',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Página de Destino',
            'clave' => 'ga:searchDestinationPage',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'12',
            'nombre' => 'Buscar Página de Destino',
            'clave' => 'ga:searchAfterDestinationPage',
        ]);

        //App Tracking Dimensions---------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'ID Instalador de Aplicación',
            'clave' => 'ga:appInstallerId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Versión de la Aplicación',
            'clave' => 'ga:appVersion',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Nombre de la Aplicación',
            'clave' => 'ga:appName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'ID de la Aplicación',
            'clave' => 'ga:appId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Nombre de la Pantalla',
            'clave' => 'ga:screenName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Profundidad de la Pantalla',
            'clave' => 'ga:screenDepth',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Pantalla de Aterrizaje',
            'clave' => 'ga:landingScreenName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'14',
            'nombre' => 'Pantalla de Salida',
            'clave' => 'ga:exitScreenName',
        ]);

        //Event Tracking Dimensions--------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Categoría del Evento',
            'clave' => 'ga:eventCategory',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Acción del Evento',
            'clave' => 'ga:eventAction',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'15',
            'nombre' => 'Etiqueta del Evento',
            'clave' => 'ga:eventLabel',
        ]);

        //Ecommerce Dimensions--------------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'ID de la Transacción',
            'clave' => 'ga:transactionId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Afiliación',
            'clave' => 'ga:affiliation',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Sesiones para la Transacción',
            'clave' => 'ga:sessionsToTransaction',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Dias para la Transacción',
            'clave' => 'ga:daysToTransaction',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Producto SKU',
            'clave' => 'ga:productSku',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Producto',
            'clave' => 'ga:productName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Categoría del Producto',
            'clave' => 'ga:productCategory',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Código de la Moneda',
            'clave' => 'ga:currencyCode',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Opciones de Envío',
            'clave' => 'ga:checkoutOptions',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Creative Promoción Interna',
            'clave' => 'ga:internalPromotionCreative',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'ID de Promoción Interna',
            'clave' => 'ga:internalPromotionId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Nombre de Promoción Interna',
            'clave' => 'ga:internalPromotionName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Posición de Promoción Interna',
            'clave' => 'ga:internalPromotionPosition',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Codigo del Cupón de pedido',
            'clave' => 'ga:orderCouponCode',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Producto de Marca',
            'clave' => 'ga:productBrand',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Categoría del Producto',
            'clave' => 'ga:productCategoryHierarchy',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Categoría del Producto nivel XX',
            'clave' => 'ga:productCategoryLevelXX',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Código del Cupón de Producto',
            'clave' => 'ga:productCouponCode',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Nombre de la Lista del Producto',
            'clave' => 'ga:productListName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Posición de la List adel Producto',
            'clave' => 'ga:productListPosition',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Variante del Producto',
            'clave' => 'ga:productVariant',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'16',
            'nombre' => 'Fase de Compra',
            'clave' => 'ga:shoppingStage',
        ]);

        //Social Interactions Dimensions----------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Red Social',
            'clave' => 'ga:socialInteractionNetwork',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Acción Social',
            'clave' => 'ga:socialInteractionAction',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Red Social y Acción',
            'clave' => 'ga:socialInteractionNetworkAction',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Entidad Social',
            'clave' => 'ga:socialInteractionTarget',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'17',
            'nombre' => 'Tipo Social',
            'clave' => 'ga:socialEngagementType',
        ]);

        //User Timings Dimensions-------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'18',
            'nombre' => 'Categoría del Tiempo',
            'clave' => 'ga:userTimingCategory',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'18',
            'nombre' => 'Etiqueta del Tiempo',
            'clave' => 'ga:userTimingLabel',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'18',
            'nombre' => 'Variable del Tiempo',
            'clave' => 'ga:userTimingVariable',
        ]);

        //Exceptions Dimensions---------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'19',
            'nombre' => 'Descripción de la Excepción',
            'clave' => 'ga:exceptionDescription',
        ]);

        //Content Experiments Dimensions------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'20',
            'nombre' => 'ID de Experimento',
            'clave' => 'ga:experimentId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'20',
            'nombre' => 'Variant',
            'clave' => 'ga:experimentVariant',
        ]);

        //Custom Variables or Columns Dimensions-----------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'21',
            'nombre' => 'Dimensión Personalizada XX',
            'clave' => 'ga:dimensionXX',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'21',
            'nombre' => 'Variable Personalizada (Key XX)',
            'clave' => 'ga:customVarNameXX',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'21',
            'nombre' => 'Variable Personalizada (Value XX)',
            'clave' => 'ga:customVarValueXX',
        ]);

        //Time Dimensions----------------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Fecha',
            'clave' => 'ga:date',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Año',
            'clave' => 'ga:year',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Mes del año',
            'clave' => 'ga:month',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Semana del año',
            'clave' => 'ga:week',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Día del Mes',
            'clave' => 'ga:day',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Hora',
            'clave' => 'ga:hour',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Minuto',
            'clave' => 'ga:minute',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Índice del mes',
            'clave' => 'ga:nthMonth',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Índice de la semana',
            'clave' => 'ga:nthWeek',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Índice del Día',
            'clave' => 'ga:nthDay',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Índice del minuto',
            'clave' => 'ga:nthMinute',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Día de la Semana',
            'clave' => 'ga:dayOfWeek',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Nombre del Día de la Semana',
            'clave' => 'ga:dayOfWeekName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Hora del Día',
            'clave' => 'ga:dateHour',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Month of Year',
            'clave' => 'ga:yearMonth',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Semana del Año',
            'clave' => 'ga:yearWeek',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Semana del Año ISO',
            'clave' => 'ga:isoWeek',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Año ISO',
            'clave' => 'ga:isoYear',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Semana ISO del Año ISO',
            'clave' => 'ga:isoYearIsoWeek',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'22',
            'nombre' => 'Índice de la Hora',
            'clave' => 'ga:nthHour',
        ]);

        //DoubleClick Campaign Manager Dimensions-------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad (GA Model)',
            'clave' => 'ga:dcmClickAd',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad ID (GA Model)',
            'clave' => 'ga:dcmClickAdId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad Type (GA Model)',
            'clave' => 'ga:dcmClickAdType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad Type ID',
            'clave' => 'ga:dcmClickAdTypeId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Advertiser (GA Model)',
            'clave' => 'ga:dcmClickAdvertiser',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Advertiser ID (GA Model)',
            'clave' => 'ga:dcmClickAdvertiserId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Campaign (GA Model)',
            'clave' => 'ga:dcmClickCampaign',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Campaign ID (GA Model)',
            'clave' => 'ga:dcmClickCampaignId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative ID (GA Model)',
            'clave' => 'ga:dcmClickCreativeId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative (GA Model)',
            'clave' => 'ga:dcmClickCreative',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Rendering ID (GA Model)',
            'clave' => 'ga:dcmClickRenderingId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative Type (GA Model)',
            'clave' => 'ga:dcmClickCreativeType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative Type ID (GA Model)',
            'clave' => 'ga:dcmClickCreativeTypeId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative Version (GA Model)',
            'clave' => 'ga:dcmClickCreativeVersion',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Site (GA Model)',
            'clave' => 'ga:dcmClickSite',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Site ID (GA Model)',
            'clave' => 'ga:dcmClickSiteId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Placement (GA Model)',
            'clave' => 'ga:dcmClickSitePlacement',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Placement ID (GA Model)',
            'clave' => 'ga:dcmClickSitePlacementId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Floodlight Configuration ID (GA Model)',
            'clave' => 'ga:dcmClickSpotId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Activity',
            'clave' => 'ga:dcmFloodlightActivity',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Activity and Group',
            'clave' => 'ga:dcmFloodlightActivityAndGroup',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Activity Group',
            'clave' => 'ga:dcmFloodlightActivityGroup',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Activity Group ID',
            'clave' => 'ga:dcmFloodlightActivityGroupId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Activity ID',
            'clave' => 'ga:dcmFloodlightActivityId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Advertiser ID',
            'clave' => 'ga:dcmFloodlightAdvertiserId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Floodlight Configuration ID',
            'clave' => 'ga:dcmFloodlightSpotId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad',
            'clave' => 'ga:dcmLastEventAd',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad ID (DFA Model)',
            'clave' => 'ga:dcmLastEventAdId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad Type (DFA Model)',
            'clave' => 'ga:dcmLastEventAdType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Ad Type ID (DFA Model)',
            'clave' => 'ga:dcmLastEventAdTypeId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Advertiser (DFA Model)',
            'clave' => 'ga:dcmLastEventAdvertiser',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Advertiser ID (DFA Model)',
            'clave' => 'ga:dcmLastEventAdvertiserId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Attribution Type (DFA Model)',
            'clave' => 'ga:dcmLastEventAttributionType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Campaign (DFA Model)',
            'clave' => 'ga:dcmLastEventCampaign',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Campaign ID (DFA Model)',
            'clave' => 'ga:dcmLastEventCampaignId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative ID (DFA Model)',
            'clave' => 'ga:dcmLastEventCreativeId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative (DFA Model)',
            'clave' => 'ga:dcmLastEventCreative',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Rendering ID (DFA Model)',
            'clave' => 'ga:dcmLastEventRenderingId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative Type (DFA Model)',
            'clave' => 'ga:dcmLastEventCreativeType',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative Type ID (DFA Model)',
            'clave' => 'ga:dcmLastEventCreativeTypeId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Creative Version (DFA Model)',
            'clave' => 'ga:dcmLastEventCreativeVersion',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Site (DFA Model)',
            'clave' => 'ga:dcmLastEventSite',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Site ID (DFA Model)',
            'clave' => 'ga:dcmLastEventSiteId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Placement (DFA Model)',
            'clave' => 'ga:dcmLastEventSitePlacement',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Placement ID (DFA Model)',
            'clave' => 'ga:dcmLastEventSitePlacementId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'23',
            'nombre' => 'DFA Floodlight Configuration ID (DFA Model)',
            'clave' => 'ga:dcmLastEventSpotId',
        ]);

        //Audience Dimensions-------------------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'24',
            'nombre' => 'Edad',
            'clave' => 'ga:userAgeBracket',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'24',
            'nombre' => 'Género',
            'clave' => 'ga:userGender',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'24',
            'nombre' => 'Otra Categoría',
            'clave' => 'ga:interestOtherCategory',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'24',
            'nombre' => 'Categoría de Afinidad (reach)',
            'clave' => 'ga:interestAffinityCategory',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'24',
            'nombre' => 'Segmento In-Market',
            'clave' => 'ga:interestInMarketCategory',
        ]);

        //AdSense Dimensions---------------------------------------------------------------------


        //AdExchange Dimensions------------------------------------------------------------------


        //DoubleClick for Publishers Dimensions--------------------------------------------------


        //DoubleClick for Publishers Backfill Dimensions-----------------------------------------


        //Lifetime Value and Cohorts Dimensions--------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Campaña de adquisición',
            'clave' => 'ga:acquisitionCampaign',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Adquisición Media',
            'clave' => 'ga:acquisitionMedium',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Fuente de Adquisición',
            'clave' => 'ga:acquisitionSource',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Fuente de Adquisición / Media',
            'clave' => 'ga:acquisitionSourceMedium',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Canal de Adquisición',
            'clave' => 'ga:acquisitionTrafficChannel',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Cohorte',
            'clave' => 'ga:cohort',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Día',
            'clave' => 'ga:cohortNthDay',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Mes',
            'clave' => 'ga:cohortNthMonth',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'29',
            'nombre' => 'Semana',
            'clave' => 'ga:cohortNthWeek',
        ]);

        //Channel Grouping Dimensions---------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'30',
            'nombre' => 'Agrupación de Canales Predeterminada',
            'clave' => 'ga:channelGrouping',
        ]);

        //Related Products Dimensions----------------------------------------------------------

        DB::table('dimension')->insert([
            'tipo_id' =>'31',
            'nombre' => 'ID del Modelo de Correlación',
            'clave' => 'ga:correlationModelId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'31',
            'nombre' => 'ID del Producto en Consulta',
            'clave' => 'ga:queryProductId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'31',
            'nombre' => 'Nombre del Producto en Consulta',
            'clave' => 'ga:queryProductName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'31',
            'nombre' => 'Variación del Producto en Consulta',
            'clave' => 'ga:queryProductVariation',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'31',
            'nombre' => 'ID del Producto Relacionado',
            'clave' => 'ga:relatedProductId',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'31',
            'nombre' => 'Nombre del Producto Relacionado',
            'clave' => 'ga:relatedProductName',
        ]);

        DB::table('dimension')->insert([
            'tipo_id' =>'31',
            'nombre' => 'Variación del Producto Relacionado',
            'clave' => 'ga:relatedProductVariation',
        ]);

    }
}