<?php
//Libraries Import
	require_once("../modules/exaction/library/exaction.inc.php");
	$myExaction			= 	new cwd_exaction();
	$exaction	       	=   new cwd_exaction();
    //Library call
	require('../modules/exaction/langfiles/'.$langFile.'.php');
	
	//Data for stats
	$nbExaction		=	$myExaction->count_exactions();		//All
	$nbKillings		=	$myExaction->count_exactions('1');	//Killings
	$nbAbductions	=	$myExaction->count_exactions('2');	//Kidnappings
	$nbBurnings		=	$myExaction->count_exactions('3');	//Burning and lootings
	$nbInjuries		=	$myExaction->count_exactions('4');	//Injuries
	$nbRapes		=	$myExaction->count_exactions('5');	//Rapes
	$nbExtorsions	=	$myExaction->count_exactions('6');	//Extorsions
    $mostDangerous	=	$myExaction->get_exaction_most_dangerous_area();
?>

<?php 
    /***********************************************************
    *                      Graph plugin                        *
    ************************************************************/
    
    require('../plugins/chartphp/lib/inc/chartphp_dist.php'); //Graph 
    $p              =   new chartphp();
    //Uses Pie chart
    
    
	$p->data 		=   array(array(
	    array($mod_lang_output['EXACTION_STATS_KILLINGS_LABEL'], $nbKillings),
	    array($mod_lang_output['EXACTION_STATS_ABDUCTIONS_LABEL'], $nbAbductions),
	    array($mod_lang_output['EXACTION_STATS_BURNINGS_LABEL'], $nbBurnings),
	    array($mod_lang_output['EXACTION_STATS_INJURIES_LABEL'], $nbInjuries),
	    array($mod_lang_output['EXACTION_STATS_RAPES_LABEL'], $nbRapes),
	    array($mod_lang_output['EXACTION_STATS_EXTORTIONS_LABEL'], $nbExtorsions)
	)); 
	$p->chart_type 	= 	'pie';
	
	// Common Options
	$p->title	=   $mod_lang_output['EXACTION_GRAPH_TITLE']." : $nbExaction";
	$chartOut	= 	$p->render('c1');
?>
