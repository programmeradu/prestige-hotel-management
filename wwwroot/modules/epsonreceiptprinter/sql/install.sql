CREATE TABLE IF NOT EXISTS `PREFIX_epson_receipt_history` (
    `id_receipt_history` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `id_order` int(10) unsigned NOT NULL,
    `id_employee` int(10) unsigned NOT NULL,
    `date_add` datetime NOT NULL,
    `employee_name` varchar(255) NOT NULL,
    PRIMARY KEY (`id_receipt_history`),
    KEY `id_order` (`id_order`),
    KEY `id_employee` (`id_employee`)
) ENGINE=ENGINE_TYPE DEFAULT CHARSET=utf8;