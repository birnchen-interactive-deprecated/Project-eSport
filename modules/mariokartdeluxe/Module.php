<?php

namespace app\modules\mariokartdeluxe;

use Yii;

/**
 * Class Module
 * @package app\modules\mariokartdeluxe
 */
 class Module extends \yii\base\Module
 {
 	public function init()
 	{
 		parent::init();

 		$this->registerTranslations();
 	}

 	/**
 	 * Register the module translation
 	 */
 	public function registerTranslations()
 	{
 		Yii::$app->i18n->translations['modules/mariokartdeluxe/*'] = [
 			'class' => 'yii\i18n\PhpMessageSource',
 			'sourceLanguage' => 'de',
 			'basePath' => '@app/modules/mariokartdeluxe/messages',
 			'fileMap' => [
 				'modules/mariokartdeluxe/overview' => 'overview.php',
 				'modules/mariokartdeluxe/details' => 'details.php',
 				//'modules/mariokartdeluxe/register' => 'register.php',
 				//'modules/mariokartdeluxe/account' => 'account.php',
 				//'modules/mariokartdeluxe/userDetails' => 'userDetails.php',
 			],
 		];

 		Yii::$app->i18n->translations['modules/mariokartdeluxe/*'] = [
 			'class' => 'yii\i18n\PhpMessageSource',
 			'sourceLanguage' => 'en',
 			'basePath' => '@app/modules/mariokartdeluxe/messages',
 			'fileMap' => [
 				'modules/mariokartdeluxe/overview' => 'overview.php',
 				'modules/mariokartdeluxe/details' => 'details.php',
 				//'modules/mariokartdeluxe/register' => 'register.php',
 				//'modules/mariokartdeluxe/account' => 'account.php',
 				//'modules/mariokartdeluxe/userDetails' => 'userDetails.php',
 			],
 		];
 	}

 	/**
     * @inheritdoc
     */
 	public static function t($category, $message, $language = null, $params = [])
 	{
 		return Yii::t('modules/mariokartdeluxe/' . $category, $message, $params, $language);
 	}
 }