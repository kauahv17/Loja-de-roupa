var dataChartFuncionario = [];
carregaChartFuncionario();

function carregaChartFuncionario() {
    $.ajax({
        dataType: 'json',
        type: 'POST',
        url: '../db/chartVendasPorFuncionario.php',
        data: {}
    }).done(function (data) {
        dataChartFuncionario = []; 
        $.each(data.data, function (key, value) {
            dataChartFuncionario.push([String(value.funcionario), Number(value.total_vendas)]);
        });

        google.charts.load('current', { packages: ['corechart'] });
        google.charts.setOnLoadCallback(drawChart);
    });

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Funcionário');
        data.addColumn('number', 'Valor Vendido');

        data.addRows(dataChartFuncionario);

        var options = {
            title: 'Valor Total de Vendas por Funcionário',
            width: 500,
            height: 400,
            pieHole: 0.4,  // DONUT
            pieSliceText: 'none',
            legend: { position: 'right', alignment: 'center' },
            chartArea: { left: 50, top: 50, width: '80%', height: '75%' },
            colors: ['#FF5733', '#33FF57', '#3357FF', '#FFC300', '#DAF7A6', '#C70039', '#900C3F', '#581845'],
            animation: {
                startup: true,
                duration: 1000,
                easing: 'out'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_vendas_funcionario'));
        chart.draw(data, options);
    }
}
