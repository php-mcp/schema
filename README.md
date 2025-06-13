# PHP MCP Schema

[![Latest Version on Packagist](https://img.shields.io/packagist/v/php-mcp/schema.svg?style=flat-square)](https://packagist.org/packages/php-mcp/schema)
[![Total Downloads](https://img.shields.io/packagist/dt/php-mcp/schema.svg?style=flat-square)](https://packagist.org/packages/php-mcp/schema)
[![License](https://img.shields.io/packagist/l/php-mcp/schema.svg?style=flat-square)](LICENSE)

This package provides PHP Data Transfer Objects (DTOs) and Enums for the [Model Context Protocol (MCP)](https://modelcontextprotocol.io/) schema. It is intended to be used by PHP implementations of MCP servers and clients, ensuring type safety and consistency with the official specification.

Current MCP Schema Version: [**2025-03-26**](https://github.com/modelcontextprotocol/modelcontextprotocol/blob/main/schema/2025-03-26/schema.ts)

## Installation

```bash
composer require php-mcp/schema
```

## Usage

This package contains PHP classes and enums that directly correspond to the types defined in the official MCP TypeScript schema (linked above). These can be used for:

*   Type-hinting in your MCP server or client application logic.
*   Serializing PHP objects into arrays that match the MCP JSON structure before sending them over a transport.
*   Deserializing associative arrays (from decoded JSON) received from an MCP transport into strongly-typed PHP objects.

### DTO Features

Each Data Transfer Object (DTO) class typically provides:

*   **Readonly Public Properties:** For immutability and direct access to data fields.
*   **Constructor:** For instantiating objects with all required properties and optional ones.
*   **Static `make(...): static` Method:** (For most DTOs) A convenient alternative factory method, often mirroring the constructor's signature, allowing for a fluent instantiation style.
*   **`toArray(): array` Method:** Converts the DTO instance into an associative array suitable for `json_encode()`. Optional properties with `null` values are typically omitted from the output array for cleaner JSON.
*   **Static `fromArray(array $data): static` Factory Method:** Constructs a DTO instance from an associative array (e.g., after `json_decode(..., true)`). This method usually includes validation for required fields.
*   **`JsonSerializable` Interface:** Most DTOs implement this, allowing them to be directly used with `json_encode()`.

See the `src/` directory for all available schema types, organized by their functional area within the Model Context Protocol.

## Contributing

Contributions are welcome! Please refer to the contributing guidelines of the main `php-mcp` project.

## License

MIT License. See [LICENSE](LICENSE) file.