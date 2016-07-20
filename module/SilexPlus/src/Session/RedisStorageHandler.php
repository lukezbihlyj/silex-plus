<?php

namespace LukeZbihlyj\SilexPlus\Session;

use SessionHandlerInterface;
use InvalidArgumentException;
use Silex\Application;
use Credis_Client;
use Credis_Cluster;

/**
 * @package LukeZbihlyj\SilexPlus\Session\RedisStorageHandler
 */
class RedisStorageHandler implements SessionHandlerInterface
{
    const DEFAULT_HOST = 'localhost';
    const DEFAULT_PORT = 6379;
    const DEFAULT_DATABASE = 0;
    const KEY_PREFIX = 'session:';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Credis_Client
     */
    protected $driver;

    /**
     * @param Application $app
     * @return self
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        if (is_array($this->app['session.redis'])) {
            $this->driver = new Credis_Cluster($this->app['session.redis']);
        } else {
            list($host, $port, $dsnDatabase, $user, $password, $options) = $this->parseDsn($this->app['session.redis']);

            $timeout = isset($options['timeout']) ? intval($options['timeout']) : null;
            $persistent = isset($options['persistent']) ? $options['persistent'] : '';

            $this->driver = new Credis_Client($host, $port, $timeout, $persistent);

            if ($password) {
                $this->driver->auth($password);
            }
        }

        return $this;
    }

    /**
     * @param string $savePath
     * @param string $sessionName
     * @return void
     */
    public function open($savePath, $sessionName)
    {
        return;
    }

    /**
     * @return void
     */
    public function close()
    {
        return;
    }

    /**
     * @param string $sessionId
     * @return array
     */
    public function read($sessionId)
    {
        $key = self::KEY_PREFIX . $this->app['session.cookie_name'] . $sessionId;
        $sessionData = $this->driver->get($key);

        return $sessionData;
    }

    /**
     * @param string $sessionId
     * @param string $sessionData
     * @return void
     */
    public function write($sessionId, $sessionData)
    {
        $key = self::KEY_PREFIX . $this->app['session.cookie_name'] . $sessionId;

        $this->driver->set($key, $sessionData);
        $this->driver->expire($key, $this->app['session.lifetime']);
    }

    /**
     * @param string $sessionId
     * @return void
     */
    public function destroy($sessionId)
    {
        $key = self::KEY_PREFIX . $this->app['session.cookie_name'] . $sessionId;

        $this->driver->del($key);
    }

    /**
     * @param integer $maxLifetime
     * @return void
     */
    public function gc($maxLifetime)
    {
        return;
    }

    /**
     * @param string $dsn
     * @return array
     */
    protected function parseDsn($dsn)
    {
        if ($dsn == '') {
            $dsn = 'redis://' . self::DEFAULT_HOST;
        }

        $parts = parse_url($dsn);
        $validSchemes = ['redis', 'tcp'];

        if (isset($parts['scheme']) && ! in_array($parts['scheme'], $validSchemes)) {
            throw new InvalidArgumentException('Invalid DSN. Supported schemes are ' . implode(', ', $validSchemes));
        }

        if (!isset($parts['host']) && isset($parts['path'])) {
            $parts['host'] = $parts['path'];
            unset($parts['path']);
        }

        $port = isset($parts['port']) ? intval($parts['port']) : self::DEFAULT_PORT;
        $database = false;

        if (isset($parts['path'])) {
            $database = intval(preg_replace('/[^0-9]/', '', $parts['path']));
        }

        $user = isset($parts['user']) ? $parts['user'] : false;
        $pass = isset($parts['pass']) ? $parts['pass'] : false;
        $options = [];

        if (isset($parts['query'])) {
            parse_str($parts['query'], $options);
        }

        return [$parts['host'], $port, $database, $user, $pass, $options];
    }
}
