Vue.directive('focus', {
  inserted: function (el) {
    el.focus();
  },
}),
	new Vue({
	  el: 'main',
	  data: {
	    titulo: 'Departamento',
	    url: 'http://192.168.1.35/repoEstado/',
	    usuario: '',
	    nombre: '',
	    descripcion: '',
	    telefono: '',
	    archivo: '',
	    archivoNombre: '',
	    archivoUrl: '',
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
	    async crearDepartamento() {

	      var url = this.url + 'insertDepartamento';
	      param = new FormData();
	      param.append('depto_nombre', this.nombre);
	      param.append('depto_descripcion', this.descripcion);
	      param.append('depto_telefono', this.telefono);
	      param.append('depto_img', this.archivoUrl);

	      if (this.nombre.length == 0 || this.descripcion.length == 0 || this.telefono.length == 0 || this.archivoUrl.length == 0) {
		toastr["error"]("ERROR", 'FALTAN DATOS');
	      } else {
		var data = await axios.post(url, param).then(res => {
		  if (res.data.resp === "Departamento creado con exito") {
		    toastr["success"]("CORRECTO!", "DEPARTAMENTO CREADO CON EXITO!");
		    this.limpiar();
		  } else
		  {
		    toastr.error('Error de datos', "Datos inválidos");
		  }

		}).catch(e => {
		  console.log(e);
		});
	      }
	    },
	    async iniciarEnter(event) {
	      if (event.key == "Enter") {
		this.iniciar();
	      }
	    },
	    async limpiar() {
	      this.nombre = '';
	      this.descripcion = '';
	      this.telefono = '';
	      this.archivoUrl = '';
	    },
	    async onFileSelected(event) {
	      console.log(event);
	      console.log(event.target.files[0].name);
	      this.archivo = event.target.files[0];
	      this.archivoNombre = event.target.files[0].name;
	      var data = new FormData();
	      data.append('archivo', this.archivo, this.archivo.name);
	      var res = await axios.post(this.url + "subirFotoDepto", data);
	      console.log(res);
	      this.archivoUrl = res.data.url;
//	      this.usuario.usuario_img = res.data.url;
	      if (res.data.exito == true) {
		toastr["success"](res.data.resp);
	      } else
	      {
		toastr.error(res.data.resp);
	      }
	    },
	  },
	  created() {
	    this.estadosUnicos();
	    this.limpiar();
	  },
	  mounted() {
	    toastr.options = {
	      "closeButton": false,
	      "debug": false,
	      "newestOnTop": false,
	      "progressBar": true,
	      "positionClass": "toast-top-right",
	      "preventDuplicates": false,
	      "onclick": null,
	      "showDuration": "100",
	      "hideDuration": "1000",
	      "timeOut": "1500",
	      "extendedTimeOut": "0",
	      "showEasing": "swing",
	      "hideEasing": "linear",
	      "showMethod": "fadeIn",
	      "hideMethod": "fadeOut"
	    }
	  }
	});




