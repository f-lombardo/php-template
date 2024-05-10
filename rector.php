<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Php74\Rector\Property\RestoreDefaultNullToNullableTypePropertyRector;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Php80\Rector\FuncCall\ClassOnObjectRector;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromAssignsRector;

return function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/tests',
        __DIR__.'/src',
        __DIR__.'/migrations',
    ]);
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_82,
    ]);

    $rectorConfig->skip([
        ClassPropertyAssignToConstructorPromotionRector::class,
        ReadOnlyClassRector::class,
        TypedPropertyFromAssignsRector::class,
        ClassOnObjectRector::class,
        RestoreDefaultNullToNullableTypePropertyRector::class,
    ]);
};
