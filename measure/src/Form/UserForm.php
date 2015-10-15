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
 
 
class UserForm extends FormBase {

  /**
   * {@inheritdoc}.
   */
   
   
  public function getFormId() {
    
	
	
	return 'user_forma';
  }

  /**
   * {@inheritdoc}.
   */
  
  public function buildForm(array $form, FormStateInterface $form_state) {
  			
  		
	
	
	$drop = array();	
  	
  	$result = db_query("SELECT * FROM {unit}");
    
   foreach ($result as $units) 
   {
    	
		$form[]= array(
      '#markup' => '<br><a href="'.base_path().'./user/add/select?type='.$units->type.'">'.$units->type.'</a>',
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

  
  }
  
}

?>