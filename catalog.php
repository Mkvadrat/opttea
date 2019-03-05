<? include ("blocks/db.php");
$rezult = mysql_query ("SELECT title, meta_d, meta_k, text FROM set_table_sist WHERE page='index'",$db);
if (mysql_num_rows($rezult)>0){
		$row = mysql_fetch_array($rezult);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/scroll.js"></script>
<script type="text/javascript" src="js/revol.js"></script>

<meta name="description" content="<?php echo $row['meta_d']; ?> ">
<meta name="keywords" content=" <?php echo $row['meta_k']; ?>">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name='yandex-verification' content='49d8eedf5ee49d6c' />
<title><?php echo $row['title']; ?></title>

<link href="css/style.css?ver=<?=$ver?>" rel="stylesheet" type="text/css" />

<link rel="icon" href="ico.ico" type="image/x-icon">
<link rel="shortcut icon" href="ico.ico" type="image/x-icon">
</head>

<body>
<table class="mainTable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <?php include('blocks/head.php'); ?>
  </tr>
  <tr>
    <td valign="top" height="500" class="cenTd">
    			
                <table width="100%" border="0"  cellspacing="0" cellpadding="5">
                  <tr>
                   <?php include('blocks/left.php'); ?>
                   <td valign="top" class="center">

                        		        <table class="catTab" border="0" cellpadding="10" cellspacing="0" width="850"> 
                                              <tr align="center">
                                            <?php 
                                                $n=1;
                                                $k=1;
                                                $ForCat=mysql_query("SELECT img, id, nam_categories FROM categories order by `ord`");
                                                while ($RowCat=mysql_fetch_array($ForCat)) {
                                                    $count=mysql_num_rows($ForCat);
                                                    $link="img/catalog/".$RowCat['img'];
                                                    $href="tea.php?cat=".$RowCat['id'];
                                                    $title=$RowCat['nam_categories'];
                                                    $forprint[$n]="<td class=\"catD\" ><a href=\"$href\">$title</a></td>";
                                                    if(($n==4) or ($k==$count)){
                                                        print"
                                                            <td><a  href=\"$href\"><img  src=\"$link\" /></a><br>
                                                            </td></tr><tr>
                                                        ";
                                                        for ($i=1; $i<=$n; $i++){ 
                                                            $show=$forprint[$i];
                                                            print $show;
                                                        }
                                                        print"
                                                            </tr>
                                                            </table>
                                                        ";
                                                        unset($title);
                                                        if ($k==$count){ } else {
                                                            print"
                                                                <table class=\"catTab\" border=\"0\" cellpadding=\"10\" cellspacing=\"0\" width=\"850\"> 
                                                                <tr align=\"center\">
                                                            ";	
                                                        }
                                                        $n=1;
                                                        $k++;
                                                    } else {
                                                        print"
                                                            <td ><a  href=\"$href\"><img  src=\"$link\" /></a>
                                                            </td>
                                                        ";
                                                        $n++;
                                                        $k++;
                                                    }	
                                                }
                                            ?>
                              
                   </td>
                </tr>
                </table>
    </td>
  </tr>
  <tr>
	<?php include('blocks/footer.php'); ?>
  </tr>
</table>


 <?php include('blocks/end.php'); ?>
</body>
</html>
