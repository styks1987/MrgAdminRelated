<?php
	App::uses('Helper', 'View');

	class MrgAdminRelatedHelper extends AppHelper{
		var $helpers = ['Html', 'Form', 'Js'];

		public function __construct(View $view, $settings = array()) {
			parent::__construct($view, $settings);
			// Load a custom select box
				// $this->Html->css('MrgCustomSelect.jquery.plugins.selectBoxIt', array('inline'=>false)).
				// $this->Html->script('MrgAdminRelated.MrgAdminRelatedScript.js', array('inline'=>false));
		}

		/**
		 * create a repeatable section that can be managed using the
		 * jquery repeater widget. This takes the model and fields needed in a single group
		 * This also assumes you are using the bootstrap framework
		 *
		 * @model = Model Name
		 * @fields = [[cols, name, options]]
		 * @options = ['group_container'=>'repeater_group_container', 'group'=>'repeater_group']
		 *
		 * return (String) group of rows
		 *
		 *
		 * Date Added: Mon, Mar 24, 2014
		 */

		function init($model, $fields=[], $options = ['group_container'=>'repeater_group_container', 'group'=>'repeater_group']){


			$this->model = $model;
			$this->fields = $fields;
			$this->options = $options;

			$output = '';
			$i = 0;
			if(!empty($this->data[$this->model])){
				foreach($this->data[$this->model] as $d){
					$id = (!empty($d['id']))?$d['id'] : '';
					$output .= $this->_single($i, $id);
					$i++;
				}
			}else{
				$output .= $this->_single($i, 'empty');
			}

			return $this->Html->div($this->options['group_container'], $output);
		}
		/**
		 * get a single group of fields
		 *
		 * @i = current index
		 * @id = current id
		 *
		 * return (String) row of content
		 *
		 * Date Added: Mon, Mar 24, 2014
		 */

		private function _single($i, $id){
			$fields = $this->_fields($i, $id);

			return	$this->Html->row($fields, ['class'=>$this->options['group'], 'data-id'=>$id]);

		}
		/**
		 * get the fields for a single row
		 *
		 * @i = current index
		 *
		 * return (Array) columns for a row
		 *
		 * Date Added: Mon, Mar 24, 2014
		 */

		private function _fields($i, $id){
			$fields = [];
			$k = 0;
			foreach($this->fields as $field){
				$field[2] = (!empty($field[2]))?$field[2]:[];
				list($cols, $name, $options) = $field;
				if(!$name){
					$content = $options['content'];
				}else{
					$content = $this->Form->input($this->model.'.'.$i.'.'.$name, $options);
				}
				if($k == 0 && is_numeric($id)){
					$content .= $this->Form->hidden($this->model.'.'.$i.'.id');
				}
				$fields[] = [$cols,$content];
				$k++;
			}
			return $fields;

		}
	}

?>
