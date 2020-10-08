<?php

namespace Drupal\demo\Plugin\Block;

use \Drupal\Core\Block\BlockBase;
use \Drupal\Core\Form\FormStateInterface;

/**
 * Création du bloc démo
 * 
 * @Block(
 *  id = "demo_block",
 *  admin_label = "Demo Block"
 * )
 */
class DemoBlock extends BlockBase
{
    public function build()
    {
        $extra = $this->getConfiguration()['enabled'] 
            ? '(Extra ON)' 
            : '(Extra OFF)';
        return ['#markup' => '<strong>block demo '.$extra.'</strong>'];
    }

    public function defaultConfiguration()
    {
        return ['enabled' => 1];
    }

    public function blockForm($form, FormStateInterface $form_state)
    {
        // récupère le retour de defaultConfiguration()
        // $config est un tableau assoc
        $config = $this->getConfiguration();

        // ajout d'une boîte à cocher dans le formulaire de config
        // du block
        $form['enabled'] = array(
            '#type' => 'checkbox',
            '#title' => 'Activer',
            '#description' => 'Cocker pour activer',
            '#default_value' => $config['enabled']
        );

        return $form;
    }

    public function blockSubmit($form, FormStateInterface $form_state)
    {
        // storage dans la config de la valeur associé ah champ enabled (la cbox du formulaire)
        $this->configuration['enabled'] = $form_state->getValue('enabled');
    }
}