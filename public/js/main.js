$(function(){
    var apiUrl = "http://infic.papaikuji.info/api/";
    //var apiUrl = "http://infic.garoo.jp/api/";
    
    // ユーザ定義関数
    function api(action, params, callback){
	    $.post(
			apiUrl + action,
			params, 
			callback,
			"json"
	    );
    }

/*
	api("user/login_check", null, function(result){
		console.log(result.data);
	});
*/
/*
    $("#login").submit(function() {
		var params = {
			'username': $("#username").val(),
			'password': $("#password").val()
		};
		api("user/login", params, function(result){
			if(result.data) {
				console.log(result.data);
				location.href = "/user/";
			}
		});
		return false;
	});
*/
	drawGraph();

	$(".graph_checkbox").change(function() {
		drawGraph();
	});

	function drawGraph() {
		api("data/dashboard?sensor_id=" + sensor_id + "&date=" + date, null, function(result){
			console.log(result.data);
		});
		api("data/graph?sensor_id=" + sensor_id + "&type=temperature&span=10&date=" + date, null, function(result){
			var values = [];
			var graphs = [];
			
			if($("#graph_temperature").prop('checked')) {
				values.push({
				        "id":"temperature",
				        "axisColor": "#FF9900",
				        "axisThickness": 2,
				        "gridAlpha": 0,
				        "axisAlpha": 1,
				        "position": "left"
				    });
				graphs.push({
				        "valueAxis": "temperature",
				        "lineColor": "#FF9900",
				        "lineThickness": 2,
				        "bullet": "round",
				        "bulletBorderAlpha": 1,
				        "bulletSize": 8,
				        "bulletColor": "#FFFFFF",
				        "title": "室温",
				        "valueField": "temperature",
						"fillAlphas": 0,
						"useLineColorForBulletBorder": true
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
				        "bullet": "round",
				        "bulletBorderAlpha": 1,
				        "bulletSize": 8,
				        "bulletColor": "#FFFFFF",
				        "title": "湿度",
				        "valueField": "humidity",
						"fillAlphas": 0,
						"useLineColorForBulletBorder": true
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
				        "bullet": "round",
				        "bulletBorderAlpha": 1,
				        "bulletSize": 8,
				        "bulletColor": "#FFFFFF",
				        "title": "照度",
				        "valueField": "illuminance",
						"fillAlphas": 0,
						"useLineColorForBulletBorder": true
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
				        "valueField": "active"
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