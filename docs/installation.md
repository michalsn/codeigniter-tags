# Installation

- [Composer Installation](#composer-installation)
- [Manual Installation](#manual-installation)
- [Database migration](#database-migration)

## Composer Installation

The only thing you have to do is to run this command, and you're ready to go.

```console
composer require michalsn/codeigniter-tags
```

## Manual Installation

In the example below we will assume, that files from this project will be located in `app/ThirdParty/tags` directory.

Download this project and then enable it by editing the `app/Config/Autoload.php` file and adding the `Michalsn\CodeIgniterTags` namespace to the `$psr4` array. You also have to add `Common.php` to the `$files` array, like in the below example:

```php
<?php

// ...

public $psr4 = [
    APP_NAMESPACE => APPPATH, // For custom app namespace
    'Config'      => APPPATH . 'Config',
    'Michalsn\CodeIgniterTags' => APPPATH . 'ThirdParty/tags/src',
];

// ...

public $files = [
    APPPATH . 'ThirdParty/tags/src/Common.php',
];
```

## Database migration

Regardless of which installation method you chose, we also need to migrate the database to add new tables.

You can do this with the following command:

```console
php spark migrate --all
```
