<?php

namespace App\Models;


class Cart
{
    public $itemsName = null;
    public $itemsQuantity= 0;
    public $totalPrice= 0;

    public function __construct($oldCart)
    {
    	if ($oldCart)
    	{
    		$this->itemsName = $oldCart->itemsName;
    		$this->itemsQuantity= $oldCart->itemsQuantity;
    		$this->totalPrice = $oldCart->totalPrice;
    	}
    }

    public function addItem($itemName, $id)
    {
    	$itemToAdd = ['item'=>$itemName->item, 'price'=>$itemName->price, 'quantity'=>0 ];
    	if ($this->itemsName)
    	{
    		if (array_key_exists($id, $this->itemsName))
    		{
    			$itemToAdd = $this->itemsName[$id];
    		}
    	}
    	$itemToAdd['quantity']++;
    	$itemToAdd['price'] = $itemName->price*$this->itemsQuantity['quantity'];
    	$this->itemsName[$id] = $itemToAdd;
    	$this->itemsQuantity++;
    	$this->totalPrice+= $itemName->price;

    }
}
