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
    codigo: ''



  },
  methods: {

    async recibirDocumento() {

      var url = this.url + 'recibirDocumentoEstado';
      var codigo = this.codigo;

      var arr = codigo.split("-");
      var cod = arr[1];
      param = new FormData();
      param.append('iddocumento', cod);
      var data = await axios.post(url, param).then(res => {
	console.log(res.data);
	if (res.data.existe === true) {
	  toastr.success(res.data.resp, 'EXITO');
	  this.codigo = '';
	}else if(res.data.resp == 'Documento Terminado') {
	  toastr.warning(res.data.resp, 'TERMINADO');
	}else{
	  toastr.error(res.data.resp, 'ERROR');
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
    },
  },
  created() {


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

