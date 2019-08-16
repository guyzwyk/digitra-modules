<?php
    //Initializations for statistics
    $my_interviewStats	    =	new cwd_interview();
    $nbInterviews			=	$my_interviewStats->count_interviews();
    //Library call
    require('../modules/interview/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-street-view nav_icon\"></i>Interview Manager<span class=\"badge badge-primary\">$nbInterviews</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=interview&what=display\"><i class=\"fa fa-eye nav_icon\"></i>".$mod_lang_output['INTERVIEW_ADMIN_MENU_DISPLAY']."</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=interview&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>".$mod_lang_output['INTERVIEW_ADMIN_MENU_CREATE']."</a>
                    </li>
                </ul>     
            </li>";
?>