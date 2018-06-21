<?php

namespace SehrGut\LaravelObjectRoles;

trait ResolvesByName
{
    /**
     * Resolve a Role or Permission name into the corresponding Object.
     *
     * @param  static|string $instanceOrName
     * @return static
     * @throws InvalidArgumentException when the argument is neither an instance nor a
     *                                  name that can be resolved into an instance
     */
    public static function resolve($instanceOrName): self
    {
        if ($instanceOrName instanceof static) {
            return $instanceOrName;
        }

        if (is_string($instanceOrName)
            and $object = static::where('name', $instanceOrName)->first()
        ) {
            return $object;
        }

        $className = __CLASS__;
        throw new \InvalidArgumentException(
            "Argument must be either a $className object or the ".
            "name of a $className that exists in Database."
        );
    }
}
