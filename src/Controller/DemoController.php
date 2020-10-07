<?php
namespace Drupal\demo\Controller;

use \Drupal\Core\Controller\ControllerBase;
use \Symfony\Component\HttpFoundation\Response;

class DemoController extends ControllerBase
{
    public function hello()
    {
        $salutation = 'Coucou';
        // réponse passant par le moteur de rendu Drupal
        // on renvoie un tableau associatif balisé
        return [
            '#markup' => '<em>' . $salutation .'</em>'
        ];
    }

    public function helloSymfony()
    {
        $student = [
            'firstname' => 'Kevin',
            'lastname' => 'Bataille',
            'isCompetent' => true,
            'languages' => ['PHP', 'JS', 'Java']
        ];

        // réponse directe sans passer par le moteur de rendu Drupal
        // 
        return new \Symfony\Component\HttpFoundation\Response(json_encode($student));
        $response = new Response(json_encode($student));
        return $response;
    }
}