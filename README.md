Yii2 i18n module.
===================
Module or managing site translation messages from admin area.

USAGE:
------

- add to your config file into 'components'
```
'i18n'  => [
    'translations' => [
        '*' => [
            'class' => 'yii\i18n\DbMessageSource',
        ],
    ],
],
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


