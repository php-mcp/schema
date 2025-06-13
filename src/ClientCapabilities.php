<?php

declare(strict_types=1);

namespace PhpMcp\Schema;

use JsonSerializable;

/**
 * Capabilities a client may support. Known capabilities are defined here, in this schema, but this is not a closed set: any client can define its own, additional capabilities.
 */
class ClientCapabilities implements JsonSerializable
{
    /**
     * Present if the client supports listing roots.
     * @var array{ listChanged: bool }|null
     */
    public readonly ?array $roots;

    /**
     *  Present if the client supports sampling from an LLM.
     */
    public readonly ?array $sampling;

    /**
     *  Experimental, non-standard capabilities that the client supports.
     */
    public readonly ?array $experimental;

    public function __construct(
        ?bool $rootsListChanged = null,
        ?bool $sampling = null,
        ?array $experimental = null
    ) {
        $this->roots = ($rootsListChanged !== null) ? ['listChanged' => $rootsListChanged] : null;
        $this->sampling = ($sampling === true) ? [] : $sampling;
        $this->experimental = $experimental;
    }

    public static function make(?bool $rootsListChanged = null, ?bool $sampling = null, ?array $experimental = null): static
    {
        return new static($rootsListChanged, $sampling, $experimental);
    }

    public function toArray(): array
    {
        $data = [];
        if ($this->roots !== null) {
            $data['roots'] = (object) $this->roots;
        }
        if ($this->sampling !== null) {
            $data['sampling'] = (object) $this->sampling;
        }
        if ($this->experimental !== null) {
            $data['experimental'] = $this->experimental;
        }
        return $data;
    }

    public static function fromArray(array $data): static
    {
        $rootsListChanged = null;
        if (isset($data['roots'])) {
            if (is_array($data['roots']) && array_key_exists('listChanged', $data['roots'])) {
                $rootsListChanged = (bool) $data['roots']['listChanged'];
            } elseif (is_object($data['roots']) && property_exists($data['roots'], 'listChanged')) {
                $rootsListChanged = (bool) $data['roots']->listChanged;
            }
        }

        $sampling = null;
        if (isset($data['sampling'])) {
            $sampling = true;
        }

        return new static(
            $rootsListChanged,
            $sampling,
            $data['experimental'] ?? null
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
