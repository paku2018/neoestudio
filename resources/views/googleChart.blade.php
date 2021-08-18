<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style type="text/css">
        @font-face {
            font-family: "Proxima Nova Regular";
            src: url("{{asset('neostudio/pnswr.ttf')}}");
        }

        @font-face {
            font-family: "Rounded Elegance";
            src: url("{{asset('neostudio/rou.ttf')}}");
        }

        ::-webkit-scrollbar {
            width: 0px; /* Remove scrollbar space */
            background: transparent; /* Optional: just make scrollbar invisible */
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('visualization', '1.1', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tema');
            data.addColumn('number', 'Conocimientos');
            data.addColumn('number', 'Inglés');
            data.addColumn('number', 'Psicotécnicos');
            data.addColumn('number', 'Ortografía');
            data.addColumn('number', 'Global sin baremo');
            data.addColumn('number', 'Global con baremo');


            data.addRows(<?php echo $mainData; ?>);
            // data.addRows([['E 1',80,90,80,70,60,50],['T 01',90,80,70,80,50,60],['T 02',40,50,60,70,80,90],['T 03',60,50,40,80,90,80],['T 04',70,50,60,80,90,70],['T 05',50,90,80,70,60,50],['T 06',null,null,null,null,null,null],['T 07',null,null,null,null,null,null],['T 08',null,null,null,null,null,null],['T 09',null,null,null,null,null,null],['T 10',null,null,null,null,null,null],['T 11',null,null,null,null,null,null],['T 12',null,null,null,null,null,null],['T 13',null,null,null,null,null,null],['T 14',null,null,null,null,null,null],['T 15',null,null,null,null,null,null],['T 16',null,null,null,null,null,null],['T 17',null,null,null,null,null,null],['T 18',null,null,null,null,null,null],['T 19',null,null,null,null,null,null],['T 20',null,null,null,null,null,null],['T 21',null,null,null,null,null,null],['T 22',null,null,null,null,null,null],['F 01',null,null,null,null,null,null],['F 02',null,null,null,null,null,null],['F 03',null,null,null,null,null,null],['F 04',null,null,null,null,null,null],['F 05',null,null,null,null,null,null],['F 06',null,null,null,null,null,null]]);
            //var data = google.visualization.arrayToDataTable(<?php //echo $mainData; ?>);
            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1, {
                calc: 'stringify',
                sourceColumn: 1,
                type: 'string',
                role: 'annotation'
            }, 2, {calc: 'stringify', sourceColumn: 2, type: 'string', role: 'annotation'}, 3, {
                calc: 'stringify',
                sourceColumn: 3,
                type: 'string',
                role: 'annotation'
            }, 4, {calc: 'stringify', sourceColumn: 4, type: 'string', role: 'annotation'}, 5, {
                calc: 'stringify',
                sourceColumn: 5,
                type: 'string',
                role: 'annotation'
            }, 6, {calc: 'stringify', sourceColumn: 6, type: 'string', role: 'annotation'}]);


            var options = {
                chartArea: {
                    left: 30,
                    right: 15,
                    width: '100%'
                },
                //chartArea:{
                //width:1350,
                //height: 500

                //},
                lineWidth: 2,
                pointSize: 1,
                legendTextStyle: {color: '#c6c6c6', fontSize: 9},
                legend: {position: 'bottom', alignment: 'center'},
                backgroundColor: 'transparent',
                annotations: {
                    style: 'point',
                    stem: {
                        color: 'transparent'
                    },

                    textStyle: {
                        color: '#c6c6c6',
                        bold: true,
                        fontSize: 7,

                    }
                },
                vAxis: {
                    textStyle: {color: '#c6c6c6', bold: true, fontSize: 9},
                    minorGridlines: {
                        color: 'transparent'
                    },
                    gridlines: {
                        color: '#696969',
                        count: 10
                    },
                    viewWindow: {
                        max: 100,
                        min: 0
                    }

                },

                hAxis: {
                    textStyle: {color: '#c6c6c6', bold: true, fontSize: 8}
                },
                series: {
                    0: {color: '#4574cc'},
                    1: {color: '#fe0000'},
                    2: {color: '#fffe00'},
                    5: {color: '#3b8631', curveType: 'function'},
                    4: {color: '#dddddd', curveType: 'function'},
                    3: {color: 'orange'}
                }
            };


            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(view, options);
        }
        $(window).resize(function () {
            drawChart();
        });
    </script>
</head>

<body style="background-image: url('rankBg.png');background-size: 100% 100%; background-repeat: no-repeat; font-family: Rounded Elegance;">


<div class="" style="">

    <h3 style="color: #dddddd; text-align: center; padding-top: 2%;">RANKING GLOBAL</h3>
    <!--<img src="Logo.png" style="width: 10%; float: right; margin-top: -5%;">-->

    <!--<div class="row">
      <div class="col-md-8">
        <h3 style="color: white; padding-top: 25px; margin-left: 65%">RANKING GLOBAL</h3>
      </div>
      <div class="col-md-4">
        <img src="Logo.png" style="width: 20%; padding-top: 20px; margin-left: 70%">
      </div>
    </div>
  -->
    <div id="curve_chart" style="height: 105%; margin-top: -8%;">

    </div>
</div>
</body>
</html>