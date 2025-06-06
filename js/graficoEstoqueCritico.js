var dataChartEstoqueCritico = [];
carregaChartEstoqueCritico();

function carregaChartEstoqueCritico() {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '../db/chartEstoqueCritico.php',
        data: {}
    }).done(function (data) {
        dataChartEstoqueCritico = []; 
        $.each(data.data, function (key, value) {
            dataChartEstoqueCritico.push([value.produto, Number(value.quantidade)]);
        });

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Produto');
        data.addColumn('number', 'Quantidade');

        data.addRows(dataChartEstoqueCritico);

        var options = {
            title: 'Produtos com Estoque Crítico',
            legend: { position: 'none' },
            colors: ['#e0440e'],
            bars: 'vertical',
            bar: { groupWidth: '60%' },
            chartArea: { left: 50, top: 50, width: '80%', height: '70%' },
            hAxis: {
                slantedText: true,
                slantedTextAngle: 45
            },
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
            
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_estoque_critico'));
        chart.draw(data, options);
    }
}
