<?php

declare(strict_types=1);

namespace App\Concerns\Rbac;

use BackedEnum;
use ReflectionClassConstant;

/**
 * Trait for accessing attributes on backed enum cases.
 *
 * @template-requires BackedEnum
 * @mixin BackedEnum
 */
trait HasAttributes
{
    /**
     * Get all attributes of a specific class from the enum constant.
     *
     * @template TAttribute of object
     * @param class-string<TAttribute> $attributeClass The attribute class to retrieve.
     * @return array<int, TAttribute> An array of attribute instances.
     */
    public function getAttributes(string $attributeClass): array
    {
        $reflection = new ReflectionClassConstant($this::class, $this->name);
        return array_map(
            static fn($attribute) => $attribute->newInstance(),
            $reflection->getAttributes($attributeClass),
        );
    }

    /**
     * Get the first attribute of a specific class from the enum constant.
     *
     * @template TAttribute of object
     * @param class-string<TAttribute> $attributeClass The attribute class to retrieve.
     * @return object|null The first attribute instance or null if none found.
     */
    public function getAttribute(string $attributeClass): ?object
    {
        return $this->getAttributes($attributeClass)[0] ?? null;
    }
}
