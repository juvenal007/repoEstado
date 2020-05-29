new Vue({
  el: 'main',
  data: {
    codigoDoc: '',
    titulo: 'Lista Departamentos',
    subtitulo: 'Departamento',
    url: 'http://192.168.1.35/repoEstado/',
    usuario: '',
    departamento_iddepartamento: '',
    mostrar: false,
    codigo: '',
    cantidadEstados: '',
    archivos: [],
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

      var url = this.url + 'getDepartamentos';
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.departamentos = res.data;
	deptos = res.data;
      }).catch(e => {
	console.log(e);
      });

      for (var i = 0; i < deptos.length; i++) {
	depto_nombres.push(deptos[i].depto_nombre);
      }

      console.log(depto_nombres);

      console.log(this.departamentos);
      $(document).ready(function () {

	var ctx = document.getElementById('myChart');
	var chart = new Chart(ctx, {
	  // The type of chart we want to create
	  type: 'bar',
	  // The data for our dataset	  
	  data: {
	    labels: depto_nombres,
	    datasets: [{
		label: 'Completados',
		backgroundColor: 'rgb(40, 60, 255)',
		borderColor: 'rgb(0, 0, 0)',
		data: [7, 12, 4, 15]
	      },
	      {
		label: 'Enviados',
		backgroundColor: 'rgb(255, 40, 60)',
		borderColor: 'rgb(0ss, 0, 0)',
		data: [5, 10, 5, 2]
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

    async seguimiento(doc) {
      var iddocumento = doc.iddocumento;
      if (doc.docu_tipo == 'MEMORANDO' || doc.docu_tipo == 'CIRCULAR' || doc.docu_tipo == 'OTROS') {
	window.location.href = this.url + 'verMensajes/' + iddocumento;
	var param = new FormData();
	param.append('iddocumento', iddocumento);
	var data = await axios.post(url, param).then(res => {
	  console.log(res.data);
	}).catch(e => {
	  console.log(e);
	});
      } else
      {
	window.location.href = this.url + 'verEstados/' + iddocumento;
	var param = new FormData();
	param.append('iddocumento', iddocumento);
	var data = await axios.post(url, param).then(res => {
	  console.log(res.data);

	}).catch(e => {
	  console.log(e);
	});
      }

    },
    async descargarDoc(doc) {
      var id = doc.iddocumento;
      var url = this.url + 'getArchivo/';
      var param = new FormData();
      param.append('iddocumento', id);
      var data = await axios.post(url, param).then(res => {
	this.archivos = res.data.archivo;
	console.log(res.data);
      }).catch(e => {
	console.log(e);
      });
//      window.open(archivoUrl);
    },

    async editarDocumento(doc) {

      this.documento = doc;
//      var url = this.url + 'getArchivo/';
//      var param = new FormData();
//      param.append('iddocumento', id);
//      var data = await axios.post(url, param).then(res => {
//	this.archivos = res.data.archivo;
//	console.log(res.data);
//      }).catch(e => {
//	console.log(e);
//      });
    },

    async descarga(archivo) {
      var archivoUrl = archivo.archivo_url;
      window.open(archivoUrl);
    },

    async limpiar() {

    },

    async verDocumento(iddocumento) {

      var iddocumento = iddocumento;
      window.open(this.url + "generarPDF/" + iddocumento, "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=500, height=500");
      toastr["info"]("Generando documento PDF", "Cargando")

    },
    mouseover: function () {
      console.log('dentro');
    },
    mouseleave: function () {
      console.log('fuera');
    },

    async mouse() {
      $('[data-toggle="tooltip"]').tooltip();
    },
    async onFileSelected(event) {
      console.log(event);
      console.log(event.target.files[0].name);
      this.archivo = event.target.files[0];
      this.archivoNombre = event.target.files[0].name;
      //  console.log(this.foto);
      var data = new FormData();
      data.append('archivo', this.archivo, this.archivo.name);
      var res = await axios.post(this.url + "subirArchivo", data);
      console.log(res);

      if (res.data.exito == true) {
	var archivo = {};
	archivo.nombre = res.data.nombre;
	archivo.extension = res.data.extension;
	archivo.url = res.data.url;
	this.archivo = archivo;
	toastr.success(res.data.resp);
      } else
      {
	toastr.error(res.data.resp);
      }
    },
    async agregarArchivo() {

      var id = this.documento.iddocumento;
      var url = this.url + 'agregarArchivo/';

      var param = new FormData();
      param.append('documento_iddocumento', id);
      param.append('archivo_nombre', this.archivo.nombre);
      param.append('archivo_extension', this.archivo.extension);
      param.append('archivo_url', this.archivo.url);
      var data = await axios.post(url, param).then(res => {
	if (res.data.existe == true) {
	  toastr.success(res.data.resp);
	} else {
	  toastr.error(res.data.resp);
	}
      }).catch(e => {
	console.log(e);
      });
    },

    async limpiar() {

      this.documento = '';
      this.archivos = '';
      this.documentos = '';

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
  },
  mounted() {

  }
});