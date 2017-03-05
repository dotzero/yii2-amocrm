# AmoCRM Extension for Yii 2

[![Latest Stable Version](https://poser.pugx.org/dotzero/yii2-amocrm/version)](https://packagist.org/packages/dotzero/yii2-amocrm)
[![License](https://poser.pugx.org/dotzero/yii2-amocrm/license)](https://packagist.org/packages/dotzero/yii2-amocrm)

Расширение для Yii Framework 2 реализующее клиент для работы с API amoCRM
используя библиотеку для работы с API [amocrm-php](https://github.com/dotzero/amocrm-php).

## Требования:

- [Yii Framework 2](https://github.com/yiisoft/yii2)
- [Composer](http://getcomposer.org/doc/)

## Установка

### Через composer:

```bash
$ composer require dotzero/yii2-amocrm
```

-  Добавить `amocrm` в секцию `components` конфигурационного файла:

```php
'components' => [
    ...
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
],
```

## Пример использования:

```php
try {
    // Получение экземпляра модели для работы с аккаунтом
    $amo = Yii::$app->amocrm->getClient();
    $account = $amo->account;

    // или прямо
    $account = Yii::$app->amocrm->account;

    // Вывод информации об аккаунте
    print_r($account->apiCurrent());

    // Получение экземпляра модели для работы с контактами
    $contact = $amo->contact;

    // Заполнение полей модели
    $contact['name'] = 'ФИО';
    $contact['request_id'] = '123456789';
    $contact['date_create'] = '-2 DAYS';
    $contact['responsible_user_id'] = $amo->fields['ResponsibleUserId'];
    $contact['company_name'] = 'ООО Тестовая компания';
    $contact['tags'] = ['тест1', 'тест2'];
    $contact->addCustomField(448, [
        ['+79261112233', 'WORK'],
    ]);

    // Добавление нового контакта и получение его ID
    print_r($contact->apiAdd());

} catch (\AmoCRM\Exception $e) {
    printf('Error (%d): %s' . PHP_EOL, $e->getCode(), $e->getMessage());
}
```

## Документация

Смотреть документацию к библиотеке [amocrm-php](https://github.com/dotzero/amocrm-php).

## Лицензия

Библиотека доступна на условиях лицензии MIT: http://www.opensource.org/licenses/mit-license.php
