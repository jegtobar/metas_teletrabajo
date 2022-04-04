
<!DOCTYPE html>
<html>
<link rel="shortcut icon" href="images/favicon2.png">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Page title -->
    <title>Dashboard Metas</title>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="vendor/animate.css/animate.css" />
    
    <link rel="stylesheet" href="vendor/toastr/build/toastr.min.css" />
    
    <!-- App styles -->
    <link rel="stylesheet" href="fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="vendor/bootstrap/dist/css/bootstrap.css" />

   <!-- vuetify -->
   <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
 


    <script src="vue/vue.js"></script>
    <style>
        .progress {
            margin-top: 27px;
        }
        #divSeccion{
            margin-top: 27px;
        }
        

    </style>

</head>
<body class="fixed-sidebar hide-sidebar">


<!-- Main Wrapper -->

<div id="app">

<div class="normalheader transition animated fadeIn">
    <div class="hpanel">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-2">
                    <img alt="logo"  style="height: 75px" src="img/logo_catastro.png">
                </div>
                <div class="col-md-10">
                    <h2 class="font-light m-b-xs" style="margin-top: 12px; ">
                        Direcci&oacute;n de Catastro y Administraci&oacute;n del IUSI.
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content animate-panel">
<div class="row">
	<div class="col-lg-4 col-md4">
        <div id="rendSemanal">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h4 class="font-light m-b-xs" style="margin-top: 12px; ">
                        Actividades Regulares 
                    </h4>
                </div>

                <div class="panel-body">
                <div class="row">
                        <div class="col-md-9">
                            <div class="progress">
                                
                                <div :class="'progress-bar ' + rendimiento_semanal.bar_style" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" :style="'min-width: 3em; width: ' + rendimiento_semanal.rendimiento + '%'">
                                    {{ rendimiento_semanal.realizado }}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <h2 :class="rendimiento_semanal.text_style">
                                {{ rendimiento_semanal.meta }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div id="rendPoa">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h4 class="font-light m-b-xs" style="margin-top: 12px; cursor: pointer; " @click="dialog = true">
                        Actividades POA 
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="progress">

                                <div :class="'progress-bar ' + rendimiento_poa.bar_style" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" :style="'min-width: 3em; width: ' + rendimiento_poa.rendimiento + '%'">
                                    {{ rendimiento_poa.realizado }}
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <h2 :class="rendimiento_poa.text_style">
                                {{ rendimiento_poa.meta }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-4">
        <div id="rendPoa">
            <div class="panel panel-default">
                <div class="panel-heading"> 
                    <h4 class="font-light m-b-xs" style="margin-top: 12px; ">
                        Rendimiento Semanal
                    </h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="text-center">
                            <h1 :class="rendimientoPromedio.text_style" style="font-size: 40px; margin-left: 150px;">
                            <b> {{rendimientoPromedio.rendimiento }}%</b>
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                    <div class="panel-heading" > 
                        <h4 class="font-light m-b-xs" style="margin-top: 12px; cursor: pointer;" v-on:click="fetchDetailAll()">
                            Secciones
                        </h4>
                    </div>
                    <div class="panel-body">
                        <div class="row" v-for="(seccion, key) in secciones" :key="key">
                            <div style="cursor: pointer;" v-on:click="fetchDetail(seccion)" class="col-md-3" id="divSeccion">
                            <h4><span :class="seccion.selected ? ' label label-success' : '' " >{{seccion.DESCRIPCION}}</span></h4>
                            </div>
                            <div class="col-md-2" id="divSeccion">
                                <!-- <span class="label label-default">{{ seccion.REALIZADO }}</span> / 
                                <span class="label label-default">{{ seccion.META }}</span> -->
                            </div>
                            <div class="col-md-5">
                                <div class="progress">
                                    <div :class="'progress-bar ' + seccion.bar_style" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" :style="'min-width: 2em; width: ' + seccion.cumplimientop + '%'">
                                        {{ seccion.cumplimientop }}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <h1 :class="seccion.text_style">
                                    {{ seccion.cumplimientop }}%
                                </h1>
                            </div>
                        </div>
                        
    
</div>
</div>
</div>
</div>

        <!-- Detalle -->

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">POA</a></li>
        </ul>

        <br>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <table class="table table-striped">
                     <thead>
                        <tr>
                            <th width="50%">Descripción</th>
                            <th width="15%">Modalidad</th>
                            <th width="10%">Tipo</th>
                            <th width="10%">Realizado</th>
                            <th width="10%">Meta</th>
                            <th width="5%">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(meta, key) in metas_poa" :key="key">
                            <td>
                                {{ meta.NOMBRE }}
                            </td>
                            <td>
                                {{ meta.MODALIDAD }}
                            </td>
                            <td>
                                {{ meta.TIPO }}
                            </td>
                            <td>
                                {{ meta.REALIZADO }}
                            </td>
                            <td>
                                {{ meta.META }}
                            </td>
                            <td class="meta.COLORTEXT">
                            <p :class="meta.COLORTEXT"><b> {{ meta.PROMEDIO }}</b></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Actividades Regulares</a></li>
        </ul>

        <br>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Descripción</th>
                                <th width="15%">Modalidad</th>
                                <th width="10%">Tipo</th>
                                <th width="10%">Realizado</th>
                                <th width="10%">Meta</th>
                                <th width="5%">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(meta, key) in metas_regulares" :key="key">
                                <td>
                                    {{ meta.NOMBRE }}
                                </td>
                                <td>
                                    {{ meta.MODALIDAD }}
                                </td>
                                <td>
                                    {{ meta.TIPO }}
                                </td>
                                <td>
                                    {{ meta.REALIZADO }}
                                </td>
                                <td>
                                    {{ meta.META }}
                                </td>
                                <td>
                                   <p :class="meta.COLORTEXT"><b> {{ meta.PROMEDIO }}</b></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Actividades Temporales</a></li>
        </ul>

        <br>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Descripción</th>
                                <th width="15%">Modalidad</th>
                                <th width="10%">Tipo</th>
                                <th width="10%">Realizado</th>
                                <th width="10%">Meta</th>
                                <th width="5%">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(meta, key) in metas_temporales" :key="key">
                                <td>
                                    {{ meta.NOMBRE }}
                                </td>
                                <td>
                                    {{ meta.MODALIDAD }}
                                </td>
                                <td>
                                    {{ meta.TIPO }}
                                </td>
                                <td>
                                    {{ meta.REALIZADO }}
                                </td>
                                <td>
                                    {{ meta.META }}
                                </td>
                                <td>
                                   <p :class="meta.COLORTEXT"><b> {{ meta.PROMEDIO }}</b></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Adicionales</a></li>
        </ul>

        <br>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="50%">Actividad</th>
                                <th width="25%">Modalidad</th>
                                <th width="10%">Realizado</th>
                                <th width="10%">Meta</th>
                                <th width="5%">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(meta, key) in metas_adicionales" :key="key">
                                <td>
                                    {{ meta.NOMBRE }}
                                </td>
                                <td>
                                    {{ meta.MODALIDAD }}
                                </td>
                                <td>
                                    {{ meta.REALIZADO }}
                                </td>
                                <td>
                                    {{ meta.META }}
                                </td>
                                <td>
                                <p :class="meta.COLORTEXT"><b> {{ meta.PROMEDIO }}</b></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

<div data-app>
      <MyComponent />
</div>

<template>
  <div class="text-center">
    <v-dialog
      v-model="dialog"
      width="800"
    >
      <!-- <template v-slot:activator="{ on, attrs }">
        <v-btn
          color="red lighten-2"
          dark
          v-bind="attrs"
          v-on="on"
        >
          Click Me
        </v-btn>
      </template> -->

      <v-card>
        <v-card-title class="text-h5 grey lighten-2">
          Consolidado Meta Poa Programado
        </v-card-title>

        <v-card-text>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="progress">

                            <div :class="'progress-bar ' + rendimientoPoaProgramado.bar_style" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" :style="'min-width: 3em; width: ' + rendimientoPoaProgramado.porcentaje + '%'">
                                {{ rendimientoPoaProgramado.ejecutado }}
                            </div>

                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <h2 :class="rendimientoPoaProgramado.text_style">
                            {{ rendimientoPoaProgramado.programado }}
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                    <h2>Rendimiento: </h2>    
                    <h2 :class="rendimiento_poa.text_style">
                           <b> {{ rendimientoPoaProgramado.porcentaje}}%<b/>
                        </h2>
                    </div>
                </div>
            </div>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="dialog = false"
          >
            Cerrar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<!-- Vendor scripts -->
<script type="application/javascript" src="vendor/jquery/dist/jquery.min.js"></script>
<script type="application/javascript" src="vendor/jquery-ui/jquery-ui.min.js"></script>
<script type="application/javascript" src="vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script type="application/javascript" src="vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- App scripts -->
<script src="vuetify/vue.js"></script>
<script src="vuetify/vuetify.js"></script>
 
    
<script>

    var app = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: {
            message: 'Hello Vue!',
            lista_metas_general: [],
            rendimiento_global :[],
            secciones: [],
            metas_poa: [],
            rendimientoPromedio:[],
            rendimientoPoaProgramado:[],
            promedioStyle:[],
            metas_regulares: [],
            metas_adicionales: [],
            metas_temporales:[],
            rendimiento_semanal: {},
            rendimiento_poa: {},
            dialog: false,
        },
        methods: {

            fetchData(){

                const queryString = window.location.search;

                const urlParams = new URLSearchParams(queryString);

                const codarea = urlParams.get('area')
                const id_periodo = urlParams.get('id_periodo')
     
                fetch('get_indicadores_without_auth.php', {
                    method: 'POST',
                    mode: 'no-cors',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        codarea: codarea,
                        id_periodo: id_periodo
                    })
                })
                .then(response => response.json())
                .then(data => {
                    this.lista_metas_general = data.lista_metas_general
                    this.rendimiento_poa = data.rendimiento_poa
                    this.rendimiento_semanal = data.rendimiento_semanal
                    this.secciones = data.secciones
                    this.rendimiento_global = data.rendimiento_global
                    this.rendimientoPromedio = data.rendimientoSemanalPromedio
                    this.rendimientoPoaProgramado = data.rendimiento_poa_programado
                })

            },
            fetchDetail(seccion){
                this.secciones.forEach(element => {
                    element.selected = false
                });
                seccion.selected = true
                const queryString = window.location.search;

                const urlParams = new URLSearchParams(queryString);

                const id_periodo = urlParams.get('id_periodo')

                fetch('get_detalle_indicadores_without_auth.php', {
                    method: 'POST',
                    mode: 'no-cors',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        codarea: seccion.CODAREA,
                        id_periodo: id_periodo
                    })
                })
                .then(response => response.json())
                .then(data => {
                    this.metas_poa = data.metas_poa
                    this.metas_regulares = data.metas_regulares
                    this.metas_adicionales = data.metas_adicionales
                    this.metas_temporales = data.metas_temporales
                
                })
            },

            fetchDetailAll(){

                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                const codarea = urlParams.get('area')
                const id_periodo = urlParams.get('id_periodo')

                
               
            fetch('get_metas_all_without_auth.php', {
                method: 'POST',
                mode: 'no-cors',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    codarea: codarea,
                    id_periodo: id_periodo
                })
            })
            .then(response => response.json())
            .then(data => {
                this.metas_poa = data.metas_poa
                this.metas_regulares = data.metas_regulares
                this.metas_adicionales = data.metas_adicionales
               
            })
            }
        },
        mounted(){
            this.fetchData()
            this.fetchDetailAll()
        }
    })

</script>

</body>
</html>