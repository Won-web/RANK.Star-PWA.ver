<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	
	<title>Welcome to RankingStar</title>

	
    <style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
        margin: 0;
		/*font: 13px/20px normal Helvetica, Arial, sans-serif;*/
		color: #4F5155;
	}
    .image-container {
        width: 100%;
        height: auto;
    }
    .image {
        width: 100%;
        height: 100%;
		margin:15px;
    }
    figure{
    	margin :0px !important;
    }
    /*img{
    	margin:  31px !important;
    }*/
	/* #container {
		margin: 15px;
	} */
	</style> 

</head>
<body>
<!--    
<div id="container" class="image">
    <?php echo $noticeDetails[0]['notice_description']; ?>
</div>
-->
<div><?php echo $noticeDetails[0]['notice_description']; ?></div>
 
</body>
</html>


