<?php

namespace yii\amocrm;

use Yii;
use yii\base\Object;
use yii\base\InvalidConfigException;

/**
 * Client class file.
 *
 * @package yii\amocrm
 * @version 0.1.0
 * @author dotzero <mail@dotzero.ru>
 * @link http://www.dotzero.ru/
 * @link https://github.com/dotzero/yii2-amocrm
 * @link https://developers.amocrm.ru/rest_api/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Расширения для Yii Framework 2 реализующее клиент
 * для работы с API amoCRM используя библиотеку amocrm-php
 *
 * Требования:
 * - Yii Framework 2
 * - Composer
 *
 * Установка:
 * - composer require dotzero/yii2-amocrm
 * - Добавить amocrm в секцию components конфигурационного файла:
 *
 * 'components' =>[
 *     ...
 *     'amocrm' => [
 *         'class' => 'yii\amocrm\Client',
 *         'subdomain' => 'example', // Персональный поддомен на сайте amoCRM
 *         'login' => 'login@mail.com', // Логин на сайте amoCRM
 *         'hash' => '00000000000000000000000000000000', // Хеш на сайте amoCRM
 *
 *         // Для хранения ID полей можно воспользоваться хелпером
 *         'fields' => [
 *             'StatusId' => 10525225,
 *             'ResponsibleUserId' => 697344,
 *         ],
 *     ],
 * ],
 */
class Client extends Object
{
    /**
     * @var null|string Персональный поддомен на сайте amoCRM
     */
    public $subdomain = null;

    /**
     * @var null|string Логин на сайте amoCRM
     */
    public $login = null;

    /**
     * @var null|string API ключ для доступа
     */
    public $hash = null;

    /**
     * @var array Хелпер для хранения ID полей
     */
    public $fields = [];

    /**
     * @var null|\AmoCRM\Client Экземпляр клиента для работы с amoCRM
     */
    private $client = null;

    /**
     * Initializes the application component
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!class_exists('\\AmoCRM\\Client')) {
            throw new InvalidConfigException('AmoCRM not found. Try to install it via composer require dotzero/amocrm');
        }
    }

    /**
     * Инициализация экземпляра клиента для работы с amoCRM
     *
     * @return \AmoCRM\Client
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->client = new \AmoCRM\Client($this->subdomain, $this->login, $this->hash);

            if (count($this->fields) > 0) {
                foreach ($this->fields AS $name => $value) {
                    $this->client->fields[$name] = $value;
                }
            }
        }

        return $this->client;
    }
}
