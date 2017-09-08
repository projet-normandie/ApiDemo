<?php
declare(strict_types = 1);

namespace Tests\Generalisation;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;

/**
 * Class AbstractJsonTestCase
 * This is the base test case for all functional tests of services.
 *
 * @category Tests
 * @package Generalisation
 * @abstract
 *
 * @license MIT
 */
abstract class AbstractJsonTestCase extends TestCase
{
    use TraitParameters;

    /** @var string Name of the environment variable where the service name must be set. */
    protected const ENV_CONTAINER_NAME = 'SYMFONY__HTTP__HOST__ENV';

    /** @var string Name of the environment variable where the service name must be set. */
    protected const ENV_MULTITENANT_TENANT_ID = 'MULTITENANT__TENANT__ID';

    /** @var string Final method that will be used to make the API request. Defined in each test-case. */
    protected const METHOD = '';

    /** @var string Constant to define the method GET. */
    public const METHOD_GET = 'GET';

    /** @var string Constant to define the method POST. */
    public const METHOD_POST = 'POST';

    /** @var string Constant to define the method PUT. */
    public const METHOD_PUT = 'PUT';

    /** @var string Constant to define the method PATCH. */
    public const METHOD_PATCH = 'PATCH';

    /** @var string Constant to define the method DELETE. */
    public const METHOD_DELETE = 'DELETE';

    /** @var string Final URI where to make the API request. Defined in each test-case. */
    public const URI = '';

    /** @var string Name of the service */
    protected $serviceName = '';

    /** @var string Uri to call (corresponding to the action) */
    protected $uri = '';

    /** @var array Header to pass with request */
    protected $headers = [];

    /** @var string HTTP method to used when calling (corresponding to the action) */
    protected $method = '';

    /** @var mixed Body of the request use to execute the call. */
    protected $body;

    /**
     * Sets up each test method. Will be executed before any call of a test method.
     * Currently defines the service (docker container name) to load and the URI to call for each test method.
     * Defines also the default values of the parameters if there are some.
     *
     * @return $this
     */
    public function setUp()
    {
        $this->initServiceName()
            ->setUri(static::URI)
            ->addHeader('Content-Type', 'application/json')
            ->addHeader('X-TENANT-ID', \getenv(static::ENV_MULTITENANT_TENANT_ID))
            ->setMethod(static::METHOD);

        return $this;
    }

    /**
     * Initializes the name of the service based on an environment variable.
     *
     * @return $this
     */
    public function initServiceName()
    {
        $this->serviceName = \getenv(static::ENV_CONTAINER_NAME);
        return $this;
    }

    /**
     * Sets the URI to call.
     *
     * @param string $uri
     * @return $this
     */
    public function setUri(string $uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addHeader(string $key, string $value)
    {
        $this->headers[$key] = $key . ': ' . $value;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Sets the HTTP method.
     *
     * @param string $method
     * @return $this
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Sets the body of the HTTP Request.
     *
     * @param mixed $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Asks for the call building the context options to make a valid call.
     *
     * @return stdClass
     * @throws RuntimeException
     */
    public function callService(): stdClass
    {
        return $this->call($this->buildContextOptions());
    }

    /**
     * Asks for the call but changing the context options first to make the call invalid.
     *
     * @return stdClass
     * @throws RuntimeException
     */
    public function invalidCallService(): stdClass
    {
        $contextOptions = $this->buildContextOptions();
        // Making the content invalid
        $contextOptions[\CURLOPT_POSTFIELDS] = 'Not a valid JSON';
        return $this->call($contextOptions);
    }

    /**
     * Does the call to the service according to a given context.
     *
     * @param array $curlOptions
     * @return stdClass
     * @throws RuntimeException
     */
    protected function call($curlOptions): stdClass
    {
        // Make the cURL call.
        $ch = \curl_init(\trim('http://' . $this->serviceName . $this->uri . $this->getQueryString()));
        \curl_setopt_array($ch, $curlOptions);
        if (false === ($rawContent = \curl_exec($ch))) {
            throw new RuntimeException('CURL Error: ' . \curl_error($ch));
        }
        \curl_close($ch);

        // Try to JSON decode the response ($rawContent) and return the decoded if no errors.
        $result = \json_decode($rawContent);
        if (\JSON_ERROR_NONE !== \json_last_error()) {
            $exceptionString = 'Invalid JSON returned. JSON error message is "%s". Raw content is "%s".';
            throw new RuntimeException(\sprintf($exceptionString, \json_last_error_msg(), $rawContent));
        }
        return $result;
    }

    /**
     * Builds a valid context option used to create contexts.
     *
     * @return array
     */
    public function buildContextOptions(): array
    {
        return [
            // Method to call in this context (GET, POST, PUT, PATCH or DELETE)
            \CURLOPT_CUSTOMREQUEST => $this->method,
            // HTTP-Headers sent in this context.
            \CURLOPT_HTTPHEADER => \array_values($this->getHeaders()),
            // Body content (JSON encoded, generally)
            \CURLOPT_POSTFIELDS => (!empty($this->body)) ? \json_encode($this->body) . \PHP_EOL : null,
            // We must return the value of the response.
            \CURLOPT_RETURNTRANSFER => true,
            // Only 1 second maximum is authorized to connect.
            \CURLOPT_CONNECTTIMEOUT => 1,
            // Only 3 seconds maximum is authorized to fetch the response.
            \CURLOPT_TIMEOUT => 3
        ];
    }
}
