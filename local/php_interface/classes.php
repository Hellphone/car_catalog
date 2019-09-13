<?php

require($_SERVER["DOCUMENT_ROOT"].'/local/modules/kodix.carcatalog/lib/car.php');
require($_SERVER["DOCUMENT_ROOT"].'/local/modules/kodix.carcatalog/lib/set.php');
require($_SERVER["DOCUMENT_ROOT"].'/local/modules/kodix.carcatalog/lib/model.php');
require($_SERVER["DOCUMENT_ROOT"].'/local/modules/kodix.carcatalog/lib/brand.php');
require($_SERVER["DOCUMENT_ROOT"].'/local/modules/kodix.carcatalog/lib/option.php');

use Bitrix\Main\Context;
use Bitrix\Main\Request;
use Kodix\CarCatalog\CarTable;
use Kodix\CarCatalog\SetTable;
use Kodix\CarCatalog\ModelTable;
use Kodix\CarCatalog\BrandTable;
use Kodix\CarCatalog\OptionTable;
