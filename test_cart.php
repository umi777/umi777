<?php
// https://estrin.pw/bitrix-d7-snippets/s/sale-basket/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$basket = Bitrix\Sale\Basket::loadItemsForFUser(Bitrix\Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
$products = array(
    array('PRODUCT_ID' => 3376, 'PRICE' => 400, 'BASE_PRICE' => 400, 'CURRENCY' => 'RUB', 'QUANTITY' => 1),
    array(
      'PRODUCT_ID' => 3394, 
        'QUANTITY' => 2,
        'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
        'LID' => Bitrix\Main\Context::getCurrent()->getSite(),
        'PRODUCT_PROVIDER_CLASS' => 'CCatalogProductProvider')
            );
$product = \Bitrix\Catalog\ProductTable::getList(['filter'=>['ID'=>3394]]);
//print_r($product->fetch());
$property =     array(
    'NAME' => 'Соус',
    'CODE' => 'SAUSE',
    'VALUE' => 'Обычный',
    'SORT' => 100,
);
//$basket = Bitrix\Sale\Basket::create(SITE_ID);
echo '<pre>';
foreach ($products as $product)
    {
        $item = $basket->createItem("catalog", $product["PRODUCT_ID"]);
        print_r($item);
        $basket->save();
        $basket->refresh();
        unset($product["PRODUCT_ID"]);
        $item->save();
        $item->setFields($product);
        print_r($item);
        $basketPropertyCollection = $item->getPropertyCollection(); 
        $basketPropertyCollection->setProperty([$property]);
        $basketPropertyCollection->save();
        $item->save();
        //print_r($item->getPropertyCollection()->getPropertyValues());
        
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
