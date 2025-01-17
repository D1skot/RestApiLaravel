<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    private $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = env('API_BASE_URL');
    }

    public function index()
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

        if (! empty($allPets)) {
            return view('pets.index', ['pets' => $allPets]);
        }

        return back()->withErrors('Failed to fetch pets.');
    }

    public function show($id)
    {
        $url      = $this->apiBaseUrl . "/pet/{$id}";
        $response = $this->makeCurlRequest('GET', $url);

        if ($response['success']) {
            return view('pets.show', ['pet' => $response['data']]);
        }

        return back()->withErrors('Pet not found.');
    }
    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $url  = $this->apiBaseUrl . '/pet';
        $data = [
            'id'     => $request->input('id'),
            'name'   => $request->input('name'),
            'status' => $request->input('status'),
        ];

        $response = $this->makeCurlRequest('POST', $url, $data);

        if ($response['success']) {
            return redirect()->route('pets.index')->with('success', 'Pet added successfully!');
        }

        return back()->withErrors('Failed to add pet.');
    }

    public function update(Request $request, $id)
    {
        $url  = $this->apiBaseUrl . "/pet/{$id}";
        $data = [
            'name'   => $request->input('name'),
            'status' => $request->input('status'),
        ];

        $response = $this->makeCurlRequest('PUT', $url, $data);

        if ($response['success']) {
            return redirect()->route('pets.index')->with('success', 'Pet updated successfully!');
        }

        return back()->withErrors('Failed to update pet.');
    }

    public function destroy($id)
    {
        $url      = $this->apiBaseUrl . "/pet/{$id}";
        $response = $this->makeCurlRequest('DELETE', $url);

        if ($response['success']) {
            return redirect()->route('pets.index')->with('success', 'Pet deleted successfully!');
        }

        return back()->withErrors('Failed to delete pet.');
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

        if ($httpCode >= 200 && $httpCode < 300) {
            return [
                'success' => true,
                'data'    => json_decode($response, true),
            ];
        }

        return [
            'success' => false,
            'error'   => json_decode($response, true),
        ];
    }
}
