<?php
	$file = glob("doc/rub".'/*');
	$file_rub = $file[0];

	$file = glob("doc/grn".'/*');
	$file_grn = $file[0];
?>

<td class="head" valign="bottom" align="right">
	<span id="login-head">Отследить заказ</span>
	<a title="Скачать прайс РУБЛИ" href="<?=$file_rub?>" id="doc-save2"></a>
	<a title="Скачать прайс ГРИВНЫ" href="<?=$file_grn?>" id="doc-save"></a>
    <a title="Корзина" href="order.php" id="cart"></a>
    
    <div class="Menu2">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="topMenuLeft">&nbsp;</td>
            <td class="topMenuCenter">
                <div><a href="index.php">Главная</a> </div>
                <div><a href="catalog.php">Каталог</a> </div>
                <div><a href="price.php">Прайс-лист</a>   </div>
                <div><a href="delivery.php">Заказ и оплата</a>   </div>
                <div> <a href="shop.php">Наши магазины</a>  </div>
                <div><a href="doc.php">Документы</a>   </div>
                <div><a href="franchising.php">Франчайзинг</a>   </div>
                <div style="border:none;"><a href="contact.php">Контакты.</a>   </div>
            </td>
            <td class="topMenuRight">&nbsp;</td>
          </tr>
        </table>
    </div>
    
</td>