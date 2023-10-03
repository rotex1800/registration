<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasDocuments
{
    public function owns(Document $document): bool
    {
        $owner = $document->owner;
        if ($owner == null) {
            return false;
        }

        return $owner->id == $this->id;
    }

    /**
     * Convenience method for getting the relation associated with the given
     * DocumentType.
     */
    public function relationFor(DocumentCategory $category): ?Relation
    {
        if ($category == DocumentCategory::PassportCopy) {
            return $this->passport();
        }

        return null;
    }

    /**
     * Returns the first document matching the category or null if no such
     * Document can be found.
     */
    public function documentBy(DocumentCategory $category): Document
    {
        $preExisting = $this->documents()->whereCategory($category)->first();
        if ($preExisting != null) {
            return $preExisting;
        }

        $newlyCreated = new Document([
            'category' => $category->value,
            'type' => Document::TYPE_DIGITAL,
            'state' => DocumentState::Missing,
            'name' => $category->displayName(),
            'owner_id' => $this->id,
        ]);

        $this->documents()->save($newlyCreated);

        return $newlyCreated;
    }

    /**
     * @return HasMany<Document>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'owner_id');
    }
}
