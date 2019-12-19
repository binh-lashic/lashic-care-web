$(function(){

    //plansテーブルのidの対応表
    const WIFI_RENTALS = {
        1:5,
        2:6,
        3:7
    }

   function api(action, params, callback){
      $.post(
         "/api/" + action,
         params,
         callback,
         "json"
      );
   }

   $("input:button").click(function(event) {
      var plan_ids = [];
      var plan = $(this).data('plan');

      if($('#box-1').is(':checked')){
          plan_ids.push(WIFI_RENTALS[plan]);
      }

      plan_ids.push(plan);
      api("/shopping/set_plans", { plan_ids : plan_ids}, function(result){
          location.href = '/shopping/cart';
      });
   });
});
