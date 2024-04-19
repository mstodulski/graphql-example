<?php

namespace App\Struct;

use App\Struct\Types\ComplexObjectType;
use App\Struct\Types\ComplexObjectLevel2Type;
use App\Struct\Types\ComplexObjectLevel3Type;
use Closure;
use Exception;
use GraphQL\Type\Definition\Type;

final class Types
{
    /** @var array<string, Type> */
    private static array $types = [];

    public static function complexObject(): Type
    {
        return self::byClassName(ComplexObjectType::class);
    }

    public static function complexObjectLevel2(): Type
    {
        return self::byClassName(ComplexObjectLevel2Type::class);
    }

    public static function complexObjectLevel3(): Type
    {
        return self::byClassName(ComplexObjectLevel3Type::class);
    }

    /** @throws Exception */
    public static function byTypeName(string $shortName): Type
    {
        $cacheName = strtolower($shortName);
        $type = null;
        $method = lcfirst($shortName);

        if (!isset(self::$types[$cacheName])) {

            if (method_exists(self::class, $method)) {
                /** @var Closure $type */
                $type = self::{$method}();
            }

            if (!$type) {
                throw new Exception('Unknown graphql type: ' . $shortName);
            }

            /** @var Type $newType */
            $newType = $type();
            self::$types[$cacheName] = $newType;
        }

        return self::$types[$cacheName];
    }

    /** @param class-string<Type> $classname */
    private static function byClassName(string $classname): Type
    {
        $parts = explode('\\', $classname);

        $withoutTypePrefix = preg_replace('~Type$~', '', $parts[count($parts) - 1]);
        assert(is_string($withoutTypePrefix), 'regex is statically known to be correct');

        $cacheName = strtolower($withoutTypePrefix);

        if (!isset(self::$types[$cacheName])) {

            $object = new $classname();
            self::$types[$cacheName] = $object;
        }

        return self::$types[$cacheName];
    }

}