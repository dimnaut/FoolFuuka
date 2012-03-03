<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');


class FS_Articles extends Plugins
{
	/*
	 * This is a plugin that is in actual production, but that is also
	 * good for use as tutorial. It contains all the base functions that
	 * you will have to edit to match
	 */


	function __construct()
	{
		// KEEP THIS EMPTY, use the initialize_plugin method instead

		parent::__construct();
	}


	/**
	 * We leave the install, update, remove, enable, disable functions on 
	 * bottom of this file
	 */
	function initialize_plugin()
	{
		$this->plugins->register_controller_function($this, array('admin', 'articles', 'manage'),
			'manage');
		
		$this->plugins->register_controller_function($this, array('chan', '(:any)', 'articles'),
			'article');
	}


	function manage()
	{
		echo 'here yep';
	}
	
	
	function article()
	{
		$this->template->title('/' . get_selected_radix()->shortname . '/ - ' . get_selected_radix()->name);
		$this->template->set('section_title', 'Articles');
		$this->template->set_partial('top_tools', 'top_tools');
		$this->template->set_partial('post_tools', 'post_tools');
		
		// unless you're making a huge view you can live with output buffers
		ob_start();
		?>

		<h1>Welcome to the articles section!</h1>
		
		<?php
		$this->template->set('content', ob_get_clean());
		
		$this->template->build('plugin');
	}


	/**
	 * Grab the whole table of articles 
	 */
	function get_all()
	{
		$query = $this->db->query('
	    SELECT *
	    FROM `' . $this->db->dbprefix('plugin_fs-articles') . '`
	');

		return $query->result();
	}


	function get_by_slug($slug)
	{
		$query = $this->db->query('
	    SELECT *
	    FROM `' . $this->db->dbprefix('plugin_fs-articles') . '`
	    WHERE slug = ?
	',
			array($slug));

		return $query->result();
	}


	function get_by_id($id)
	{
		$query = $this->db->query('
	    SELECT *
	    FROM `' . $this->db->dbprefix('plugin_fs-articles') . '`
	    WHERE slug = ?
	',
			array($id));

		return $query->result();
	}


	function save($data)
	{
		$name = "";
		$url = "";
		$article = "";
		$positions = array();

		if ($data["url"])
		{
			
		}
	}


	/**
	 * Using the install function creates folders and database entries for 
	 * the plugin to function. 
	 */
	function install()
	{
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix('plugin_fs-articles') . "` (
				`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`slug` varchar(128) NOT NULL,
				`name` varchar(256) NOT NULL,
				`url` text,
				`article` text,
				`active` smallint(2),
				`positions` text,
				`edited` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				KEY `edited` (`edited`),
				KEY `slug` (`slug`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	    ");
	}

	/**
	 * If any upgrade is necessary, use this format. Update checks are
	 * performed every time the version of the plugin is changed.
	 */
	/*
	  function upgrade_001()
	  {

	  }
	 */


	/**
	 * Removes everything by the plugin.
	 */
	function remove()
	{
		$this->db->query('
			DROP TABLE `fu_plugin_fs-articles`
	    ');
	}


	/**
	 * A function triggered when the user enables the plugin.
	 * If not present at all (it mostly shouldn't be necessary) nothing
	 * wrong will happen. 
	 */
	function enable()
	{
		
	}


	/**
	 * A function triggered when the user disables the plugin.
	 * If not present at all (it mostly shouldn't be necessary) nothing
	 * wrong will happen. 
	 */
	function disable()
	{
		
	}

}