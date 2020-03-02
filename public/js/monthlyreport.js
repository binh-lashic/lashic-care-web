/*
 * マンスリーレポート
 */
$(window).on('load', function() {

    // APIを並列で実行
    dispLoading();
    $.when(
        get_trend(user_id),
        get_monthlies(user_id),
        get_dailies(user_id, year, month)
    ).done(function(data) {
        // ローディングインジケータ表示
        setTimeout(function() {
            removeLoading();
       },  1500);
    }).fail(function() {
        alert('失敗しました。');
    });
    
});
function formatValue (value) {
    return Math.round(value * 10) / 10;
}
/*
 * ローディング画像表示
 */
function dispLoading(msg){
    if($("#loading").size() == 0){
        $("body").append("<div id='loading'></div>");
    } 
}
 
 /*
  * ローディング画像非表示
  */
function removeLoading(){
    $("#loading").remove();
}

/*
 * 傾向と対策
 * 
 * @param int user_id
 */
var get_trend = function(user_id) {
    $.ajax({
        url : '/api/monthlyreport/gettrend?user_id=' + user_id,
        type:"GET",
        dataType: "json"
    }).done(function(data) {
        $('#activity').html(data.trends.activity.replace(/\r?\n/g, '<br>'));
        $('#sleep').html(data.trends.sleep.replace(/\r?\n/g, '<br>'));
        $('#environment').html(data.trends.environment.replace(/\r?\n/g, '<br>'));
        $('#dementia').html(data.trends.dementia.replace(/\r?\n/g, '<br>'));
    });
};
       
/*
 * 過去6ヶ月平均
 * 
 * @param int user_id
 */
var get_monthlies = function(user_id) {
    $.ajax({
        url : '/api/monthlies/get?user_id=' + user_id,
        type:"GET",
        dataType:"json"
    }).done(function(data) {
        activity_monthlytrend_columnChart(data.result);
        sleep_monthlytrend_columnChart(data.result);
    });
};

/*
 * 月間推移
 * 
 * @param int user_id
 * @param int year
 * @param int month
 */
var get_dailies = function(user_id, year, month) {
    $.ajax({
        url : '/api/dailies/get?user_id=' + user_id + '&year=' + year + '&month=' + month,
        type:"GET",
        dataType:"json"
    }).done(function(data) {
        activity_monthlytrend_lineChart(data.result);
        sleep_monthlytrend_timeline(data.result);
        temperature_monthlytrend_lineChart(data.result);
        humidity_monthlytrend_lineChart(data.result);
    });
};
        
/*
 * 運動量　月間推移（折れ線グラフ）
 *
 * @param array datas
 */
function activity_monthlytrend_lineChart(datas)
{
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', '日付');
        data.addColumn('number', '運動量');

        data.addRows($activity_lineChart_data(datas));

        var options = {
            vAxis: { gridlines: {color: "#E2E2E2"}, baselineColor: "#E2E2E2", textStyle: { fontSize: 13, color: '#747474' } },
            hAxis: { baselineColor: "#E2E2E2", format: "M/d", textStyle: { fontSize: 13, color: '#747474' } },
            chartArea: {left: 55, bottom: 25, top: 5, right: 5, width: "100%", height: "100%", backgroundColor: "#F9F9F9" },
            legend: { position: 'none' },
            colors:['#F2ABD5'],
            pointSize : 5,
        };

        var chart = new google.visualization.LineChart(document.getElementById('activity_linechart'));
        chart.draw(data, options);
    } 
}

/*
 * 運動量　過去平均との比較（棒グラフ）
 * 
 * @param array datas
 */
function activity_monthlytrend_columnChart(datas)
{
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '日付');
        data.addColumn('number', '運動量 ');
        data.addRows($activity_columnChart_data(datas));

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                         { 
                            calc: function(dataTable, rowIndex) {
                                return dataTable.getFormattedValue(rowIndex, 1);
                            },
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation"
                        }
                    ]);

        var options = {
            annotations: { textStyle: { fontSize: 14, color: '#747474', auraColor: "transparent" }, alwaysOutside: true },
            chartArea: { left:0, bottom: 25, top: 5, right: 5, width: "100%", height: "100%" },
            vAxis: { gridlines: {color: "transparent"}, baselineColor: "#E2E2E2", textStyle: { fontSize: 13, color: '#747474' } },
            hAxis: { format: "M月", gridlines: {color: "transparent" }, textStyle: { fontSize: 13, color: '#747474' } },
            colors: ['#F2ABD5'],
            legend: { position: 'none'}
        };
      
    var chart = new google.visualization.ColumnChart(document.getElementById('activity_columnchart'));
    chart.draw(view, options);
  }
}

 /*
  * 睡眠時間　月間推移(タイムライン)
  * 
  * @param array data
  */
