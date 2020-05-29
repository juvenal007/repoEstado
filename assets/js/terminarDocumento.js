Vue.directive('focus', {
  inserted: function (el) {
    el.focus();
  },
}),
	new Vue({
	  el: 'main',
	  data: {
	    titulo: 'Documentos',
	    url: 'http://192.168.1.35/repoEstado/',
	    usuario: '',
	    codigo: '',
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
	    async terminarDocumento() {

	      var url = this.url + 'terminarDoc';
	      var codigo = this.codigo;

	      var arr = codigo.split("-");
	      var cod = arr[1];
	      var tipo = arr[0];
	      param = new FormData();
	      param.append('tipo_documento', tipo);
	      param.append('iddocumento', cod);
	      var data = await axios.post(url, param).then(res => {
		console.log(res.data);
		if (res.data.existe === true) {
		  toastr.success(res.data.resp, 'EXITO');
		  this.codigo = '';
		} else if (res.data.resp == 'Documento Terminado') {
		  toastr.success(res.data.resp, 'TERMINADO');
		} else {
		  toastr.error(res.data.resp, 'ERROR');
		  console.log(res.data);
		}
	      }).catch(e => {
		console.log(e);
	      });
	    },

	    async cargarModal()
	    {
	      $("#modal-overlay").modal("show");
	    },

	    async limpiar() {
	      this.codigo = '';
	    },
	    async iniciarEnter(event) {
	      if (event.key == "Enter") {
		this.recibirDocumento();
	      }
	    }, async moment() {
	      moment.locale('es');
	      console.log(moment().format('LLLL') + "MOMMENT");
	    },
	  },
	  created() {
	    this.moment();
	    this.estadosUnicos();

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
	      "timeOut": "4000",
	      "extendedTimeOut": "500",
	      "showEasing": "swing",
	      "hideEasing": "linear",
	      "showMethod": "fadeIn",
	      "hideMethod": "fadeOut"
	    }

	  }
	});