# Basic usage

- [Working with model](#working-with-model)
    - [Adding tags](#adding-tags)
    - [Modifying tags](#modifying-tags)
    - [Removing tags](#removing-tags)
    - [Results with tags](#results-with-tags)
    - [Results with certain tags only](#results-with-certain-tags-only)
    - [Results with any tags](#results-with-any-tags)
    - [Displaying tags](#displaying-tags)
- [Working with Entity](#working-with-entity)
- [Helper functions](#helper-functions)

## Working with model

This is how basic usage look like. It's designed to easily integrate with usual form request workflow.

!!! warning

    Be sure to **validate** your tags before saving them. You should validate things like: maximum lenght, allowed characters etc.
    The maximum length of a single tag is **32 characters**.

!!! note

    Very nice library that can help you managing tags on a frontend is [tagify](https://github.com/yairEO/tagify).
    Remember that validating tags on the frontend is not enought - you need **backend validation** too.

!!! note

    Your model/table should not use the `tags` field name, as it is used exclusively by this library. Please treat the `tags` field name as **reserved**.

### Adding tags

Adding tags with normal request flow is very easy.

```php
model(ImageModel::class)->insert([
    'name'   => 'sampleFile.jpeg',
    'width'  => 100,
    'height' => 100,
    // this is our field with tags
    // we can also set it as an array: ['tag1', 'tag2', 'tag3']
    'tags'   => 'tag1,tag2,tag3',
]);
```

### Modifying tags

Modifying tags with normal request flow is very easy.

```php
model(ImageModel::class)->save([
    'id'   => 1,
    // this is our field with tags
    // we can also set it as an array: ['tag1', 'tag2']
    'tags' => 'tag1,tag2',
]);
```

### Removing tags

Removing tags with normal request flow is very easy.

```php
model(ImageModel::class)->save([
    'id'   => 1,
    // this is our field with tags
    // we can also set it as an array: []
    'tags' => '',
]);
```

### Results with tags

You can retrieve the results, which will include tags, using the `withTags()` method, it works with all other methods from the CodeIgniter Model.

```php
model(ImageModel::class)->withTags()->find(1);
// or
model(ImageModel::class)->withTags()->findAll();
```

### Results with all tags

This will return a result with images that have both tags assigned.

```php
model(ImageModel::class)->withAllTags(['tag1', 'tag2'])->findAll();
```

### Results with any tags

This will return a result with images that have any of these tags assigned.

```php
model(ImageModel::class)->withAnyTags(['tag1', 'tag2'])->findAll();
```

### Displaying tags

When we get the tags in a result, they are available as a [Collection](https://github.com/lonnieezell/myth-collection) class.
For this reason, tag iteration is specific:

```php
$image = model(ImageModel::class)->withTags()->find(1);
// tags are available as a Collection
foreach ($image->tags->items() as $tag) {
    d($tag->name, $tag->slug);
}
```

## Working with Entity

Using `TaggableEntity` trait in our entity gives us some nice features if we want to work directly on a `tags` field.

```php
$model = model(ImageModel::class);
$image = $model->find(1);
// set tags
$image->tags = ['tag1', 'tag2']
// add a new tag
$image->addTags(['tag3']);
// remove tag
$image->removeTags(['tag2']);
// save changes with tags: tag1 and tag3
$model->save($image);
```

## TagModel

Some useful methods that you can find in the `TagModel` class.

### Tags searching (for autocomplete)

If you're building an autocomplete functionality when user is typing, then you can use `search` method.

Let's say we have two tables: `foods` and `countries`. And our tags are: `Carrot`, `Potato`, `Portugal` and `Italy`.

The code below will return tags: `Potato` and `Portugal`.

```php
model(TagModel::class)->search('po');
```

But this code will return only tag: `Portugal`.

```php
model(TagModel::class)->search('po', 'countries');
```

We can also change the number of results we're returning and the page number:

```php
$perPage = 5;
$page    = 0;
model(TagModel::class)->search('po', null, $perPage, $page);
```

## Helper functions

All helper functions are available without requiring additional helper.

### convert_to_tags()

This function is useful, especially if you do not use entity classes, and when you want to manipulate tags manually, before writing to the database.

Here is an example that shows how to add a new tag to the existing ones:

```php
$model = model(ImageModel::class);
$image = $model->withTags()->find(1);
// instead of writing code like this:
$image->tags->push(new Tag(['name' => 'second tag']));
// we can simplify it to this:
$image->tags->push(convert_to_tags('second tag'));
```


