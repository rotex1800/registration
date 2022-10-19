<?php

namespace App\Models;

enum DocumentCategory: string
{
    case AppfCopy = 'appf-copy';
    case InsurancePolice = 'insurance';
    case Motivation = 'motivation';
    case PassportCopy = 'passport';
    case Picture = 'picture';
    case ResidencePermit = 'residence-permit';
    case Rules = 'rules';
    case SchoolCertificate = 'school-certificate';

    case Unknown = 'unknown';

    public static function read(?string $value): DocumentCategory
    {
        if ($value == null) {
            return DocumentCategory::Unknown;
        }

        return DocumentCategory::from($value);
    }

    public function displayName(): string
    {
        return match ($this) {
            self::Rules => __('registration.rules'),
            self::InsurancePolice => __('registration.insurance-policy'),
            self::Motivation => __('registration.motivation'),
            self::PassportCopy => __('registration.passport-copy'),
            self::Picture => __('registration.picture'),
            self::ResidencePermit => __('registration.residence-permit'),
            self::SchoolCertificate => __('registration.school-certificate'),
            self::AppfCopy => __('registration.appf-copy'),
            default => 'unknown',
        };
    }
}
