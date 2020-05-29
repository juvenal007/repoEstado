new Vue({
  el: 'main',
  data: {
    titulo: 'Buscar Documento por Usuario',
    url: 'http://192.168.1.35/repoEstado/',
    usuario: '',
    departamentos: [],
    iddepartamento: '',
    departamento_iddepartamento: '',
    documentos: [],
    usuarios: [],
    iddocumento: '',
    mostrar: false,
    codigo: ''

  },
  methods: {
    
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
//	    var faltaHora = moment(fechaHora, "YYYY-MM-DD, hh:mm:ss a").startOf('hour').fromNow();  

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

    async verDocumento(iddocumento) {
      var iddocumento = iddocumento;
      window.open(this.url + "generarPDF/" + iddocumento, "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=500, height=500");
      toastr["info"]("Generando documento PDF", "Cargando")

    },

    async seguimiento(iddocumento) {
      var iddocumento = iddocumento;
      window.location.href = this.url + 'verEstados/' + iddocumento;
      var param = new FormData();
      param.append('iddocumento', iddocumento);
      var data = await axios.post(url, param).then(res => {
	console.log(res.data);
      }).catch(e => {
	console.log(e);
      });
    },

    async moment() {
      moment.locale('es');
      console.log(moment().format('LLLL') + "MOMMENT");
    },

    async buscarDocumentoPorCodigo(res) {
      moment.locale('es');
      console.log(res.data.documentos);
      var docus = [];

      for (var i = 0; i < res.data.documentos.length; i++) {
	docus[i] = res.data.documentos[i];
      }

      for (var i = 0; i < docus.length; i++) {
	var desc = docus[i].docu_descripcion;
	var str = desc.substring(0, 8);
	var desc2 = docus[i].docu_nombre;
	var str2 = desc2.substring(0, 8);
	docus[i].docu_descripcion = str;
	docus[i].docu_nombre = str2;

	var fechaHora = docus[i].docu_fecha_ingreso;

	var fechaComp = moment(fechaHora).format("YYYY/MM/DD HH:mm:ss");

	var now = moment();
	var fechaAct = moment().format('YYYY/MM/DD HH:mm:ss');

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

	console.log(docus);
      }

      this.documentos = docus;
      toastr["info"](res.data.resp, "Datos")
//	  this.usuario = res.data.usuario;
      this.mostrar = res.data.existe;
      this.limpiar();


    },

    async limpiar() {
      this.codigo = '';
    },

    async buscarPorCodigo() {

      var url = this.url + 'getDocumentoPorCodigo';
      param = new FormData();

      var codigo = this.codigoDoc;

      var arr = codigo.split("-");
      var cod = arr[1];

      param.append('iddocumento', cod);
      var data = await axios.post(url, param).then(res => {
	console.log(res.data);
	this.documentos = res.data.documentos;
	var resp = res;
	this.buscarDocumentoPorCodigo(resp);

      }).catch(e => {
	console.log(e);
      });

    },

    async buscarCodigo() {

      var url = this.url + 'verDocumentoBuscar';
      param = new FormData();

      var codigo = codigo;

      var arr = codigo.split("-");
      var cod = arr[1];

      var data = await axios.get(url).then(res => {
	console.log(res.data);
      }).catch(e => {
	console.log(e);
      });

    }

  },
  created() {
    this.moment();
    this.buscarCodigo();


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




