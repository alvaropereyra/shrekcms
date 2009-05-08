<?php
class Usermeta extends Model {
	
	var $campos = array();
    var $tabla = 'wp_usermeta';

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
    function insertar($values, $id)
    {
    	$tmp['user_id'] = $id;
    	foreach($values as $value)
    	{
    		$tmp['meta_key'] = $value['meta_key'];
    		$tmp['meta_value'] = $value['meta_value'];
    		$this->db->insert($this->tabla, $tmp);
    	}
    }
}