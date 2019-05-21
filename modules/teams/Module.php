<?php

namespace app\modules\teams;

use Yii;

/**
 * Class Module
 * @package app\modules\teams
 */
class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        $this->registerTranslations();
    }

    /**
     * Registers the module translations
     */
    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/teams/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'de',
            'basePath' => '@app/modules/teams/messages',
            'fileMap' => [
                'modules/teams/teams' => 'teams.php'
                //'modules/user/user' => 'user.php',
                //'modules/user/login' => 'login.php',
                //'modules/user/register' => 'register.php',
                //'modules/user/account' => 'account.php',
            ],
        ];

        Yii::$app->i18n->translations['modules/teams/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en',
            'basePath' => '@app/modules/teams/messages',
            'fileMap' => [
                'modules/teams/teams' => 'teams.php'
                //'modules/user/user' => 'user.php',
                //'modules/user/login' => 'login.php',
                //'modules/user/register' => 'register.php',
                //'modules/user/account' => 'account.php',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function t($category, $message, $language = null, $params = [])
    {
        return Yii::t('modules/teams/' . $category, $message, $params, $language);
    }
}