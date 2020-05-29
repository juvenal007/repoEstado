new Vue({
  el: 'main',
  data: {
    titulo: 'Usuarios',
    url: 'http://192.168.1.35/repoEstado/',
    archivo: '',
    archivoNombre: '',
    archivoUrl: '',
    usuario_img: '',
    usu_rut: '',
    usuario_rut_digito: '',
    usuario_nombre_pri: '',
    usuario_nombre_secu: '',
    usuario_apellido_pat: '',
    usuario_apellido_mat: '',
    usuario_anexo: '',
    usuario_tipo: '',
    usuario_correo: '',
    usuario_funcion: '',
    departamento_iddepartamento: '',
    departamentos: [],
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
    async crearUsuario() {

      var url = this.url + 'insertUsuario';
      param = new FormData();

      param.append('usu_rut', this.usu_rut);
      param.append('usuario_nombre_pri', this.usuario_nombre_pri);
      param.append('usuario_nombre_secu', this.usuario_nombre_secu);
      param.append('usuario_apellido_pat', this.usuario_apellido_pat);
      param.append('usuario_apellido_mat', this.usuario_apellido_mat);
      param.append('usuario_anexo', this.usuario_anexo);
      param.append('usuario_tipo', this.usuario_tipo);
      param.append('usuario_correo', this.usuario_correo);
      param.append('usuario_funcion', this.usuario_funcion);
      param.append('departamento_iddepartamento', this.departamento_iddepartamento);
      param.append('usuario_img', this.archivoUrl);

      if (this.usu_rut.length == 0 || this.usuario_nombre_pri.length == 0 || this.usuario_nombre_secu.length == 0 || this.usuario_apellido_pat.length == 0 || this.usuario_apellido_mat.length == 0 || this.usuario_anexo.length == 0 || this.usuario_tipo.length == 0 || this.usuario_correo.length == 0 || this.usuario_funcion.length == 0 || this.departamentoñ_iddepartamento.length == 0 || this.archivoUrl.length == 0) {
	toastr["error"]("ERROR", 'FALTAN DATOS');
      } else {
	var data = await axios.post(url, param).then(res => {
	  if (res.data.existe === true) {
	    toastr["success"]("CORRECTO!", res.data.resp);
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

    async getDepartamentos() {
      var url = this.url + 'getDepartamentos';
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.departamentos = res.data;
      }).catch(e => {
	console.log(e);
      });
    },
    async iniciarEnter(event) {
      if (event.key == "Enter") {
	this.iniciar();
      }
    },
    async limpiar() {
      this.usu_rut = '';
      this.usuario_rut_digito = '';
      this.usuario_nombre_pri = '';
      this.usuario_nombre_secu = '';
      this.usuario_apellido_pat = '';
      this.usuario_apellido_mat = '';
      this.usuario_tipo = '';
      this.usuario_anexo = '';
      this.departamento_iddepartamento = '';
    },

    async verificador() {
      if (this.usu_rut.length > 7) {
	var url = this.url + 'validarRut';
	param = new FormData();
	param.append('usu_rut', this.usu_rut);
	var data = await axios.post(url, param).then(res => {
	  if (res.data.resp === true) {
	    toastr["success"]("CORRECTO!", "Rut válido");

	  } else
	  {
	    toastr.error('Error de datos', "Rut inválido");
	    this.usu_rut = '';
	  }
	}).catch(e => {
	  console.log(e);
	});
      } else
      {
	toastr.error('Error de datos', "Rut inválido");
	this.usu_rut = '';
      }


    },

    async onFileSelected(event) {
      console.log(event);
      console.log(event.target.files[0].name);
      this.archivo = event.target.files[0];
      this.archivoNombre = event.target.files[0].name;

      var data = new FormData();
      data.append('archivo', this.archivo, this.archivo.name);
      var res = await axios.post(this.url + "subirFotoUsuario", data);
      console.log(res);
      this.archivoUrl = res.data.url;
      if (res.data.exito == true) {
	toastr["success"](res.data.resp);
      } else
      {
	toastr.error(res.data.resp);
      }
    },

  },
  created() {
    this.getDepartamentos();
    this.limpiar();
    this.estadosUnicos();
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
Vue.directive('focus', {
  inserted: function (el) {
    el.focus();
  },
})



