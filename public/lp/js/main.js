$(function(){
    //初期費用
    const INITIAL_COST_ID = 4

    //plansテーブルのidの対応表
    const WIFI_RENTALS = {
        1:5,
        2:6,
        3:7
    }

    //plansテーブルのidの対応表
    const HALF_A_MONTH = {
        1:8,
        2:9,
        3:10
    }

    scrollTop('.toPageTop', 500);
    /**
     * login-toggle
     */
    const tablet = '960px';

    window.onload = function () {
        loginToggle(tablet);
    };
    window.onscroll = function () {
        loginToggle(tablet);
    };
    matchMedia(`(max-width: ${tablet})`).addListener(loginToggle);

   $("input:button").click(function(event) {
      var plan_ids = [];
      var plan = $(this).data('plan');

      if($('#box-1').is(':checked')){
          plan_ids.push(WIFI_RENTALS[plan]);
      }

      plan_ids.push(plan);
      plan_ids.push(INITIAL_COST_ID);

      var date = new Date();
      if(date.getDate() >= 16) {
          plan_ids.push(HALF_A_MONTH[plan]);
      }

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

function loginToggle(tablet) {
    if (matchMedia(`(max-width: ${tablet} )`).matches) {
        return;
    }else{
        let this_y = window.pageYOffset;
        if (this_y > 240) {
            document.querySelector('.Header__item:last-child').style.display = 'none';
        } else {
            document.querySelector('.Header__item:last-child').style.display = 'block';
        }
    }
}