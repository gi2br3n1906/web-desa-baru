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

    private static function firstExistingImage(string $filename): ?string
    {
        foreach (['png', 'jpg', 'jpeg'] as $extension) {
            $path = "images/{$filename}.{$extension}";

            if (is_file(public_path($path))) {
                return $path;
            }
        }

        return null;
    }
}
