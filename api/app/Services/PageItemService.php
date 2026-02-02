<?php

namespace App\Services;

use App\Models\BlogPostsItem;
use App\Models\CampItem;
use App\Models\ContactItem;
use App\Models\FaqItem;
use App\Models\FilesItem;
use App\Models\FormItem;
use App\Models\GenericItem;
use App\Models\GroupEventsItem;
use App\Models\ImageItem;
use App\Models\LocationItem;
use App\Models\TextItem;
use Illuminate\Database\Eloquent\Model;

class PageItemService
{
    public function syncItems(Model $parent, array $itemsData)
    {
        $itemsData = collect($itemsData)->sortBy('sort')->values()->all();
        $sortCounter = 0;

        $foreignKey = $parent->getItemForeignKey();
        $parentId = $parent->id;

        foreach ($itemsData as $itemData) {
            $data = [
                'sort' => $sortCounter,
                $foreignKey => $parentId,
            ];
            
            switch ($itemData['type']) {
                case 'textItem':
                    TextItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, [
                            'title' => $itemData['title'] ?? '',
                            'body' => $itemData['body'] ?? '',
                            'section_id' => $itemData['section_id'] ?? null,
                            'group_id' => $itemData['group_id'] ?? null,
                        ])
                    );
                    break;
                case 'imageItem':
                    $imageItem = ImageItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        $data
                    );
                    $fileIds = isset($itemData['files']) ? array_column($itemData['files'], 'id') : [];
                    if (isset($itemData['id'])) {
                        $imageItem->files()->sync($fileIds);
                    } else {
                        $imageItem->files()->attach($fileIds);
                    }
                    break;
                case 'formItem':
                    FormItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, [
                            'form_id' => $itemData['form_id'] ?? null,
                        ])
                    );
                    break;
                case 'filesItem':
                    $filesItem = FilesItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, [
                            'title' => $itemData['title'] ?? '',
                            'view_mode' => $itemData['view_mode'] ?? 'gallery',
                        ])
                    );
                    $fileIds = isset($itemData['files']) ? array_column($itemData['files'], 'id') : [];
                    if (isset($itemData['id'])) {
                        $filesItem->files()->sync($fileIds);
                    } else {
                        $filesItem->files()->attach($fileIds);
                    }
                    break;
                case 'contactItem':
                    $contactItem = ContactItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, ['type' => 'contactItem'])
                    );
                    $groupIds = $itemData['groups'] ?? [];
                    if (!empty($groupIds) && is_array($groupIds) && is_array($groupIds[0] ?? null)) {
                        $groupIds = array_column($groupIds, 'id');
                    }
                    $contactItem->groups()->sync($groupIds);
                    break;
                case 'groupsItem':
                    GenericItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, ['type' => 'groupsItem'])
                    );
                    break;
                case 'sectionsItem':
                    GenericItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, ['type' => 'sectionsItem'])
                    );
                    break;
                case 'campItem':
                    CampItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, [
                             'group_id' => $itemData['group_id'] ?? null,
                        ])
                    );
                    break;
                case 'locationItem':
                     LocationItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                         array_merge($data, [
                             'location_id' => $itemData['location_id'] ?? null,
                         ])
                    );
                    break;
                case 'faqItem':
                    FaqItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                         array_merge($data, [
                             'faq_id' => $itemData['faq_id'] ?? null,
                         ])
                    );
                    break;
                case 'groupEventsItem':
                     GroupEventsItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                         array_merge($data, [
                             'group_id' => $itemData['group_id'] ?? null,
                         ])
                    );
                    break;
                case 'blogPostsItem':
                    $blogItem = BlogPostsItem::updateOrCreate(
                        ['id' => $itemData['id'] ?? null],
                        array_merge($data, [
                            'view_mode' => $itemData['view_mode'] ?? 'all',
                        ])
                    );
                    
                    $tagIds = isset($itemData['tags']) ? array_column($itemData['tags'], 'id') : [];
                    $blogItem->tags()->sync($tagIds);

                    $ids = isset($itemData['blog_posts']) ? array_column($itemData['blog_posts'], 'id') : [];
                    $blogItem->blogPosts()->sync($ids);
                    break;
                default:
                    break;
            }
            $sortCounter++;
        }
    }
}
