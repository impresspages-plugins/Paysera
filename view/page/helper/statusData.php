<table>
    <tr>
        <td><b><?php echo __('Order ID', 'Paysera') ?></b></td>
        <td><?php echo esc($payment['orderId']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Paid', 'Paysera') ?></b></td>
        <td><?php echo __($payment['isPaid'] ? 'Yes' : 'No', 'Paysera') ?>
            <?php if (!$payment['isPaid']) { ?>
                <a href="<?php echo $paymentUrl ?>">(<?php echo __('Pay Now', 'Paysera') ?>)</a>
            <?php } ?>
        </td>
    </tr>
    <tr>
        <td><b><?php echo __('Item', 'Paysera') ?></b></td>
        <td><?php echo esc($payment['title']) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Amount', 'Paysera') ?></b></td>
        <td><?php echo esc(ipFormatPrice($payment['price'], $payment['currency'], 'Paysera')) ?></td>
    </tr>
    <tr>
        <td><b><?php echo __('Date', 'Paysera') ?></b></td>
        <td><?php echo esc(ipFormatDateTime(strtotime($payment['createdAt']), 'Paysera')) ?></td>
    </tr>
</table>
