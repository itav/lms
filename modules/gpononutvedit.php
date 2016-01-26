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
 *  $Id: gpoonutvedit.php,v 1.69 2012/09/13 23:07:47 DK Exp $
 */
if (!chkconfig(ConfigHelper::getConfig('phpui.gpon')))
{
	$SESSION->redirect('?m=gponoffline');
}
if(! $GPON->GponOnuTvExists($_GET['id']))
{
	$SESSION->redirect('m=gpononutvlist');
}		

$action = !empty($_GET['action']) ? $_GET['action'] : '';
$edit = '';
$subtitle = '';

switch($action)
{

default:
	$edit = 'data';
	break;
}

if(isset($_POST['netdev']))
{
	$netdevdata = $_POST['netdev'];
	$netdevdata['id'] = $_GET['id'];

	$netdevdata['ipaddr']=trim($netdevdata['ipaddr']);
if(strlen($netdevdata['ipaddr'])==0)
		$error['ipaddr'] = trans('Node IP address is required!');
	elseif(!check_ip($netdevdata['ipaddr']))
		$error['ipaddr'] = trans('Incorrect node IP address!');
	elseif (!$GPON->IsGponOnuTvMulticast($netdevdata['ipaddr']))
		$error['ipaddr'] = 'Wpisany adres nie jest typu multicast';
	elseif ($GPON->GponOnuTvIpExists($netdevdata['ipaddr'],$_GET['id']))
		$error['ipaddr'] = 'Ten adres jest już używany przez inny kanał TV';
	
	$netdevdata['canal']=trim($netdevdata['canal']);
	if(strlen($netdevdata['canal'])==0)
		$error['canal'] = 'Podaj nazwę kanału TV';
	

	if(!$error)
	{

		$GPON->GponOnuTvUpdate($netdevdata);
		
		$SESSION->redirect('?m=gpononutvinfo&id='.$_GET['id']);
	}
}
else 
{
	$netdevdata = $GPON->GetGponOnuTv($_GET['id']);
	
}


unset($netdevlist['total']);
unset($netdevlist['order']);
unset($netdevlist['direction']);



$layout['pagetitle'] = 'GPON-ONU-TV: '.trans('$a ($b)', $netdevdata['ipaddr'], $netdevdata['canal']);

if($subtitle) $layout['pagetitle'] .= ' - '.$subtitle;

$SMARTY->assign('error',$error);
$SMARTY->assign('netdevinfo',$netdevdata);

switch($edit)
{
    case 'data':
	
	$SMARTY->display('gpononutvedit.html');
    break;
    default:
	$SMARTY->display('gpononutvinfo.html');
    break;
}
?>
