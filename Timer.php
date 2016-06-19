<?php

/**
 * Copyright (c) 2010-2016 Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Timer;

/**
 * Timer class
 *
 * @author Romain Cottard
 * @version 2.0.0
 */
class Timer
{
    /**
     * @var float[] $times List of timers with start time
     */
    protected static $times = array();

    /**
     * @var float $time Global timer
     */
    protected static $time = 0.0;

    /**
     * Start time. If name is null, start global timer.
     *
     * @param  string $name
     * @return void
     */
    public static function start($name = null)
    {
        if (null === $name) {
            static::$time = -static::getTime();
        } else {
            static::$times[$name] = -static::getTime();
        }
    }

    /**
     * Get Time time.
     *
     * @param  string $name
     * @return float
     */
    public static function get($name = null)
    {
        if (null === $name) {
            $time = static::$time;
        } elseif (isset(static::$times[$name])) {
            $time = static::$times[$name];
        } else {
            throw new \LogicException('Timer with given name does not exist!');
        }

        return ($time + static::getTime());
    }

    /**
     * Display timer value
     * @param string $name
     * @param int  $round
     * @return void
     */
    public static function display($name = null, $round = 3)
    {
        $time = round(static::get($name), $round);
        $name = ($name === null ? 'GLOBAL' : $name);

        if (PHP_SAPI !== 'cli') {
            echo '
<div style="background-color: #99CCCC">
    <strong>Timer[' . $name . ']: </strong> ' . $time . ' s
</div>';
        } else {
            echo ' ### Timer[' . $name . ']: ' . $time . 's ###' . PHP_EOL;
        }
    }

    /**
     * Get microtime
     *
     * @return float
     */
    public static function getTime()
    {
        return microtime(true);
    }
}