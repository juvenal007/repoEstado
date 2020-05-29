new Vue({
  el: 'main',
  data: {
    titulo: 'Documentos',
    url: 'http://192.168.1.35/repoEstado/',
    departamento_iddepartamento: '',
    usuario: '',
    codigo: '',
    nombre: '',
    tipo: '',
    mostrar: false,
    descripcion: '',
    telefono: '',
    departamento: '',
    dirigido: '',
    archivo: '',
    archivoUrl: '',
    archivoNombre: '',
    destinatariosArr: [],
    depto: [],
    documento: [],
    departamentos: [],
    usuarios: [],
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
    async crearDocumento() {
      var url = this.url + 'insertDocumento';
      var destin = '';

      for (var i = 0; i < this.destinatariosArr.length; i++) {
	destin = destin + this.destinatariosArr[i].id;
	destin = destin + '-';
      }

      console.log(destin + '4444444444444444444444444');

      param = new FormData();
      param.append('docu_codigo', this.codigo);
      param.append('docu_tipo', this.tipo);
      param.append('docu_nombre', this.nombre);
      param.append('docu_descripcion', this.descripcion);
      param.append('destinatarios', destin);
      param.append('archivoUrl', this.archivoUrl);
      param.append('archivoNombre', this.archivoNombre);

      if (this.codigo.length == 0 || this.tipo.length == 0 || this.nombre.length == 0 || this.descripcion == 0 || this.archivoUrl == 0 || this.archivoNombre == 0) {
	toastr["error"]("ERROR", 'FALTAN DATOS');
      } else
      {
	var data = await axios.post(url, param).then(res => {

	  console.log(res.data)

	  if (res.data.existe === true) {
	    toastr["success"]("CORRECTO!", res.data.resp);
	    this.documento = res.data.documento;
	    this.generarPDF();
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

    async generarPDF() {

      var iddocumento = this.documento[0].iddocumento;
      window.open(this.url + "generarPDF/" + iddocumento, "nuevo", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=Documento PDF, width=500, height=500");
      toastr["info"]("Generando documento PDF", "Cargando")

    },

    async cargarModal()
    {
      $("#modal-overlay").modal("show");
    },

    async limpiar() {
      this.tipo = '';
      this.codigo = '';
      this.nombre = '';
      this.descripcion = '';
    },

    async getDepartamentos() {
      this.departamentos = [];
      var url = this.url + 'getDepartamentos';
      var data = await axios.get(url).then(res => {
	console.log(res.data);
	this.departamentos = res.data;
      }).catch(e => {
	console.log(e);
      });
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

    async cargarUsuarios() {
      var letra = this.departamento_iddepartamento;
      this.getUsuarios(letra);
      console.log(letra);
    },

    async menuUsuarios() {
      this.limpiar();
      this.getDepartamentos();
      switch (this.tipo) {
	case 'MEMORANDO':
	  this.mostrar = true;
	  break;
	case 'CIRCULAR':
	  this.mostrar = true;
	  break;
	case 'OTROS':
	  this.mostrar = true;
	  break;
	default:
	  this.mostrar = false;
	  break;
      }
    },
    async limpiar() {
      this.codigo = '';
      this.nombre = '';
      this.descripcion = '';
      this.departamento_iddepartamento = '';
      this.usuarios = [];
      this.usuario = '';
      this.destinatariosArr = [];
    },

    async destinatariosDeptos() {

      var deptos = this.departamentos;
      var iddepartamento = this.departamento_iddepartamento;
      var dest = {};
      var esta = false;

      for (var j = 0; j < this.destinatariosArr.length; j++) {
	if (this.destinatariosArr[j].iddepartamento == iddepartamento) {
	  console.log(this.destinatariosArr.length);
	  esta = true;
	  console.log(esta);
	}
      }

      console.log(iddepartamento + 'ID_DEPARTAMENTO');
      for (var i = 0; i < deptos.length; i++) {
	console.log(deptos[i].depto_nombre + 'DEPTOSSSS');
      }

      for (var i = 0; i < deptos.length; i++) {
	if (deptos[i].iddepartamento == iddepartamento && esta == false) {
	  dest = deptos[i];
	  dest.id = deptos[i].iddepartamento;
	  dest.nombre = deptos[i].depto_nombre;
	  dest.departamento = deptos[i].depto_nombre;
	  console.log(dest + '*****************');
	  this.destinatariosArr.push(dest);
	  break;
	}
      }
      console.log(this.destinatariosArr);
    },

    async destinatariosUsuario() {


      var usuarios = this.usuarios;
      var usu_rut = this.usuario;
      var usua = {};
      var esta = false;
      for (var j = 0; j < this.destinatariosArr.length; j++) {
	if (this.destinatariosArr[j].usu_rut == usu_rut) {
	  esta = true;
	}
      }
      for (var i = 0; i < usuarios.length; i++) {
	if (usuarios[i].usu_rut == usu_rut && esta == false) {
	  usua = usuarios[i];
	  usua.id = usuarios[i].usu_rut;
	  usua.nombre = usuarios[i].usuario_nombre_pri + " " + usuarios[i].usuario_apellido_pat;
	  usua.departamento = usuarios[i].depto_nombre;
	  this.destinatariosArr.push(usua);
	  break;
	}
      }
      console.log(this.destinatariosArr);
      this.usuarios = '';
    },

    async eliminarDestinatario(id) {
      var id = id;
      console.log(id);
      for (var i = 0; i < this.destinatariosArr.length; i++) {
	if (this.destinatariosArr[i].id == id) {
	  console.log(this.destinatariosArr.splice(i, 1));
	}
      }
      console.log(this.destinatariosArr);
      this.eliminarDest = '';

    },

    async onFileSelected(event) {
      console.log(event);
      console.log(event.target.files[0].name);
      this.archivo = event.target.files[0];
      this.archivoNombre = event.target.files[0].name;

      var data = new FormData();
      data.append('archivo', this.archivo, this.archivo.name);
      var res = await axios.post(this.url + "subirArchivo", data);
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
    this.menuUsuarios();
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
      "hideDuration": "1000",
      "timeOut": "6000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

  }
});

