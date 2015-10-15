<?php
/**
 * @file
 * @author Sahil Mahajan
 * Contains \Drupal\measure\Form\MeasureForm.
 */

namespace Drupal\measure\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Implements an example form.
 */
 
 
class EntityForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
   
   
   
  public function getFormId() {
    	
    return 'entity_form';
  }

  /**
   * {@inheritdoc}.
   */
  
  public function buildForm(array $form, FormStateInterface $form_state) {
			
			
		$form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('+Add'),
      '#button_type' => 'primary',
    );
		
			
			$form['entity'] = array(
      '#type' => 'textfield', 
      '#title' => $this->t('Add New Measurement Type')
    );
	
	
		// $form['#attached']['library'][] = 'measure/measure_css'; 
		
    return $form;
  
  }

  /**
   * {@inheritdoc}
   */
  
  public function validateForm(array &$form, FormStateInterface $form_state) 
  {
  	 if (strlen($form_state->getValue('entity')) < 1 || preg_match("/^[0-9]/", $form_state->getValue('entity'))) {
      $form_state->setErrorByName('', $this->t('Please enter a valid measurement type.'));
    }
	 
	
	 
	 
	}

  /**
   * {@inheritdoc}
   * 
   * 
   */
   function measure_type($tablename) {
   
   $sql  = 'CREATE TABLE IF NOT EXISTS ' .$tablename .'( unitname varchar(255), multiplier varchar(255))';
   
   db_query($sql);
  
}
  public function submitForm(array &$form, FormStateInterface $form_state ) {
  		
		$check = db_query("SELECT * FROM  unit where type='". $form_state->getValue('entity') ."'");	 
 	
	//echo $form_state->getValue('unitvalue');
 	
 	//echo "SELECT * FROM  " . $_REQUEST['type'] . " where unitname='". $form_state->getValue('unitvalue') ."'";
 	//exit;
 	foreach ($check as $value) 
	{
			$checkarray[$value->type] =	$value->type;		  
	}
	 
	 if(count($checkarray) > 0)
	 {
	 		
	 	drupal_set_message(t(strtoupper(($form_state->getValue('entity')) .  " " . 'already exist')));
	 }
	 else
	 
	{
			
	drupal_set_message
($this->t('@entity is added as Measurement Type', array('@entity' => strtoupper($form_state->getValue('entity')))));

$fields = array('type' => strtoupper($form_state->getValue('entity')));
db_insert('unit')
  ->fields($fields)
  ->execute();

	}
$this->measure_type($form_state->getValue('entity'));



$form_state->setRedirect('measure.form');
	  
  }

}

?>