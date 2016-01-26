<?php

/*
 * LMS version 1.11.10 Kri
 *
 *  (C) Copyright 2001-2010 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id: gpononutvdel.php,v 1.27 2012/09/13 23:07:47 DK Exp $
 */
if (!chkconfig(ConfigHelper::getConfig('phpui.gpon')))
{
	$SESSION->redirect('?m=gponoffline');
}
if(! $GPON->GponOnuTvExists($_GET['id']))
{
	$SESSION->redirect('?m=gpononutvlist');
}		

$layout['pagetitle'] = 'GPON-ONU-TV: '.trans('Deletion of Device with ID: $a',sprintf('%04d',$_GET['id']));
$SMARTY->assign('netdevid',$_GET['id']);

if($_GET['is_sure']!=1)
    {
	    $body = '<P>'.trans('Are you sure, you want to delete that device?').'</P>'; 
	    $body .= '<P><A HREF="?m=gpononutvlist&id='.$_GET['id'].'&is_sure=1">'.trans('Yes, I am sure.').'</A></P>';
    }else{
	    header('Location: ?m=gpononutvlist');
	    $body = '<P>'.trans('Device has been deleted.').'</P>';
	    $GPON->DeleteGponOnuTv($_GET['id']);
    }
	
$SMARTY->assign('body',$body);
$SMARTY->display('dialog.html');

?>
