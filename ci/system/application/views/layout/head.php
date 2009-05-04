<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load->helper('html'); ?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->config->item('charset'); ?>" />
<title><?php echo $seccion; ?></title>
<?php echo link_tag('css/style.css'); ?>

<!--  jQuery -->
<script src="<?php echo $this->config->item('base_url'); ?>js/jquery.js" type="text/javascript" language="javascript"></script>

<!--  jQuery UI -->
<script src="<?php echo $this->config->item('base_url'); ?>js/jquery-ui.js" type="text/javascript" language="javascript"></script>

<!--  jQuery UI CSS-->
<?php echo link_tag('css/jquery-ui.css'); ?>

<!--  tiny editor -->
<script src="<?php echo $this->config->item('base_url'); ?>js/tiny_mce/tiny_mce.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript">
tinyMCE.init({
	mode : "exact",
	elements : "texto"
});
</script>


<script type="text/javascript" src="http://www.swfupload.org/swfupload.js"></script> 

<script type="text/javascript" language="javascript">
	var swfu;
	window.onload = function () {
		var settings_object = {
				upload_url : "http://www.swfupload.org/upload.php",
				flash_url : "http://www.swfupload.org/swfupload.swf",
				file_size_limit : "20 MB"
		}; 

		swfu = new SWFUpload(settings_object); 
};
</script>

<!--[if lte IE 6]>
	<?php echo link_tag('css/ie6.css'); ?>

<![endif]-->

<!--  theMagic -->
<script src="<?php echo $this->config->item('base_url'); ?>js/application.js" type="text/javascript" language="javascript"></script>


</head>
<body>

	<div id="wrap">