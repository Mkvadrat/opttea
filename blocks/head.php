<?php
	$file = glob("doc/rub".'/*');
	$file_rub = $file[0];

	$file = glob("doc/grn".'/*');
	$file_grn = $file[0];
?>

<td class="head" valign="bottom" align="right">
	<span id="login-head">��������� �����</span>
	<a title="������� ����� �����" href="<?=$file_rub?>" id="doc-save2"></a>
	<a title="������� ����� ������" href="<?=$file_grn?>" id="doc-save"></a>
    <a title="�������" href="order.php" id="cart"></a>
    
    <div class="Menu2">
        <table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="topMenuLeft">&nbsp;</td>
            <td class="topMenuCenter">
                <div><a href="index.php">�������</a> </div>
                <div><a href="catalog.php">�������</a> </div>
                <div><a href="price.php">�����-����</a>   </div>
                <div><a href="delivery.php">����� � ������</a>   </div>
                <div> <a href="shop.php">���� ��������</a>  </div>
                <div><a href="doc.php">���������</a>   </div>
                <div><a href="franchising.php">�����������</a>   </div>
                <div style="border:none;"><a href="contact.php">��������.</a>   </div>
            </td>
            <td class="topMenuRight">&nbsp;</td>
          </tr>
        </table>
    </div>
    
</td>