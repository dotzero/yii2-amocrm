<?php

namespace yiiunit\extensions\amocrm;

use Yii;

class ClientTest extends TestCase
{
    /**
     * @dataProvider modelsProvider
     */
    public function testGetModel($name, $expected)
    {
        $amo = Yii::$app->amocrm->getClient();

        $model = $amo->{$name};
        $this->assertInstanceOf($expected, $model);
        $this->assertInstanceOf('\AmoCRM\Models\ModelInterface', $model);
        $this->assertSame($expected, (string)$model);
    }

    /**
     * @dataProvider modelsProvider
     */
    public function testMagicGetModel($name, $expected)
    {
        $model = Yii::$app->amocrm->{$name};
        $this->assertInstanceOf($expected, $model);
        $this->assertInstanceOf('\AmoCRM\Models\ModelInterface', $model);
        $this->assertSame($expected, (string)$model);
    }

    public function modelsProvider()
    {
        return [
            // model name, expected
            ['account', 'AmoCRM\Models\Account'],
            ['call', 'AmoCRM\Models\Call'],
            ['catalog', 'AmoCRM\Models\Catalog'],
            ['catalog_element', 'AmoCRM\Models\CatalogElement'],
            ['company', 'AmoCRM\Models\Company'],
            ['contact', 'AmoCRM\Models\Contact'],
            ['customer', 'AmoCRM\Models\Customer'],
            ['customers_periods', 'AmoCRM\Models\CustomersPeriods'],
            ['custom_field', 'AmoCRM\Models\CustomField'],
            ['lead', 'AmoCRM\Models\Lead'],
            ['links', 'AmoCRM\Models\Links'],
            ['note', 'AmoCRM\Models\Note'],
            ['pipelines', 'AmoCRM\Models\Pipelines'],
            ['task', 'AmoCRM\Models\Task'],
            ['transaction', 'AmoCRM\Models\Transaction'],
            ['unsorted', 'AmoCRM\Models\Unsorted'],
            ['webhooks', 'AmoCRM\Models\WebHooks'],
            ['widgets', 'AmoCRM\Models\Widgets'],
        ];
    }
}