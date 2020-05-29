new Vue({
  el: 'main',
  data: {
    codigoDoc: '',
    titulo: 'Lista Departamentos',
    subtitulo: 'Departamento',
    url: 'http://192.168.1.35/repoEstado/',
    usuario: '',
    documentosFaltantes: [],
    departamento_iddepartamento: '',
    mostrar: false,
    codigo: '',
    cantidadEstados: '',
    estadosMen: [],
    cantidadEstadosMen: '',
    estadosMenNotificaciones: '',
    estadosNotificaciones: [],
    estados: [],
    usuarios: [],
    departamentos: [],
    deptos: []
  },
  methods: {

    async exportarExcel() {

      var url = this.url + 'exportarExcel';
      document.location.target = "_blank";
      document.location.href = url;
      toastr.success('Exportando a excel', 'Notificacion');


    },

    async cargarModal()
    {
      $("#modal-overlay").modal("show");
    },

    async limpiar() {
      this.codigo = '';
    },

    async getDepartamentos() {
      var url = this.url + 'getDepartamentos';
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.departamentos = res.data;
	this.deptos = res.data;
      }).catch(e => {
	console.log(e);
      });
    },
    async cargarUsuarios() {
      var letra = this.departamento_iddepartamento;
      this.getUsuarios(letra);
      console.log(letra);
    },

    async getUsuarios(iddepartamento) {
      var url = this.url + 'getUsuarios';
      param = new FormData();
      param.append('iddepartamento', iddepartamento);
      var data = await axios.post(url, param).then(res => {
	console.log(res.data);
	this.usuarios = res.data;
      }).catch(e => {
	console.log(e);
      });
    },

    async barChart() {

      let deptos = '';
      var depto_nombres = [];
      var nombres = [];
      var documentos = [];
      var url = this.url + 'faltantesDepartamentos';
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.documentosFaltantes = res.data.datos;
	var docFaltantes = this.documentosFaltantes;
	for (var i = 0; i < docFaltantes.length; i++) {
	  nombres.push(docFaltantes[i].depto_nombre);
	  documentos.push(docFaltantes[i].documentosProceso);
	}
      }).catch(e => {
	console.log(e);
      });

      console.log(depto_nombres);

      console.log(this.departamentos);
      $(document).ready(function () {

	var ctx = document.getElementById('myChart');
	var chart = new Chart(ctx, {
	  // The type of chart we want to create
	  type: 'bar',
	  // The data for our dataset	  
	  data: {
	    labels: nombres,
	    datasets: [
	      {
		label: 'Pendientes',
		backgroundColor: 'rgb(255, 40, 60)',
		borderColor: 'rgb(0ss, 0, 0)',
		data: documentos
	      }]
	  },

	  // Configuration options go here
	  options: {
	    responsive: true,
	    lineTension: 1,
	    scales: {
	      yAxes: [{
		  ticks: {
		    beginAtZero: true,
		    padding: 25,
		  }
		}]
	    }
	  }
	});
      });

    },

    async pendientesPorUsuario() {

      let deptos = '';
      var depto_nombres = [];
      var nombres = [];
      var apellidos = [];
      var cantidad = [];
      var nombresCom = '';



      var url = this.url + 'faltantesUsuarios';
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.documentosFaltantes = res.data.datos;
	var docFaltantes = this.documentosFaltantes;
	for (var i = 0; i < docFaltantes.length; i++) {

	  nombresCom = docFaltantes[i].nombre + ' ' + docFaltantes[i].apellido;

	  nombres.push(docFaltantes[i].nombre);
	  apellidos.push(docFaltantes[i].apellido);
	  cantidad.push(docFaltantes[i].cantidad);
	}
      }).catch(e => {
	console.log(e);
      });




      $(document).ready(function () {

	var ctx = document.getElementById('pendientesPorUsuario');

	var str = nombresCom.substring(0, 5);

	console.log(str);

	var chart = new Chart(ctx, {
	  // The type of chart we want to create
	  type: 'horizontalBar',
	  // The data for our dataset	  
	  data: {
	    labels: nombres,
	    datasets: [
	      {
		label: 'Pendientes',
		backgroundColor: 'rgb(255, 40, 60)',
		borderColor: 'rgb(0ss, 0, 0)',
		data: cantidad
	      }]
	  },

	  // Configuration options go here
	  options: {
	    responsive: true,
	    lineTension: 1,
	    scales: {
	      yAxes: [{
		  ticks: {
		    beginAtZero: true,
		    padding: 25,
		  }
		}]
	    }
	  }
	});


      });

    },

    async estadosUnicos() {
      moment.locale('es');
      var url = this.url + 'getDocumentosNotificaciones';
      param = new FormData();
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.estados = res.data.estados;
	this.estadosMen = res.data.estadosMen;

	var estadosMen = res.data.estadosMen;
	var estados = res.data.estados;

	var estadosUnicosProcesados = [];

	var j = 0;
	var k = 0;
	for (var i = 0; i < this.estados.length; i++) {
	  if (this.estados[i].estado_nombre == 'EN PROCESO') {
	    estadosUnicosProcesados.push(this.estados[i]);
	    j++;
	    if (j == 4) {
	      break;
	    }
	  }
	}

	for (var i = 0; i < this.estados.length; i++) {
	  if (this.estados[i].estado_nombre == 'EN PROCESO') {
	    k++;
	  }
	}

	var estadosMenUnicos = [];

	var y = 0;
	var w = 0;
	for (var i = 0; i < this.estadosMen.length; i++) {
	  if (this.estadosMen[i].estado_nombre == 'PROCESO') {
	    estadosMenUnicos.push(this.estadosMen[i]);
	    y++;
	    if (y == 4) {
	      break;
	    }
	  }
	}

	for (var i = 0; i < this.estadosMen.length; i++) {
	  if (this.estadosMen[i].estado_nombre == 'PROCESO') {
	    w++;
	  }
	}

	this.estadosMenNotificaciones = estadosMenUnicos;
	this.cantidadEstadosMen = w;

	var docusMen = this.estadosMenNotificaciones;

	this.estadosNotificaciones = estadosUnicosProcesados;
	this.cantidadEstados = k;

	var docus = this.estadosNotificaciones;

	for (var i = 0; i < docus.length; i++) {
	  var desc = docus[i].docu_descripcion;
	  var str = desc.substring(0, 8);
	  var desc2 = docus[i].docu_nombre;
	  var str2 = desc2.substring(0, 8);
	  docus[i].docu_descripcion_corta = str;
	  docus[i].docu_nombre_corta = str2;
	  var fechaHora = docus[i].docu_fecha_ingreso;
	  var fechaComp = moment(fechaHora).format("YYYY/MM/DD HH:mm:ss");
	  var now = moment();
	  var fechaAct = moment().format('YYYY/MM/DD HH:mm:ss');
	  var falta = moment(fechaComp, "YYYY/MM/DD HH:mm:ss").fromNow();

	  var fecha1 = moment(fechaAct, "YYYY/MM/DD HH:mm:ss");
	  var fecha2 = moment(fechaComp, "YYYY/MM/DD HH:mm:ss");

	  var now = fecha1;
	  var end = fecha2;
	  var duration = moment.duration(now.diff(end));
	  var days = duration.days();
	  var hours = duration.hours();
	  var minutes = duration.minutes();

	  docus[i].docu_falta_dias = days;
	  docus[i].docu_falta_horas = hours;
	  docus[i].docu_falta_minutos = minutes;
	  docus[i].docu_falta = falta;
	}

	for (var i = 0; i < docusMen.length; i++) {
	  var desc = docusMen[i].docu_descripcion;
	  var str = desc.substring(0, 8);
	  var desc2 = docusMen[i].docu_nombre;
	  var str2 = desc2.substring(0, 8);
	  docusMen[i].docu_descripcion_corta = str;
	  docusMen[i].docu_nombre_corta = str2;
	  var fechaHora = docusMen[i].docu_fecha_ingreso;
	  var fechaComp = moment(fechaHora).format("YYYY/MM/DD HH:mm:ss");
	  var now = moment();
	  var fechaAct = moment().format('YYYY/MM/DD HH:mm:ss');
	  var falta = moment(fechaComp, "YYYY/MM/DD HH:mm:ss").fromNow();

	  var fecha1 = moment(fechaAct, "YYYY/MM/DD HH:mm:ss");
	  var fecha2 = moment(fechaComp, "YYYY/MM/DD HH:mm:ss");

	  var now = fecha1;
	  var end = fecha2;
	  var duration = moment.duration(now.diff(end));
	  var days = duration.days();
	  var hours = duration.hours();
	  var minutes = duration.minutes();

	  docusMen[i].docu_falta_dias = days;
	  docusMen[i].docu_falta_horas = hours;
	  docusMen[i].docu_falta_minutos = minutes;
	  docusMen[i].docu_falta = falta;
	}

	this.estadosMenNotificaciones = docusMen;
	this.estadosNotificaciones = docus;

      }).catch(e => {
	console.log(e);
      });
    },

    async verEstado(estado) {
      console.log(estado);
      var id = estado.iddocumento;
      if (estado.estado_nombre == 'EN PROCESO') {
	window.location.href = this.url + 'verEstados/' + id;
      } else if (estado.estado_nombre == 'PROCESO') {
	window.location.href = this.url + 'verMensajes/' + id;
      }
    },

    async moment() {
      moment.locale('es');
      console.log(moment().format('LLLL') + "MOMMENT");
    },

  },
  created() {
    this.moment();
    this.estadosUnicos();
    this.getDepartamentos();
    this.barChart();
    this.pendientesPorUsuario();
  },
  mounted() {

  }
});

