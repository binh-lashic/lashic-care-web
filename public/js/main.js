$(function(){
    // ユーザ定義関数
    function api(action, params, callback){
	    $.post(
			"/api/" + action,
			params, 
			callback,
			"json"
	    );
    }

	var temperature = Cookies.get('temperature');
	var humidity = Cookies.get('humidity');
	var illuminance = Cookies.get('illuminance');
	var active = Cookies.get('active');
	var wake_up_time = Cookies.get('wake_up_time');
	var sleep_time = Cookies.get('sleep_time');

	//クッキーの設定がない場合はデフォルト
	if(typeof temperature == "undefined") {
		temperature = 'true';
		humidity = 'true';
		illuminance = 'true';
		active = 'true';
		wake_up_time = 'true';
		sleep_time = 'true';
	}

    if(typeof temperature != "undefined" && temperature != 'false') {
		$("#graph_temperature").prop('checked', true);
	}
    if(typeof humidity != "undefined" && humidity != 'false') {
		$("#graph_humidity").prop('checked', true);
	}
    if(typeof illuminance != "undefined" && illuminance != 'false') {
		$("#graph_illuminance").prop('checked', true);
	}
    if(typeof active != "undefined" && active != 'false') {
		$("#graph_active").prop('checked', true);
	}
    if(typeof wake_up_time != "undefined" && wake_up_time != 'false') {
		$("#graph_wake_up_time").prop('checked', true);
	}
    if(typeof sleep_time != "undefined" && sleep_time != 'false') {
		$("#graph_sleep_time").prop('checked', true);
	}

	setInterval(
		function() {
			drawGraph();
			drawData();
		},
	60000);

	if(typeof sensor_id != "undefined" && typeof date != "undefined" ) {
		drawData();
		drawGraph();
	}

	$(".graph_checkbox").change(function() {
		drawGraph();
	});

	$(".link_back").click(function() {
		history.back();
	});


	$(".save_alert").click(function() {
		var id = $(this).attr('data-id');
		var confirm = $("#confirm" + id).val();
		var expiration_hour = $("#expiration_hour" + id).val();
		api("alert/save", { id : id, confirm_status : confirm,expiration_hour: expiration_hour}, function(result){
			hide_body(id);
		});
	});

	$("#checkAll").change(function() {
		if($("#checkAll").prop('checked')) {
			$(".alert_check").prop("checked",true);
		}
		
	});

	$(".confirm_status_top").change(function() {
		$(".confirm_status_bottom").val($(".confirm_status_top").val());
	});

	$(".confirm_status_bottom").change(function() {
		$(".confirm_status_top").val($(".confirm_status_bottom").val());
	});


	$(".graph24_cal_back").click(function(){
		selected_date = new Date(selected_date.getFullYear(),selected_date.getMonth()-1, 1);
		drawCalender();
	});

	$(".graph24_cal_next").click(function(){
		selected_date = new Date(selected_date.getFullYear(),selected_date.getMonth()+1, 1);
		drawCalender();
	});

	$(".graph24_cal_today").click(function(){
		selected_date = new Date();
		drawCalender();
	});

	$("ins .slide_btn_ok").click(function() {
		var year = $("ins .calendar_year_select").val();
		var month = $("ins .calendar_month_select").val();
		selected_date = new Date(year, month - 1, 1);
		drawCalender();
	});
	if(typeof date != "undefined") {
		var selected_date = new Date(date); 
		$(".calendar_year_select").val(selected_date.getFullYear());
		$(".calendar_month_select").val(selected_date.getMonth() + 1);
		drawCalender();
	}

	function drawData() {
		var today = new Date(date);
		$("#today").html((today.getMonth() + 1) + "/" + today.getDate());
		var weekDayList = [ "日", "月", "火", "水", "木", "金", "土" ] ;
		$("#today_week").html(weekDayList[today.getDay()]);

		var prev_date = new Date();
		prev_date.setDate(today.getDate() - 1);
		
		$("#prev_date").attr("data-date", prev_date.getFullYear() + "-" + (prev_date.getMonth() + 1) + "-" + prev_date.getDate());

		var next_date = new Date();
		next_date.setDate(today.getDate() + 1);

		$("#next_date").attr("data-date", next_date.getFullYear() + "-" + (next_date.getMonth() + 1) + "-" + next_date.getDate());

		api("data/dashboard?sensor_id=" + sensor_id + "&date=" + date, null, function(result){
			$('.myStat').empty();
			if(typeof result.data.temperature != "undefined") {
				$("#data_temperature").attr("data-text", result.data.temperature + "°C");
				$("#data_temperature").attr("data-percent", result.data.temperature);
			} else {
				$("#data_temperature").attr("data-text", "");
				$("#data_temperature").attr("data-percent","");
			}
			if(typeof result.data.humidity != "undefined") {
				$("#data_humidity").attr("data-text", result.data.humidity + "%");
				$("#data_humidity").attr("data-percent", result.data.humidity);
			} else {
				$("#data_humidity").attr("data-text", "");
				$("#data_humidity").attr("data-percent","");
			}
			if(typeof result.data.illuminance != "undefined") {
				$("#data_illuminance").attr("data-text", result.data.illuminance + "lux");
				$("#data_illuminance").attr("data-percent", result.data.illuminance / 10);
			} else {
				$("#data_illuminance").attr("data-text", "");
				$("#data_illuminance").attr("data-percent","");
			}
			if(typeof result.data.active != "undefined") {
				$("#data_active").attr("data-text", result.data.active);
				$("#data_active").attr("data-percent", result.data.active);
			} else {
				$("#data_active").attr("data-text", "");
				$("#data_active").attr("data-percent","");
			}
			if(typeof result.data.discomfort != "undefined") {
				$("#data_discomfort").attr("data-text", result.data.discomfort + "%");
				$("#data_discomfort").attr("data-percent", result.data.discomfort);
			} else {
				$("#data_discomfort").attr("data-text", "");
				$("#data_discomfort").attr("data-percent","");
			}

			if(result.data.wake_up_time != null) {
				$("#data_wake_up_time").html(result.data.wake_up_time.substring(0, 5));
				wake_up_time_data = result.data.wake_up_time.substring(0, 4) + "0";
			} else {
				$("#data_wake_up_time").empty();
			}
			if(result.data.sleep_time != null) {
				$("#data_sleep_time").html(result.data.sleep_time.substring(0, 5));
				sleep_time_data = result.data.sleep_time.substring(0, 4) + "0";
			} else {
				$("#data_sleep_time").empty();
			}
			if(result.data.wake_up_time_average != null) {
				$("#data_wake_up_time_average").html(result.data.wake_up_time_average.substring(0, 5));
			} else {
				$("#data_wake_up_time_average").empty();
			}
			if(result.data.sleep_time_average != null) {
				$("#data_sleep_time_average").html(result.data.sleep_time_average.substring(0, 5));
			} else {
				$("#data_sleep_time_average").empty();
			}
			$('.myStat').circliful();
		});
	}

	function drawCalender() {
		$('.calendar_body').html("");
		$(".calendar_year_month").text((selected_date.getMonth() + 1) + "月 " + selected_date.getFullYear());
		var today = new Date();
		var first_date = new Date(selected_date.getFullYear(),selected_date.getMonth(), 1);
		var last_date = new Date(selected_date.getFullYear(),selected_date.getMonth()+1, 0);
		$tr = $('<tr>');
		for(var i = 0; i < first_date.getDay(); i++) {
			var current_date = new Date(selected_date.getFullYear(),selected_date.getMonth(), i - first_date.getDay());
			$td = $('<td>');
			$td.addClass('graph24_cal-prevday');
			$span = $('<span>');
			$span.text(current_date.getDate());
			$td.append($span);
			$tr.append($td);
		}
		
		for(var i = 1; i <= last_date.getDate(); i++) {
			var week = (i + first_date.getDay() - 1) % 7;
			$td = $('<td>');
			$td.addClass('graph24_cal-active');
			$span = $('<span>');
			$span.attr('data-date', selected_date.getFullYear() + "-" + (selected_date.getMonth() + 1)+ "-" +  i);

			if(selected_date.getDate() == i) {
				$td.addClass('graph24_cal-selected');
			}
			if(today.getFullYear() == selected_date.getFullYear() && today.getMonth() == selected_date.getMonth() && today.getDate() == i) {
				$td.addClass('graph24_cal-today');
				$span.html(i + "<br>今日");
			} else {
				$span.text(i);
			}
			
			$td.append($span);
			$tr.append($td);
			if(week == 6) {
				$('.calendar_body').append($tr);
				$tr = $('<tr>');
			}
		}

		if(week < 6) {
			var j = 1;
			for(var i = week + 1; i <= 6; i++) {
				var current_date = new Date(selected_date.getFullYear(),selected_date.getMonth(), last_date.getDate() + j);
				$td = $('<td>');
				$td.addClass('graph24_cal-nextday');
				$span = $('<span>');
				$span.text(current_date.getDate());
				$td.append($span);
				$tr.append($td);
				j++;
			}	
			$('.calendar_body').append($tr);
		}

		$(".graph24_cal-active span").on("click", function() {
			changeDate($(this).attr("data-date"));
		});
	}

	function changeDate(_date) {
		date = _date;
		if($("#graph_temperature").prop('checked')) {
			temperature = 1;
		}
		if($("#graph_humidity").prop('checked')) {
			humidity = 1;
		}
		if($("#graph_illuminance").prop('checked')) {
			illuminance = 1;
		}		
		if($("#graph_active").prop('checked')) {
			active = 1;
		}
		if($("#graph_wake_up_time").prop('checked')) {
			wake_up_time = 1;
		}
		if($("#graph_sleep_time").prop('checked')) {
			sleep_time = 1;
		}
		wake_up_time_data = "";
		sleep_time_data = "";
		drawGraph();
		drawData();
//		location.href = url;
	}

	$(".change_date").on("click", function() {
		changeDate($(this).attr("data-date"));
	});

	$(".graph_setting").click(function() {
		console.log("graph_setting");
		//センサーの設定
		var params = {
			id:$('#sensor_id').val(),
			temperature_level:$('#temperature_level').val(),
			fire_level:$('#fire_level').val(),
			heatstroke_level:$('#heatstroke_level').val(),
			mold_mites_level:$('#mold_mites_level').val(),
			humidity_level:$('#humidity_level').val(),
			illuminance_daytime_level:$('#illuminance_daytime_level').val(),
			illuminance_night_level:$('#illuminance_night_level').val(),
			wake_up_level:$('#wake_up_level').val(),
			sleep_level:$('#sleep_level').val(),
			abnormal_behavior_level:$('#abnormal_behavior_level').val(),
			active_non_detection_level:$('#active_non_detection_level').val(),
			active_night_level:$('#active_night_level').val(),
			wake_up_start_time:$('#wake_up_start_time').val(),
			wake_up_end_time:$('#wake_up_end_time').val(),
			sleep_start_time:$('#sleep_start_time').val(),
			sleep_end_time:$('#sleep_end_time').val(),
		};
		api("sensor/save", params, function(result){
			console.log("sensor success");
		});

		//ユーザごとの設定
		var params = {
			user_id:$('#user_id').val(),
			sensor_id:$('#sensor_id').val(),
			temperature_alert:$('#temperature_alert').hasClass("mail_on") ? 1 : 0,
			fire_alert:$('#fire_alert').hasClass("mail_on") ? 1 : 0,
			heatstroke_alert:$('#heatstroke_alert').hasClass("mail_on") ? 1 : 0,
			mold_mites_alert:$('#mold_mites_alert').hasClass("mail_on") ? 1 : 0,
			humidity_alert:$('#humidity_alert').hasClass("mail_on") ? 1 : 0,
			illuminance_daytime_alert:$('#illuminance_daytime_alert').hasClass("mail_on") ? 1 : 0,
			illuminance_night_alert:$('#illuminance_night_alert').hasClass("mail_on") ? 1 : 0,
			wake_up_alert:$('#wake_up_alert').hasClass("mail_on") ? 1 : 0,
			sleep_alert:$('#sleep_alert').hasClass("mail_on") ? 1 : 0,
			abnormal_behavior_alert:$('#abnormal_behavior_alert').hasClass("mail_on") ? 1 : 0,
			active_non_detection_alert:$('#active_non_detection_alert').hasClass("mail_on") ? 1 : 0,
			active_night_alert:$('#active_night_alert').hasClass("mail_on") ? 1 : 0,
			snooze_times:$('#snooze_times').val(),
			snooze_interval:$('#snooze_interval').val(),
		};
		api("/user/sensor/save", params, function(result){
			console.log("user sensor success");
			console.log(params);
		});
	});
	function drawGraph() {
		api("data/graph?sensor_id=" + sensor_id + "&type=temperature&span=10&date=" + date, null, function(result){
			console.log("drawGraph");
			var values = [];
			var graphs = [];			
			var display_graphs = [];
			Cookies.set('active', $("#graph_active").prop('checked'), { expires: 90 });
			Cookies.set('temperature', $("#graph_temperature").prop('checked'), { expires: 90 });
			Cookies.set('humidity', $("#graph_humidity").prop('checked'), { expires: 90 });
			Cookies.set('illuminance', $("#graph_illuminance").prop('checked'), { expires: 90 });
			Cookies.set('wake_up_time', $("#graph_wake_up_time").prop('checked'), { expires: 90 });
			Cookies.set('sleep_time', $("#graph_sleep_time").prop('checked'), { expires: 90 });

			if($("#graph_active").prop('checked')) {
				display_graphs.push({
					value:{
				        "id":"active",
				        "axisColor": "#FFCCFF",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    },
				    graph:{
						"valueAxis": "active",
						"lineColor": "#FFCCFF",
				        "columnWidth": 1,
				        "fillAlphas": 1,
				        "title": "運動量",
				        "type": "column",
				        "connect": false,
				        "valueField": "active",
					}
				});		
			}
			if($("#graph_temperature").prop('checked')) {
				display_graphs.push({
					value:{
				        "id":"temperature",
				        "axisColor": "#FF9900",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left"
				    },
				    graph:{
				        "valueAxis": "temperature",
				        "lineColor": "#FF9900",
				        "lineThickness": 2,
				        "title": "室温",
				        "connect": false,
				        "valueField": "temperature",
					}
				});
			}
			if($("#graph_humidity").prop('checked')) {
				display_graphs.push({
					value:{
				        "id":"humidity",
				        "axisColor": "#88D3F5",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    },
				    graph:{
				        "valueAxis": "humidity",
				        "lineColor": "#88D3F5",
				        "lineThickness": 2,
				        "title": "湿度",
				        "connect": false,
				        "valueField": "humidity",
					}
				});	
			}
			if($("#graph_illuminance").prop('checked')) {
				display_graphs.push({
					value:{
				        "id":"illuminance",
				        "axisColor": "#DED31C",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    },
				    graph:{
				        "valueAxis": "illuminance",
				        "lineColor": "#DED31C",
				        "lineThickness": 2,
				        "title": "照度",
				        "connect": false,
				        "valueField": "illuminance",
					}
				});			
			}

			$.each(result.data, function(i, item){
				if(typeof wake_up_time_data != "undefined") {
					if(wake_up_time_data == item.time.substring(11, 16)) {
						result.data[i].wake_up_time = 5;
					}
					if(sleep_time_data == item.time.substring(11, 16)) {
						result.data[i].sleep_time = 5;
					}	
				}
			});
			if($("#graph_wake_up_time").prop('checked')) {
				values.push({
				    "id":"wake_up_time",
			        "axisThickness": 0,
			        "gridAlpha": 0,
			        "axisAlpha": 0,
			        "color":"#FFFFFF",
				    "position": "left",
				});
				graphs.push({
					"valueAxis": "wake_up_time",
					"lineColor": "#FF0000",
					"useLineColorForBulletBorder": true,
			        "bullet": "round",
			        "bulletBorderAlpha": 1,
			        "bulletSize": 8,
			        "bulletColor": "#FFFFFF",
			        "title": "起床時間",
			        "valueField": "wake_up_time",
					"fillAlphas": 0
				});												
			}
			if($("#graph_sleep_time").prop('checked')) {
				values.push({
				    "id":"sleep_time",
			        "axisThickness": 0,
			        "gridAlpha": 0,
			        "axisAlpha": 0,
			        "color":"#FFFFFF",
				    "position": "left",
				});
				graphs.push({
					"valueAxis": "sleep_time",
					"lineColor": "#3300FF",
					"useLineColorForBulletBorder": true,
			        "bullet": "round",
			        "bulletBorderAlpha": 1,
			        "bulletSize": 8,
			        "bulletColor": "#FFFFFF",
			        "title": "睡眠時間",
			        "valueField": "sleep_time",
					"fillAlphas": 0
				});	
			}
			$.each(display_graphs, function(i, item){
				if(i % 2 == 0) {
					item.value.position = "left";
				} else {
					item.value.position = "right";
				}
				item.value.offset = parseInt(i / 2) * 50;
				values.push(item.value);
			    graphs.push(item.graph);
			});

			var chart = AmCharts.makeChart("graph", {
			    "type": "serial",
			    "theme": "light",
			    "legend": {
			        "useGraphSettings": true
			    },
			    "dataProvider": result.data,
			    "valueAxes": values,
			    "graphs": graphs,
			    "chartCursor": {
			        "cursorPosition": "mouse"
			    },
			    "categoryField": "label",
			    "categoryAxis": {
			        "parseDates": false,
			        "axisColor": "#DADADA",
			        "minorGridEnabled": true
			    },
			});
		});			

	}

	//カート系の処理
    getCartPlans();

    function getCartPlans() {
		api("shopping/get_plans", {}, function(result){
			displayCartPlans(result);
		});
    }

    function displayCartPlans(result) {
		$("#cart").empty();
    	if(result.data.plans != null) {
			$.each(result.data.plans, function(index, plan) {
				$("#cart").append("<li id=\"nav_order" + plan.id + "\" class=\"nav_userList cart_plan\"><p class=\"nav_cart_title\">" + 
											plan.options[0].title + 
											"</p><p class=\"nav_cart_btnArea right\"><a href=\"javascript:void(0);\" data-plan=\"" + plan.id + "\" class=\"delete_plan nav_cart_link\" id=\"nav_cart_delete01\">× 削除</a></p></li>");
			});
			$("#cart").append("<li><p class=\"nav_cart_btnArea\"><a href=\"/shopping/cart\" class=\"nav_cart_btn\">購入手続きへ</a></p></li>");
			$('.delete_plan').on('click', function(){
				event.preventDefault();
				var plan = $(this).attr('data-plan');
				api("shopping/delete_plan", { plan_id : plan }, function(result){
					displayCartPlans(result);
				});
				//$('#nav_order' + plan).remove();
				$('#nav_cart').addClass("opened");
				$('.opened').delay().queue(function(){
					$('#nav_cart').removeClass("opened");
					$('#nav_cart').addClass("open").dequeue();
				});
				$('.nav_cart_alert').fadeIn(1000).delay().fadeOut(500);
				return false;
			});
			$(".nav_number").css('display', 'run-in');
    	} else {
    		$(".nav_number").css('display', 'none');
    		$("#cart").prepend("<li class=\"nav_userList center cart_plan\"><p class=\"nav_cart_title\">何も入っていません</p></li>");
    	}
		console.log(result);
    }
    //ショッピングページ用
    $(".shoppingFancybox").click(function(event) {
		if(typeof $(this).attr('data-plan') != "undefined") {
			var plan_ids = [];
			var plan = $(this).attr('data-plan');
			if(plan == '1') {
				plan_ids.push(1);
			} else if(plan == '2') {
				plan_ids.push(2);
			} else if(plan == '3') {
				plan_ids.push(3);
			}
			plan_ids.push(4);	//初期費用
			if($("#pack" + plan).prop('checked')) {
				plan_ids.push(5);	//wifi貸出
			}
	        Cookies.set("plan_id", JSON.stringify(plan_ids), { expires: 90 });
		}
    });


 	$(".shoppingFancybox").fancybox();
	$(".startShopping").click(function(event) {
		api("shopping/set_plans", { plan_ids : JSON.parse(Cookies.get("plan_id")) }, function(result){
			displayCartPlans(result);
		});
    });
});