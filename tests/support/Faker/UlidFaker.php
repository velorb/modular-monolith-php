<?php

declare(strict_types=1);

namespace App\Tests\Support\Faker;

use App\Shared\Domain\Id\Ulid;

class UlidFaker
{
    private const ENCODING = '0123456789ABCDEFGHJKMNPQRSTVWXYZ';

    public static function generate(): string
    {
        $time = (int)(microtime(true) * 1000); // timestamp in ms (48 bits)
        $random = random_bytes(10); // 80 bits

        $timeBin = str_pad(decbin($time), 48, '0', STR_PAD_LEFT);
        $randomBin = '';
        foreach (str_split($random) as $char) {
            $randomBin .= str_pad(decbin(ord($char)), 8, '0', STR_PAD_LEFT);
        }

        $fullBin = $timeBin . $randomBin; // 128 bits total

        $ulid = '';
        for ($i = 0; $i < 26; $i++) {
            $chunk = substr($fullBin, $i * 5, 5); // 5 bits per Base32 char
            $index = bindec($chunk);
            $ulid .= self::ENCODING[$index];
        }

        return $ulid;
    }
}
