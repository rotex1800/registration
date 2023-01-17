<?php

namespace App\Exports;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RegistrationsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithStyles
{
    private Event $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    public function query(): Relation
    {
        return $this->event->attendees();
    }

    /**
     * @return string[]
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    /**
     * @param  Worksheet  $sheet
     * @return array<mixed>
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Vorname',
            'Nachname',
            'Referenznummer',
            'Geburtstag',
            'Summe bezahlt',
            'Geschlecht',
            'E-Mail',
            'Handy',
            'T-Shirt',
            'Ernährung',
            'Allergien',
            'Gesundheitliche Probleme',
            'Nationalität',
            'Passnummer',
            'Ausstellungsdatum',
            'Ablaufdatum',
            'Host Club',
            'Host Distrikt',
            'Sponsor Club',
            'Sponsor Distrikt',
            'Counselor',
            'Counselor Tel',
            'Counselor E-Mail',
            'YEO',
            'YEO Tel',
            'YEO E-Mail',
            'Mutter',
            'Vater',
            'Leibliche Eltern E-Mail',
            'Telefon',
            'Adresse',
            'Gastfamilie 1 Name',
            'Gastfamlilie 1 E-Mail',
            'Gastfamilie 1 Telefon',
            'Gastfamilie 1 Adresse',
            'Gastfamilie 2 Name',
            'Gastfamilie 2 E-Mail',
            'Gastfamilie 2 Telefon',
            'Gastfamilie 2 Adresse',
            'Gastfamilie 3 Name',
            'Gastfamilie 3 E-Mail',
            'Gastfamilie 3 Telefon',
            'Gastfamilie 3 Adresse',
            'Kommentar',
        ];
    }

    /**
     * @param  mixed  $user
     * @return array<int, array<int, mixed>>
     */
    public function map(mixed $user): array
    {
        if (! ($user instanceof User)) {
            return [];
        }

        return [
            [
                $user->first_name,
                $user->family_name,
                $this->transferReferenceForUser($user),
                $this->getExcelDate($user->birthday),
                $user->sumPaidFor($this->event),
                $user->gender,
                $user->email,
                $user->mobile_phone,
                $user->additionalInfo?->tshirt_size,
                $user->additionalInfo?->diet,
                $user->additionalInfo?->allergies,
                $user->health_issues,

                $user->passport?->nationality ?? '',
                $user->passport?->passport_number ?? '',
                $this->getExcelDate($user->passport?->issue_date),
                $this->getExcelDate($user->passport?->expiration_date),

                $user->rotaryInfo?->host_club ?? '',
                $user->rotaryInfo?->host_district ?? '',
                $user->rotaryInfo?->sponsor_club ?? '',
                $user->rotaryInfo?->sponsor_district ?? '',

                $user->counselor?->name ?? '',
                $user->counselor?->phone ?? '',
                $user->counselor?->email ?? '',

                $user->yeo?->name ?? '',
                $user->yeo?->phone ?? '',
                $user->yeo?->email ?? '',

                $user->bioFamily?->parent_one ?? '',
                $user->bioFamily?->parent_two ?? '',
                $user->bioFamily?->email ?? '',
                $user->bioFamily?->phone ?? '',
                // TODO: Add address for bio family
                //                $user->bioFamily?->address ?? '',

                $user->firstHostFamily()->name,
                $user->firstHostFamily()->phone,
                $user->firstHostFamily()->email,
                $user->firstHostFamily()->address,

                $user->secondHostFamily()->name,
                $user->secondHostFamily()->phone,
                $user->secondHostFamily()->email,
                $user->secondHostFamily()->address,

                $user->thirdHostFamily()->name,
                $user->thirdHostFamily()->phone,
                $user->thirdHostFamily()->email,
                $user->thirdHostFamily()->address,

                $user->registrationComment?->body ?? '',
            ],
        ];
    }

    public function transferReferenceForUser(User $user): string
    {
        return $user->short_name;
    }

    /**
     * @param  Carbon|null  $date
     * @return float|string
     */
    private function getExcelDate(?Carbon $date): float|string
    {
        if ($date == null) {
            return '';
        }

        return Date::dateTimeToExcel($date);
    }
}
