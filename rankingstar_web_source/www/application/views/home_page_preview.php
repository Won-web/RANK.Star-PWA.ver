<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
	<title>Welcome to RankingStar</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
        margin: 15px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}
    .image-container {
        width: 100%;
        height: auto;
    }
    .image {
        width: 100%;
        height: 100%;
    }
	/* #container {
		margin: 15px;
	} */
	figure{
    	margin :0px !important;
    }
    img{
    	margin:  31px !important;
    }
	</style>
</head>
<body>

<div id="container">
    <?php echo $contestDetails[0]['description']; ?>
	<!-- <div class="image-container">
        <img class="image" src="<?php /// echo CON_CONTEST_URL . $contestDetails[0]['home_page_image']; ?>" alt="<?php // echo $contestDetails[0]['home_page_image'] ?>">
    </div> -->
</div>
</body>
</html>


