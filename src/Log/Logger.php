<?php

namespace CaesarCipher\Log;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

class Logger
{
    public static $log;

    const LOG_PATH = __DIR__ . '/../../logs/app.log';

    protected static function configure()
    {
        $dateFormat = "Y-m-d H:i:s";
        $output = "[%datetime%] %channel% %level_name% %message%\n";

        $formatter = new LineFormatter($output, $dateFormat);
        $stream = new StreamHandler(Logger::LOG_PATH, MonologLogger::DEBUG);
        $stream->setFormatter($formatter);

        self::$log = new MonologLogger('LOG');
        self::$log->pushProcessor(new \Monolog\Processor\UidProcessor());
        self::$log->pushHandler($stream);
    }

    /**
     * Add a new debug log | 100
     * @param string $message
     */
    public static function debug(string $message)
    {
        self::configure();
        self::$log->debug($message);
    }

    /**
     * Add a new info log | 200
     * @param string $message
     */
    public static function info(string $message)
    {
        self::configure();
        self::$log->info($message);
    }

    /**
     * Add a new notice log | 250
     * @param string $message
     */
    public static function notice(string $message)
    {
        self::configure();
        self::$log->notice($message);
    }

    /**
     * Add a new warning log | 300
     * @param string $message
     */
    public static function warning(string $message)
    {
        self::configure();
        self::$log->warning($message);
    }

    /**
     * Add a new error log | 400
     * @param string $message
     */
    public static function error(string $message)
    {
        self::configure();
        self::$log->error($message);
    }

    /**
     * Add a new critical log | 500
     * @param string $message
     */
    public static function critical(string $message)
    {
        self::configure();
        self::$log->critical($message);
    }

    /**
     * Add a new alert log | 550
     * @param string $message
     */
    public static function alert(string $message)
    {
        self::configure();
        self::$log->alert($message);
    }

    /**
     * Add a new emergency log | 600
     * @param string $message
     */
    public static function emergency(string $message)
    {
        self::configure();
        self::$log->emergency($message);
    }
}
