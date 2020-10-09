<?php
namespace Drupal\demo\Controller;

use \Drupal\Core\Controller\ControllerBase;

class JsController extends ControllerBase
{
    public function testJs()
    {
        $render = [
            '#theme' => 'demo_theme_hook',
            '#variable1' => 'Test JS',
            '#students' => NULL
        ];

        return $render;
    }

    public function testJquery()
    {
        $render = [
            '#markup' => '<div class="clock"></div>',
            '#attached' => ['library' => ['demo/demo-clock'] ]
        ];

        return $render;
    }
}