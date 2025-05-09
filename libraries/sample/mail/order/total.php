<tfoot style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
    <tr>
        <td align="right" colspan="3" style="padding:5px 9px">Tạm tính</td>
        <td align="right" style="padding:5px 9px"><span>{orderTempPrice}</span></td>
    </tr>

    <?php if (!empty($params['shipPrice'])) { ?>
        <tr>
            <td align="right" colspan="3" style="padding:5px 9px">Phí vận chuyển</td>
            <td align="right" style="padding:5px 9px"><span>{orderShipPrice}</span></td>
        </tr>
    <?php } ?>

    <tr bgcolor="#eee">
        <td align="right" colspan="3" style="padding:7px 9px"><strong><big>Tổng giá trị đơn hàng</big> </strong></td>
        <td align="right" style="padding:7px 9px"><strong><big><span>{orderTotalPrice}</span> </big> </strong></td>
    </tr>
</tfoot>