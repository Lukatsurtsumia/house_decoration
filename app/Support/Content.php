<?php

namespace App\Support;

/**
 * The site's content in one language. config/homepage.php is the Georgian site and holds every
 * setting; lang/{locale}/homepage.php holds the other languages' texts with the same keys and is
 * laid over it, so prices, photos and links are shared.
 */
class Content
{
    /**
     * @return array<string, array<string, string>>
     */
    public static function locales(): array
    {
        return config('homepage.locales');
    }

    public static function defaultLocale(): string
    {
        return array_key_first(self::locales());
    }

    /**
     * @return array<int, string>
     */
    public static function otherLocales(): array
    {
        return array_values(array_diff(array_keys(self::locales()), [self::defaultLocale()]));
    }

    /**
     * @return array<string, mixed>
     */
    public static function get(?string $locale = null): array
    {
        $locale ??= app()->getLocale();
        $content = config('homepage');

        if ($locale !== self::defaultLocale() && is_file($path = lang_path("{$locale}/homepage.php"))) {
            $content = array_replace_recursive($content, require $path);
        }

        return $content;
    }

    /**
     * The home page in a language: the default at "/", the others at "/{locale}".
     */
    public static function url(?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $root = rtrim(config('app.url'), '/');

        return $locale === self::defaultLocale() ? $root.'/' : "{$root}/{$locale}";
    }
}
