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

    if(typeof temperature != "undefined") {
		$("#graph_temperature").prop('checked', true);
	}
    if(typeof humidity != "undefined") {
		$("#graph_humidity").prop('checked', true);
	}
    if(typeof illuminance != "undefined") {
		$("#graph_illuminance").prop('checked', true);
	}
    if(typeof active != "undefined") {
		$("#graph_active").prop('checked', true);
	}
    if(typeof wake_up_time != "undefined") {
		$("#graph_wake_up_time").prop('checked', true);
	}
    if(typeof sleep_time != "undefined") {
		$("#graph_sleep_time").prop('checked', true);
	}

	setInterval(
		function() {
			drawGraph();
			drawData();
		},
	60000);

	if(typeof sensor_id != "undefined" && typeof date != "undefined" ) {
		drawGraph();
		drawData();
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
		api("data/dashboard?sensor_id=" + sensor_id + "&date=" + date, null, function(result){
			$("#data_temperature").attr("data-text", result.data.temperature + "°C");
			$("#data_humidity").attr("data-text", result.data.humidity + "%");
			$("#data_illuminance").attr("data-text", result.data.illuminance + "lux");
			$("#data_active").attr("data-text", result.data.active);
			$("#data_discomfort").attr("data-text", result.data.discomfort + "%");
			$('.myStat').empty();
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

	function changeDate(date) {
		var url =  "/user/?date=" + date;
		if($("#graph_temperature").prop('checked')) {
			url += "&temperature=1";
		}
		if($("#graph_humidity").prop('checked')) {
			url += "&humidity=1";
		}
		if($("#graph_illuminance").prop('checked')) {
			url += "&illuminance=1";
		}		
		if($("#graph_active").prop('checked')) {
			url += "&active=1";
		}
		if($("#graph_wake_up_time").prop('checked')) {
			url += "&wake_up_time=1";
		}
		if($("#graph_sleep_time").prop('checked')) {
			url += "&sleep_time=1";
		}
		location.href = url;
	}

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
			if($("#graph_wake_up_time").prop('checked') || $("#graph_sleep_time").prop('checked')) {
				api("data/dashboard?sensor_id=" + sensor_id + "&date=" + date, null, function(result){
					/*
					if($("#graph_wake_up_time").prop('checked')) {
						graphs.push({
						        "valueAxis": "wake_up_time",
						        "bullet": "round",
						        "bulletBorderAlpha": 1,
						        "bulletSize": 8,
						        "bulletColor": "#FFFFFF",
						        "title": "湿度",
						        "valueField": "humidity",
								"fillAlphas": 0
							});							
					}*/
				});
			}		
			if($("#graph_temperature").prop('checked')) {
				values.push({
				        "id":"temperature",
				        "color": "#FF9900",
				        "gridAlpha": 0,
				        "axisAlpha": 0,
				        "position": "left"
				    });
				graphs.push({
				        "valueAxis": "temperature",
				        "lineColor": "#FF9900",
				        "lineThickness": 2,
				        "title": "室温",
				        "connect": false,
				        "valueField": "temperature",
					});			
			}
			if($("#graph_humidity").prop('checked')) {
				values.push({
				        "id":"humidity",
				        "axisColor": "#88D3F5",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    });
				graphs.push({
				        "valueAxis": "humidity",
				        "lineColor": "#88D3F5",
				        "lineThickness": 2,
				        "title": "湿度",
				        "connect": false,
				        "valueField": "humidity",
					});			
			}
			if($("#graph_illuminance").prop('checked')) {
				values.push({
				        "id":"illuminance",
				        "axisColor": "#DED31C",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    });
				graphs.push({
				        "valueAxis": "illuminance",
				        "lineColor": "#DED31C",
				        "lineThickness": 2,
				        "title": "照度",
				        "connect": false,
				        "valueField": "illuminance",
					});			
			}
			if($("#graph_active").prop('checked')) {
				values.push({
				        "id":"active",
				        "axisColor": "#EB71B6",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left",
       					"offset": values.length * 50,
				    });    
				graphs.push({
						"valueAxis": "active",
						"lineColor": "#EB71B6",
				        "columnWidth": 1,
				        "fillAlphas": 1,
				        "title": "運動量",
				        "type": "column",
				        "connect": false,
				        "valueField": "active",
				    });			
			}
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
});