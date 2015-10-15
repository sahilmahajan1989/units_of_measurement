<?php
/**
 * @file
 * @author Sahil Mahajan
 * Contains \Drupal\measure\Form\MeasureForm.
 */

namespace Drupal\measure\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form;

/**
 * Implements an example form.
 */
 
 
class AddForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
   
   
  public function getFormId() {
    	
		
    return 'add_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
	
		$name = array();	
  	    $sel = db_query("SELECT * FROM  " . $_REQUEST['type']);
		
    // echo "<pre>";
	// print_r($sel);
	// exit;
$form[]= array(
      '#markup' =>   $_REQUEST['type'] . " " . Units . ">>"  ,
    );
foreach ($sel as $value) 
{
		$name[$value->unitname] =	$value->unitname;
		
	$form[]= array(
      '#markup' => '<br><a href="#"">'.$value->unitname.'</a>',
    );	  
}
		
		
	
			
			$form['unitvalue'] = array(
      '#type' => 'textfield', 
      '#title' => $this->t('Add New Unit')
    );
	
	
            $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('+Add Unit'),
      '#name' => 'unit',
      '#button_type' => 'primary',
    );
	
		
	
	
	        $form['multiplier'] = array(
      '#type' => 'textfield', 
      '#title' => $this->t('Add Multiplier')
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
	

		   $form['baseunit'] = array(
	      '#type' => 'select',
	      '#options' => $name,
	      '#title' => $this->t('Select Base Unit'),
	    );

	
	
	$form['actions']['submit1'] = array(
      '#type' => 'submit',
      '#value' => $this->t('+Select Base Unit'),
      '#name' => 'base',
      
      '#button_type' => 'primary',
  
  
    );
	
		
	
	// $form['#attached']['library'][] = 'measure/measure_css';

return $form;
  
}

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
  	
	if(isset($_REQUEST['unit']))
 {
 		
 	if (strlen($form_state->getValue('unitvalue')) < 1 || preg_match("/^[0-9]/", $form_state->getValue('unitvalue'))) {
      $form_state->setErrorByName('', $this->t('Please enter a valid unit.'));
    }

    if (strlen($form_state->getValue('multiplier')) < 1 || !preg_match("/^[0-9]/", $form_state->getValue('multiplier'))) {
      $form_state->setErrorByName('', $this->t('Please enter a numeric multiplier.'));
    }
	
	

 }
 
 
 /**if(isset($_REQUEST['base']))
 {
 		
 	
	
	if (strlen($form_state->getValue('multiplier')) < 1 || $form_state->getValue('multiplier') != 1) {
      $form_state->setErrorByName('', $this->t('Please select the base unit.'));
    }
	
  
}
**/
 
 
 }

  

public function getButtons() {
    return $this->buttons;
  }
   
   
  public function submitForm(array &$form, FormStateInterface $form_state ) {
 
 
 
 if(isset($_REQUEST['unit']))
 {
 		
 	

     
	$check = db_query("SELECT * FROM  " . $_REQUEST['type'] . " where unitname='". $form_state->getValue('unitvalue') ."'");	 
 	
	//echo $form_state->getValue('unitvalue');
 	
 	//echo "SELECT * FROM  " . $_REQUEST['type'] . " where unitname='". $form_state->getValue('unitvalue') ."'";
 	//exit;
 	foreach ($check as $value) 
	{
			$checkarray[$value->unitname] =	$value->unitname;		  
	}
	 
	 if(count($checkarray) > 0)
	 {
	 		
	 	drupal_set_message(t($form_state->getValue('unitvalue') . " " . 'Unit already exists'));
	 }
	 else
	 {
		 $fields = array('unitname' => $form_state->getValue('unitvalue'),
	                      'multiplier' => $form_state->getValue('multiplier'));
	     db_insert($_REQUEST['type'])
	               ->fields($fields)
	               ->execute();
		drupal_set_message
       ($this->t('@unitvalue is added as Unit', array('@unitvalue' => $form_state->getValue('unitvalue'))));
	 }
 }

 if(isset($_REQUEST['base']))
{
	$sql = "SELECT multiplier FROM  " . $_REQUEST['type'] . " where unitname = '". $form_state->getValue('baseunit')."'";
	
	$select = db_query($sql);
	foreach ($select as $value) 
{
		//echo $value->multiplier;
		
		echo $multiplier =  $value->multiplier;
		echo " ";


}

$sql1 = "SELECT * FROM  " . $_REQUEST['type'] . "";
	
	$select1 = db_query($sql1);
	foreach ($select1 as $value1) 
{
		//echo $value->multiplier;
		
		 $allmultiplier =  $value1->multiplier;
		 $unit_name =  $value1->unitname;
		 	//echo " " . $value1->multiplier;
		 
		 $result = $allmultiplier/$multiplier;
		 //echo $result;
		 $update="UPDATE " . $_REQUEST['type'] .   " SET multiplier = " . $result . " WHERE unitname = '" . $unit_name ."'";
		 //echo $update;
		 
		db_query($update);
}

drupal_set_message
       ($this->t($form_state->getValue('baseunit') . " is added as Base Unit"));
	
		//die();
		 
		
		
		
		
 	/**$fields = array('unitname' => $form_state->getValue('baseunit'),
                      'multiplier' => 1);
     db_insert($_REQUEST['type'])
               ->fields($fields)
               ->execute();
	*/

}

 
}
  
  

}

?>