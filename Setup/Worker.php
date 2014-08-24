<?php
/**
 * @package   ImpressPages
 */




namespace Plugin\Paysera\Setup;


class Worker
{
    public function activate()
    {

        $table = ipTable('Paysera');
        $sql="
        CREATE TABLE IF NOT EXISTS $table (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `orderId` varchar(255) NOT NULL COMMENT 'unique order id from shopping cart',
          `userId` int(11) NOT NULL,
          `title` varchar(255) NOT NULL,
          `currency` varchar(3) NOT NULL,
          `price` int(11) NOT NULL COMMENT 'in cents',
          `successUrl` VARCHAR(255) NOT NULL,
          `cancelUrl` VARCHAR(255) NOT NULL,
          `isPaid` tinyint(1) DEFAULT 0,
          `payer_first_name` VARCHAR(255) NULL,
          `payer_last_name` VARCHAR(255) NULL,
          `payer_email` VARCHAR(255) NULL,
          `payer_country` VARCHAR(255) NULL,
          `securityCode` VARCHAR(32) NOT NULL COMMENT 'password to access order status via link',
          `createdAt` datetime NOT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

        ";

        ipDb()->execute($sql);
    }
}