function sleep_monthlytrend_timeline(datas)
{
    var chart = AmCharts.makeChart("sleep_timeline", {
                    "theme": "light",
                    "type": "serial",
                    "marginTop": 0,
                    "marginBottom": 0,
                    "dataProvider": $sleep_timeline_data(datas),
                    "valueAxes": [
                        {
                            "axisAlpha": 0,
                            "labelFunction": function(value) {
                                var labelHour="";
                                if (value <= 23) {
                                    labelHour = value;
                                } else {
                                    labelHour = value - 24;
                                }
                                return labelHour +'時';
                            },
                            "guides": [
                                {
                                    "fillAlpha": 0.1,
                                    "fillColor": "#CCCCCC",
                                    "lineAlpha": 0,
                                    "toValue": 100,
                                    "value": 0
                                }
                            ],
                            "gridAlpha": 0.3,
                            "gridColor": "#DADADA",
                        }
                    ],
                    "startDuration": 0,
                    "graphs": [{
                            "balloonText": "<b>[[category]]</b><br>就寝時間: [[last_sleep_time]]<br>起床時間: [[wake_up_time]]",
                            "fillAlphas": 0.8,
                            "lineAlpha": 0,
                            "openField": "start",
                            "type": "column",
                            "valueField": "end",
                            "lineColor": "#D3B9E8"
                    }],
                    "rotate": true,
                    "columnWidth": 0.5,
                    "categoryField": "date",
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "gridAlpha": 0.1,
                        "position": "left",
                        "labelFunction": function(value) {
                            var date = new Date(value);
                            return (date.getMonth()+1)+ '/' +  date.getDate();
                        },
                        "gridColor": "#DADADA",
                        "gridAlpha": 1
                    },
                    "export": {
                        "enabled": true
                    }
                }); 
}

/*
 * 睡眠時間　過去平均との比較（棒グラフ）
 * 
 * @param array datas
 */
function sleep_monthlytrend_columnChart(datas)
{
    google.charts.load("current", {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', '日付');
        data.addColumn('number', '睡眠平均時間');
        data.addRows($sleep_columnChart_data(datas));

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                         { 
                            calc: function(dataTable, rowIndex) {
                                return dataTable.getFormattedValue(rowIndex, 1) + 'h';
                            },
                            sourceColumn: 1,
                            type: "string",
                            role: "annotation"
                        }]);

        var options = {
            height: 152,
            width: 752,
            annotations: { textStyle: { fontSize: 14, color: '#747474', auraColor: "transparent" }, alwaysOutside: true },
            chartArea: { left: 0, bottom: 25, top: 0, right: 5, width: "100%" , height: "100%", style: {"stroke-width": 0} },
            vAxis: { gridlines: {color: "transparent"}, baselineColor: "#E2E2E2", textStyle: { fontSize: 13, color: '#747474' } },
            hAxis: { format: "M月", gridlines: {color: "transparent" }, baselineColor: "#E2E2E2", textStyle: { fontSize: 13, color: '#747474' } },
            colors: ['#D3B9E8'],
            legend: { position: 'none'},
        };

    var chart = new google.visualization.ColumnChart(document.getElementById('sleep_columnchart'));
    chart.draw(view, options);
  }
}

/*
 * 月間推移  気温平均 (折れ線グラフ)
 * 
 * @param array datas
 */
function temperature_monthlytrend_lineChart(datas)
{
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', '日付');
        data.addColumn('number', '気温');

        data.addRows($temperature_lineChart_data(datas));

        var options = {
            width: "671",
            vAxis: { gridlines: {color: "transparent"}, format: "####° ", baselineColor: "#E2E2E2", textStyle: { fontSize: 13, color: '#747474' } },
            hAxis: { gridlines: {color: "#E2E2E2"}, format: "M/d", textStyle: { fontSize: 13, color: '#747474' } },
            chartArea: {left: 45, bottom: 25, top: 5, right: 5, width: "100%", height: "100%", backgroundColor: '#F9F9F9'},
            legend: { position: 'none' },
            colors:['#FD8204'],
            pointSize : 5
        };

        var chart = new google.visualization.LineChart(document.getElementById('temperature_linechart'));

        chart.draw(data, options);
    } 
}

/*
 * 月間推移  湿度平均 (折れ線グラフ)
 * 
 * @param array datas
 */
