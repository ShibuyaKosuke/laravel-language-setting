# laravel-language-setting

## Install

```
composer require shibuyakosuke/laravel-language-setting --dev
```

## Commands

Edit `config/app.php` in your project below.

```
'locale' => 'ja',
```

## Execute command.

### Publish language files

```
php artisan lang:setting ja // If you use japanese.
```

Publish these files like belows.

- `Resources/lang/ja.json`
- `Resources/lang/ja/auth.php`
- `Resources/lang/ja/pagination.php`
- `Resources/lang/ja/passwords.php`
- `Resources/lang/ja/validation.php`

### Show languages list

```
php artisan lang:list
```

## Languages

| language | locale |
|:--------:|:--------:|
| Japanese | ja |

## Contribution

If you have other language files, clone this repository and add your language files.
Send me pull request, please.

