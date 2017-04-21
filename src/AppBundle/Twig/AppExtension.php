<?php

namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('censorship', array($this, 'censorship')),
        );
    }

    public function censorship($parameters)
    {
        print_r($parameters);
    }

    public function getName()
    {
        return 'app_censorship';
    }
}