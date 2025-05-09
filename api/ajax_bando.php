<?php
include "config.php";
	
	if($_POST["id_item"]){
		$id_item = htmlspecialchars($_POST["id_item"]);
		$news = $d->rawQueryOne("select options2 from #_news where id = ? limit 0,1",array($id_item));
		 $optnews0 = (isset($news['options2']) && $news['options2'] != '') ? json_decode($news['options2'],true) : null;
	}else{		
		echo 'Bạn vui lòng chọn chi nhánh khác !!!';		
	}
?>

<?php if($optnews0['bando']!=''){?>
	<?php echo $optnews0['bando'];?>
<?php }?>