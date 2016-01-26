<?php
echo "<pre>";
$result = shell_exec ( 'sudo -u root /sbin/lms-sendinvoices-ssl --did=' . $_GET['id'] );

header ('Content-type: text/html; charset=utf-8');
echo "\nWysylanie faktury:\n";
echo "$result";

?>
