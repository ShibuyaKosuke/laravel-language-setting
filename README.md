# laravel-language-setting

## Install

```
composer require shibuyakosuke/laravel-language-setting --dev
```

## Setting

Edit `config/app.php` in your project below.

```
'locale' => 'ja',
```

## Execute command.

```
php artisan lang:setting ja // If you use japanese.
```

Publish these files like belows.

- `Resources/lang/ja.json`
- `Resources/lang/ja/auth.php`
- `Resources/lang/ja/pagination.php`
- `Resources/lang/ja/passwords.php`
- `Resources/lang/ja/validation.php`

