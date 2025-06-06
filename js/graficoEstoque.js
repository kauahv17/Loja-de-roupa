var dataChartEstoque = [];
carregaChartEstoque();

function carregaChartEstoque() {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '../db/chartEstoque.php',
        data: {}
    }).done(function (data) {
        dataChartEstoque = []; 
        $.each(data.data, function (key, value) {
            dataChartEstoque.push([String(value.descricao), Number(value.total)]);
        });

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tipo de Produto');
        data.addColumn('number', 'Quantidade');

        data.addRows(dataChartEstoque);

        var options = {
            title: 'Estoque por Tipo de Produto',
            width: 500,
            height: 400,
            pieHole: 0.4,  // DONUT
            pieSliceText: 'none',
            legend: { position: 'right', alignment: 'center' },
            chartArea: { left: 20, top: 50, width: '80%', height: '75%' },
            colors: ['#3300CC', '#DC3912', '#FF9900', '#109618', '#990099'],
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
}
