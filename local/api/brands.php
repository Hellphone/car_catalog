<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

<?php

use Bitrix\Main\Context;
use Bitrix\Main\Request;
use Kodix\CarCatalog\BrandTable as BrandTable;

$response = [];

$request = Context::getCurrent()->getRequest();
$method = $request->getRequestMethod();

if ($request->getRequestMethod() === 'GET') {
	
	$result = BrandTable::getList();

	while ($brand = $result->fetch()) {
		$response['brands'][] = $brand;
	}

} else {
	http_response_code(405);
	$response['error'] = "405 Method Not Allowed";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
