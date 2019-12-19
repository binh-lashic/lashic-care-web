$(function(){
    //plansテーブルのidの対応表
    const WIFI_RENTALS = {
        1:5,
        2:6,
        3:7
    }

    scrollTop('.toPageTop', 500);
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

/**
 * toPageTop
 */
function scrollTop(elem, duration) {
    let target = document.querySelector(elem);
    target.addEventListener('click', function () {
        let currentY = window.pageYOffset;
        let step = duration / currentY > 1 ? 10 : 100;
        let timeStep = duration / currentY * step;
        let intervalID = setInterval(scrollUp, timeStep);
        function scrollUp() {
            currentY = window.pageYOffset;
            if (currentY === 0) {
                clearInterval(intervalID);
            } else {
                scrollBy(0, -step);
            }
        }
    });
}

function api(action, params, callback){
    $.post(
        "/api/" + action,
        params,
        callback,
        "json"
    );
}