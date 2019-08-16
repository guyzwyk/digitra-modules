<?php
    require_once('../../../plugins/chartphp/lib/inc/chartphp_dist.php');    
    $p  =   new chartphp();
?>

<?php 
	//Pie chart	
	 $p->data 			  =   array(array(
	    array($mod_lang_output['EXACTION_STATS_KILLINGS_LABEL'], $nbKillings),
	    array($mod_lang_output['EXACTION_STATS_ABDUCTIONS_LABEL'], $nbAbductions),
	    array($mod_lang_output['EXACTION_STATS_BURNINGS_LABEL'], $nbBurnings),
	    array($mod_lang_output['EXACTION_STATS_INJURIES_LABEL'], $nbInjuries),
	    array($mod_lang_output['EXACTION_STATS_RAPES_LABEL'], $nbRapes),
	    array($mod_lang_output['EXACTION_STATS_EXTORTIONS_LABEL'], $nbExtorsions)
	)); 
	$p->chart_type 		= 	'pie';
	
	// Common Options
	$p->title	=   $mod_lang_output['EXACTION_GRAPH_TITLE']." : $nbExaction";
	$chartOut	= 	$p->render('c1');
?>
	
