<?php
namespace Kodix\CarCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class ModelTable extends Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'kodix_model';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('NAME', array(
                'required' => true
            )),
            new Entity\IntegerField('BRAND_ID'),
            (new Reference(
                    'BRAND',
                    BrandTable::class,
                    Join::on('this.BRAND_ID', 'ref.ID')
                ))
                ->configureJoinType('inner')
		);
    }
}