<?php
    //Initializations for statistics
    $my_newsStats	=	new cwd_news();
    $nbNews			=	$my_newsStats->count_news();

    //Library call
    require('../modules/news/langfiles/'.$langFile.'.php');
?>
<?php
    $admin_menu =   "<li>
                <a href=\"#\"><i class=\"fa fa-indent nav_icon\"></i>News Manager<span class=\"badge badge-primary\">$nbNews</span><span class=\"fa arrow\"></span></a>
                <ul class=\"nav nav-second-level\">
                    <li>
                        <a href=\"admin.php?page=news&what=display\"><i class=\"fa fa-eye nav_icon\"></i>Display stories</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=news&what=insert\"><i class=\"fa fa-plus nav_icon\"></i>Create story</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=news&what=catDisplay\"><i class=\"fa fa-eye nav_icon\"></i>Display categories</a>
                    </li>
                    <li>
                        <a href=\"admin.php?page=news&what=catInsert\"><i class=\"fa fa-plus nav_icon\"></i>Create category</a>
                    </li>
                    <li>
                        <a href=\"#\"><i class=\"fa fa-cogs nav_icon\"></i>Story settings<span class=\"fa arrow\"></span></a>
                        <ul class=\"nav nav-third-level\">
                            <li>
                                <a href=\"admin.php?page=news&what=_authorDisplay\"><i class=\"fa fa-eye nav_icon\"></i>View authors</a>
                            </li>
                            <li>
                                <a href=\"admin.php?page=news&what=_authorInsert\"><i class=\"fa fa-plus nav_icon\"></i>Add author</a>
                            </li>
                            <li>
                                <a href=\"admin.php?page=news&what=_authorCatDisplay\"><i class=\"fa fa-eye nav_icon\"></i>View authors categories</a>
                            </li>
                            <li>
                                <a href=\"admin.php?page=news&what=_authorGroupInsert\"><i class=\"fa fa-plus nav_icon\"></i>Add author group</a>
                            </li>
                        </ul>	
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>";
?>