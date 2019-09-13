<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?php

use Bitrix\Main\Context;
use Bitrix\Main\Request;
use Kodix\CarCatalog\ModelTable as ModelTable;
use Kodix\CarCatalog\BrandTable as BrandTable;

$response = [];
$filter = [];

$request = Context::getCurrent()->getRequest();
$method = $request->getRequestMethod();

if ($request->getRequestMethod() === 'GET') {

	$request->get('brand') ? $filter['=BRAND_ID'] = $request->get('brand') : '';

	$result = ModelTable::getList([
		'select' => [
			'model_name' => 'name',
			'brand_name' => BRAND_TABLE_NAME . '.name',
		],
		'runtime' => array(
			BRAND_TABLE_NAME => [
				'data_type' => BrandTable::getEntity(),
				'reference' => [
					'=this.brand_id' => 'ref.id',
				],
				'join_type' => 'INNER'
			]
		),
		'filter' => $filter
	]);
	
	while ($model = $result->fetch()) {
		$response['models'][] = $model;
	}

} else {
	http_response_code(405);
	$response['error'] = "405 Method Not Allowed";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
