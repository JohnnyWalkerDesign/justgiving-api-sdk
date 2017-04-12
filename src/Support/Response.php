<?php

namespace Klever\JustGivingApiSdk\Support;

use Klever\JustGivingApiSdk\Exceptions\UnexpectedStatusException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response implements ResponseInterface
{
    /**
     * The original response object.
     *
     * @var ResponseInterface
     */
    protected $response;

    /**
     * Store the response object.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Decode the JSON body.
     *
     * @return mixed
     */
    public function getBodyAsObject()
    {
        return json_decode($this->response->getBody()->__toString());
    }

    /**
     * Return true if the response has a 2xx status code.
     *
     * @return bool
     */
    public function wasSuccessful()
    {
        return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
    }

    /**
     * Check if the requested resource exists. Throw an exception if the status is not 200 or 404.
     *
     * @return bool
     * @throws UnexpectedStatusException
     */
    public function existenceCheck()
    {
        if ( ! in_array($this->getStatusCode(), [200, 404])) {
            throw new UnexpectedStatusException($this);
        }

        return $this->getStatusCode() == 200;
    }

    /**
     * Defer all unknown methods to main response class.
     *
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->response->$method(...$args);
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion()
    {
        return $this->response->getProtocolVersion();
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * @param string $version HTTP protocol version
     * @return ResponseInterface
     */
    public function withProtocolVersion($version)
    {
        return $this->response->withProtocolVersion($version);
    }

    /**
     * Retrieves all message header values.
     *
     * @return string[][] Returns an associative array of the message's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name Case-insensitive header field name.
     * @return bool Returns true if any header names match the given header
     *                     name using a case-insensitive string comparison. Returns false if
     *                     no matching header name is found in the message.
     */
    public function hasHeader($name)
    {
        return $this->response->hasHeader($name);
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * @param string $name Case-insensitive header field name.
     * @return string[] An array of string values as provided for the given
     *                     header. If the header does not appear in the message, this method MUST
     *                     return an empty array.
     */
    public function getHeader($name)
    {
        return $this->response->getHeader($name);
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * @param string $name Case-insensitive header field name.
     * @return string A string of values as provided for the given header
     *                     concatenated together using a comma. If the header does not appear in
     *                     the message, this method MUST return an empty string.
     */
    public function getHeaderLine($name)
    {
        return $this->response->getHeaderLine($name);
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * @param string          $name  Case-insensitive header field name.
     * @param string|string[] $value Header value(s).
     * @return ResponseInterface
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withHeader($name, $value)
    {
        return $this->response->withHeader($name, $value);
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * @param string          $name  Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     * @return ResponseInterface
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withAddedHeader($name, $value)
    {
        return $this->response->withAddedHeader($name, $value);
    }

    /**
     * Return an instance without the specified header.
     *
     * @param string $name Case-insensitive header field name to remove.
     * @return ResponseInterface
     */
    public function withoutHeader($name)
    {
        return $this->response->withoutHeader($name);
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface Returns the body as a stream.
     */
    public function getBody()
    {
        return $this->response->getBody();
    }

    /**
     * Return an instance with the specified message body.
     *
     * @param StreamInterface $body Body.
     * @return ResponseInterface
     * @throws \InvalidArgumentException When the body is not valid.
     */
    public function withBody(StreamInterface $body)
    {
        return $this->response->withBody($body);
    }

    /**
     * Gets the response status code.
     *
     * @return int Status code.
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     * Return an instance with the specified status code and, optionally, reason phrase.
     *
     * @param int    $code         The 3-digit integer result code to set.
     * @param string $reasonPhrase The reason phrase to use with the
     *                             provided status code; if none is provided, implementations MAY
     *                             use the defaults as suggested in the HTTP specification.
     * @return ResponseInterface * @throws \InvalidArgumentException For invalid status code arguments.
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        return $this->response->withStatus($code, $reasonPhrase);
    }

    /**
     * Gets the response reason phrase associated with the status code.
     *
     * @return string Reason phrase; must return an empty string if none present.
     */
    public function getReasonPhrase()
    {
        return $this->response->getReasonPhrase();
    }
}
