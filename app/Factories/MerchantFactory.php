<?php

namespace App\Factories;

use App\BaseMerchant;
use Tatter\Handlers\BaseFactory;

/**
 * Merchant Factory Class
 *
 * Used to discover Actions.
 *
 * @method static class-string<BaseMerchant>   find(string $id)
 * @method static class-string<BaseMerchant>[] findAll()
 */
class MerchantFactory extends BaseFactory
{
    public const HANDLER_PATH = 'Merchants';
    public const HANDLER_TYPE = BaseMerchant::class;
}
