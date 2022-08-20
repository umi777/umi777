<?php
// https://estrin.pw/bitrix-d7-snippets/s/sale-basket/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
$property =     array(
    'NAME' => 'Соус',
    'CODE' => 'SAUSE',
    'VALUE' => 'Обычный',
    'SORT' => 100,
);
$products = array(
    array('PRODUCT_ID' => 3376, 'QUANTITY' => 1, 'PROPS'=>[$property]
    ),
    array('PRODUCT_ID' => 3394, 'QUANTITY' => 1, 'PROPS'=>[$property]
    ),
            );
// $product = \Bitrix\Catalog\ProductTable::getList(['filter'=>['ID'=>3394]]);
//print_r($product->fetch());
//$basket = Bitrix\Sale\Basket::create(SITE_ID);
echo '<pre>';
foreach ($products as $product)
    {
        $basketResult = \Bitrix\Catalog\Product\Basket::addProduct($product/*, $rewriteFields, $options */);
if ($basketResult->isSuccess())
{
    $ressult['success'] = true;

    $data = $basketResult->getData();

    /* 

    Array ( 

        [ID] => 3 // basket id

    )

    */

    $basket = \Bitrix\Sale\Basket::loadItemsForFUser(

        \Bitrix\Sale\Fuser::getId(), 

        \Bitrix\Main\Context::getCurrent()->getSite()

    );

    $refreshStrategy = \Bitrix\Sale\Basket\RefreshFactory::create(\Bitrix\Sale\Basket\RefreshFactory::TYPE_FULL);

    $basket->refresh($refreshStrategy);    

    $basket->save();

}

else

{

    $ressult['success'] = false;

    $ressult['error'] = $basketResult->getErrorMessages();

}

        
    }

$basket->save();
$basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
$items = $basket->getBasketItems();
foreach ($items as $item){
print_r($item->getPropertyCollection()->getPropertyValues());
}
?>
</pre>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>