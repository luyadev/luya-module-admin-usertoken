<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya/master/docs/logo/luya-logo-0.2x.png" alt="LUYA Logo"/>
</p>

# LUYA *VENDOR/NAME* module/extension

[![LUYA](https://img.shields.io/badge/Powered%20by-LUYA-brightgreen.svg)](https://luya.io)
[![Maintainability](https://api.codeclimate.com/v1/badges/48bcbaece4a451825e24/maintainability)](https://codeclimate.com/github/luyadev/luya-module-admin-usertoken/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/48bcbaece4a451825e24/test_coverage)](https://codeclimate.com/github/luyadev/luya-module-admin-usertoken/test_coverage)

*Package description*

## Installation

Install the extension through composer:

```sh
composer require luyadev/luya-module-admin-usertoken
```

add to the config

```php
'modules' => [
    'usertoken' => [
      'class' => 'luya\admin\usertoken\Module',
    ]
]
```

bootstrap the app:

```php
'bootstrap' => [
    'luya\admin\usertoken\Bootstrap',
]
```

Run the import command afterwards:

```sh
./luya migrate
```

```sh
./luya import
```

## Usage

*Usage description*
