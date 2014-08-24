<table>
    <tr>
        <td><b><?php echo __('Order ID', 'Mokejimai') ?></b></td>
        <td><?php echo esc($payment['orderId']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Paid', 'Mokejimai') ?></b></td>
        <td><?php echo __($payment['isPaid'] ? 'Yes' : 'No', 'Mokejimai') ?>
            <?php if (!$payment['isPaid']) { ?>
                <a href="<?php echo $paymentUrl ?>">(<?php echo __('Pay Now', 'Mokejimai') ?>)</a>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b><?php echo __('Item', 'Mokejimai') ?></b></td>
        <td><?php echo esc($payment['title']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Amount', 'Mokejimai') ?></b></td>
        <td><?php echo esc(ipFormatPrice($payment['price'], $payment['currency'], 'Mokejimai')) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Date', 'Mokejimai') ?></b></td>
        <td><?php echo esc(ipFormatDateTime(strtotime($payment['createdAt']), 'Mokejimai')) ?></td>
    </tr>
</table>
