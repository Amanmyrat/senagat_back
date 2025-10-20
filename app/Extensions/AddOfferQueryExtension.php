<?php

namespace App\Extensions;

use Dedoc\Scramble\Extensions\OperationExtension;
use Dedoc\Scramble\Support\Generator\Operation;
use Dedoc\Scramble\Support\Generator\Parameter;
use Dedoc\Scramble\Support\Generator\Schema;
use Dedoc\Scramble\Support\Generator\Types\BooleanType;
use Dedoc\Scramble\Support\RouteInfo;

class AddOfferQueryExtension extends OperationExtension
{
    public function handle(Operation $operation, RouteInfo $routeInfo): void
    {
        if (\count($routeInfo->phpDoc()->getTagsByName('@offersFilter'))) {
            $operation->addParameters([
                Parameter::make('offers_credit', 'query')
                    ->description('Filter locations that offer credit.')
                    ->setSchema(Schema::fromType(new BooleanType)),

                Parameter::make('offers_card', 'query')
                    ->description('Filter locations that offer card.')
                    ->setSchema(Schema::fromType(new BooleanType)),

                Parameter::make('offers_certificate', 'query')
                    ->description('Filter locations that offer certificate.')
                    ->setSchema(Schema::fromType(new BooleanType)),
            ]);
        }
    }
}
