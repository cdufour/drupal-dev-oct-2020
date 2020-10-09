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
        \Drupal::state()->set('demo.squareTxt', 'Simple carré');
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
        // suppession de la clé demo.squareVisits dans le state
        \Drupal::state()->delete('demo.squareVisits');

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

        $sqText = \Drupal::state()->get('demo.squareTxt');

        $visits = \Drupal::state()->get('demo.squareVisits');
        if (!$visits) {
            $visits = 1;
            \Drupal::state()->set('demo.squareVisits', $visits);
        } else {
            \Drupal::state()->set('demo.squareVisits', $visits += 1);
        }

        $sqText .= ' ('.$visits .')'; // concaténation incluant le nombre de visites
        
        // accès directe à une configuration
        $message = $this->config('demo.square_message')
            ->get('message');

        $sq = '<div style="height:'.$width.'px;width:'.$width.'px;background-color:#'.$color.'">'.$message.'</div>';
        $res->setContent($sq);
        return $res;
    }

    public function generateForm()
    {
        // getForm() retourne le formulaire construit par buildForm
        $form = \Drupal::formBuilder()->getForm('\Drupal\demo\Form\DemoForm');
        
        $build = array();

        $build['enabled'] = array(
            '#type' => 'checkbox',
            '#title' => 'Activer'
        );

        $build['forms'] = array(
            'form1' => $form,
            'form2' => $form
        );

        return $build;
    }

    public function testNode()
    {
        // $data = [
        //     'type' => 'article',
        //     'title' => 'Lorem ipsum'
        // ];
        $articles = [
            array('type' => 'article', 'title' => 'Super article', 'status' => 0),
            array('type' => 'article', 'title' => 'Très bon article', 'status' => 0),
            array('type' => 'article', 'title' => 'Mauvais article', 'status' => 0)
        ];

        foreach ($articles as $article) {
            $this->createNode($article);
        }

        return new Response(sizeof($articles) . ' articles created');
    }

    private function createNode($data)
    {
        $node = \Drupal::entityManager()->getStorage('node')->create($data);
        $node->save();
    }
}