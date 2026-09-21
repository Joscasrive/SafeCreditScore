<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuracion de integracion con Array.io.
 *
 * Los valores por defecto corresponden al entorno sandbox. En produccion
 * definalos mediante variables de entorno (.env) para no versionar secretos:
 *
 *   arrayio.appKey   = "..."
 *   arrayio.apiToken = "..."
 */
class ArrayIo extends BaseConfig
{
    /**
     * Clave publica de la aplicacion (appKey). Se usa en los componentes web.
     */
    public string $appKey = '313778AF-64C7-4BC5-B54C-CA178D76A380';

    /**
     * Token privado de servidor (x-array-server-token). NUNCA exponer en el HTML/JS.
     */
    public string $apiToken = 'A95F6F25-8B3C-415D-A73F-4EA2387ADE88';

    /**
     * URL base de la API REST de Array (sandbox).
     */
    public string $baseUrl = 'https://sandbox.array.io/api';

    /**
     * URL usada por los componentes web (apiUrl del array-credit-report).
     */
    public string $componentApiUrl = 'https://sandbox.array.io';

    /**
     * Origen de los scripts embebidos de los componentes.
     */
    public string $embedUrl = 'https://embed.array.io/cms';

    /**
     * Indica si se trabaja en modo sandbox.
     */
    public bool $sandbox = true;
}
