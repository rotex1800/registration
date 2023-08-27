<?php

use App\Exports\RegistrationsExport;
use App\Models\AdditionalInfo;
use App\Models\BioFamily;
use App\Models\CounselorInfo;
use App\Models\Event;
use App\Models\HostFamily;
use App\Models\Passport;
use App\Models\Payment;
use App\Models\RegistrationComment;
use App\Models\User;
use App\Models\YeoInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

uses(RefreshDatabase::class);

it('contains expected columns', function () {
    $payment = Payment::factory()->make();
    $event = Event::factory()->create();
    $event->payments()->save($payment);
    $user = User::factory()->create();
    $user->payments()->save($payment);

    $user->yeo()->save(YeoInfo::factory()->make());

    $user->counselor()->save(CounselorInfo::factory()->make());

    $user->passport()->save(Passport::factory()->create());

    $user->bioFamily()->save(BioFamily::factory()->make());

    $user->registrationComment()->save(RegistrationComment::factory()->make());

    $user->hostFamilies()->save(HostFamily::factory()->nth(1)->make());
    $user->hostFamilies()->save(HostFamily::factory()->nth(2)->make());
    $user->hostFamilies()->save(HostFamily::factory()->nth(3)->make());

    $user->additionalInfo()->save(AdditionalInfo::factory()->make());

    $event->attendees()->save($user);

    $export = new RegistrationsExport($event);
    expect($export->map($user))
        ->toHaveLength(1)
        ->and($export->map($user)[0])
        ->toContain(
            $user->first_name,
            $user->family_name,
            $export->transferReferenceForUser($user),
            Date::dateTimeToExcel($user->birthday),
            $user->sumPaidFor($event),
            $user->additionalInfo->note ?? '',
            $user->gender,
            $user->email,
            $user->mobile_phone,
            $user->additionalInfo?->tshirt_size?->displayName() ?? '',
            $user->additionalInfo?->diet ?? '',
            $user->additionalInfo?->allergies ?? '',
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
            //        ->toContain($user->bioFamily->address),
            $user->firstHostFamily()->name ?? '',
            $user->firstHostFamily()->phone ?? '',
            $user->firstHostFamily()->email ?? '',
            $user->firstHostFamily()->address ?? '',
            $user->secondHostFamily()->name ?? '',
            $user->secondHostFamily()->phone ?? '',
            $user->secondHostFamily()->email ?? '',
            $user->secondHostFamily()->address ?? '',
            $user->thirdHostFamily()->name ?? '',
            $user->thirdHostFamily()->phone ?? '',
            $user->thirdHostFamily()->email ?? '',
            $user->thirdHostFamily()->address ?? '',
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
            'Referenznummer',
            'Geburtstag',
            'Summe bezahlt',
            'Notiz',
            'Geschlecht',
            'E-Mail',
            'Handy',
            'T-Shirt',
            'Ernährung',
            'Allergien',
            // TODO: Add address for bio family
            //        ->toContain($user->bioFamily->address)
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
            'Kommentar'
        );
});

it('formats dates columns correctly', function () {
    $event = Event::factory()->create();
    $export = new RegistrationsExport($event);
    expect($export->columnFormats())
        ->toHaveKey('D', NumberFormat::FORMAT_DATE_DDMMYYYY)
        ->toHaveKey('O', NumberFormat::FORMAT_DATE_DDMMYYYY)
        ->toHaveKey('P', NumberFormat::FORMAT_DATE_DDMMYYYY);
});

it('applies bold style to first row', function () {
    $event = Event::factory()->create();
    $export = new RegistrationsExport($event);

    expect($export->styles(new Worksheet()))
        ->toBeArray()
        ->toHaveKey(1, ['font' => ['bold' => true]]);
});

test('map returns empty string when not given a user', function () {
    $event = Event::factory()->create();
    $export = new RegistrationsExport($event);

    expect($export->map(''))
        ->toBe([]);
});

it('can create transfer reference for a user', function () {
    $event = Event::factory()->state([
        'name' => 'Awesome Tour',
        'start' => Carbon::parse('2023-05-06'),
    ])->make();
    $export = new RegistrationsExport($event);

    $user = User::factory()->state([
        'first_name' => 'Foo Bar',
        'family_name' => 'Simpson',
        'birthday' => '2002-11-28',
    ])->create();

    expect($export->transferReferenceForUser($user))
        ->toBe('FBS-2811');
});
