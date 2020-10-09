<?php

namespace Drupal\demo\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class DemoConfigForm extends ConfigFormBase
{
    // méthode spécifique à ConfigFormBase
    protected function getEditableConfigNames()
    {
        return ['demo.square_message'];
    }

    public function getFormId()
    {
        // returns string identifier (machine name)
        return 'demo_config_form';
    }

    public function buildForm($form, FormStateInterface $form_state)
    {
        $config = $this->config('demo.square_message');

        $form['square_message'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Inner message for square'),
            '#default_value' => $config->get('message')
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
        // persistance (écriture) dans une config de la valeur postée
        $this->config('demo.square_message')
            ->set('message', $form_state->getValue('square_message'))
            ->save(); // requête d'enregistrement en db

        //\Drupal::messenger()->addMessage($this->t('Message bien enregistré'));
        // équivalent syntaxique:
        $this->messenger()->addMessage($this->t('Message enregistré !'));
    }
}

