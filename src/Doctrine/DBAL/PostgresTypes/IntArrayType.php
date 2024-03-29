<?php

/**
 * This file is part of Opensoft Doctrine Postgres Types.
 *
 * Copyright (c) 2013 Opensoft (http://opensoftdev.com)
 */
namespace Doctrine\DBAL\PostgresTypes;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Only supports single dimensional arrays like text[].
 *
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 * @author Eugene Leonovich <gen.work@gmail.com>
 */
class IntArrayType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        $value = trim($value, '{}');

        if ($value === '') {
            return array();
        }

        return array_map('intval', explode(',', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
    {
        return '{'.implode(',', $value).'}';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'int_array';
    }

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return '_int4';
    }
}
