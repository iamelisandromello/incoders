$(function(){
   $.ajaxSetup({
      headers: 
      {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $(".btn-envio1").click(function(e) {
      e.preventDefault();
      alert(nome.value);
      alert(endereco.value);
      alert(valor.value);
      alert(vencimento.value);

      var name       = "Teste";
      var password   = "Teste2";;
      var email      = "Teste3";
      alert(email);        

      $.ajax({
         type:'POST',
         url:'/ajaxRequest',
         data:{name:name, password:password, email:email},
         success:function(data){
            alert(data.success);
         }
      });
   });
   
});

function sendEmail($data){ 
   alert('teste');
}

function enviar(dadosSplit, obj) {

   if(dadosSplit != '') {

      /*
      descarta o próprio elemento e com o closest procura o primeiro elemento
      de tag <div> a partir de seu primeiro ascendente.
      */
      jQuery(obj).parent().closest('div').fadeOut();
      resultado = dadosSplit.split("|");
      var data = JSON.stringify(resultado);

      var nameJson      = resultado[0];
      var addressJson   = resultado[1];
      var valueJson     = resultado[2];
      var expiryJson    = resultado[3];

      $.ajax({
         type:'POST',
         url:'/ajaxRequest',
         data:{name:nameJson , address:addressJson, value:valueJson, expiry:expiryJson},
         dataType: 'json',
         success:function(data){
            alert(data.success);
         }
      });

   }

   return false;
}