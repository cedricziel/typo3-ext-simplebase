<?php

namespace CedricZiel\Simplebase\Framework\Database;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * @package CedricZiel\Simplebase\Database
 */
class ConnectionFactory
{
    /**
     * @return Connection
     */
    public static function getConnection()
    {
        /** @var ConnectionPool $connectionPool */
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $connection = $connectionPool->getConnectionByName(ConnectionPool::DEFAULT_CONNECTION_NAME);

        return $connection;
    }
}
