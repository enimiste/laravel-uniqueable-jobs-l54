## Laravel 5.4 Uniqueable Jobs

### Install

Require this package with composer using the following command:

```bash
composer require "enimiste/laravel-uniqueable-jobs-l54:5.4.*"
```

After updating composer, add the service provider to the `providers` array in `config/app.php`

```php
Com\NickelIT\UniqueableJobs\UniqueableJobsServiceProvider::class,
```

Publish migration : 
```bash
php artisan vendor:publish  --tag=migrations
```

In your Jobs classes use `Com\NickelIT\UniqueableJobs\Dispatchable` and `Com\NickelIT\UniqueableJobs\Uniqueable` instead of the default ones.

To ensure that a given job will be stored in the database once per model and model id you use `->unique(Model::class, $model->id)` on the job instance or after calling `dispatch()` method like :
```php
$u = User::first();
DoSomethingJob::dispatch('Hello from unique job ' . $u->email)
                        ->unique(User::class, $u->id);
DoSomethingJob::dispatch('Hello from unique job ' . $u->email)
                        ->unique(User::class, $u->id);
//In this case the job will be stored once if it was already in the db
```

### License

The Laravel IDE Helper Generator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

[link-packagist]: https://packagist.org/packages/enimiste/laravel-uniqueable-jobs-l54
[link-author]: https://github.com/enimiste
[link-contributors]: ../../contributors
