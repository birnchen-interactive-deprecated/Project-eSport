<?php

namespace app\modules\tournaments\models;

use yii\db\ActiveRecord;

/**
 * Class Cup
 * @package app\modules\tournament\models
 *
 * @property int $id
 * @property string $name
 * @property string $season
 * @property string $twitter_channel
 */
class Cup extends ActiveRecord
{
	/**
     * @return string
     */
    public static function tableName()
    {
        return 'cup';
    }

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
	public function getSeason()
	{
		return $this->season;
	}

	/**
	 * @return string name
	 */
	public function getTwitterChannel()
	{
		return $this->twitter_channel;
	}
}