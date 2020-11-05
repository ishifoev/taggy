## Laravel Taggy
[![Build Status](https://travis-ci.org/AlexMalikov94/taggy.svg?branch=master)](
    https://travis-ci.org/github/AlexMalikov94/taggy
)
[![Total Downloads](https://poser.pugx.org/amalikov/taggy/downloads)](//packagist.org/packages/amalikov/taggy)
[![Latest Stable Version](https://poser.pugx.org/amalikov/taggy/v)](//packagist.org/packages/amalikov/taggy)
[![Latest Unstable Version](https://poser.pugx.org/amalikov/taggy/v/unstable)](//packagist.org/packages/amalikov/taggy)
[![License](https://poser.pugx.org/amalikov/taggy/license)](//packagist.org/packages/amalikov/taggy)

An Eloquent tagging package for Laravel

## Installation

Install the package through [Composer](http://getcomposer.org/). 

Run the Composer require command from the Terminal:

    composer require amalikov/taggy

The final steps for you are to add the service provider of the package and alias the package. To do this open your `config/app.php` file.

`Amalikov\Taggy\TaggyServiceProvider::class`

Go to the terminal in folder that you are migrate the `tags` and `taggable` tables:

```php artisan migrate```

## Usage

Add the `TaggableTrait` trait to a model you like to use `tags` on.

```
use Amalikov\Taggy\TaggableTrait;

class YourEloquentModel extends Model
{
    use TaggableTrait;
}
```

Create a tags data for table that you use for example in controller or whatever place you want:

```
use Illuminate\Support\Str;

$tags = Tag::create([
 'name' => 'Tag Name',
 'slug' => Str::slug('Tag Name')
]);

```

You just need to pass the data that working with the models 
```
$model = new YourEloquentModel;
$model->title = 'Test';
$model->save();
```

## If you would like to tag something

```
$model->tag(['your_tag_name'])
````

## If you would like to untag something
```
$model->untag(['your_tag_name'])
````

## If you would like to retag something
```
$model->retag(['your_tag_name'])
````