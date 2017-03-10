<?php

namespace Inventory\Services;

use Inventory\Entity\Location;

interface PurchaseOrderServiceInterface
{
    public function createPurchaseOrders();

    public function setShippingLocation(Location $location);

    public function setBillingLocation(Location $location);

    public function addProducts($products);

    public function getPurchaseOrders();
}