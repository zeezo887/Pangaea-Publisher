<?php
declare(strict_types=1);

namespace App\Http\Interfaces;

/**
 * Interface RequestInterface
 * @package App\Http\Interfaces
 */
interface RequestInterface
{
    public function sendToMany(array $body, array $urls = []): array;
}
