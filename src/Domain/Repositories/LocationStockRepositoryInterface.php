<?php

namespace Inventory\Repositories;

use Inventory\Entity\Location;
use Inventory\Entity\Product;

interface LocationStockRepositoryInterface
{
    public function getStock(Product $product, Location $location);
}