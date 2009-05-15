<?php
/**
 * @package WordPress
 * @subpackage LaMula
 */

/*
Template Name: Archive
*/

function snippet($text,$length=64,$tail="...") {
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
}

$row = null; 
$author = 1;
get_header(); ?>

<?php include '/usr/local/www/wordpress-mu2/mulapress/ci/system/cidip/cidip_index.php';  ?>

<div id="content">
  
	<div id="content_feed">
	
	<?php
	$ci =& get_instance();
	$ci->load->model('users');
	$ci->load->model('usermeta');
	
	$perfil = $ci->usermeta->select_all($author);
	$perfil = $perfil->result_array();
	$data['perfil'] = $perfil;
	echo $ci->load->view('usuarios/perfil', $data, true)  ?> 
	</div> <!-- content_feed -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>