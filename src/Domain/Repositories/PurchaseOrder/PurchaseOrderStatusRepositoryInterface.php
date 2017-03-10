<?php


namespace Inventory\Repositories\PurchaseOrder;


interface PurchaseOrderStatusRepositoryInterface
{
    public function find($id);

    public function findAll();
}