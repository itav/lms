<?php

/*
 * LMS version 2.00 Ap-media
 *
 *  $Id: gpononuDM.php,v 1.00 2014/06/22 $
 */


if ($_GET['id'])
{
    $rdata = $LMS->DB->GetRow("SELECT a.nas, a.oltport, g.name, d.secret FROM gpononu g
			JOIN gponauthlog a ON a.onuid = g.id
			JOIN gpononu2olt go ON go.gpononuid = g.id
			JOIN netdevices d ON go.netdevicesid = d.id
			WHERE g.id = ? ORDER BY time LIMIT 1", array($_GET['id']));

    $q="echo \"Dasan-Gpon-Olt-Id=".$rdata['oltport'].",Dasan-Gpon-Onu-Serial-Num=".$rdata['name']." \"| radclient -r 1 ".$rdata['nas']."  disconnect ".$rdata['secret'];
    system($q." >/dev/null");
    $GPON->Log(4, 'gpononu', $_GET['id'], 'Disconnect Message send.');
}

$SESSION->redirect('?m=gpononuinfo&id='.$_GET['id']);

?>
