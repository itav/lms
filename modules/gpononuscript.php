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
 *  $Id: gponoltinfo.php,v 1.33 2012/04/14 13:07:47 DK Exp $
 */
if (!(ConfigHelper::getConfig('phpui.gpon')))
{
	$SESSION->redirect('?m=gponoffline');
}
$gpon_onu_autoscript_debug = (! ConfigHelper::getConfig('phpui.gpon_onu_autoscript_debug')) ? 0 : ConfigHelper::getConfig('phpui.gpon_onu_autoscript_debug');

$output=$GPON->GetGponAutoScript($gpon_onu_autoscript_debug);

$SMARTY->assign('output',$output);
$SMARTY->display('gpononuscript.html');
?>
