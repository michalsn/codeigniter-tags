# CodeIgniter Tags

A library that helps you build **tags** functionality around your existing models in the CodeIgniter 4 framework.

[![PHPUnit](https://github.com/michalsn/codeigniter-tags/actions/workflows/phpunit.yml/badge.svg)](https://github.com/michalsn/codeigniter-tags/actions/workflows/phpunit.yml)
[![PHPStan](https://github.com/michalsn/codeigniter-tags/actions/workflows/phpstan.yml/badge.svg)](https://github.com/michalsn/codeigniter-tags/actions/workflows/phpstan.yml)
[![Deptrac](https://github.com/michalsn/codeigniter-tags/actions/workflows/deptrac.yml/badge.svg)](https://github.com/michalsn/codeigniter-tags/actions/workflows/deptrac.yml)
[![Coverage Status](https://coveralls.io/repos/github/michalsn/codeigniter-tags/badge.svg?branch=develop)](https://coveralls.io/github/michalsn/codeigniter-tags?branch=develop)

![PHP](https://img.shields.io/badge/PHP-%5E8.1-blue)
![CodeIgniter](https://img.shields.io/badge/CodeIgniter-%5E4.3-blue)

## Installation

    composer require michalsn/codeigniter-tags

Migrate your database:

    php spark migrate --all

## Configuration

Add `HasTags` trait to your model.

```php
class ExampleModel extends BaseModel
{
    use HasTags;

    // ...
}
```

And if you use [entities](https://www.codeigniter.com/user_guide/models/entities.html), add `TaggableEntity` to it:

```php
class Example extends Entity
{
    use TaggableEntity;

    // ...
}
```

## Docs

https://michalsn.github.io/codeigniter-tags/
