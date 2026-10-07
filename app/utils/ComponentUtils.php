<?php

class ComponentUtils
{


    private function __construct()
    {
        throw new \Exception('Not implemented');
    }

    public static function grid(string $class, object $callback): void
    {

        echo "<grid class='{$class}'>";

        $callback();

        echo "</grid>";
    }
}
