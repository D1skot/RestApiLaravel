<?php
namespace App\Services;

class PetService
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = 'https://petstore.swagger.io/v2';
    }

    public function getAllPets()
    {
        $statuses = ['available', 'pending', 'sold'];
        $allPets  = [];

        foreach ($statuses as $status) {
            $url      = $this->apiBaseUrl . "/pet/findByStatus?status=$status";
            $response = $this->makeCurlRequest('GET', $url);

            if ($response['success'] && ! empty($response['data'])) {
                $allPets = array_merge($allPets, $response['data']);
            }
        }

        return $allPets;
    }

    public function getPetById($id)
    {
        $url = $this->apiBaseUrl . "/pet/{$id}";
        return $this->makeCurlRequest('GET', $url);
    }

    public function createPet($data)
    {
        $url = $this->apiBaseUrl . '/pet';
        return $this->makeCurlRequest('POST', $url, $data);
    }

    public function updatePet($id, $data)
    {
        $url        = $this->apiBaseUrl . '/pet';
        $data['id'] = (int) $id;
        return $this->makeCurlRequest('PUT', $url, $data);
    }

    public function deletePet($id)
    {
        $url = $this->apiBaseUrl . "/pet/{$id}";
        return $this->makeCurlRequest('DELETE', $url);
    }

    private function makeCurlRequest($method, $url, $data = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        if (in_array($method, ['POST', 'PUT'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'success' => $httpCode >= 200 && $httpCode < 300,
            'data'    => json_decode($response, true),
            'error'   => $httpCode >= 400 ? json_decode($response, true) : null,
        ];
    }
}
