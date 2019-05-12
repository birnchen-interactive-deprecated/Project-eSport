<?php

namespace app\modules\platformgames\models;

use yii\db\ActiveRecord;

/**
 * Class Gender
 * @package app\modules\user\models
 *
 * @property int $id
 * @property string $name
 * @property string $description
 */
class Games extends ActiveRecord
{
	/**
	 * @return int id
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string name
	 */
	public function getDescription()
	{
		return $this->description;
	}
}