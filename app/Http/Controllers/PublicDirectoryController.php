<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Directory\PublicDirectoryQueryService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final class PublicDirectoryController extends Controller
{
    public function index(Request $request, PublicDirectoryQueryService $directory): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'type' => ['nullable', 'string', 'max:40'],
            'locality' => ['nullable', 'string', 'max:120'],
            'filters' => ['nullable', 'array', 'max:6'],
            'filters.*' => ['nullable', 'string', 'max:120'],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        $query = trim((string) ($validated['q'] ?? ''));
        $type = ($validated['type'] ?? '') !== '' ? (string) $validated['type'] : null;
        $locality = trim((string) ($validated['locality'] ?? ''));
        $filterOptions = $directory->filterOptions();
        $filters = [];
        foreach (($validated['filters'] ?? []) as $key => $value) {
            if (isset($filterOptions[$key]) && in_array($value, $filterOptions[$key]['values'], true)) {
                $filters[$key] = $value;
            }
        }
        $data = $directory->search($query, $type, $locality, $filters);
        $perPage = 20;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $results = new LengthAwarePaginator(
            array_slice($data['results'], ($page - 1) * $perPage, $perPage),
            count($data['results']),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('directory.index', [
            'query' => $query,
            'type' => $type,
            'locality' => $locality,
            'filters' => $filters,
            'filterOptions' => $filterOptions,
            'typeOptions' => $directory->typeOptions(),
            'facets' => $data['facets'],
            'results' => $results,
        ]);
    }

    public function show(string $entity, PublicDirectoryQueryService $directory): View
    {
        $profile = $directory->find($entity);
        abort_if($profile === null, 404);

        return view('directory.show', ['profile' => $profile]);
    }
}
