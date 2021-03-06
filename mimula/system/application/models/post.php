<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Modelo de post
 *
 * @package		mulapress
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

// ------------------------------------------------------------------------

/**
 * Modelo de post
 *
 *
 * @package		mulapress
 * @subpackage	Models
 * @category	Models
 * @author		Srdperu | Juan Alberto
 * @version		Version 1.0
 */

class Post extends Model {
	
    /**
     * Campos de la tabla
     * @var array
     *
     */	
	var $campos = array();
    /**
     * Tabla a utilizar
     * @var array
     *
     */	
	var $tabla = 'wp_1_posts';

	/**
	 * Constructor de la case
	 */  	
    function __construct()
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database('default');        
    }
    
	/**
	 * Consigue los post para la geomula
	 * @param array $values terminos de busqueda
	 * @param array $limit cantidad de registros a retornar
	 * @return array 
	 */     
    function get_geomula($values, $limit)
    {
        $fields = array($this->tabla . '.ID',
        				$this->tabla . '.guid',
        				$this->tabla . '.post_title',
        				'DATE_FORMAT(`wp_1_posts`.`post_date`, \'%d-%m-%Y\') as post_date',
        				$this->tabla . '.comment_count',
        				$this->tabla . '.post_content');

		foreach ($fields as $field)
		{
		   $this->db->select($field, FALSE);
		}
		
    	
		$this->db->select('wp_users.user_login');
		$this->db->select('wp_users.user_nicename');
		
		$this->db->from($this->tabla);
		$this->db->join('wp_1_postmeta', 'wp_1_posts.ID = wp_1_postmeta.post_id');
		$this->db->join('wp_users', 'wp_1_posts.post_author = wp_users.ID');
			
		$this->db->where('post_type', 'post');
		$this->db->where('post_status', 'publish');
		$this->db->where($values);
		
		$this->db->limit($limit['show'], $limit['from']);
		
		$query = $this->db->get();
		return $query;
    }
    
	/**
	 * Consigue los ultimos posts de un autor
	 * @param array $id id del autor
	 * @param array $posts cantidad de registros a retornar
	 * @return array 
	 */     
    function get_lastpost($id, $posts)
    { 
    	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($this->tabla . '.' . $field);
		}

		$this->db->from($this->tabla);
		$this->db->where('post_type', 'post');
		$this->db->where('post_author', $id);
		$this->db->where('(post_status like "publish" or post_status like "inherit")');
		//$this->db->where('post_status', 'publish');
		
		$this->db->limit($posts, 0);
		
		$this->db->order_by($this->tabla . '.post_date', 'DESC');
		
		$todo = $this->db->get();
		$post[] = $todo->result_array();

		$categorias = $this->terms->get_categories_perfil($db);
		
		foreach($categorias as $key => $values)
		{
			
	    	$fields = $this->db->list_fields($this->tabla);

			foreach ($fields as $field)
			{
			   $this->db->select($this->tabla . '.' . $field);
			}
			
			$this->db->from($this->tabla);
			$this->db->join('wp_1_term_relationships', 'wp_1_posts.ID = wp_1_term_relationships.object_id');
			
			$this->db->where('post_type', 'post');
			$this->db->where('post_author', $id);
			$this->db->where('wp_1_term_relationships.term_taxonomy_id', $key);
			
			$this->db->order_by($this->tabla . '.post_date', 'DESC');
			
			$this->db->limit($posts, 0);
			$query = $this->db->get();
			$post[] = $query->result_array();

		}

		return $post;
		
    }

	/**
	 * Consigue los posts de un usuario
	 * @param array $user id del autor
	 * @param array $limit cantidad de registros a retornar
	 * @return array 
	 */      
    function get_mypost($user, $limit = NULL)
    {   	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($this->tabla . '.' . $field);
		}
		$this->db->select('wp_1_terms.name');
		$this->db->select('wp_1_terms.slug');
		
		$this->db->from($this->tabla);
		
		$this->db->join('wp_1_term_relationships', 'wp_1_posts.ID = wp_1_term_relationships.object_id');
		$this->db->join('wp_1_term_taxonomy', 'wp_1_term_taxonomy.term_taxonomy_id = wp_1_term_relationships.term_taxonomy_id');
		$this->db->join('wp_1_terms', 'wp_1_terms.term_id = wp_1_term_taxonomy.term_id');		
		
		$this->db->where('wp_1_posts.post_type', 'post');
		$this->db->where('wp_1_term_taxonomy.parent', '28');
		$this->db->where($this->tabla . '.post_author', $user);		
		$this->db->order_by($this->tabla . '.post_date', 'DESC');
		
		$this->db->limit($limit['show'], $limit['from']);
		$query = $this->db->get();
		return $query;
    }
    
	/**
	 * Inserta un post del tipo attach
	 * @param array $values valores a insertar
	 * @return integer
	 */     
    function insert_attach($values)
    {
    	$values['post_type'] = 'attachment';    	
		$values['post_status'] = 'inherit';
		
		$post_id = $this->_insertar($values);
    	
		return $post_id;
    }
    
	/**
	 * Inserta un post del tipo articulo
	 * @param array $values valores a insertar
	 * @param array $customs valores personalizados
	 * @return integer
	 */  
    function insert_article($values, $customs)
    {
    	$this->load->library('session');
    	$this->load->helper('inflector');
    	
    	$values['post_author'] = $this->session->userdata('id');
    	$values['post_type'] = 'post';
    	$values['post_name'] = sanitize2url($values['post_title']);
		$values['post_status'] = 'publish';    
		$values['guid'] =  $this->options->get_('home') . date('Y/m/') . $values['post_name'];
		  
    	//inserta los tags
    	$tags_id = $this->terms->insert_tags($values['tags']);
    	
    	//limpia los tags
    	unset($values['tags']);

    	if (is_array($tags_id))
    	{
    		foreach ($tags_id as $value)
    		{
    			$tmp[] = $value;
    		}
    	}
    	
    	if (is_array($values['terms_taxonomy_id']))
    	{
    		foreach ($values['terms_taxonomy_id'] as $value)
    		{
    			$tmp[] = $value;
    		}
    	}
    	
    	$terms_taxonomy_id = $tmp;

    	unset($values['terms_taxonomy_id']);

    	$post_id = $this->_insertar($values);
     	
    	$this->postmeta->insertar_customs_locations($customs, $post_id);
    	
    	$this->term_relationships->insertar($post_id, $terms_taxonomy_id);
    	
    	return $post_id;
    }

	/**
	 * Retorna una o más instancias del modelo
	 * @param array $search terminos de busqueda
	 * @param array $limit cantidad de registros a retornar
	 * @return array 
	 */     
    function seleccionar($search = NULL, $limit = NULL)
    {
    	$this->load->database();
    	
    	$fields = $this->db->list_fields($this->tabla);

		foreach ($fields as $field)
		{
		   $this->db->select($field);
		}

    	$this->db->from($this->tabla);
    	
    	if ($search != NULL)
    	{
    		$this->db->where($search);
    	}

        if ($limit != NULL)
    	{
    		$this->db->limit($limit['show'], $limit['from']);
    	}
    	
        $query = $this->db->get();
        return $query;
    }

	/**
	 * Inserta un registro
	 * @param array $values valores a insertar
	 * @return integer 
	 */       
    function _insertar($values)
    {	
    	$values['post_date'] = date('Y-m-d G:i:s');
    	$values['post_date_gmt'] = $values['post_date'];
    	$values['post_modified'] = $values['post_date'];
    	$values['post_modified_gmt'] = $values['post_date'];

    	$values['comment_status'] = 'open';
    	$values['ping_status'] = 'closed';
    	
    	$this->db->insert($this->tabla, $values);
    	
    	return $this->db->insert_id();
    }
    
	/**
	 * Actualiza un registro
	 * @param array $values valores a cambiar
	 * @param array $where id o dato del registro
	 * @return void 
	 */     
    function actualizar_count($values,$where){
      
          $this->db->update($this->tabla, $values, $where);     
    }
    
	/**
	 * Actualiza un registro
	 * @param array $values valores a cambiar
	 * @param array $customs metadata a cambiar
	 * @param array $where id o dato del registro
	 * @return void 
	 */     
    function actualizar($values, $customs, $where)
    {
    	//TODO: aca deberia limpiar esto T_T
    	
    	//Actualiza los customs
    	$this->postmeta->actualizar($customs, $where);
    	
    	//Limpia toodos los tags
    	$tags_id = $this->terms->clear_tags($where['id']);
    	
    	//Los vuelve a actualizar
    	$tags_id = $this->terms->insert_tags($values['tags']);
    	//die(print_r($tags_id));
    	//limpia los tags
    	unset($values['tags']);

    	if (is_array($tags_id))
    	{
    		foreach ($tags_id as $value)
    		{
    			$tmp[] = $value;
    		}
    	}
    	
    	if (is_array($values['terms_taxonomy_id']))
    	{
    		foreach ($values['terms_taxonomy_id'] as $value)
    		{
    			$tmp[] = $value;
    		}
    	}
    	
    	$terms_taxonomy_id = $tmp;

    	$this->term_relationships->insertar($where['id'], $terms_taxonomy_id);
    	
    	unset($values['terms_taxonomy_id']);
    	
        $this->db->update($this->tabla, $values, $where);
        
    }

	/**
	 * Retorna la cantidad de post publicados
	 * @param integer $id id del autor
	 * @return integer
	 */    
    function published_posts($id)
    {      
		$this->db->select('post_author');
		$this->db->from($this->tabla);
		$this->db->where('post_author',$id);
		$this->db->where('post_status like "publish"');
		return $this->db->count_all_results();
    }

	/**
	 * Retorna la cantidad de post totales
	 * @param integer $id id del autor
	 * @return integer
	 */       
    function total_posts($id){
       $this->db->select('post_author');
       $this->db->from($this->tabla);
       $this->db->where('post_author',$id);
       return $this->db->count_all_results();
     }
     
	/**
	 * Retorna un promedio
	 * @param integer $id id del autor
	 * @return array
	 */        
     function promedio($userid)
     {
     	return $this->db->query('SELECT sum(user_votes) as user_votes, sum(user_voters) as user_voters,
     							sum(visitor_votes) as visitor_votes, sum(visitor_voters) as visitor_voters
     		FROM mulapress_gdsr_data_article 
     		WHERE (user_voters > 0 or visitor_voters > 0)  and post_id IN
     		(
				SELECT ID
				FROM wp_1_posts
				WHERE post_author = \'' . $userid . '\'
				AND post_status = \'publish\'
			)');
     }   
}
/* End of file post.php */
/* Location: ./system/application/model/post.php */