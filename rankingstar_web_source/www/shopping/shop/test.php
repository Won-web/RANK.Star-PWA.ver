
<?php 
	
	$device = $_GET["device"];
	echo "device ::: ".$device;
?>
<!DOCTYPE html>
<html>
<head>
<title>webview</title>

<script type="text/javascript">

	function nativeClose(dev) {

	   // if(dev == "iOS") { // iOS     
			// window.webkit.messageHandlers.callbackHandler.postMessage('msg'); 
	   // } else {
	    	Android.showToast('msg'); // Android
	   // }
	}
</script>
</head>
<body>

	<div align="center">
		
		<input  type="button" value="Close Webview" onclick="nativeClose('<$device>');"  style="width:300pt;height:200pt;font-size:20pt;"/>
	
	</div>

	

</body>
</html>