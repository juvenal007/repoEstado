new Vue({
  el: 'main',
  data: {
    titulo: 'Documentos',
    url: 'http://192.168.1.35/repoEstado/',
    iddocumento: '',
    estados: [],
    estadosFinales: [],
    documento: {},
    usuario: {}

  },
  methods: {

    async getEstados() {

      var url = this.url + 'getEstados';
      param = new FormData();
      param.append('iddocumento', this.iddocumento);

      var data = await axios.post(url, param).then(res => {
	console.log(res.data)
	this.estados = res.data.estados;
	var estados = this.estados;
	for (var i = 0; i < this.estados.length; i++) {
	  var fechaIngresoEstado = moment(this.estados[i].estado_fecha_ingreso).format('LLLL a');
	  this.estados[i].fecha_ingreso = fechaIngresoEstado;
	  // DEFINIR LARGO DEL NOMBRE
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
    this.capturar();
    this.getEstados();
//    this.calcularFecha();

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
