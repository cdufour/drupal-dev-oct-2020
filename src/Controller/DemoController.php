<?php
namespace Drupal\demo\Controller;

use \Drupal\Core\Controller\ControllerBase;
use \Symfony\Component\HttpFoundation\Response;
use Drupal\demo\Service\DemoService;

class DemoController extends ControllerBase
{
    private $demoService;

    public function __construct()
    {
        // Design Pattern DI (Dependency Injection)
        $this->demoService = new DemoService();
    }

    public function hello()
    {
        //$salutation = 'Coucou';

        // instanciation ad hoc de DemoService
        //$demoService = new DemoService(); 
        //$salutation = $demoService->getSalutation();

        // utilisation par DI (le service est utilisable pour totalité des méthodes de cette classe)
        //$salutation = $this->demoService->getSalutation();

        // utilisation d'un conteneur de services
        $salutation = \Drupal::service('demo.demoService')->getSalutation();

        //$students = ['Student 1', 'Student 2', 'Student 3'];
        $students = [
            [ 'name' => 'Student1', 'points' => 14 ],
            [ 'name' => 'Student2', 'points' => 6 ],
            [ 'name' => 'Student3', 'points' => 20 ]
        ];

        // réponse passant par le moteur de rendu Drupal
        // on renvoie un tableau associatif balisé


        return [
            '#theme' => 'demo_theme_hook',
            '#variable1' => 'Texte provenant du controleur',
            '#students' => $students
        ];

        return [
            '#theme' => 'item_list', // theme hook item_list
            '#items' => $students
        ];

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

    public function helloBis($salutation)
    {
        $res = new Response();

        if ($salutation == 'coucou') {
            $res->setContent('Coucou à toi également!');
        } else {
            $res->setContent($salutation);
        }

        return $res;
    }

    public function square($width, $color)
    {
        $res = new Response();

        if ($width > 500) {
            $res->setContent('Carré trop grand...');
            return $res;
        }

        $sq = '<div style="height:'.$width.'px;width:'.$width.'px;background-color:#'.$color.'"></div>';
        $res->setContent($sq);
        return $res;
    }
}