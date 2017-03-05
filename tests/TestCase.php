<?php

namespace yiiunit\extensions\amocrm;

use Yii;
use yii\helpers\ArrayHelper;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $this->mockWebApplication();
    }

    protected function tearDown()
    {
        $this->destroyApplication();
    }

    /**
     * Populates Yii::$app with a new console application
     * The application will be destroyed on tearDown() automatically.
     *
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
        ], $config));
    }

    /**
     * Populates Yii::$app with a new web application
     * The application will be destroyed on tearDown() automatically.
     *
     * @param array $config The application configuration, if needed
     * @param string $appClass name of the application class to create
     */
    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => dirname(__DIR__) . '/vendor',
            'components' => [
                'request' => [
                    'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
                    'scriptFile' => __DIR__ . '/index.php',
                    'scriptUrl' => '/index.php',
                ],
                'amocrm' => [
                    'class' => 'yii\amocrm\Client',
                    'subdomain' => 'example', // Персональный поддомен на сайте amoCRM
                    'login' => 'login@mail.com', // Логин на сайте amoCRM
                    'hash' => '00000000000000000000000000000000', // Хеш на сайте amoCRM

                    // Для хранения ID полей можно воспользоваться хелпером
                    'fields' => [
                        'StatusId' => 10525225,
                        'ResponsibleUserId' => 697344,
                    ],
                ],
            ]
        ], $config));
    }

    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        Yii::$app = null;
    }
}
