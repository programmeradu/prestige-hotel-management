<?php
$cookie_key = 'wUchZVrNq4DDUV2pRMtbyQ9oCABm5AMTi5NYeEiq0YnoJMq1kst91Qb9';
$new_password = 'password';
$hashed_password = md5($cookie_key . $new_password);
echo $hashed_password;
?>