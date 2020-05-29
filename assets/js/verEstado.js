new Vue({
  el: 'main',
  data: {
    titulo: '',
    url: 'http://192.168.1.35/repoEstado/',
    iddocumento: '',
    codigo: '',
    estados: [],
    estadosFinales: [],
    documento: {},
    usuario: {},
    cantidadEstados: '',
    estadosMen: [],
    cantidadEstadosMen: '',
    estadosMenNotificaciones: '',
    estadosNotificaciones: [],
    estadosF: [],

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

    async estadosUnicos() {
      moment.locale('es');
      var url = this.url + 'getDocumentosNotificaciones';
      param = new FormData();
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.estadosF = res.data.estados;
	this.estadosMen = res.data.estadosMen;
	var estadosMen = res.data.estadosMen;
	var estadosF = res.data.estados;
	var estadosUnicosProcesados = [];
	var j = 0;
	var k = 0;
	for (var i = 0; i < this.estadosF.length; i++) {
	  if (this.estadosF[i].estado_nombre == 'EN PROCESO') {
	    estadosUnicosProcesados.push(this.estadosF[i]);
	    j++;
	    if (j == 4) {
	      break;
	    }
	  }
	}
	for (var i = 0; i < this.estadosF.length; i++) {
	  if (this.estadosF[i].estado_nombre == 'EN PROCESO') {
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
    async getEstados() {

      var url = this.url + 'getEstados';
      param = new FormData();
      param.append('iddocumento', this.iddocumento);

      var data = await axios.post(url, param).then(res => {
	console.log(res.data)
	this.estados = res.data.estados;
	var estados = this.estados;
	this.titulo = 'Documento: ' + this.estados[0].docu_tipo + '-' + this.estados[0].iddocumento;
	for (var i = 0; i < this.estados.length; i++) {
	  var fechaIngresoEstado = moment(this.estados[i].estado_fecha_ingreso).format('LLLL a');
	  this.estados[i].fecha_ingreso = fechaIngresoEstado;
	  this.estados[i].docu_nombre = estados[i].docu_nombre.substr(0, 5);
	  this.estados[i].docu_descripcion = estados[i].docu_descripcion.substr(0, 30);

	}
	if (res.data.existe === true) {
//	  toastr["success"]("CORRECTO!", res.data.resp);
	  this.calcularFecha(estados);
	} else
	{
	  toastr.error(res.data.resp, "Datos inválidos");
	}
      }).catch(e => {
	console.log(e);
      });
    },

    async capturar() {
      this.iddocumento = $('#iddocumento').val();
    },
    async moment() {
      moment.locale('es');
      console.log(moment().format('LLLL') + "MOMMENT");
    },

    async calcularFecha(estados) {

      var estadosFinal = estados;

      for (var i = 0; i < estadosFinal.length; i++) {

	var fechaAct = moment(estadosFinal[i].estado_fecha_ingreso).format('YYYY/MM/DD HH:mm');
	console.log(fechaAct);
	try {
	  var fechaAct2 = moment(estadosFinal[i + 1].estado_fecha_ingreso).format('YYYY/MM/DD HH:mm');
	  console.log(fechaAct2);
	} catch (e) {
	  var fechaAct2 = fechaAct;
	}
	var fecha1 = moment(fechaAct, "YYYY/MM/DD HH:mm");
	console.log(fecha1);
	var fecha2 = moment(fechaAct2, "YYYY/MM/DD HH:mm");
	console.log(fecha2);
	var dif = fecha1.diff(fecha2);

	var diferencia = moment(dif, "YYYY/MM/DD HH:mm");

	var now = fecha2;
	console.log(now + 'NNNNNNNNNNNNNNNNN');
	var end = fecha1;
	console.log(end + 'MMMMMMMMMMMMMMMMM');
	var duration = moment.duration(now.diff(end));

	console.log(minutes + 'DUUUURRAAAAAATION');

	var days = duration.days();

	var hours = duration.hours();

	var minutes = duration.minutes();


	estadosFinal[i].estado_min = minutes;
	estadosFinal[i].estado_hora = hours;
	estadosFinal[i].estado_dia = days;
	estadosFinal[i].ultimo = false;
	if (i == (estadosFinal.length - 1)) {

	  estadosFinal[i].ultimo = true;

	  var now = moment();
	  var fechaAct = moment().format('YYYY/MM/DD HH:mm:ss');

	  var fecha1 = moment(fechaAct, "YYYY/MM/DD HH:mm");
	  var fecha2 = moment(estadosFinal[i].estado_fecha_ingreso, "YYYY/MM/DD HH:mm");
	  var dif = fecha1.diff(fecha2);

	  var min = fecha2.diff(fecha1, 'minutes');
	  var hora = fecha2.diff(fecha1, 'hours');
	  var dia = fecha2.diff(fecha1, 'days');
	  console.log("---" + min + "---" + hora + "---" + dia);

	  var now = fecha1;
	  var end = fecha2;
	  var duration = moment.duration(now.diff(end));
	  var days = duration.days();
	  var hours = duration.hours();
	  var minutes = duration.minutes();



	  estadosFinal[i].estado_dias = days;
	  estadosFinal[i].estado_horas = hours;
	  estadosFinal[i].estado_minutos = minutes;


	}



//	console.log(dif + "---" + min + "---" + hora + "---" + dia);

	console.log(diferencia);

	console.log('*************************************');
	this.estadosFinales.push(estadosFinal[i]);
      }
      this.estados = [];
    },

  },
  created() {
    this.moment();
    this.estadosUnicos();
    this.capturar();
    this.getEstados();
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
