<?php

namespace AppBundle\Game\Loader;

/**
 * Class TextFileLoader
 * @package AppBundle\Game\Loader
 */
class TextFileLoader implements LoaderInterface
{
    public function load($dictionary)
    {
        return array_map('trim', file($dictionary));
    }
}