<?php

namespace PurpleObject\Factuursturen;

use GuzzleHttp\Client;

class FactuurSturen
{
    /** @var \GuzzleHttp\Client */
    public $client;

    /** @var array */
    public $auth;

    /**
     * Factuur Sturen Service constructor.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => config('services.factuursturen.api'),
                'headers'  => [
                    'Accept' => 'application/json',
                ]
            ]
        );

        $this->auth = [
            config('services.factuursturen.username'),
            config('services.factuursturen.key')
        ];
    }

    /**
     * Create a new client.
     *
     * @param $params
     *
     * @return mixed
     */
    public function createClients($params)
    {
        return $this->apiCall('POST', 'clients', null, $params);
    }

    /**
     * Show a client by clientID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function showClients($id)
    {
        return $this->apiCall('GET', 'clients', $id);
    }

    /**
     * List all clients.
     *
     * @return mixed
     */
    public function indexClients()
    {
        return $this->apiCall('GET', 'clients');
    }

    /**
     * Update a client by clientID.
     *
     * @param $id
     * @param $params
     *
     * @return mixed
     */
    public function updateClients($id, $params)
    {
        return $this->apiCall('PUT', 'clients', $id, $params);
    }

    /**
     * Delete a client by clientID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function deleteClients($id)
    {
        return $this->apiCall('DELETE', 'clients', $id);
    }

    /**
     * Create a new product.
     *
     * @param $params
     *
     * @return mixed
     */
    public function createProducts($params)
    {
        return $this->apiCall('POST', 'products', null, $params);
    }

    /**
     * Show a product by productID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function showProducts($id)
    {
        return $this->apiCall('GET', 'products', $id);
    }

    /**
     * List all products.
     *
     * @return mixed
     */
    public function indexProducts()
    {
        return $this->apiCall('GET', 'products');
    }

    /**
     * Update a product by productID.
     *
     * @param $id
     * @param $params
     *
     * @return mixed
     */
    public function updateProducts($id, $params)
    {
        return $this->apiCall('PUT', 'products', $id, $params);
    }

    /**
     * Delete a product by productID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function deleteProducts($id)
    {
        return $this->apiCall('DELETE', 'products', $id);
    }

    /**
     * Create a new invoice.
     *
     * @param $params
     *
     * @return mixed
     */
    public function createInvoices($params)
    {
        return $this->apiCall('POST', 'invoices', null, $params);
    }

    /**
     * Show an invoice by invoiceID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function showInvoices($id)
    {
        return $this->apiCall('GET', 'invoices', $id);
    }

    /**
     * Show all invoices.
     *
     * @return mixed
     */
    public function indexInvoices()
    {
        return $this->apiCall('GET', 'invoices');
    }

    /**
     * Delete an invoice by invoiceID.
     *
     * @param $id
     *
     * @return mixed
     */
    public function deleteInvoices($id)
    {
        return $this->apiCall('DELETE', 'invoices', $id);
    }

    /**
     * List all profiles.
     *
     * @return mixed
     */
    public function getProfiles()
    {
        return $this->apiCall('GET', 'profiles');
    }

    /**
     * List all taxes.
     *
     * @return mixed
     */
    public function getTaxes()
    {
        return $this->apiCall('GET', 'taxes');
    }

    /**
     * Search by query string.
     *
     * @param        $endpoint
     * @param        $searchQuery
     * @param string $field
     *
     * @return bool|\Psr\Http\Message\ResponseInterface
     */
    public function search($endpoint, $searchQuery, $field = 'all')
    {
        $allowedEndpoints = [
            'clients',
            'invoices',
            'products'
        ];

        if (!in_array($endpoint, $allowedEndpoints)) {
            return false;
        }

        $endpoint .= '/' . $field . '/' . $searchQuery;

        $response = $this
            ->client
            ->get($endpoint, ['auth' => $this->auth]
            );


        return $response;
    }

    /**
     * List all available countries.
     *
     * @param string $language
     *
     * @return bool|mixed
     */
    public function getCountryList($language = 'nl')
    {
        $allowedCountries = [
            'nl',
            'en',
            'de',
            'fr',
            'es'
        ];

        if (!in_array($language, $allowedCountries)) {
            return false;
        }

        return $this->apiCall('GET', 'countrylist', $language);
    }

    /**
     * Do the actual API call to factuursturen.
     *
     * @param      $method
     * @param      $endpoint
     * @param null $id
     * @param null $params
     *
     * @return mixed
     */
    protected function apiCall($method, $endpoint, $id = null, $params = null)
    {
        if (isset($id)) {
            $endpoint .= '/' . $id;
        }

        switch ($method) {
            case"POST":
                $response = $this
                    ->client
                    ->post($endpoint, [
                            'auth'        => $this->auth,
                            'form_params' => $params
                        ]
                    );
                break;

            case "PUT":
                $response = $this
                    ->client
                    ->put($endpoint, [
                            'auth'        => $this->auth,
                            'form_params' => $params
                        ]
                    );
                break;

            case"DELETE":
                $response = $this
                    ->client
                    ->delete($endpoint, ['auth' => $this->auth]
                    );
                break;

            default:
                $response = $this
                    ->client
                    ->get($endpoint, ['auth' => $this->auth]
                    );

        }

        return json_decode($response->getBody(), true);
    }
}