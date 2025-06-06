var dataChartVendasDia = [];
carregaChartVendasDia();

function carregaChartVendasDia() {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '../db/chartVendasPorDia.php',
        data: {}
    }).done(function (data) {
        dataChartVendasDia = []; 
        $.each(data.data, function (key, value) {
            dataChartVendasDia.push([String(value.dia), Number(value.total_vendas)]);
        });

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dia');
        data.addColumn('number', 'Vendas');

        data.addRows(dataChartVendasDia);

        var options = {
            title: 'Vendas por Dia',
            curveType: 'function',
            legend: { position: 'none' },
            chartArea: { left: 50, top: 50, width: '80%', height: '70%' },
            hAxis: {
                slantedText: true,
                slantedTextAngle: 45,
                title: 'Data'
            },
            vAxis: {
                title: 'Quantidade de Vendas'
            },
            colors: ['#3366CC'],
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_vendas_dia'));
        chart.draw(data, options);
    }
}
