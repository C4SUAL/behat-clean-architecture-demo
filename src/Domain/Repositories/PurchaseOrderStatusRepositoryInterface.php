<?php


namespace Inventory\Repositories;


interface PurchaseOrderStatusRepositoryInterface
{
    public function find($id);

    public function findAll();
}