## Laravel 5.4 Uniqueable Jobs

### Install

Require this package with composer using the following command:

```bash
composer require enimiste/laravel-uniqueable-jobs
```

After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
Com\NickelIT\UniqueableJobsServiceProvider::class,
```

Publish migration : 
```bash
php artisan vendor:publish --provider=Com\NickelIT\UniqueableJobsServiceProvider
```
### License

The Laravel IDE Helper Generator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

[link-packagist]: https://packagist.org/packages/enimiste/laravel-uniqueable-jobs
[link-author]: https://github.com/enimiste
[link-contributors]: ../../contributors
