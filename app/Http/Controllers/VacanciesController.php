<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVacancyRequest;
use App\Http\Requests\UpdateVacancyRequest;
use App\Http\Resources\VacancyResource;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VacanciesController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return VacancyResource::collection(Vacancy::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVacancyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVacancyRequest $request): VacancyResource
    {
        $data = $request->validated();

        $vacancy = Vacancy::create([
            'date_from' => $data['date_from'],
            'date_to' => $data['date_to'],
            'price' => $data['price'],
            'number_of_vacancies' => $data['number_of_vacancies'],
        ]);

        return new VacancyResource($vacancy);
    }

    public function show(Vacancy $vacancy): VacancyResource
    {
        return new VacancyResource($vacancy);
    }

    public function update(UpdateVacancyRequest $request, Vacancy $vacancy)
    {
        $data = $request->validated();

        $vacancy->update($data);

        return new VacancyResource($vacancy);
    }

    public function destroy(Vacancy $vacancy): JsonResponse
    {
        $vacancy->delete();

        return response()->json(null, 204);
    }
}
