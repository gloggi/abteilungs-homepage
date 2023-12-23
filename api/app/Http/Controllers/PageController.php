<?php
namespace App\Http\Controllers;


use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\FilesItem;
use App\Models\FormItem;
use App\Models\ImageItem;
use App\Models\TextItem;
use App\Models\GenericItem;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $pages = Page::with(['files'])
                       ->paginate($perPage);

        return response()->json($pages);
    }
    public function store(StorePageRequest $request)
    {
        $validatedData = $request->validated();
       
        $page = Page::create($validatedData);

        $page->files()->sync(array_column($request->input('files', []), 'id'));

        $this->createPageItemsFromValidatedData($page, $validatedData);

        return response()->json([
            'id' => $page->id,
            'title' => $page->title,
            'route' => $page->route,
            'page_items' => $page->getAllItems(),
        ], 201);
    }

    public function update(UpdatePageRequest $request, $id)
    {
        $page = Page::find($id);
        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }
        $validatedData = $request->validated();
        $page->update($validatedData);
        $page->files()->sync(array_column($request->input('files', []), 'id'));
        $this->createPageItemsFromValidatedData($page, $validatedData);

        $currentPageItems = $page->getAllItems();
        foreach ($currentPageItems as $currentField) {
            $found = false;
            foreach ($validatedData['page_items'] as $pageItemData) {
                if (!isset($pageItemData['id']) || ($currentField->id == $pageItemData['id'] && $currentField->type == $pageItemData['type'])) {
                    $found = true;

                    break;
                }
            }
            if (!$found) {
                $currentField->delete();
            }
        }
        $page = Page::find($id);

        return response()->json([
            'id' => $page->id,
            'title' => $page->title,
            'route' => $page->route,
            'page_items' => $page->getAllItems(),
        ], 200);
    }

    public function show($page)
    {
        if ($page == "0") {
            $page = null;
        }
        if (is_numeric($page)) {
            $page = Page::with('files')->find($page);
        } else {
            $page = Page::with('files')->where('route', $page)->first();
        }
        $pageItems = $page->getAllItems();
        foreach ($pageItems as $currentField) {
            if ($currentField->type == 'formItem' && $currentField->form) {
                $currentField->form->fields = $currentField->form->getAllFields();
            }
        }
        return response()->json(array_merge($page->toArray(), [
            'page_items' => $pageItems,
        ]), 200);

    }

    public function destroy($id)
    {
        $page = Page::find($id);

        if (!$page) {
            return response()->json(['message' => 'Page not found'], 404);
        }

        $page->delete();

        return response()->json(null, 204);
    }
    private function createPageItemsFromValidatedData(Page $page, $validatedData)
    {
        if (!isset($validatedData['page_items'])) {
            return;
        }
        $validatedData['page_items'] = collect($validatedData['page_items'])->sortBy('sort')->values()->all();
        $sort_counter = 0;
        foreach ($validatedData['page_items'] as $pageItemData) {
            switch ($pageItemData['type']) {
                case 'textItem':
                    TextItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'title' => $pageItemData['title'] ?? '',
                            'body' => $pageItemData['body'] ?? '',
                            'show_fleur_de_lis'=>$pageItemData['show_fleur_de_lis'] ?? false,
                            'page_id' => $page->id,
                            'sort' => $sort_counter
                        ]
                    );
                    break;
                case 'imageItem':
                    $imageItem = ImageItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter
                        ]
                    );
                    $fileIds = isset($pageItemData['files']) ? array_column($pageItemData['files'], 'id') : [];

                    if (isset($pageItemData['id'])) {
                        $imageItem->files()->sync($fileIds);
                    } else {
                        $imageItem->files()->attach($fileIds);
                    }
                    break;
                case 'formItem':
                    FormItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'form_id' => $pageItemData['form_id'] ?? null,
                        ]
                    );
                    break;
                case 'filesItem':
                    $imageItem = FilesItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'title' => $pageItemData['title'] ?? '',
                            'sort' => $sort_counter
                        ]
                    );
                    $fileIds = isset($pageItemData['files']) ? array_column($pageItemData['files'], 'id') : [];

                    if (isset($pageItemData['id'])) {
                        $imageItem->files()->sync($fileIds);
                    } else {
                        $imageItem->files()->attach($fileIds);
                    }
                    break;
                case 'contactItem':
                    GenericItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'type' => 'contactItem'
                        ]
                    );

                    break;
                case 'groupsItem':
                    GenericItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'type' => 'groupsItem'
                        ]
                    );
                    break;
                case 'sectionsItem':
                    GenericItem::updateOrCreate(
                        ['id' => $pageItemData['id'] ?? null],
                        [
                            'page_id' => $page->id,
                            'sort' => $sort_counter,
                            'type' => 'sectionsItem'
                        ]
                    );
                    break;
                default:
                    throw new \InvalidArgumentException("Unsupported field type: {$pageItemData['type']}");
            }
            $sort_counter++;
        }
    }

}