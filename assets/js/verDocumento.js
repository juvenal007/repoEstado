new Vue({
  el: 'main',
  data: {
    titulo: 'Documentos',
    url: 'http://192.168.1.35/repoEstado/',
    usuario: '',
    archivo: {},
    documento: [],
    archivos: [],
    documentos: [],
    usuario: {},
    active: false,
    cantidadEstados: '',
    estadosMen: [],
    cantidadEstadosMen: '',
    estadosMenNotificaciones: '',
    estadosNotificaciones: [],
    estados: [],

  },
  methods: {

    async verEstado(estado) {
      console.log(estado);
      var id = estado.iddocumento;
      if (estado.estado_nombre == 'EN PROCESO') {
	window.location.href = this.url + 'verEstados/' + id;
      } else if (estado.estado_nombre == 'PROCESO') {
	window.location.href = this.url + 'verMensajes/' + id;
      }
    },

    async eliminarDocumento(id) {

    console.log(id+'IDDDDDDDDDDDDDDDDDDDDDDDDDDDDDDD');

      var url = this.url + 'eliminarDocumento';
      param = new FormData();
      param.append('iddocumento', id);
      if (confirm("Desea eliminar Documento")) {
	var data = await axios.get(url).then(res => {
	  console.log(res);
	}).catch(e => {
	  console.log(e);
	});
      }


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

    async verDoc() {
      this.limpiar();
      var url = this.url + 'getDoc';
      param = new FormData();
      var data = await axios.get(url).then(res => {
	console.log(res.data.documentos);
	this.documentos = res.data.documentos;
	console.log(res.data.resp);
	var docus = [];
	for (var i = 0; i < res.data.documentos.length; i++) {
	  docus[i] = res.data.documentos[i];
	}

	for (var i = 0; i < docus.length; i++) {
	  var desc = docus[i].docu_descripcion;
	  var str = desc.substring(0, 8);
	  var desc2 = docus[i].docu_nombre;
	  var str2 = desc2.substring(0, 8);
	  docus[i].docu_descripcion_corta = str;
	  docus[i].docu_nombre_corta = str2;

	  var fechaHora = docus[i].docu_fecha_ingreso;

	  var fechaComp = moment(fechaHora).format("YYYY/MM/DD HH:mm:ss");

	  console.log(fechaComp + "<------- FECHA");

	  console.log(fechaHora);
	  var soloFecha = fechaHora;

	  console.log(docus[i].docu_fecha_ingreso);
	  console.log(soloFecha);

	  var fechaArr = soloFecha.split("-");
	  console.log(fechaArr);

	  var fechaFinal = fechaArr[0] + fechaArr[1] + fechaArr[2];

	  console.log(fechaFinal);

	  var now = moment();
	  var fechaAct = moment().format('YYYY/MM/DD HH:mm:ss');

	  console.log(fechaAct + "*******FECHA ACTUAL*******");

	  var falta = moment(fechaComp, "YYYY/MM/DD HH:mm:ss").fromNow();


	  var fecha1 = moment(fechaAct, "YYYY/MM/DD HH:mm:ss");
	  var fecha2 = moment(fechaComp, "YYYY/MM/DD HH:mm:ss");
	  var dif = fecha1.diff(fecha2);
	  var min = fecha2.diff(fecha1, 'minutes');
	  var hora = fecha2.diff(fecha1, 'hours');
	  var dia = fecha2.diff(fecha1, 'days');
	  console.log(dif + "---" + min + "---" + hora + "---" + dia);
	  var now = fecha1;
	  var end = fecha2;
	  var duration = moment.duration(now.diff(end));
	  var days = duration.days();
	  var hours = duration.hours();
	  var minutes = duration.minutes();
	  console.log(days + "***********************");
	  console.log(hours + "***********************");
	  console.log(minutes + "***********************");

	  docus[i].docu_falta_dias = days;
	  docus[i].docu_falta_horas = hours;
	  docus[i].docu_falta_minutos = minutes;

	  docus[i].docu_falta = falta;
	  console.log(docus);
	}
	this.documentos = docus;
      }).catch(e => {
	console.log(e);
      });

    },

    async moment() {
      moment.locale('es');
      console.log(moment().format('LLLL') + "MOMMENT");
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

    },

    async descarga(archivo) {
      var archivoUrl = archivo.archivo_url;
      window.open(archivoUrl);
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
  },
  async moment() {
    moment.locale('es');
    console.log(moment().format('LLLL') + "MOMMENT");
  },
  created() {
    this.moment();
    this.estadosUnicos();
    this.mouse();
    this.verDoc();

  },
  mounted() {
    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "500",
      "timeOut": "1500",
      "extendedTimeOut": "500",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }
  }
});


