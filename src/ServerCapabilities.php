<?php

declare(strict_types=1);

namespace PhpMcp\Schema;

use JsonSerializable;

/**
 * Capabilities that a server may support. Known capabilities are defined here, in this schema, but this is not a closed set: any server can define its own, additional capabilities.
 */
class ServerCapabilities implements JsonSerializable
{
    /**
     * Present if the server supports sending log messages to the client.
     */
    public readonly ?array $logging;

    /**
     * Present if the server supports argument autocompletion suggestions.
     */
    public readonly ?array $completions;

    /**
     * Present if the server offers any prompt templates.
     * @var array{ listChanged: bool }|null
     */
    public readonly ?array $prompts;

    /**
     * Present if the server offers any resources.
     * @var array{ subscribe: bool, listChanged: bool }|null
     */
    public readonly ?array $resources;

    /**
     * Present if the server offers any tools.
     * @var array{ listChanged: bool }|null
     */
    public readonly ?array $tools;

    /**
     * Experimental, non-standard capabilities that the server supports.
     */
    public readonly ?array $experimental;

    /**
     * @param bool $toolsEnabled  Server supports tools.
     * @param bool $toolsListChanged  Server supports sending a notification when the list of tools changes.
     * @param bool $resourcesEnabled  Server supports resources.
     * @param bool $resourcesSubscribe  Server supports subscribing to changes in the list of resources.
     * @param bool $resourcesListChanged  Server supports sending a notification when the list of resources changes.
     * @param bool $promptsEnabled  Server supports prompts.
     * @param bool $promptsListChanged  Server supports sending a notification when the list of prompts changes.
     * @param bool $loggingEnabled  Server supports sending log messages to the client.
     * @param bool $completionsEnabled  Server supports argument autocompletion suggestions.
     * @param array|null $experimental  Experimental, non-standard capabilities that the server supports.
     */
    public function __construct(
        public readonly bool $toolsEnabled = true,
        public readonly bool $toolsListChanged = false,
        public readonly bool $resourcesEnabled = true,
        public readonly bool $resourcesSubscribe = false,
        public readonly bool $resourcesListChanged = false,
        public readonly bool $promptsEnabled = true,
        public readonly bool $promptsListChanged = false,
        public readonly bool $loggingEnabled = false,
        public readonly bool $completionsEnabled = false,
        ?array $experimental = null
    ) {
        $this->logging = $loggingEnabled ? [] : null;
        $this->completions = $completionsEnabled ? [] : null;

        if ($promptsEnabled) {
            $this->prompts = ['listChanged' => $promptsListChanged];
        } else {
            $this->prompts = null;
        }

        if ($resourcesEnabled) {
            $resources = [];
            if ($resourcesSubscribe) {
                $resources['subscribe'] = $resourcesSubscribe;
            }
            if ($resourcesListChanged) {
                $resources['listChanged'] = $resourcesListChanged;
            }
            $this->resources = $resources;
        } else {
            $this->resources = null;
        }

        if ($toolsEnabled) {
            $this->tools = ['listChanged' => $toolsListChanged];
        } else {
            $this->tools = null;
        }

        $this->experimental = $experimental;
    }

    /**
     * Create a new ServerCapabilities object.
     *
     * @param bool $toolsEnabled  Server supports tools.
     * @param bool $toolsListChanged  Server supports sending a notification when the list of tools changes.
     * @param bool $resourcesEnabled  Server supports resources.
     * @param bool $resourcesSubscribe  Server supports subscribing to changes in the list of resources.
     * @param bool $resourcesListChanged  Server supports sending a notification when the list of resources changes.
     * @param bool $promptsEnabled  Server supports prompts.
     * @param bool $promptsListChanged  Server supports sending a notification when the list of prompts changes.
     * @param bool $loggingEnabled  Server supports sending log messages to the client.
     * @param bool $completionsEnabled  Server supports argument autocompletion suggestions.
     * @param array|null $experimental  Experimental, non-standard capabilities that the server supports.
     */
    public static function make(
        bool $toolsEnabled = true,
        bool $toolsListChanged = false,
        bool $resourcesEnabled = true,
        bool $resourcesSubscribe = false,
        bool $resourcesListChanged = false,
        bool $promptsEnabled = true,
        bool $promptsListChanged = false,
        bool $loggingEnabled = false,
        bool $completionsEnabled = false,
        ?array $experimental = null
    ) {
        return new static(
            $toolsEnabled,
            $toolsListChanged,
            $resourcesEnabled,
            $resourcesSubscribe,
            $resourcesListChanged,
            $promptsEnabled,
            $promptsListChanged,
            $loggingEnabled,
            $completionsEnabled,
            $experimental
        );
    }

    public function toArray(): array
    {
        $data = [];
        if ($this->logging !== null) {
            $data['logging'] = (object) $this->logging;
        }
        if ($this->completions !== null) {
            $data['completions'] = (object) $this->completions;
        }
        if ($this->prompts !== null) {
            $data['prompts'] = (object) $this->prompts;
        }
        if ($this->resources !== null) {
            $data['resources'] = (object) $this->resources;
        }
        if ($this->tools !== null) {
            $data['tools'] = (object) $this->tools;
        }
        if ($this->experimental !== null) {
            $data['experimental'] = (object) $this->experimental;
        }
        return $data;
    }

    public static function fromArray(array $data): static
    {
        $loggingEnabled = isset($data['logging']);
        $completionsEnabled = isset($data['completions']);

        $promptsListChanged = null;
        if (isset($data['prompts'])) {
            if (is_array($data['prompts']) && array_key_exists('listChanged', $data['prompts'])) {
                $promptsListChanged = (bool) $data['prompts']['listChanged'];
            } elseif (is_object($data['prompts']) && property_exists($data['prompts'], 'listChanged')) {
                $promptsListChanged = (bool) $data['prompts']->listChanged;
            }
        }


        $resourcesSubscribe = null;
        $resourcesListChanged = null;
        if (isset($data['resources'])) {
            if (is_array($data['resources']) && array_key_exists('subscribe', $data['resources'])) {
                $resourcesSubscribe = (bool) $data['resources']['subscribe'];
            } elseif (is_object($data['resources']) && property_exists($data['resources'], 'subscribe')) {
                $resourcesSubscribe = (bool) $data['resources']->subscribe;
            }
            if (is_array($data['resources']) && array_key_exists('listChanged', $data['resources'])) {
                $resourcesListChanged = (bool) $data['resources']['listChanged'];
            } elseif (is_object($data['resources']) && property_exists($data['resources'], 'listChanged')) {
                $resourcesListChanged = (bool) $data['resources']->listChanged;
            }
        }

        $toolsListChanged = null;
        if (isset($data['tools'])) {
            if (is_array($data['tools']) && array_key_exists('listChanged', $data['tools'])) {
                $toolsListChanged = (bool) $data['tools']['listChanged'];
            } elseif (is_object($data['tools']) && property_exists($data['tools'], 'listChanged')) {
                $toolsListChanged = (bool) $data['tools']->listChanged;
            }
        }

        return new static(
            $loggingEnabled,
            $completionsEnabled,
            $promptsListChanged,
            $resourcesSubscribe,
            $resourcesListChanged,
            $toolsListChanged,
            $data['experimental'] ?? null
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
