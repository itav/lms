<?php

if ( !isset($_GET['o']) ) {
    require_once 'lanserver/info/info_info.php';
} else {
    switch ( $_GET['o'] ) {
	case 'info': require_once 'lanserver/info/info.php'; break;
	case 'accidents': require_once 'lanserver/accidents/accidents.php'; break;
	case 'activecustomers': require_once 'lanserver/activecustomers/activecustomers.php'; break;
	case 'antyspam': require_once 'lanserver/antyspam/antyspam.php'; break;
	case 'arpalert': require_once 'lanserver/arpalert/arpalert.php'; break;
	case 'automessages': require_once 'lanserver/automessages/automessages.php'; break;
	case 'conficker': require_once 'lanserver/conficker/conficker.php'; break;
	case 'contracts': require_once 'lanserver/contracts/contracts.php'; break;
	case 'customerhistory': require_once 'lanserver/customerhistory/customerhistory.php'; break;
	case 'dhcpsniffer': require_once 'lanserver/dhcpsniffer/dhcpsniffer.php'; break;
	case 'invoices': require_once 'lanserver/invoices/invoices.php'; break;
	case 'logs': require_once 'lanserver/logs/logs.php'; break;
	case 'mikrotik': require_once 'lanserver/mikrotik/mikrotik.php'; break;
	case 'netmap': require_once 'lanserver/netmap/netmap.php'; break;
	case 'pinger': require_once 'lanserver/pinger/pinger.php'; break;
	case 'ports': require_once 'lanserver/ports/ports.php'; break;
	case 'pppoe': require_once 'lanserver/pppoe/pppoe.php'; break;
	case 'radius': require_once 'lanserver/radius/radius.php'; break;
	case 'routerhistory': require_once 'lanserver/routerhistory/routerhistory.php'; break;
	case 'warnings': require_once 'lanserver/warnings/warnings.php'; break;
	case 'trafficcontrol': require_once 'lanserver/trafficcontrol/trafficcontrol.php'; break;

	case 'logowanie': require_once 'lanserver/lmsloginhistory/logowanie.php'; break;
	case 'faktury_archiwum': require_once 'lanserver/invoices/faktury_archiwum.php'; break;
	case 'sendinvoices_info': require_once 'lanserver/invoices/sendinvoices_info.php'; break;
	case 'arpalert': require_once 'lanserver/arpalert/arpalert.php'; break;
	case 'send-invoice-to-customer': require_once 'lanserver/invoices/send-invoice-to-customer.php'; break;

	case 'notify_serviceman': require_once 'lanserver/helpdesk/notify_serviceman.php'; break;
	case 'add_serviceman': require_once 'lanserver/helpdesk/add_serviceman.php'; break;
	case 'edit_serviceman': require_once 'lanserver/helpdesk/edit_serviceman.php'; break;

	case 'blokady_przekierowania': require_once 'lanserver/blokady_przekierowania.php'; break;
	case 'sendinvoices': require_once 'lanserver/sendinvoices/sendinvoices.php'; break;
	case 'bzwbk_wyciagi': require_once 'lanserver/bzwbk/wyciagi.php'; break;
	case 'pocztowy_wyciagi': require_once 'lanserver/bank_pocztowy/wyciagi.php'; break;
	case 'simpy_wyciagi': require_once 'lanserver/simpy/wyciagi.php'; break;

	case 'pcbiznes_pro_invoice_export': require_once 'lanserver/pcbiznes_pro_invoice_export/pcbiznes_pro_invoice_export.php';break;

//	serwersms
	case 'serwersms':
	case 'serwersms_history': require_once 'lanserver/serwersms/history.php';break;

	case 'symfonia_eksport': require_once 'lanserver/symfonia/eksport.php';break;
	case 'symfonia_dokument_eksport': require_once 'lanserver/symfonia/dokument_eksport.php';break;


	case 'newinvoice_single': require_once 'lanserver/singleinvoice/newinvoice.php'; break;
	case 'editinvoice_single': require_once 'lanserver/singleinvoice/editinvoice.php'; break;


	case 'print_multiple_PDF': require_once 'lanserver/documents/print_multiple_PDF.php'; break;

	case 'gnokii_sms_confirm': require_once 'lanserver/sms_gnokii/sms_confirm.php'; break;

	case 'ending_agreements': require_once 'lanserver/ending_agreements/ending_agreements.php'; break;
	case 'ended_agreements': require_once 'lanserver/ended_agreements/ended_agreements.php'; break;

	default: require_once 'lanserver/info.php'; break;
    }
}


?>
