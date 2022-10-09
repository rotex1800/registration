<div class="flex flex-row justify-around">
    <div>
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::Rules"
        />
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::AppfCopy"
        />
    </div>

    <div>
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::InsurancePolice"
        />
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::PassportCopy"
        />
    </div>

    <div>
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::ResidencePermit"
        />
        <livewire:documents-rater
            :user="$user"
            :category="\App\Models\DocumentCategory::SchoolCertificate"
        />
    </div>

    <div>
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
