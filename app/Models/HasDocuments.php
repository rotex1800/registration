<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasDocuments
{
    /**
     * @param  Document  $document
     * @return bool
     */
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
     *
     * @param  ?DocumentCategory  $category
     * @return Document|null
     */
    public function documentBy(?DocumentCategory $category): ?Document
    {
        return $this->documents()->whereCategory($category)->first();
    }

    /**
     * @return HasMany
     * @phpstan-return HasMany<Document>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'owner_id');
    }
}
