<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/shop/cp.php');
    return;
}

define("_INDEX_", TRUE);

include_once(G5_SHOP_PATH.'/shop.head.php');
?>



<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');
?>