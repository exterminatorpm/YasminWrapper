<?php
declare(strict_types=1);

namespace Twisted\YasminWrapper\Util;

use DateTime;
use DateTimeZone;
use Exception;
use function date_default_timezone_get;
use function sprintf;
use const PHP_EOL;

class Logger{

    const COLOR_RESET = "\033[0m";
    const COLOR_BLACK = "\x1b[38;5;16m";
    const COLOR_DARK_BLUE = "\x1b[38;5;19m";
    const COLOR_DARK_GREEN = "\x1b[38;5;34m";
    const COLOR_DARK_AQUA = "\x1b[38;5;37m";
    const COLOR_DARK_RED = "\x1b[38;5;124m";
    const COLOR_PURPLE = "\x1b[38;5;127m";
    const COLOR_GOLD = "\x1b[38;5;214m";
    const COLOR_GRAY = "\x1b[38;5;145m";
    const COLOR_DARK_GRAY = "\x1b[38;5;59m";
    const COLOR_BLUE = "\x1b[38;5;63m";
    const COLOR_GREEN = "\x1b[38;5;83m";
    const COLOR_AQUA = "\x1b[38;5;87m";
    const COLOR_RED = "\x1b[38;5;203m";
    const COLOR_LIGHT_PURPLE = "\x1b[38;5;207m";
    const COLOR_YELLOW = "\x1b[38;5;227m";
    const COLOR_WHITE = "\x1b[38;5;231m";

    /**
     * Logs a formatted message to console (supports color)
     *
     * @param        $message
     * @param string $prefix
     * @param string $format (Must include 3 string arguments: time, prefix & message)
     *
     * @throws Exception
     */
    static function log($message, $prefix = "", $format = self::COLOR_BLUE . "[%s]" . self::COLOR_RESET . " %s %s"){
        $time = new DateTime('now', new DateTimeZone(date_default_timezone_get()));

        echo sprintf($format, $time->format("H:i:s"), $prefix, $message) . self::COLOR_RESET . PHP_EOL;
    }
}