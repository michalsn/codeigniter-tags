# Configuration

- [Model](#model)
- [Entity](#entity)

## Model

All we need to do is add `HasTags` trait to our model.

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
