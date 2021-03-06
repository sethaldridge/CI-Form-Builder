<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Form_builder {

	public function __construct($config = array())
	{
		$CI =& get_instance();
		$CI->load->helper('url');
	}

	function create_form($form = array())
	{
		/**
		 * Create the opening form tag and pass in the attributes
		 */
		echo form_open($form['attr']['action'], $form['attr']);
	
		/**
		 * Loop over the results and create the proper fields
		 */
		foreach ( $form as $key => $val )
		{
			if ( isset($val['type']) )
			{
				$type = $val['type'];
				$attr = $this->check_val($val['attr']);
				
				echo '<div class="control-group">';
				
				/**
				 * Create the label
				 */
				$required = ( isset($val['required']) ) ? ' *' : '';
				if ( isset($val['label']) ) echo form_label($val['label'] . $required, $key, array('class' => 'control-label'));
				
				echo '<div class="controls">';
				
				/**
				 * Select Element
				 */
				if ( $type == 'select' )
				{
					$value = ( isset($attr['value']) ) ? $attr['value'] : '';
					$select_extra = ( isset($attr['extra']) ) ? ' ' . $attr['extra'] : '';
					$extra = 'id="' . $key . '"' . $select_extra;
					
					echo form_dropdown($key, $val['options'], $value, $extra);
				}
				
				else if ( $type == 'textarea' )
				{
					$default = array_merge(array('id' => $key, 'name' => $key), $attr);
					echo form_textarea($default);
				}
				
				else if ( $type == 'checkbox' || $type == 'radio' )
				{
					$is_checkbox = ( $type == 'checkbox' ) ? TRUE : FALSE;
					
					$default = array_merge(array(), $attr);
					
					foreach ( $val['options'] as $opt => $checkbox )
					{
						$label_class = 'checkbox';
						if ( !$is_checkbox ) {
							$label_class = 'radio';
						}
						$checkbox_attr = ( isset($checkbox['attr']) ) ? $checkbox['attr'] : array();
						$checkbox_defaults = array_merge(array('id' => $opt, 'name' => $key, 'value' => $opt), $checkbox_attr);
						$checkbox_class = ( isset($attr['class']) ) ? $attr['class'] : '';
						
						echo '<label class="' . $label_class . ' ' . $checkbox_class . '">';
						echo ( $type == 'checkbox' ) ? form_checkbox($checkbox_defaults) : form_radio($checkbox_defaults);
						echo $checkbox['label'];
						echo '</label>';
					}
				}
				
				else
				{
					$default = array_merge(array('id' => $key, 'name' => $key, 'type' => $type), $attr);
					echo form_input($default);
				}
				
				if ( isset($attr['help_text']) ) 
				{
					echo '<p class="help-block">' . $attr['help_text'] . '</p>';
				}
				
				echo '</div></div>';
			}
	
		}
	
		/**
		 * Add the form buttons
		 */
		if ( isset($form['actions']) )
		{
			$i = 0;
			
			echo '<div class="form-actions">';
			
			foreach ( $form['actions'] as $button => $btn_val )
			{
				$btn_class = ( $i == 0 )  ? ' btn-primary' : '';
				
				if ( is_array($btn_val) )
				{
					$btn_class = ( isset($btn_val['class']) ) ? ' ' . $btn_val['class'] : '';
					$btn_label = ( isset($btn_val['label']) ) ? $btn_val['label'] : '';
				}
				else
				{
					$btn_label = $btn_val;
				}
				
				echo '<button type="' . $button . '" class="btn' . $btn_class . '">' . $btn_label . '</button>' . "\n";
				
				$i++;
			}
			
			echo '</div>';
		}
		
		echo form_close();
	}

	function check_val( $val )
	{
		return ( isset($val) ) ? $val : '';
	}

}