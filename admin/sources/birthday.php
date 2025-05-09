<?php 
    if(!defined('SOURCES')) die("Error");

    /* Send email */
	if(!empty($_POST["listemail"]) && !empty($_POST['subject']) && !empty($_POST['content']))
	{	
	    /* Defaults attributes email */
	    $emailDefaultAttrs = $emailer->defaultAttrs();

	    /* Variables email */
	    $emailVars = array(
	    	'{emailSubjectSender}',
	    	'{emailContentSender}'
	    );
	    $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

	    /* Values email */
	    $emailVals = array(
	    	htmlspecialchars($_POST['subject']),
	    	htmlspecialchars_decode($_POST['content'])
	    );
	    $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

		/* Send email */
		$arrayEmail = array();
		$listemail = explode(",",$_POST['listemail']);
		for($i=0;$i<count($listemail);$i++)
		{
			$id = htmlspecialchars($listemail[$i]);
			$row = $d->rawQueryOne("select id, email, fullname from #_member limit 0,1");

			if(!empty($row))
			{
				$data = array();
				$data['name'] = $row['fullname'];
				$data['email'] = $row['email'];
				$arrayEmail["dataEmail".$i] = $data;
			}
		}
		$subject = "Thư phản chúc mừng sinh nhật bạn từ ".$setting['namevi'];
		$message = str_replace($emailVars, $emailVals, $emailer->markdown('newsletter/birthday'));
		$file = 'file';
		if($emailer->send("customer", $arrayEmail, $subject, $message, $file))
		{
			$func->transfer("Email đã được gửi thành công.", "index.php?com=birthday&act=man_birthday&p=".$curPage);
		}
		else
		{
			$func->transfer("Email gửi bị lỗi. Vui lòng thử lại sau", "index.php?com=birthday&act=man_birthday&p=".$curPage, false);
		}
	}

    switch($act)
	{
		case "man_birthday":
			get_birthday();
			$template = "birthday/birthday";
			break;
		default:
			$template = "404";
	}

    function get_birthday()
	{
		global $d, $func, $curPage, $items, $paging, $config;

		$where = "";

		if(isset($_REQUEST['keyword']))
		{
			$keyword = htmlspecialchars($_REQUEST['keyword']);
			$where .= " and (username LIKE '%$keyword%' or fullname LIKE '%$keyword%')";
		}

		$perPage = 10;
		$startpoint = ($curPage * $perPage) - $perPage;
		$limit = " limit ".$startpoint.",".$perPage;
		$sql = "select * from #_member where id <> 0 $where order by numb,id desc $limit";
		$items = $d->rawQuery($sql);
		$sqlNum = "select count(*) as 'num' from #_member where id <> 0 $where order by numb,id desc";
		$count = $d->rawQueryOne($sqlNum);
		$total = (!empty($count)) ? $count['num'] : 0;
		$url = "index.php?com=user&act=man_member";
		$paging = $func->pagination($total,$perPage,$curPage,$url);

        
	}
?>