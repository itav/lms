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
 *  $Id: gpononu.inc.php,v 1.33 2012/04/14 13:07:47 DK Exp $
 */
if (chkconfig(ConfigHelper::getConfig('phpui.gpon')))
{
	$netdevconnected = $GPON->GetGponOnuCustomersNames($_GET['id']);
	
	/* Using AJAX plugins */
	function ONU_get_param_Xj($gponoltid,$OLT_id,$ONU_id,$id,$ONU_name='')
	{
		// xajax response
		global $GPON;
		$objResponse = new xajaxResponse();
		$options_snmp=$GPON->GetGponOlt($gponoltid);
		$GPON->snmp->set_options($options_snmp);
		$error_snmp=$GPON->snmp->get_correct_connect_snmp();
		$table_param=$GPON->snmp->ONU_get_param_table($OLT_id,$ONU_id,$ONU_name);
		$objResponse->script("document.getElementById('pokaz_parametry_".$id."').value='Ukryj parametry';"); 
		$objResponse->script("document.getElementById('pokaz_parametry_".$id."').onclick=function(){document.getElementById('ONU_param_".$id."').innerHTML='';document.getElementById('pokaz_parametry_".$id."').value='Pokaż parametry';document.getElementById('pokaz_parametry_".$id."').onclick=function(){xajax_ONU_get_param_Xj(".$gponoltid.",".$OLT_id.",".$ONU_id.",".$id.",'".$ONU_name."');}};"); 
		$objResponse->assign("ONU_param_".$id,"innerHTML",$error_snmp.$table_param);
		return $objResponse;
	}
	$LMS->InitXajax();
	$LMS->RegisterXajaxFunction('ONU_get_param_Xj');
	$SMARTY->assign('xajax', $LMS->RunXajax());
	
	/* end AJAX plugin stuff */
	$SMARTY->assign('netdevlist',$netdevconnected);
}
?>
