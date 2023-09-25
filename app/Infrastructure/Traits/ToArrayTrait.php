<?php

namespace App\Infrastructure\Traits;

use ReflectionClass;
use Attribute;
#[Attribute(Attribute::TARGET_CLASS)]
class ToArray {}

trait ToArrayTrait
{
    public function toArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $properties[$propertyName] = $property->getValue($this);
        }

        return $properties;
    }
}
