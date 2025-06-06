var dataChartMaisVendidos = [];
carregaChartMaisVendidos();

function carregaChartMaisVendidos() {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '../db/chartProdutosMaisVendidos.php',
        data: {}
    }).done(function (data) {
        dataChartMaisVendidos = []; 
        $.each(data.data, function (key, value) {
            dataChartMaisVendidos.push([value.produto, Number(value.total_vendido)]);
        });

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Produto');
        data.addColumn('number', 'Quantidade Vendida');

        data.addRows(dataChartMaisVendidos);

        var options = {
            title: 'Top 10 Produtos Mais Vendidos',
            legend: { position: 'none' },
            bar: { groupWidth: '60%' },
            chartArea: { left: 50, top: 50, width: '80%', height: '70%' },
            hAxis: {
                slantedText: true,
                slantedTextAngle: 45
            },
            colors: ['#4285F4'],
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_produtos_mais_vendidos'));
        chart.draw(data, options);
    }
}
