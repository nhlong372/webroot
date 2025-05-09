<tbody bgcolor="#f7f7f7" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
    <tr>
        <td align="left" style="padding:3px 9px" valign="top">
            <span style="display:block;font-weight:bold">{productName}</span>
            <?php if (!empty($params['productAttr'])) { ?>
                <span style="display:block;font-size:12px">{productAttr}</span>
            <?php } ?>
        </td>

        <?php if (!empty($params['salePrice'])) { ?>
            <td align="left" style="padding:3px 9px" valign="top">
                <span style="display:block;color:#ff0000;">{productSalePrice}</span>
                <span style="display:block;color:#999;text-decoration:line-through;font-size:11px;">{productRegularPrice}</span>
            </td>
        <?php } else { ?>
            <td align="left" style="padding:3px 9px" valign="top"><span style="color:#ff0000;">{productRegularPrice}</span></td>
        <?php } ?>

        <td align="center" style="padding:3px 9px" valign="top">{productQuantity}</td>

        <?php if (!empty($params['salePrice'])) { ?>
            <td align="right" style="padding:3px 9px" valign="top">
                <span style="display:block;color:#ff0000;">{productSaleTotalPrice}</span>
                <span style="display:block;color:#999;text-decoration:line-through;font-size:11px;">{productRegularTotalPrice}</span>
            </td>
        <?php } else { ?>
            <td align="right" style="padding:3px 9px" valign="top"><span style="color:#ff0000;">{productRegularTotalPrice}</span></td>
        <?php } ?>
    </tr>
</tbody>