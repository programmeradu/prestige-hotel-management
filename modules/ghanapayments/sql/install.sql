CREATE TABLE IF NOT EXISTS `PREFIX_ghanapayments_transactions` (
    `id_transaction` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `id_cart` int(10) unsigned NOT NULL,
    `id_order` int(10) unsigned DEFAULT NULL,
    `reference` varchar(64) NOT NULL,
    `payment_method` varchar(64) NOT NULL,
    `amount` decimal(20,6) NOT NULL,
    `status` varchar(64) NOT NULL,
    `transaction_data` text DEFAULT NULL,
    `date_add` datetime NOT NULL,
    `date_upd` datetime NOT NULL,
    PRIMARY KEY (`id_transaction`),
    KEY `id_cart` (`id_cart`),
    KEY `id_order` (`id_order`),
    KEY `reference` (`reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
