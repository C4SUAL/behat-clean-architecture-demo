<?php


namespace Inventory\Repositories\PurchaseOrderRepositoryInterface;


interface PurchaseOrderStatusRepositoryInterface
{
    public function find($id);

    public function findAll();
}