<?php
namespace Kodix\CarCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

class OptionTable extends Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'kodix_option';
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
            (new ManyToMany('SETS', SetTable::class))
                ->configureTableName('kodix_option_set'),
            (new ManyToMany('CARS', CarTable::class))
                ->configureTableName('kodix_option_car')
                /*->configureLocalPrimary('ID', 'OPTION_ID')
                ->configureLocalReference('OPTION')
                ->configureRemotePrimary('ID', 'CAR_ID')
                ->configureRemoteReference('CAR')*/
		);
    }
}