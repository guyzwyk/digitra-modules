<?php
	//:::::::::::::::::::::::::::::::Guest Book Module:::::::::::::::::::::::::::::::

	$guest_tickerContent	=  stripslashes($myWishes->display_valid_wishes());
	$guest_ticker = "<DIV ID=\"TICKER\" STYLE=\"overflow:hidden; width:440px\"  onmouseover=\"TICKER_PAUSED=true\" onmouseout=\"TICKER_PAUSED=false\">
                     
					 	$myWishes = &new yafe_wishes();
						print ;
					 
                    </DIV>
					<div style=\"margin:0; padding:0;\">
						<p style=\"text-align:right; font-weight:bold;\"><a href=\"wishes.php\">Vous aussi, envoyez vos voeux maintenant&nbsp;!&nbsp;&raquo;</a></p>
					</div>
                    <script type=\"text/javascript\" src=\"webticker_lib.js\" language=\"javascript\"></script>";
?>
