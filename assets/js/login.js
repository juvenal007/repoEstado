Vue.directive('focus', {
  inserted: function (el) {
    el.focus();
  },
}),
	new Vue({
	  el: 'main',
	  data: {
	    url: 'http://192.168.1.35/repoEstado/',
	    usuario: '',
	    password: ''
	  },
	  methods: {

	    async iniciar() {
	      var url = this.url + 'iniciar';
	      param = new FormData();
	      param.append('usuario', this.usuario);
	      param.append('password', this.password);
	      var data = await axios.post(url, param).then(res => {
		if (res.data.existe == true && res.data.value === "Usuario Válido") {
		  this.limpiar();
		  $(document).ready(function () {
		    toastr["success"]("Bienvenido Usuario", "Inicio Válido");
		    setTimeout(function () {
		      console.log(res.data);
		      window.location.href = res.data.ruta;
		    }, 1500);
		    this.usuario = '';
		    this.password = '';
		  });
		} else
		{
		  toastr.error('Error de datos', "Datos inválidos");
		  this.usuario = '';
		  this.password = '';
		}

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
	      this.usuario = '';
	      this.password = '';
	    }

	  },
	  created() {
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



