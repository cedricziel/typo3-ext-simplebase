<?php

namespace CedricZiel\Simplebase\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\RouteCollection;

class AdvancedLoader extends Loader
{
    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();

        $resource = '@AppBundle/Resources/config/import_routing.yml';
        $type = 'yaml';

        $importedRoutes = $this->import($resource, $type);

        $collection->addCollection($importedRoutes);

        return $collection;
    }

    public function supports($resource, $type = null)
    {
        return 'advanced_extra' === $type;
    }
}
