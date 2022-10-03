<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasDocuments
{
    /**
     * @return HasMany
     * @phpstan-return HasMany<Document>
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'owner_id');
    }

    /**
     * @param  Document  $document
     * @return bool
     */
    public function owns(Document $document): bool
    {
        return $document->owner->id == $this->id;
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
}
