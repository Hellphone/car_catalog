<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?php

use Bitrix\Main\Context;
use Bitrix\Main\Request;
use Kodix\CarCatalog\SetTable as SetTable;
use Kodix\CarCatalog\ModelTable as ModelTable;

$response = [];
$filter = [];

$request = Context::getCurrent()->getRequest();
$method = $request->getRequestMethod();

if ($request->getRequestMethod() === 'GET') {

	$request->get('model') ? $filter['=MODEL_ID'] = $request->get('model') : '';

	$modelId = $request->get('model');

	$result = SetTable::getList([
		'select' => [
			'set_name' => 'name',
			'model_name' => MODEL_TABLE_NAME . '.name',
		],
		'runtime' => array(
			MODEL_TABLE_NAME => [
				'data_type' => ModelTable::getEntity(),
				'reference' => [
					'=this.model_id' => 'ref.id',
				],
				'join_type' => 'INNER'
			]
		),
		'filter' => $filter
	]);
	
	while ($set = $result->fetch()) {
		$response['comps'][] = $set;
	}

} else {
	http_response_code(405);
	$response['error'] = "405 Method Not Allowed";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
