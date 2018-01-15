<?php

namespace yii\amocrm;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Client class file.
 *
 * @package yii\amocrm
 * @author dotzero <mail@dotzero.ru>
 * @link http://www.dotzero.ru/
 * @link https://github.com/dotzero/yii2-amocrm
 * @link https://developers.amocrm.ru/rest_api/
 * @property \AmoCRM\Models\Account $account
 * @property \AmoCRM\Models\Call $call
 * @property \AmoCRM\Models\Catalog $catalog
 * @property \AmoCRM\Models\CatalogElement $catalog_element
 * @property \AmoCRM\Models\Company $company
 * @property \AmoCRM\Models\Contact $contact
 * @property \AmoCRM\Models\Customer $customer
 * @property \AmoCRM\Models\CustomersPeriods $customers_periods
 * @property \AmoCRM\Models\CustomField $custom_field
 * @property \AmoCRM\Models\Lead $lead
 * @property \AmoCRM\Models\Links $links
 * @property \AmoCRM\Models\Note $note
 * @property \AmoCRM\Models\Pipelines $pipelines
 * @property \AmoCRM\Models\Task $task
 * @property \AmoCRM\Models\Transaction $transaction
 * @property \AmoCRM\Models\Unsorted $unsorted
 * @property \AmoCRM\Models\Webhooks $webhooks
 * @property \AmoCRM\Models\Widgets $widgets
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
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
class Client extends BaseObject
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

    /**
     * Динамеческое получение моделей из \AmoCRM\Client
     *
     * @param string $property
     * @return \AmoCRM\Models\ModelInterface
     */
    public function __get($property)
    {
        return call_user_func_array([$this->getClient(), '__get'], [$property]);
    }
}
