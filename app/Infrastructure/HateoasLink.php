<?php

namespace App\Infrastructure;

class HateoasLink
{
    readonly public string $rel;
    readonly public string $href;
    readonly public string $method;

    /**
     * @param string $rel
     * @param string $href
     * @param string $method
     */
    public function __construct(string $rel, string $href, string $method = 'GET')
    {
        $this->rel = $rel;
        $this->href = $href;
        $this->method = $method;
    }

    public static function create(string $rel, string $href, string $method = 'GET'): self
    {
        return new self($rel, $href, $method);
    }

    public function toArray(): array
    {
        $map = [
            'rel' => $this->rel,
            'href' => $this->href,
            'method' => $this->method,
        ];
        if ($this->method === 'POST' || $this->method === 'PUT') {
            $map['type'] = 'application/json';
        }
        if ($this->method === 'GET') {
            unset($map['method']);
        }
        return $map;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}
