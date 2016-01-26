<?php

$send_inv = $DB->GetAll('select * from sendinvoices where customer_id=?', array($customerid));
$SMARTY->assign('send_inv',$send_inv);

?>
