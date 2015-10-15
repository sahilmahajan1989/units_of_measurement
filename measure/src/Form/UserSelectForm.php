<?php
/**
 * @file
 * @author Sahil Mahajan
 * Contains \Drupal\measure\Form\UsForm.
 */

namespace Drupal\measure\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;



/**
 * Implements an example form.
 */
 
 
class UserSelectForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
   
   
  public function getFormId() {
    
	
	
	return 'userselect_forma';
  }

  /**
   * {@inheritdoc}.
   */
  
  public function buildForm(array $form, FormStateInterface $form_state) {
  			
			$form['uservalue'] = array(
      '#type' => 'textfield', 
      '#title' => $this->t('Add value')
    );
	
			
  			
  		$name = array();	
  	    $sel = db_query("SELECT * FROM  " . $_REQUEST['type']);
		
    // echo "<pre>";
	// print_r($sel);
	// exit;

foreach ($sel as $value) 
{
		$name[$value->unitname] =	$value->unitname;
		
		  
}
$form['userunit'] = array(
	      '#type' => 'select',
	      '#options' => $name,
	      '#title' => $this->t('Select Unit'),
	    );

 

	
	
	
	$name = array();	
  	    $sel = db_query("SELECT * FROM  " . $_REQUEST['type']);
  
  foreach ($sel as $value) 
{
		$name[$value->unitname] =	$value->unitname;
		
		  
}
$form['convertedunit'] = array(
	      '#type' => 'select',
	      '#options' => $name,
	      '#title' => $this->t('Conversion Unit'),
	    );
  
  
  
    

	$form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Convert'),
      '#button_type' => 'primary',
    );
		
	
	return $form;
	
	
	
  
                 }

  /**
   * {@inheritdoc}
   */
  
  public function validateForm(array &$form, FormStateInterface $form_state) 
  {
  	
	
	 if (strlen($form_state->getValue('uservalue')) < 1 || !preg_match("/^[0-9]/", $form_state->getValue('uservalue'))) {
      $form_state->setErrorByName('', $this->t('Please enter a numeric value in Add value field.'));
    }
  	
  }

  /**
   * {@inheritdoc}
   * 
   * 
   */
   
  public function submitForm(array &$form, FormStateInterface $form_state ) {
  	
	
	$sql = "SELECT multiplier FROM  " . $_REQUEST['type'] . " where unitname = '". $form_state->getValue('userunit')."'";
	
	$select = db_query($sql);
	foreach ($select as $value) 
{
		//echo $value->multiplier;
		
		 $multiplier_from =  $value->multiplier;
}



$sql = "SELECT multiplier FROM  " . $_REQUEST['type'] . " where unitname = '". $form_state->getValue('convertedunit')."'";
	
	$select = db_query($sql);
	foreach ($select as $value) 
{
		//echo $value->multiplier;
		
		 $multiplier_to =  $value->multiplier;
}




 
  //  print_r($select);
  
 //$select = db_query("SELECT multiplier FROM  " . $_REQUEST['type'] . "where unitname=". $form_state->getValue('uservalue').";");

// echo $select;

 
 
 //die();
$result = $form_state->getValue('uservalue') * $multiplier_to / $multiplier_from. " " . $form_state->getValue('convertedunit') ;
drupal_set_message($result);
  }
  
}

?>