$(function(){
   $.ajaxSetup({
      headers: 
      {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });
});

function enviar(dadosSplit, anexo, obj) {

   if(dadosSplit != '') {

      dado  = dadosSplit.split("|");

      var data =
      {
         "email": {
            "nome"      : dado[0],
            "endereco"  : dado[1],
            "valor"     : dado[2],
            "vencimento": dado[3],
            "anexo"     : anexo,

         }
      };

      $.ajax({
         type:'POST',
         url:'/ajaxRequest',
         data:data,
         dataType: 'json',
         success:function(data)
         {
            //alert(data.success);
            triggerNotify();

            /*
            descarta o próprio elemento e com o closest procura o primeiro elemento
            de tag <div> a partir de seu primeiro ascendente.
            */
            jQuery(obj).parent().closest('div').fadeOut();

         }
      });

   }

   return false;
}


function triggerNotify() {
   var data = [];
   data['title'] = 'Eeei desistiu da requisição? ' + ' OK Fica para Depois!!!';
   data['icon'] = "icon-bubble";
   data['color'] = "purple";
   data['timer'] = 3000;

   var triggerContent = "<div class='trigger_notify trigger_notify_" + data.color + "' style='left: 100%; opacity: 0;'>";
   triggerContent += "<p class='" + data.icon + "'>" + data.title + "</p>";
   triggerContent += "<span class='trigger_notify_timer'></span>";
   triggerContent += "</div>";

   if(!$('.trigger_notify_box').length){
       $('body').prepend("<div class='trigger_notify_box'></div>");
   }

   $('.trigger_notify_box').prepend(triggerContent);
   $('.trigger_notify').stop().animate({'left': '0', 'opacity': '1'}, 200, function(){
       $(this).find('.trigger_notify_timer').animate({'width': '100%'}, data.timer, 'linear', function(){
           $(this).parent('.trigger_notify').animate({'left': '100%', 'opacity': '0'}, function(){
               $(this).remove();
           });
       });
   });

   $('body').on('click', '.trigger_notify', function(){
       $(this).animate({'left': '100%', 'opacity': '0'}, function(){
           $(this).remove();
       });
   });
}