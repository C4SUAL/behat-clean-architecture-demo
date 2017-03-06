<?php

namespace Inventory\Entity\PurchaseOrder;

use MyCLabs\Enum\Enum;

class AddressType extends Enum
{
    /**
     * Delivery address
     */
    const SHIPPING = 'shipping';

    /**
     * Billing address
     */
    const BILLING = 'billing';

    /**
     * Supplier address
     */
    const SUPPLIER = 'supplier';
}