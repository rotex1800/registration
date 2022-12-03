<?php

namespace App\Models;

enum DocumentState: string
{
    case Submitted = 'submitted';
    case Approved = 'approved';
    case Declined = 'declined';
    case Missing = 'missing';

    /**
     * @param  DocumentState[]  $states
     * @return DocumentState[]
     */
    public static function sort(array $states): array
    {
        usort($states, function (?DocumentState $lhs, ?DocumentState $rhs): int {
            if ($lhs == null && $rhs == null) {
                return 0;
            }
            if ($lhs == null) {
                return 1;
            }
            if ($rhs == null) {
                return -1;
            }

            return $lhs->compareTo($rhs);
        });

        return $states;
    }

    public function compareTo(DocumentState $other): int
    {
        $thisIntValue = $this->intValue();
        $otherIntValue = $other->intValue();

        if ($thisIntValue < $otherIntValue) {
            return -1;
        }
        if ($thisIntValue > $otherIntValue) {
            return 1;
        }

        return 0;
    }

    private function intValue(): int
    {
        return match ($this) {
            self::Submitted => 2,
            self::Approved => 3,
            self::Declined => 1,
            self::Missing => 0,
        };
    }

    public function displayName(): string
    {
        return match ($this) {
            self::Submitted => '⬆️',
            self::Approved => '✅',
            self::Declined => '⛔️',
            self::Missing => '🤷‍',
        };
    }
}
