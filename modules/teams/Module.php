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
            'sourceLanguage' => 'en',
            'basePath' => '@app/modules/teams/messages',
            'fileMap' => [
                'modules/teams/teams' => 'teams.php',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/teams/' . $category, $message, $params, $language);
    }
}