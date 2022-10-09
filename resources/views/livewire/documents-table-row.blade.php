<div class="flex flex-row">
    <div class="flex-col">
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::Rules"
        />
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::AppfCopy"
        />
    </div>

    <div class="flex-col">
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::InsurancePolice"
        />
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::PassportCopy"
        />
    </div>

    <div class="flex-col">
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::ResidencePermit"
        />
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::SchoolCertificate"
        />
    </div>

    <div class="flex-col">
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::Picture"
        />
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::Motivation"
        />
    </div>
</div>
