<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?php

use Bitrix\Main\Context;
use Bitrix\Main\Request;
use Kodix\CarCatalog\CarTable as CarTable;
use Kodix\CarCatalog\SetTable as SetTable;
use Kodix\CarCatalog\ModelTable as ModelTable;
use Kodix\CarCatalog\BrandTable as BrandTable;
use Kodix\CarCatalog\OptionTable as OptionTable;

$response = [];
$filter = [];

$request = Context::getCurrent()->getRequest();
$method = $request->getRequestMethod();

if ($request->getRequestMethod() === 'GET') {

	$curPage = $APPLICATION->GetCurPage();
	$arUrl = explode('/', $curPage);
	$carId = end($arUrl);

// if $_GET contains car ID
	if (is_numeric($carId)) {
		$filter = ['=ID' => $carId];
	} else {
		$request->get('brand') ? $filter['=' . BRAND_TABLE_NAME . '.id'] = $request->get('brand') : '';
		$request->get('model') ? $filter['=' . MODEL_TABLE_NAME . '.id'] = $request->get('model') : '';
		$request->get('set') ? $filter['=SET_ID'] = $request->get('set') : '';
		$request->get('year') ? $filter['=YEAR'] = $request->get('year') : '';
	}

	$result = CarTable::getList(array(
		'select' => [
			'brand_name' => BRAND_TABLE_NAME . '.name',
			'model_name' => MODEL_TABLE_NAME . '.name',
			'car_year' => 'year',
			'set_name' => SET_TABLE_NAME . '.name',
			'car_name' => 'name',
			'car_price' => 'price'
		],
		'runtime' => array(
			SET_TABLE_NAME => [
				'data_type' => SetTable::getEntity(),
				'reference' => [
					'=this.set_id' => 'ref.id'
				],
				'join_type' => 'INNER'
			],
			MODEL_TABLE_NAME => [
				'data_type' => ModelTable::getEntity(),
				'reference' => [
					'=this.' . SET_TABLE_NAME . '.model_id' => 'ref.id',
				],
				'join_type' => 'INNER'
			],
			BRAND_TABLE_NAME => [
				'data_type' => BrandTable::getEntity(),
				'reference' => [
					'=this.' . MODEL_TABLE_NAME . '.brand_id' => 'ref.id',
				],
				'join_type' => 'INNER'
			],
		),
		'filter' => $filter
	));
	
	while ($car = $result->fetch()) {
		$response['cars'][] = $car;
	}

} else {
	http_response_code(405);
	$response['error'] = "405 Method Not Allowed";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
