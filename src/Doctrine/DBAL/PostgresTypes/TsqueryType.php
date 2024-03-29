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
 * Opensoft\Onp\WebBundle\Doctrine\DBAL\Types\TsqueryType.
 *
 * @author Ivan Molchanov <ivan.molchanov@opensoftdev.ru>
 */
class TsqueryType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'tsquery';
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
        return 'TSQUERY';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValueSQL(string $sqlExpr, AbstractPlatform $platform): string
    {
        return sprintf('plainto_tsquery(%s)', $sqlExpr);
    }
}
