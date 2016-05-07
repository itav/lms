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
 *  $Id: gponoltadd.php,v 1.30 2012/04/18 13:07:47 DK Exp $
 */
if (!(ConfigHelper::getConfig('phpui.gpon')))
{
	$SESSION->redirect('?m=gponoffline');
}
if(isset($_POST['netdev']))
{
	$netdevdata = $_POST['netdev'];
	//-GPON-OLT
	//Dane OLTPORTS
	$gponoltportsdata=$_POST['gponoltports'];
	//-GPON-OLT
	if($netdevdata['ports'] == '')
		$netdevdata['ports'] = 0;
	else
		$netdevdata['ports'] = intval($netdevdata['ports']);

	if(empty($netdevdata['clients']))
		$netdevdata['clients'] = 0;
	else
		$netdevdata['clients'] = intval($netdevdata['clients']);
			
	if($netdevdata['name'] == '')
		$error['name'] = trans('Device name is required!');
	elseif(strlen($netdevdata['name'])>32)
		$error['name'] = trans('Device name is too long (max.32 characters)!');

	$netdevdata['purchasetime'] = 0;
	if($netdevdata['purchasedate'] != '') 
	{
		// date format 'yyyy/mm/dd'
		if(!preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $netdevdata['purchasedate']))
		{
			$error['purchasedate'] = trans('Invalid date format!');
		}
		else
		{
			$date = explode('/', $netdevdata['purchasedate']);
			if(checkdate($date[1], $date[2], (int)$date[0]))
			{
				$tmpdate = mktime(0, 0, 0, $date[1], $date[2], $date[0]);
                        	if(mktime(0,0,0) < $tmpdate)
			                $error['purchasedate'] = trans('Date from the future not allowed!');
				else
				        $netdevdata['purchasetime'] = $tmpdate;
			}
			else
				$error['purchasedate'] = trans('Invalid date format!');
		}
	}

	if($netdevdata['guaranteeperiod'] != 0 && $netdevdata['purchasetime'] == NULL)
	{
		$error['purchasedate'] = trans('Purchase date cannot be empty when guarantee period is set!');
	}

	//-GPON-OLT
	//walidacja parametrów SNMP
	if(intval($netdevdata['snmp_version'])>0 && strlen(trim($netdevdata['snmp_host']))==0)
	{
		$error['snmp_host'] = 'Podaj adres IP hosta';
	}
	if(intval($netdevdata['snmp_version'])>2)
	{
		if(strlen(trim($netdevdata['snmp_username']))==0)
		{
			$error['snmp_username'] = 'Podaj Username(login)';
		}
		if(strlen(trim($netdevdata['snmp_password']))==0)
		{
			$error['snmp_password'] = 'Podaj Password(hasło)';
		}
		if(strlen(trim($netdevdata['snmp_privacy_passphrase']))==0)
		{
			$error['snmp_privacy_passphrase'] = 'Podaj Privacy passphrase';
		}
	}
	elseif(intval($netdevdata['snmp_version'])>0)
	{
		if(strlen(trim($netdevdata['snmp_community']))==0)
		{
			$error['snmp_community'] = 'Podaj Community';
		}
	}
	//-GPON-OLT
        if(!$error)
        {
		if($netdevdata['guaranteeperiod'] == -1)
			$netdevdata['guaranteeperiod'] = NULL;
		
		if(!isset($netdevdata['shortname'])) $netdevdata['shortname'] = '';
                if(!isset($netdevdata['secret'])) $netdevdata['secret'] = '';
                if(!isset($netdevdata['community'])) $netdevdata['community'] = '';
                if(!isset($netdevdata['nastype'])) $netdevdata['nastype'] = 0;
		
        //-GPON-OLT
        //Dodawanie danych OLT
		$netdevdata['gponoltid'] = $GPON->GponOltAdd($netdevdata);
		if($netdevdata['gponoltid']>0 && is_array($gponoltportsdata) && count($gponoltportsdata)>0)
		{
			foreach($gponoltportsdata as $k=>$v)
			{
				$gponoltports[$k]['gponoltid']=$netdevdata['gponoltid'];
				$gponoltports[$k]['numport']=$k;
				$gponoltports[$k]['maxonu']=$v;
			}
			$GPON->GponOltPortsAdd($gponoltports);
		}
		//-GPON-OLT
		$netdevid = $LMS->NetDevAdd($netdevdata);
		$SESSION->redirect('?m=gponoltinfo&id='.$netdevid);
        }
	
	$SMARTY->assign('error', $error);
	$SMARTY->assign('netdev', $netdevdata);
}

$layout['pagetitle'] = trans('New Device').': GPON - OLT';

$SMARTY->assign('nastype', $LMS->GetNAStypes());

if ((ConfigHelper::getConfig('phpui.ewx_support')))
	$SMARTY->assign('channels', $DB->GetAll('SELECT id, name FROM ewx_channels ORDER BY name'));

$SMARTY->display('gponoltadd.html');

?>
