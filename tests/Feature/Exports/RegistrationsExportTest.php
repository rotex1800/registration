<?php

use App\Exports\RegistrationsExport;
use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\RegistrationComment;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

uses(RefreshDatabase::class);

it('contains expected columns', function () {
    $event = Event::factory()->create();
    $user = User::factory()->create();

    $user->yeo()->save(YeoInfo::factory()->make());

    $user->counselor()->save(CounselorInfo::factory()->make());

    $user->passport()->save(Passport::factory()->create());

    $user->bioFamily()->save(BioFamily::factory()->make());

    $user->registrationComment()->save(RegistrationComment::factory()->make());

    $user->hostFamilies()->save(HostFamily::factory()->nth(1)->make());
    $user->hostFamilies()->save(HostFamily::factory()->nth(2)->make());
    $user->hostFamilies()->save(HostFamily::factory()->nth(3)->make());

    $event->attendees()->save($user);

    $export = new RegistrationsExport($event);
    expect($export->map($user))
        ->toHaveLength(1)
        ->and($export->map($user)[0])
        ->toContain(
            $user->first_name,
            $user->family_name,
            Date::dateTimeToExcel($user->birthday),
            $user->gender,
            $user->email,
            $user->mobile_phone,
            $user->health_issues,
            $user->passport?->nationality ?? '',
            $user->passport?->passport_number ?? '',
            Date::dateTimeToExcel($user->passport?->issue_date),
            Date::dateTimeToExcel($user->passport?->expiration_date),
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
//        ->toContain($user->bioFamily->address)
            $user->firstHostFamily()->name ?? '',
            $user->firstHostFamily()->phone ?? '',
            $user->firstHostFamily()->email ?? '',
            $user->secondHostFamily()->name ?? '',
            $user->secondHostFamily()->phone ?? '',
            $user->secondHostFamily()->email ?? '',
            $user->thirdHostFamily()->name ?? '',
            $user->thirdHostFamily()->phone ?? '',
            $user->thirdHostFamily()->email ?? '',
            $user->registrationComment?->body ?? ''
        );
});

it('contains expected headings', function () {
    $event = Event::factory()->create();
    $export = new RegistrationsExport($event);
    expect($export->headings())
        ->toBeArray()
        ->toContain(
            'Vorname',
            'Nachname',
            'Geburtstag',
            'Geschlecht',
            'E-Mail',
            'Handy',
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
//            "Gastfamilie 1 Adresse",
            'Gastfamilie 2 Name',
            'Gastfamilie 2 E-Mail',
            'Gastfamilie 2 Telefon',
//            "Gastfamilie 2 Adresse",
            'Gastfamilie 3 Name',
            'Gastfamilie 3 E-Mail',
            'Gastfamilie 3 Telefon',
//            "Gastfamilie 3 Adresse",
            'Kommentar'
        );
});

it('formats dates columns correctly', function () {
    $event = Event::factory()->create();
    $export = new RegistrationsExport($event);
    $columnFormats = $export->columnFormats();

    expect($columnFormats)
        ->toHaveKey('C', NumberFormat::FORMAT_DATE_DDMMYYYY)
        ->toHaveKey('J', NumberFormat::FORMAT_DATE_DDMMYYYY)
        ->toHaveKey('K', NumberFormat::FORMAT_DATE_DDMMYYYY);
});
