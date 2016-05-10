<?php

namespace CedricZiel\Simplebase\Framework\Database;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;

/**
 * @package CedricZiel\Simplebase\Framework\Database
 */
class EntityManagerFactory
{
    /**
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    public static function getDefaultEntityManager()
    {
        $paths = [
            __DIR__.'/../../Entity',
            __DIR__.'/../../../simplebase_news/Entity',
        ];

        $defaultConnectionParams = $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'];
        $dbParams = [
            'dbname' => $defaultConnectionParams['dbname'],
            'user' => $defaultConnectionParams['user'],
            'password' => $defaultConnectionParams['password'],
            'host' => $defaultConnectionParams['host'],
            'port' => $defaultConnectionParams['port'],
            'driver' => 'pdo_mysql',
        ];

        $config = Setup::createConfiguration(true);
        $driver = new AnnotationDriver(new AnnotationReader(), $paths);

        // registering noop annotation autoloader - allow all annotations by default
        AnnotationRegistry::registerLoader('class_exists');
        $config->setMetadataDriverImpl($driver);

        $entityManager = EntityManager::create($dbParams, $config);

        return $entityManager;
    }
}
