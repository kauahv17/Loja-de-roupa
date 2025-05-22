<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="header-container">
    <div class="header-menu-bar">
        <div class="header-categorias">
            <a href="<?php echo $current_page; ?>?categoria="><button class="header-categoria">ver tudo</button></a>
            <a href="<?php echo $current_page; ?>?categoria=camiseta"><button class="header-categoria">camisetas</button></a>
            <a href="<?php echo $current_page; ?>?categoria=calca"><button class="header-categoria">calças</button></a>
            <a href="<?php echo $current_page; ?>?categoria=tenis"><button class="header-categoria">tênis</button></a>
            <a href="<?php echo $current_page; ?>?categoria=shorts"><button class="header-categoria">shorts</button></a>
            <a href="<?php echo $current_page; ?>?categoria=casaco"><button class="header-categoria">casacos</button></a>
            <a href="<?php echo $current_page; ?>?categoria=oculos"><button class="header-categoria">óculos</button></a>
        </div>
    </div>
</div> 