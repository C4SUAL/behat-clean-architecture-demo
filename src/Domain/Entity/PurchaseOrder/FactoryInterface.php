<?php

namespace Inventory\Entity\PurchaseOrder;

use Inventory\Entity\Location;

interface FactoryInterface
{
    public function create();

    public function setShippingLocation(Location $location);

    public function setBillingLocation(Location $location);

    public function addProducts($products);

    public function getPurchaseOrders();
}