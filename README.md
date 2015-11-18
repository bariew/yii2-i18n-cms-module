Yii2 i18n module.
===================
Module or managing site translation messages from admin area.

USAGE:
------

- add to your config file into 'components'
```
'i18n'  => [
    'class' => 'bariew\i18nModule\components\I18N',
    'translations' => [
        'modules/*' => [
            'class' => 'yii\i18n\DbMessageSource',
        ],
        'app' => [
            'class' => 'yii\i18n\DbMessageSource',
        ],
    ],
],
```

- add to your config file into 'modules'
```
'i18n' => ['class' => 'bariew\i18nModule\Module'],
```

- Copy migration file from this module 'migrations' folder into your app 'migrations' folder and run in console
```
./yii migrate
```

- copy i18n.php.example to your config folder i18n.php file and run in console
```
./yii message config/i18n.php
```

Now you have all your app translations in your backend under '/i18n/message/index' url.


