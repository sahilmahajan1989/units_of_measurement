<?php
/**
 * @file
 * @author Sahil Mahajan
 * Contains \Drupal\measure\Form\MeasureForm.
 */

namespace Drupal\measure\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Controller\ControllerBase;



/**
 * Implements an example form.
 */
 
 
class MeasureForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
   
   
  public function getFormId() {
    	
		
    return 'measure_form';
  }

  /**
   * {@inheritdoc}.
   */
  
  public function buildForm(array $form, FormStateInterface $form_state) {
  			
  		$form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('+Add Measurement Type'),
      '#button_type' => 'primary',
    );
		
		
		
  	$drop = array();	
  	
  	$result = db_query("SELECT * FROM {unit}");
    
   foreach ($result as $units) 
   {
    	
		$form[]= array(
      '#markup' => '<br><a href="'.base_path().'./admin/structure/units/add/unit?type='.$units->type.'">'.$units->type.'</a>',
    );
	       
   }
	
	return $form;
  
                 }

  /**
   * {@inheritdoc}
   */
  
  public function validateForm(array &$form, FormStateInterface $form_state) 
  {
  	
  }

  /**
   * {@inheritdoc}
   * 
   * 
   */
   
  public function submitForm(array &$form, FormStateInterface $form_state ) {

       $form_state->setRedirect('measure.form1');
  }
  
}

?>