# Configuration

- [Model](#model)
- [Entity](#entity)
- [Config](#config)

## Model

All we need to do is add `HasTags` trait to our model and initialize tags with `initTags()` method.

!!! note

    You don't need to modify `$allowedFields` array (if you use it) or your existing database schema.

```php
// app/Models/ImageModel.php
<?php

// ...

use CodeIgniter\Model;
use Michalsn\CodeIgniterTags\Traits\HasTags;

class ImageModel extends Model
{
    use HasTags;

    // ...

    // Values below are only an example for ImageModel table fields
    protected $allowedFields = ['name', 'width', 'height'];

    // ...

    protected function initialize()
    {
        $this->initTags();
    }

    // ...

}
```

## Entity

If your model return type is an `Entity`, then you can also add `TaggableEntity` trait to it.
It will help you with making changes related to the tags when working directly with the entity.

```php
// app/Entities/Image.php
<?php

// ...

use CodeIgniter\Entity\Entity;
use Michalsn\CodeIgniterTags\Traits\TaggableEntity;

class Image extends Entity
{
    use TaggableEntity;

    // ...
}
```

## Config

We can publish configuration file into our app namespace via command:

    php spark tags:publish

!!! note

    This is not mandatory. You should publish a config file only if you want to change the default values.

The configuration file gives us control over some of the library's features.

### $cleanupUnusedTags

This gives us control over how unused tags are treated. If we set `true`, we will remove all unused tags. The action to remove unused tags is triggered whenever we update an entry that uses tags. By default, this is set to `true`.
