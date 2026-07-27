<?php

namespace App\Support;

class BrandAssets
{
    public static function sragenLogo(): ?string
    {
        return self::firstExistingImage('logo-sragen');
    }

    public static function kknUndipLogo(): ?string
    {
        return self::firstExistingImage('logo-kkn-undip');
    }

    public static function image(string $filename): ?string
    {
        return self::firstExistingImage($filename);
    }

    private static function firstExistingImage(string $filename): ?string
    {
        foreach (['webp', 'png', 'jpg', 'jpeg'] as $extension) {
            $path = "images/{$filename}.{$extension}";

            if (is_file(public_path($path))) {
                return $path;
            }
        }

        return null;
    }
}
