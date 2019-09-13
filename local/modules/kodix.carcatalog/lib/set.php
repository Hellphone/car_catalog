<?php
namespace Kodix\CarCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Query\Join;

class SetTable extends Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'kodix_set';
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
            new Entity\IntegerField('MODEL_ID'),
            (new Reference(
                    'MODEL',
                    ModelTable::class,
                    Join::on('this.MODEL_ID', 'ref.ID')
                ))
                ->configureJoinType('inner'),
            (new OneToMany('CARS', CarTable::class, 'SET'))->configureJoinType('inner'),
            (new ManyToMany('OPTION', OptionTable::class))
                ->configureTableName('kodix_option_set')
		);
    }
}