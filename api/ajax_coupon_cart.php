<?php
	include "config.php";

	$coupon = htmlspecialchars($_POST['coupon']);
	$ship = htmlspecialchars($_POST['ship']);
	$flag = 1;
	$error = "";
	$total = $cart->getOrderTotal() + $ship;
	$coupon1 = $d->rawQueryOne("select * from #_coupon where ma = ? limit 0,1",array($coupon));
	if($coupon1['ngayketthuc']<time())
	{
		$flag = 0;
		$error = 'Mã ưu đãi đã hết hạn';
	}
	if($flag)
	{		
		$endow = $coupon1['chietkhau'];
		$endowID = $coupon1['id'];
		$endowType = $coupon1['loai'];
		if($endowType==1)
		{
			$total = $total - (($total * $coupon1['chietkhau']) / 100);
			$endowText = "-".$coupon1['chietkhau']."%";
		}
		if($endowType==2)
		{
			$total = $total - $coupon1['chietkhau'];
			$endowText = "-".number_format($coupon1['chietkhau'],0, ',', '.')."đ";
		}
		$totalText = number_format($total,0, ',', '.')."đ";
	}
	else
	{
		$total = $cart->getOrderTotal() + $ship;
		$totalText = number_format($total,0, ',', '.')."đ";
		$endow = 0;
		$endowType = 0;
		$endowText = 'Chưa có ưu đãi';
	}

	$data = array('error' => $error, 'endow' => $endow, 'endowID' => $endowID, 'endowType' => $endowType, 'endowText' => $endowText, 'total' => $total, 'totalText' => $totalText);
	echo json_encode($data);
?>