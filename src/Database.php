<?php

namespace WebApp;


use SQLite3;

/**
 * Class Database
 * @package WebApp
 */
class Database
{
    const DATABASE_NAME = 'mrpeasy';
    private static Database $db;
    private SQLite3 $connection;

    /**
     * Database constructor.
     */
    private function __construct()
    {
        $this->connection = new SQLite3(self::DATABASE_NAME);
    }

    /**
     * Database destructor
     */
    function __destruct()
    {
        $this->connection->close();
    }

    /**
     * Get or initialize connection
     * @return SQLite3
     */
    public static function getConnection(): SQLite3
    {
        if (!isset(self::$db) || self::$db == null) {
            self::$db = new Database();
        }
        return self::$db->connection;
    }

    /**
     * initialize datatable
     */
    public static function init()
    {
        self::getConnection()->exec('
            CREATE TABLE IF NOT EXISTS user (
                id INTEGER PRIMARY KEY,
                username CHARACTER(20) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                counter INT DEFAULT 0
            )
        ');
    }
}