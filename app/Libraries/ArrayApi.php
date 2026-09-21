<?php

namespace App\Libraries;

use Config\ArrayIo;
use Exception;
use RuntimeException;

/**
 * Libreria de integracion con la API de Array.io.
 *
 * Portada desde el proyecto api_array (api_array.php) al estandar de
 * CodeIgniter 4. Encapsula las llamadas cURL necesarias para el flujo de
 * enrolamiento, autenticacion, renovacion de token y consulta del reporte 3B.
 */
class ArrayApi
{
    private string $apiKey;
    private string $apiToken;
    private string $baseUrl;

    private ?string $userId = null;
    private ?string $authToken = null;

    /**
     * @param string|null $apiKey   appKey. Si es null se toma de Config\ArrayIo.
     * @param string|null $apiToken Server token. Si es null se toma de Config\ArrayIo.
     */
    public function __construct(?string $apiKey = null, ?string $apiToken = null)
    {
        /** @var ArrayIo $config */
        $config = config('ArrayIo');

        $this->apiKey   = $apiKey ?? $config->appKey;
        $this->apiToken = trim($apiToken ?? $config->apiToken);
        $this->baseUrl  = rtrim($config->baseUrl, '/');
    }

    public function setUserId(string $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function setAuthToken(string $authToken): self
    {
        $this->authToken = $authToken;

        return $this;
    }

    /**
     * Solicitud cURL generica.
     *
     * @param array<string,mixed> $data
     * @param array<int,string>   $headers
     */
    private function curlRequest(
        string $url,
        string $method = 'GET',
        array $data = [],
        array $headers = [],
        string $contentType = 'application/json'
    ): string {
        $ch     = curl_init();
        $method = strtoupper($method);

        $options = [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers,
        ];

        if (in_array($method, ['POST', 'PUT', 'PATCH'], true)) {
            $options[CURLOPT_POSTFIELDS] = $contentType === 'application/x-www-form-urlencoded'
                ? http_build_query($data)
                : json_encode($data);
        }

        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            throw new Exception('cURL request error: ' . $error);
        }

        curl_close($ch);

        return (string) $response;
    }

    /**
     * Crea un cliente en Array.
     *
     * @param array<string,mixed> $data
     *
     * @return array<string,mixed>
     */
    public function createCustomer(array $data): array
    {
        $url     = "{$this->baseUrl}/user/v2";
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        return $this->decode($this->curlRequest($url, 'POST', $data, $headers));
    }

    /**
     * Obtiene las preguntas de autenticacion para el cliente.
     *
     * @return array<string,mixed>
     */
    public function getAuthenticationQuestions(): array
    {
        $url = "{$this->baseUrl}/authenticate/v2?appKey={$this->apiKey}&userId={$this->userId}&provider1=tui";

        $headers = ['accept: application/json'];

        return $this->decode($this->curlRequest($url, 'GET', [], $headers));
    }

    /**
     * Envia las respuestas de autenticacion y devuelve el resultado.
     *
     * @param array<string,mixed> $answers
     *
     * @return array<string,mixed>
     */
    public function sendAuthenticationAnswers(array $answers): array
    {
        $url     = "{$this->baseUrl}/authenticate/v2";
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        $data = [
            'answers'   => $answers,
            'appKey'    => $this->apiKey,
            'userId'    => $this->userId,
            'authToken' => $this->authToken,
        ];

        return $this->decode($this->curlRequest($url, 'POST', $data, $headers));
    }

    /**
     * Renueva el userToken para seguir operando con el cliente.
     *
     * @return array<string,mixed>
     */
    public function renewUserToken(): array
    {
        $url     = "{$this->baseUrl}/authenticate/v2/usertoken";
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            "x-array-server-token: {$this->apiToken}",
        ];

        $data = [
            'appKey' => $this->apiKey,
            'userId' => $this->userId,
        ];

        return $this->decode($this->curlRequest($url, 'POST', $data, $headers));
    }

    /**
     * Devuelve directamente el userToken renovado (o cadena vacia si falla).
     */
    public function renewUserTokenValue(): string
    {
        $response = $this->renewUserToken();

        return (string) ($response['userToken'] ?? $response['user-token'] ?? '');
    }

    /**
     * Solicita el reporte 3B para el cliente.
     *
     * @return array<string,mixed>
     */
    public function request3bReport(): array
    {
        $url     = "{$this->baseUrl}/report/v2";
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
            "x-array-server-token: {$this->apiToken}",
        ];

        $data = [
            'userId'      => $this->userId,
            'productCode' => 'tui3bReportScore',
        ];

        return $this->decode($this->curlRequest($url, 'POST', $data, $headers));
    }

    /**
     * Consulta un reporte 3B ya generado.
     *
     * @return array<string,mixed>
     */
    public function view3bReport(string $reportKey, string $displayToken): array
    {
        $url     = "{$this->baseUrl}/report/v2/?reportKey={$reportKey}&displayToken={$displayToken}";
        $headers = [
            'Content-Type: application/json',
            "x-array-server-token: {$this->apiToken}",
        ];

        return $this->decode($this->curlRequest($url, 'GET', [], $headers));
    }

    /**
     * Decodifica una respuesta JSON de Array a arreglo.
     *
     * @return array<string,mixed>
     */
    private function decode(string $response): array
    {
        $decoded = json_decode($response, true);

        if (! is_array($decoded)) {
            throw new RuntimeException('Respuesta invalida de Array: ' . $response);
        }

        return $decoded;
    }
}