function humidity_monthlytrend_lineChart(datas)
{
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('date', '日付');
        data.addColumn('number', '湿度');

        data.addRows($humidity_lineChart_data(datas));

        var options = {
            width: "671",
            vAxis: { gridlines: {color: "transparent"}, format: "####％", baselineColor: "#E2E2E2", textStyle: { fontSize: 13, color: '#747474' } },
            hAxis: { gridlines: {color: "#E2E2E2"}, format: "M/d", textStyle: { fontSize: 13, color: '#747474' } },
            chartArea: {left: 45, bottom: 25, top: 5, right: 5, width: "100%", height: "100%", backgroundColor: '#F9F9F9'},
            legend: { position: 'none' },
            colors:['#7FCEF4'],
            pointSize : 5
        };

        var chart = new google.visualization.LineChart(document.getElementById('humidity_linechart'));

        chart.draw(data, options);
    } 
}

/*
 * 運動量 棒グラフ用データ設定
 * 
 * @param array data
 * @return array
 */
$activity_columnChart_data = function(data) {
    var datas = [];
    $.each(data, function(key, value) {
        var values = [];
        values.push(value.month+'月');
        
        if(value.activity === undefined) {
            values.push(0);
        } else {
            values.push(Number(formatValue(value.activity)));
        }
        datas.push(values);
    });
    return datas;
};

/*
 * 運動量 折れ線グラフ用データ設定
 * 
 * @param array data
 */
$activity_lineChart_data = function(data) {
    var datas = [];
    $.each(data, function(key, value) {
        var values = [];
        
        // ラベルの日付を整形
        var date = new Date(value.date);
        values.push(new Date(date.getFullYear(), date.getMonth(), date.getDate()));
        values.push(Number(value.activity));
        datas.push(values);
    });
    return datas;
};

 /*
  * 睡眠時間　月間推移データ設定
  * 日付のフォーマット変換と就寝時間から経過時間を計算
  * 
  * @param array data
  * @return array
  */
$sleep_timeline_data = function(data) {
    var datas = [];
    $.each(data, function(key, value) {
        var values = [];
        // wake_up_timeもしくはlast_sleep_timeがない場合は飛ばす
        if(value.last_sleep_time !== undefined && value.wake_up_time !== undefined) {
            
            // ラベルの日付を整形
            //var date = new Date(value.date);
            values['date'] = value.date;
            values['last_sleep_time'] = value.last_sleep_time;
            values['wake_up_time'] = value.wake_up_time;

            // 就寝時間を10進数で設定
            var last_sleep_time = new Date(value.last_sleep_time.replace(/-/g, '/'));
            values['start'] = last_sleep_time.getHours() + (last_sleep_time.getMinutes() / 60);

            // 就寝時間から起床時間までの時間を10進数で設定 
            var add_hours = 0;
            var add_minutes = 0;
            var calc = new Date((+new Date(value.wake_up_time.replace(/-/g, '/'))) - (+new Date(value.last_sleep_time.replace(/-/g, '/'))));
            var sec = last_sleep_time.getSeconds() + calc.getUTCSeconds();
            if (sec > 60) {
                add_minutes = 1;
                sec = sec - 60;
            }
            var min = last_sleep_time.getMinutes() + calc.getUTCMinutes() + add_minutes;
            if (min > 60) {
                add_hours = 1;
                min = min - 60;
            }
            var hours = last_sleep_time.getHours() + calc.getUTCHours() + add_hours;
            values['end'] = hours + ( min / 60 );

            datas.push(values);
        }
    });
    return datas;
};

 /*
  * 睡眠時間　過去平均との比較データ設定
  * 睡眠平均時間の算出 
  * 
  * @param array data
  */
$sleep_columnChart_data = function(data) {
    var datas = [];
    $.each(data, function(key, value) {
        var values = [];
        values.push(value.month+'月');
        
        if(value.sleeping_time === undefined) {
            values.push(0);
        } else {
            // 分を時間に変換
            var num = Number(value.sleeping_time);
            var hour = num / 60;

            values.push(formatValue(hour));
        }
        datas.push(values);
    });
    return datas;
};

/*
 * 月間推移  気温平均データ設定
 * 
 * @param array data
 */
$temperature_lineChart_data = function(data) {
    var datas = [];
    $.each(data, function(key, value) {
        var values = [];  
        // ラベルの日付を整形        
        var date = new Date(value.date);
        values.push(new Date(date.getFullYear(), date.getMonth(), date.getDate()));
        
        // レスポンスがStringなのでIntに型変換
        values.push(Number(value.temperature));
        datas.push(values);
    });
    return datas;
};

/*
 * 月間推移  湿度平均データ設定
 * 
 * @param array data
 */
$humidity_lineChart_data = function(data) {
    var datas = [];
    $.each(data, function(key, value) {
        var values = [];  
        // ラベルの日付を整形
        var date = new Date(value.date);
        values.push(new Date(date.getFullYear(), date.getMonth(), date.getDate()));
        
        // レスポンスがStringなのでIntに型変換
        values.push(Number(value.humidity));
        datas.push(values);
    });
    return datas;
};