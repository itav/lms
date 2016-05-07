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
 *  $Id: gpononusearch.php,v 1.6 2012/04/24 13:07:47 DK Exp $
 */
if (!(ConfigHelper::getConfig('phpui.gpon')))
{
	$SESSION->redirect('?m=gponoffline');
}
function NetDevSearch($order='name,asc', $search=NULL, $sqlskey='AND')
{
	global $DB;
	
	list($order,$direction) = sscanf($order, '%[^,],%s');
	
	($direction=='desc') ? $direction = 'desc' : $direction = 'asc';

        switch($order)
        {
		case 'id':
                        $sqlord = ' ORDER BY d.id';
		break;
		case 'producer':
		        $sqlord = ' ORDER BY gm.producer';
		break;
		case 'model':
		        $sqlord = ' ORDER BY gm.name';
		break;
		default:
		        $sqlord = ' ORDER BY d.name';
		break;
	}

	if(sizeof($search)) foreach($search as $idx => $value)
	{
		$value = trim($value);
	        if($value!='')
		{
			switch($idx)
			{
				case 'name':
				        $searchargs[] = '(d.name ?LIKE? '.$DB->Escape("%$value%").')';
					$nodes = true;
				break;
				case 'producer':
				        $searchargs[] = 'gm.producer LIKE '.$DB->Escape("%$value%").'';
				break;
				case 'model':
				        $searchargs[] = 'gm.name LIKE '.$DB->Escape("%$value%").'';
				break;
				default:
					// UPPER here is a postgresql ILIKE bug workaround
					$searchargs[] = "UPPER(d.$idx) ?LIKE? UPPER(".$DB->Escape("%$value%").')';
				break;
			}
		}
	}
	
	if(isset($searchargs))
                $searchargs = ' AND ('.implode(' '.$sqlskey.' ',$searchargs).')';
	$sql_query='SELECT DISTINCT d.id, d.name, d.location, d.description, gm.producer, 
				gm.name as model, d.serialnumber, (select count(gpononuportstypeid) from gpononuportstype2models where gpononumodelsid=d.gpononumodelsid) as ports
	        		FROM gpononu d
	        		inner join gpononumodels gm on gm.id=d.gpononumodelsid
	        		'
				.' WHERE 1=1 '
				.(isset($searchargs) ? $searchargs : '')
				.($sqlord != '' ? $sqlord.' '.$direction : '');
				//echo $sql_query;
	$netdevlist = $DB->GetAll($sql_query);

	$netdevlist['total'] = sizeof($netdevlist);
	$netdevlist['order'] = $order;
	$netdevlist['direction'] = $direction;
	
	return $netdevlist;
}
	
$SESSION->save('backto', $_SERVER['QUERY_STRING']);

if(isset($_POST['search']))
        $netdevsearch = $_POST['search'];
	
if(!isset($netdevsearch))
        $SESSION->restore('netdevsearch', $netdevsearch);
else
        $SESSION->save('netdevsearch', $netdevsearch);

if(!isset($_GET['o']))
	$SESSION->restore('ndlso', $o);
else
	$o = $_GET['o'];
$SESSION->save('ndlso', $o);

if(!isset($_POST['k']))
        $SESSION->restore('ndlsk', $k);
else
        $k = $_POST['k'];
$SESSION->save('ndlsk', $k);

if(isset($_GET['search']))
{
	$layout['pagetitle'] = 'GPON-ONU: '.trans('Network Devices Search Results');
	$netdevlist = NetDevSearch($o, $netdevsearch, $k);

	$listdata['total'] = $netdevlist['total'];
	$listdata['order'] = $netdevlist['order'];
	$listdata['direction'] = $netdevlist['direction'];

	unset($netdevlist['total']);
	unset($netdevlist['order']);
	unset($netdevlist['direction']);

	if($listdata['total']==1)
                $SESSION->redirect('?m=gpononuinfo&id='.$netdevlist[0]['id']);
	else
	{
		if(!isset($_GET['page']))
    			$SESSION->restore('ndlsp', $_GET['page']);
	
		$page = (! $_GET['page'] ? 1 : $_GET['page']);
		$pagelimit = (! ConfigHelper::getConfig('phpui.nodelist_pagelimit') ? $listdata['total'] : ConfigHelper::getConfig('phpui.nodelist_pagelimit'));
		$start = ($page - 1) * $pagelimit;

		$SESSION->save('ndlsp', $page);

		$SMARTY->assign('page', $page);
		$SMARTY->assign('pagelimit', $pagelimit);
		$SMARTY->assign('start', $start);
		$SMARTY->assign('netdevlist', $netdevlist);
		$SMARTY->assign('listdata', $listdata);

		$SMARTY->display('gpononusearchresults.html');
	}
}
else
{
	$layout['pagetitle'] = 'GPON-ONU: '.trans('Network Devices Search');

	$SESSION->remove('ndlsp');
	
	$SMARTY->assign('k',$k);
	$SMARTY->display('gpononusearch.html');
}

?>
