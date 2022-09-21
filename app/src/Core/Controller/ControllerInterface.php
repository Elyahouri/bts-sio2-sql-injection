<?php

namespace App\Core\Controller;

use Twig\Environment;

interface ControllerInterface
{
    public function inputRequest(array $tabInput);

    public function outputEvent();
}