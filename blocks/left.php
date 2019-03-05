<td class="leftPanel" valign="top" id="leftShop">
                    	<div class="menu">
                                <div class="topMenu"></div>
                                <div class="cenMenu"> 
                                	<b class="zaglav">Продукция </b>
                                    <?
                                        $ForCatLeft=mysql_query("SELECT * FROM `categories` order by `ord` ");
                                        while ($RowCatLeft=mysql_fetch_array($ForCatLeft)) {
                                            echo('
                                                <div class="categMenu"><a href="tea.php?cat='.$RowCatLeft['id'].'"> '.$RowCatLeft['nam_categories'].' </a></div>
                                            ');
                                        }
                                      //  echo('<div class="categMenu"><a href="soap.php"> Фигурное мыло </a></div>');
                                    ?>
                                </div>
                                <div class="botMenu"></div>
                        </div>
                    </td>