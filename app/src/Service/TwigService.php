<?php

namespace App\Service;

use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigService
{
    private static $twig;

    public static function getEnvironment(): Environment
    {
        if (!self::$twig) {
            $loader = new FilesystemLoader( __DIR__ . '/../../templates');

            self::$twig =  new Environment($loader, [
                    'debug' => true,
                //'cache' => '/path/to/compilation_cache',
            ]);
            self::$twig->addExtension(new DebugExtension());
        }

        return self::$twig;
    }

}