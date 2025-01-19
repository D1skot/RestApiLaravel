<?php
namespace App\Http\Controllers;

use App\Http\Requests\PetRequest;
use App\Services\PetService;

class PetController extends Controller
{
    private $petService;

    public function __construct(PetService $petService)
    {
        $this->petService = $petService;
    }

    public function index()
    {
        $allPets = $this->petService->getAllPets();
        return view('pets.index', ['pets' => $allPets]);
    }

    public function show($id)
    {
        $response = $this->petService->getPetById($id);

        if ($response['success']) {
            return view('pets.show', ['pet' => $response['data']]);
        }

        return back()->withErrors('Nie znaleziono danego zwierzęcia');
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(PetRequest $request)
    {
        $validatedData = $request->validated();

        $data = [
            'id'        => $validatedData['id'],
            'name'      => $validatedData['name'],
            'status'    => $validatedData['status'],
            'category'  => [
                'id'   => $validatedData['category_id'],
                'name' => $validatedData['category_name'],
            ],
            'photoUrls' => [$validatedData['photo_url']],
            'tags'      => collect($request->input('tags', []))->map(function ($tag) {
                return [
                    'id'   => $tag['id'] ?? 0,
                    'name' => $tag['name'] ?? '',
                ];
            })->toArray(),
        ];

        $response = $this->petService->createPet($data);

        if ($response['success']) {
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało pomyślnie dodane!');
        }

        return back()->withErrors($response['error'] ?? 'Nie udało się dodać zwierzęcia.');
    }

    public function edit($id)
    {
        $response = $this->petService->getPetById($id);

        if ($response['success']) {
            return view('pets.edit', ['pet' => $response['data']]);
        }

        return back()->withErrors('Nie znaleziono danego zwierzęcia');
    }

    public function update(PetRequest $request, $id)
    {
        $validatedData = $request->validated();

        $data = [
            'name'      => $validatedData['name'],
            'status'    => $validatedData['status'],
            'category'  => [
                'id'   => $validatedData['category_id'],
                'name' => $validatedData['category_name'],
            ],
            'photoUrls' => [$validatedData['photo_url']],
            'tags'      => collect($request->input('tags', []))->map(function ($tag) {
                return [
                    'id'   => $tag['id'] ?? 0,
                    'name' => $tag['name'] ?? '',
                ];
            })->toArray(),
        ];

        $response = $this->petService->updatePet($id, $data);

        if ($response['success']) {
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało pomyślnie zaktualizowane!');
        }

        return back()->withErrors($response['error'] ?? 'Nie udało się zaktualizować zwierzęcia.');
    }

    public function destroy($id)
    {
        $response = $this->petService->deletePet($id);

        if ($response['success']) {
            return redirect()->route('pets.index')->with('success', 'Zwierzę zostało usunięte!');
        }

        return back()->withErrors('Nie udało się usunąć zwierzęcia.');
    }
}
