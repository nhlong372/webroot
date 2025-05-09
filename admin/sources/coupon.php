<?php
	if(!defined('SOURCES')) die("Error");

	/* Kiểm tra active coupon */
	if(!$config['order']['coupon']) $func->transfer("Trang không tồn tại", "index.php", false);

	// /* Send email */
	// if(!empty($_POST["listemail"]) && !empty($_POST['subject']) && !empty($_POST['content'] && !empty($_POST['ma_code'])))
	// {	
	//     /* Defaults attributes email */
	//     $emailDefaultAttrs = $emailer->defaultAttrs();

	//     /* Variables email */
	//     $emailVars = array(
	//     	'{emailSubjectSender}',
	// 		'{emailCodeSender}',
	//     	'{emailContentSender}'
	//     );
	//     $emailVars = $emailer->addAttrs($emailVars, $emailDefaultAttrs['vars']);

	//     /* Values email */
	//     $emailVals = array(
	//     	htmlspecialchars($_POST['subject']),
	// 		htmlspecialchars($_POST['ma_code']),
	//     	htmlspecialchars_decode($_POST['content'])
	//     );
	//     $emailVals = $emailer->addAttrs($emailVals, $emailDefaultAttrs['vals']);

	// 	/* Send email */
	// 	$arrayEmail = array();
	// 	$listemail = explode(",",$_POST['listemail']);
	// 	for($i=0;$i<count($listemail);$i++)
	// 	{
	// 		$id = htmlspecialchars($listemail[$i]);
	// 		$row = $d->rawQueryOne("select id, email, fullname from #_member limit 0,1");

	// 		if(!empty($row))
	// 		{
	// 			$data = array();
	// 			$data['name'] = $row['fullname'];
	// 			$data['email'] = $row['email'];
	// 			$arrayEmail["dataEmail".$i] = $data;
	// 		}
	// 	}
	// 	$subject = "Thư phản hồi từ ".$setting['namevi'];
	// 	$message = str_replace($emailVars, $emailVals, $emailer->markdown('newsletter/active'));
	// 	$file = 'file';

	// 	if($emailer->send("active", $arrayEmail, $subject, $message, $file))
	// 	{
	// 		$func->transfer("Email đã được gửi thành công.", "index.php?com=coupon&act=man&type=".$type."&p=".$curPage);
	// 	}
	// 	else
	// 	{
	// 		$func->transfer("Email gửi bị lỗi. Vui lòng thử lại sau", "index.php?com=coupon&act=man&type=".$type."&p=".$curPage, false);
	// 	}
	// }

	switch($act)
	{
		case "man":
			get_items();
			$template = "coupon/man/items";
			break;

		case "man1":
			get_items();
			$template = "coupon/man/list_member_code";
			break;

		case "add":
			$template = "coupon/man/item_add";
			break;

		case "edit":
			get_item();
			$template = "coupon/man/item_add";
			break;

		case "save":
			save_item();
			break;

		case "delete":
			delete_item();
			break;
			
		default:
			$template = "404";
	}

	/* Get coupon */
	function get_items()
	{
		global $d, $func, $curPage, $items, $paging;

		$where = "";

		if($_REQUEST['keyword'])
		{
			$keyword = htmlspecialchars($_REQUEST['keyword']);
			$where .= " and ma = '$keyword'";
		}

		$per_page = 10;
		$startpoint = ($curPage * $per_page) - $per_page;
		$limit = " limit ".$startpoint.",".$per_page;
		$sql = "select * from #_coupon where id<>0 $where order by stt,id desc $limit";
		$items = $d->rawQuery($sql);
		$sqlNum = "select count(*) as 'num' from #_coupon where id<>0 $where order by stt,id desc";
		$count = $d->rawQueryOne($sqlNum);
		$total = $count['num'];
		$url = "index.php?com=coupon&act=man";
		$paging = $func->pagination($total,$per_page,$curPage,$url);
	}

	/* Edit coupon */
	function get_item()
	{
		global $d, $func, $curPage, $item;
		
		$id = htmlspecialchars($_GET['id']);

		if(!$id) $func->transfer("Không nhận được dữ liệu", "index.php?com=coupon&act=man&p=".$curPage, false);

		$item = $d->rawQueryOne("select * from #_coupon where id = ? limit 0,1",array($id));

		if(!$item['id']) $func->transfer("Dữ liệu không có thực", "index.php?com=coupon&act=man&p=".$curPage, false);
	}

	/* Save coupon */
	function save_item()
	{
		global $d, $func, $curPage;
		
		if(empty($_POST)) $func->transfer("Không nhận được dữ liệu", "index.php?com=coupon&act=man&p=".$curPage, false);

		$id = htmlspecialchars($_POST['id']);

		/* Post dữ liệu */
		$data = $_POST['data'];
		foreach($data as $column => $value) $data[$column] = htmlspecialchars($value);
		$data['ngaybatdau'] = strtotime(str_replace("/","-",htmlspecialchars($data['ngaybatdau'])));
		$data['ngayketthuc'] = strtotime(str_replace("/","-",htmlspecialchars($data['ngayketthuc'])));
		$data['toithieu'] = (isset($data['toithieu']) && $data['toithieu'] != '') ? str_replace(",","",$data['toithieu']) : 0;
		$data['toida'] = (isset($data['toida']) && $data['toida'] != '') ? str_replace(",","",$data['toida']) : 0;
		

		if($id)
		{
			$d->where('id', $id);
			$code = $data['ma'];
			$quanti = 1;
			$dataCode = array();
			if($d->update('coupon',$data)) $func->transfer("Cập nhật dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
			else $func->transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=coupon&act=man&p=".$curPage, false);
		}
		else
		{
			$quanitycode = htmlspecialchars($_REQUEST['quanitycode']);

			if($quanitycode)
			{
				for($i=0;$i<$quanitycode;$i++)
				{
					$data['ma'] = htmlspecialchars($_POST['ma'.$i]);
					$data['stt'] = $i+1;
					$data['tinhtrang'] = 0;

					if(!$d->insert('coupon',$data)) $func->transfer("Lưu dữ liệu bị lỗi", "index.php?com=coupon&act=man&p=".$curPage, false);
				}

				$func->transfer("Lưu dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
			}
			else
			{
				$func->transfer("Dữ liệu rỗng", "index.php?com=coupon&act=man&p=".$curPage, false);
			}
		}
	}

	/* Delete coupon */
	function delete_item()
	{
		global $d, $func, $curPage;
		
		$id = htmlspecialchars($_GET['id']);

		if($id)
		{
			$row = $d->rawQueryOne("select id from #_coupon where id = ? limit 0,1",array($id));

			if($row['id'])
			{
				$d->rawQuery("delete from #_coupon where id = ?",array($id));
				$func->transfer("Xóa dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
			}
			else $func->transfer("Xóa dữ liệu bị lỗi", "index.php?com=coupon&act=man&p=".$curPage, false);
		}
		elseif(isset($_GET['listid']))
		{
			$listid = explode(",",$_GET['listid']);
			
			for($i=0;$i<count($listid);$i++)
			{
				$id = htmlspecialchars($listid[$i]);
				$row = $d->rawQueryOne("select id from #_coupon where id = ? limit 0,1",array($id));

				if($row['id']) $d->rawQuery("delete from #_coupon where id = ?",array($id));
			}
			
			$func->transfer("Xóa dữ liệu thành công", "index.php?com=coupon&act=man&p=".$curPage);
		}
		else $func->transfer("Không nhận được dữ liệu", "index.php?com=coupon&act=man&p=".$curPage, false);
	}
?>