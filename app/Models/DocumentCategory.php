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
    case SchoolCertificate = 'school-certificate';

    case Unknown = 'unknown';
}
