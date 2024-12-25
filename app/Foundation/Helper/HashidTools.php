<?php

namespace App\Foundation\Helper;

use Hashids\Hashids;

class HashidTools
{
    protected $salt;

    protected $length;

    protected $alphabet;

    protected $hashids;

    public function __construct() {
        $config = config('hashids.connections.main');

        $this->salt = $config['salt'];
        $this->length = $config['length'];
        $this->alphabet = $config['alphabet'];

        $this->hashids = new Hashids($this->salt, $this->length, $this->alphabet);
    }

    public function __get(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }

        return null;
    }

    public function __set(string $key, $value): void
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }

        $this->hashids = new Hashids($this->salt, $this->length, $this->alphabet);
    }

    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    public function __unset($name)
    {
        if (property_exists($this, $name)) {
            unset($this->$name);
        }
    }

    public function connection(string $name = 'main'): ?Hashids
    {
        $config = config('hashids.connections');

        if (array_key_exists($name, $config)) {
            $config = $config[$name];
            $this->salt = $config['salt'];
            $this->length = $config['length'];
            $this->alphabet = $config['alphabet'];

            $this->hashids = new Hashids($this->salt, $this->length, $this->alphabet);

            return $this->hashids;
        }

        return null;
    }

    public function encoder(int $value): string
    {
        return $this->hashids->encode($value);
    }

    public function decoder(string $value): ?array
    {
        return $this->hashids->decode($value) ?? null;
    }

    public function encodeString(string $value): string
    {
        return $this->hashids->encodeHex($value);
    }

    public function decodeString(string $value): ?array
    {
        return $this->hashids->decodeHex($value) ?? null;
    }
}
