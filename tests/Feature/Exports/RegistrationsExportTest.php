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
        ->toContain($user->first_name)
        ->toContain($user->family_name)
        ->toContain(Date::dateTimeToExcel($user->birthday))
        ->toContain($user->gender)
        ->toContain($user->email)
        ->toContain($user->mobile_phone)
        ->toContain($user->health_issues)
        ->toContain($user->passport?->nationality ?? '')
        ->toContain($user->passport?->passport_number ?? '')
        ->toContain(Date::dateTimeToExcel($user->passport?->issue_date))
        ->toContain(Date::dateTimeToExcel($user->passport?->expiration_date))
        ->toContain($user->rotaryInfo?->host_club ?? '')
        ->toContain($user->rotaryInfo?->host_district ?? '')
        ->toContain($user->rotaryInfo?->sponsor_club ?? '')
        ->toContain($user->rotaryInfo?->sponsor_district ?? '')
        ->toContain($user->counselor?->name ?? '')
        ->toContain($user->counselor?->phone ?? '')
        ->toContain($user->counselor?->email ?? '')
        ->toContain($user->yeo?->name ?? '')
        ->toContain($user->yeo?->phone ?? '')
        ->toContain($user->yeo?->email ?? '')
        ->toContain($user->bioFamily?->parent_one ?? '')
        ->toContain($user->bioFamily?->parent_two ?? '')
        ->toContain($user->bioFamily?->email ?? '')
        ->toContain($user->bioFamily?->phone ?? '')
        // TODO: Add address for bio family
//        ->toContain($user->bioFamily->address)
        ->toContain($user->firstHostFamily()->name ?? '')
        ->toContain($user->firstHostFamily()->phone ?? '')
        ->toContain($user->firstHostFamily()->email ?? '')
        ->toContain($user->secondHostFamily()->name ?? '')
        ->toContain($user->secondHostFamily()->phone ?? '')
        ->toContain($user->secondHostFamily()->email ?? '')
        ->toContain($user->thirdHostFamily()->name ?? '')
        ->toContain($user->thirdHostFamily()->phone ?? '')
        ->toContain($user->thirdHostFamily()->email ?? '')
        ->toContain($user->registrationComment?->body ?? '');
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
