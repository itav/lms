<?php

if(isset($_GET['n']) & $_GET['n']>0 & $_GET['n']<=12)
{
    $templ = 'lanserver/sendinvoices/sendinvoices_log.html';
    $month = $_GET['n'];
    if(isset($_GET['y']))
	$year = $_GET['y'];
    else
	$year = date('Y');
	

    $tstart = mktime(0,0,0,$month,1,$year);
    $tstop = mktime(0,0,0,$month+1,1,$year);

    $SMARTY->assign('maillog', $DB->GetAll("select si.*, concat(c.name,'',c.lastname) as customer from sendinvoices si join customers c on c.id=customer_id where time>=".$tstart." and time<".$tstop));
}
else
{
    if(isset($_POST['mailbody']))
    {
	$mb = $_POST['mailbody'];
	$DB->execute('update uiconfig set value="'.$mb.'" where var="mail_body" and section="invoices"');
    }

    $mailbody = $DB->GetOne('select value from uiconfig where var="mail_body" and section="invoices"');

    $datas = $DB->GetAll("select time, count(*) as fv from sendinvoices group by time desc");
    foreach($datas as $one)
	$logi[date("Y",$one['time'])][date("m",$one['time'])] += $one['fv'];

//    echo '<pre>';print_r($logi);echo '</pre>';
    $SMARTY->assign('maillog', $logi);
    $SMARTY->assign('mail_body', $mailbody);
    $templ = 'lanserver/sendinvoices/sendinvoices.html';
}

$SMARTY->display($templ);

?>