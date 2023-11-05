<?php

declare(strict_types=1);

namespace App\ParserBundle\Domain\Enum;

class SearchFieldNameEnum
{

    public const NAME = 'name';
    public const COMPANY_NAME = 'company_name';
    public const DESCRIPTION = 'description';

    public const FIELD_NAME = [
        self::NAME => 'Поиск в название',
        self::COMPANY_NAME => 'Поиск в название компании',
        self::DESCRIPTION => 'Поиск в описании вакансии',
    ];

    public const LIST = [
        self::NAME,
        self::COMPANY_NAME,
        self::DESCRIPTION,
    ];
}
