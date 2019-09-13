<?php
namespace Kodix\CarCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Query\Join;

class CarTable extends Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'kodix_car';
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
            new Entity\IntegerField('YEAR', array(
            	'required' => true
            )),
            new Entity\IntegerField('PRICE', array(
                'required' => true
            )),
            new Entity\IntegerField('SET_ID'),
            (new Reference(
                    'SET',
                    SetTable::class,
                    Join::on('this.SET_ID', 'ref.ID')
                ))
                ->configureJoinType('inner'),
            (new ManyToMany('OPTIONS', OptionTable::class))
                ->configureTableName('kodix_option_car')
                /*->configureLocalPrimary('ID', 'CAR_ID')
                ->configureLocalReference('CAR')
                ->configureRemotePrimary('ID', 'OPTION_ID')
                ->configureRemoteReference('OPTION')*/
		);
    }
}