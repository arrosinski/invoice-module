<?php

namespace App\Infrastructure;

interface PolicyInterface
{
    public static function check($entity, $user = null): bool;
    public static function except($entity, $user = null): void;
}
