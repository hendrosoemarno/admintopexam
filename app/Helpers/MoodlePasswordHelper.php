<?php

namespace App\Helpers;

class MoodlePasswordHelper
{
    public static function verifyMoodlePassword(string $password, string $hash): bool
    {
        // Bcrypt ($2y$, $2a$, $2b$)
        if (preg_match('/^\$2[ayb]\$/', $hash)) {
            return password_verify($password, $hash);
        }

        // Argon2
        if (str_starts_with($hash, '$argon2id$') || str_starts_with($hash, '$argon2i$')) {
            return password_verify($password, $hash);
        }

        // SHA-512 crypt (format $6$rounds=...$salt$hash  atau $6$salt$hash)
        if (str_starts_with($hash, '$6$')) {
            return self::verifySha512Crypt($password, $hash);
        }

        // PHPass ($P$...) — akun lama
        if (str_starts_with($hash, '$P$')) {
            return self::verifyPhpPass($password, $hash);
        }

        // MD5 hex
        if (strlen($hash) === 32 && ctype_xdigit($hash)) {
            return md5($password) === $hash;
        }

        // SHA1 hex
        if (preg_match('/^[0-9a-f]{40}$/i', $hash)) {
            return sha1($password) === $hash;
        }

        return false;
    }

    private static function verifySha512Crypt(string $password, string $fullHash): bool
    {
        // Ambil prefix salt untuk crypt: misal "$6$rounds=10000$HKvKEE...$"
        if (preg_match('/^(\$6\$(?:rounds=\d+\$)?[^$]+\$).+$/', $fullHash, $m)) {
            $saltPrefix = $m[1]; // ini sudah termasuk trailing $
            // Gunakan crypt dengan saltPrefix
            $computed = crypt($password, $saltPrefix);
            // crypt akan mengembalikan string lengkap termasuk hash
            return hash_equals($fullHash, $computed);
        }
        return false;
    }

    // --- fungsi phpass (sama seperti sebelumnya) ---
    private static function verifyPhpPass(string $password, string $stored_hash): bool
    {
        $itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $count_log2 = strpos($itoa64, $stored_hash[3]);
        $count = 1 << $count_log2;
        $salt = substr($stored_hash, 4, 8);
        $hash = md5($salt . $password, true);
        do {
            $hash = md5($hash . $password, true);
        } while (--$count);

        $output = substr($stored_hash, 0, 12) . self::encode64($hash, 16, $itoa64);
        return hash_equals($stored_hash, $output);
    }

    private static function encode64(string $input, int $count, string $itoa64): string
    {
        $output = '';
        $i = 0;
        do {
            $value = ord($input[$i++]);
            $output .= $itoa64[$value & 0x3f];
            if ($i < $count) $value |= ord($input[$i]) << 8;
            $output .= $itoa64[($value >> 6) & 0x3f];
            if ($i++ >= $count) break;
            if ($i < $count) $value |= ord($input[$i]) << 16;
            $output .= $itoa64[($value >> 12) & 0x3f];
            if ($i++ >= $count) break;
            $output .= $itoa64[($value >> 18) & 0x3f];
        } while ($i < $count);
        return $output;
    }
}
