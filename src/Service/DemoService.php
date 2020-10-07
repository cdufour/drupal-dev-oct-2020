<?php
namespace Drupal\demo\Service;

class DemoService
{
    public function getSalutation()
    {
        $time = new \Datetime();

        if ((int) $time->format('G') >= 00 && (int) $time->format('G') < 12) {
            return 'Bonjour';
        }
    
        if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
            return 'Bonne après-midi';
        }
    
        if ((int) $time->format('G') >= 18) {
            return 'Bonsoir';
        }
    }

}