<page backcolor="#FEFEFE" backtop="0" backbottom="30mm" footer="date;time;page" style="fontsize: 12pt">
    <bookmark title="Lettre" level="0" ></bookmark>
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px">
        <tr>
            <td style="width: 25%;">
            </td>
            <td style="width: 50%; color: #111199; font-size: 16pt; font-weight: bold;">
                <img style="width: 50%;" src="../img/fatec.jpg" alt="Logo"><br>
                Relatório de vendas por dia
            </td>
            <td style="width: 25%;"></td>
        </tr>
    </table>
    <br>
    <br>
    <table cellspacing="0" style="width: 100%; text-align: left; font-size: 12pt;">
        <thead>
            <tr style="font-size: 14pt; font-weight: bold; border-spacing: 100pt;" >
                <td style="width:25%;"></td>
                <td style="width:40%;">Dia</td>
                <td style="width:15%">Total de vendas</td>
                <!-- <td style="width:20%"></td> -->
            </tr>
        </thead>
        <br>
        <br>
        <tbody>
            <?php
                include_once ('../../db/conexao.php');
                $sql =  "SELECT DATE(data_venda) AS dia, COUNT(*) AS total_vendas 
                        FROM venda 
                        GROUP BY dia 
                        ORDER BY dia";
                $result = $conn->query($sql);
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                $conn->close();
                foreach ($rows as $linha) {
            ?>
            <tr>
                <td style="width:25%;">
                    <barcode dimension="1D" type="S25" value="<?php echo $linha['data_venda'] ?>"
                    label="label" style="width:25mm; height:6mm; color: #0000FF; font-size: 4mm" />
                </td>
                <td style="width:4%;"><?php echo $linha['data_venda'] ?></td>
                <td style="width:15%"><?php echo $linha['total_vendas'] ?></td>
                
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <br>
</page>