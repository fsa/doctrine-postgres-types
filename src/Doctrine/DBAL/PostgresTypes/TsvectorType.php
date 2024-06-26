<?php

/**
 * This file is part of Opensoft Doctrine Postgres Types.
 *
 * Copyright (c) 2013 Opensoft (http://opensoftdev.com)
 */
namespace Doctrine\DBAL\PostgresTypes;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * PHP type is array
 * PostgresType is tsvector.
 *
 * https://gist.github.com/3129096
 *
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
class TsvectorType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'tsvector';
    }

    /**
     * {@inheritdoc}
     */
    public function canRequireSQLConversion(): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return 'TSVECTOR';
    }

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The PHP representation of the value.
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        // Wish there was a database way to make this cleaner... implement in convertToPHPValueSQL
        $terms = array();
        if (!empty($value)) {
            foreach (explode(' ', $value) as $item) {
                list($term, $_) = explode(':', $item);
                $terms[] = trim($term, '\'');
            }
        }

        return $terms;
    }

    /**
     * Modifies the SQL expression (identifier, parameter) to convert to a PHP value.
     *
     * @param string           $value
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToPHPValueSQL(string $value, AbstractPlatform $platform): string
    {
        return $value;
    }

    /**
     * Modifies the SQL expression (identifier, parameter) to convert to a database value.
     *
     * @param string           $sqlExpr
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToDatabaseValueSQL(string $sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('to_tsvector(%s)', $sqlExpr);
    }

    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The database representation of the value.
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        if (is_array($value)) {
            $value = implode(' ', $value);
        }

        return $value;
    }
}
