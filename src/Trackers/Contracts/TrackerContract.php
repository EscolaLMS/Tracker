<?php

namespace EscolaLms\Tracker\Trackers\Contracts;

interface TrackerContract
{
    public function isEnabled(): bool;

    public function enable(): void;

    public function disable(): void;

    public function connection(string $connection): void;

    public function getConnection(): string;

    public function ignoreUris(array $uris): void;

    public function getIgnoreUris(): array;

    public function prefix(?string $prefix): void;

    public function getPrefix(): string;
}
