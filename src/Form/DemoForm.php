<?php

namespace Drupal\demo\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class DemoForm extends FormBase
{
    public function getFormId()
    {
        // returns string identifier (machine name)
        return 'demo_form';
    }

    public function buildForm($form, FormStateInterface $form_state)
    {
        // construction d'un formulaire à 3 champs
        $form['phone'] = array(
            '#type' => 'tel',
            '#title' => $this->t('Your phone number')
        );

        $form['email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Your email')
        );

        $form['save'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Save')
        );

        return $form;
    
    }

    public function validateForm(&$form, FormStateInterface $form_state)
    {
        // validation du formulaire ici
    }

    public function submitForm(&$form, FormStateInterface $form_state)
    {
        \Drupal::state()->set('demo.phone', $form_state->getValue('phone'));
        \Drupal::state()->set('demo.email', $form_state->getValue('email'));
    }
}

