<?php

namespace App\Models;

enum DocumentCategory: string
{
    case AppfOriginal = 'appf-original';
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

    /**
     * @return DocumentCategory[]
     */
    public static function validCategories(): array
    {
        return [
            self::AppfOriginal, self::AppfCopy, self::InsurancePolice, self::Motivation, self::PassportCopy,
            self::Picture, self::ResidencePermit, self::Rules, self::SchoolCertificate,
        ];
    }

    public function displayName(): string
    {
        return strval(match ($this) {
            self::Rules => __('registration.rules'),
            self::InsurancePolice => __('registration.insurance-policy'),
            self::Motivation => __('registration.motivation'),
            self::PassportCopy => __('registration.passport-copy'),
            self::Picture => __('registration.picture'),
            self::ResidencePermit => __('registration.residence-permit'),
            self::SchoolCertificate => __('registration.school-certificate'),
            self::AppfCopy => __('registration.appf-copy'),
            self::AppfOriginal => __('registration.appf-original'),
            default => 'unknown',
        });
    }
}
