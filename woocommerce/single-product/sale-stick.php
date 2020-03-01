<?php
$show_sale = StockieSettings::show_sale_flash();
if ($show_sale) {
    woocommerce_show_product_loop_sale_flash();
}
?>
