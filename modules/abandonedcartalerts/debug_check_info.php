<?php
require(dirname(__FILE__).'/../../config/config.inc.php');
require(dirname(__FILE__).'/../../init.php');

echo "<h1>Checking Data for samueladu1970@gmail.com</h1>";

$email = 'samueladu1970@gmail.com';

// 1. Get Customer ID
$sql = 'SELECT id_customer, firstname, lastname, email FROM '._DB_PREFIX_.'customer WHERE email LIKE "%'.pSQL($email).'%"';
$customer = Db::getInstance()->getRow($sql);

if ($customer) {
    echo "<h3>Customer Found:</h3>";
    echo "<pre>"; print_r($customer); echo "</pre>";
    
    $id_customer = $customer['id_customer'];
    
    // 2. Check Addresses
    echo "<h3>Addresses for Customer ID $id_customer:</h3>";
    $sql_addr = 'SELECT id_address, alias, company, firstname, lastname, address1, city, phone, phone_mobile, date_add, date_upd 
                 FROM '._DB_PREFIX_.'address 
                 WHERE id_customer = '.(int)$id_customer;
    $addresses = Db::getInstance()->executeS($sql_addr);
    
    if ($addresses) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>ID</th><th>Alias</th><th>Phone</th><th>Mobile</th><th>Updated</th></tr>";
        foreach ($addresses as $addr) {
            echo "<tr>";
            echo "<td>".$addr['id_address']."</td>";
            echo "<td>".$addr['alias']."</td>";
            echo "<td>".$addr['phone']."</td>";
            echo "<td>".$addr['phone_mobile']."</td>";
            echo "<td>".$addr['date_upd']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color:red;'>No addresses found for this customer!</p>";
    }

} else {
    echo "<p style='color:red;'>Customer not found!</p>";
}
