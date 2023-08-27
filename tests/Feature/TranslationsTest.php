<?php

it('Overrides Default verification Mail text in german', function () {
    expect(Lang::get('Verify Email Address'))->toBe('E-Mail Adresse bestätigen')
        ->and(Lang::get('Verify Email Address',
            locale: 'de'))->toBe('E-Mail Adresse bestätigen')
        ->and(Lang::get('Please click the button below to verify your email address.'))->toBe('Bitte klicke auf den Button um deine E-Mail Adresse zu bestätigen')
        ->and(Lang::get('If you did not create an account, no further action is required.'))->toBe('Wenn du keinen Account erstellt hast, musst du nichts weiter tun.')
        ->and(Lang::get("If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\ninto your web browser:"))->toBe('Wenn du den ":actionText" Knopf nicht anklicken kannst, kopiere den Link unten und und füge ihn in deinen Browser ein.')
        ->and(Lang::get('Regards'))->toBe('Viele Grüße')
        ->and(Lang::get('Hello!'))->toBe('Hallo!');
});

it('Uses german as default locale', function () {
    expect(Lang::get('Verify Email Address'))->toBe('E-Mail Adresse bestätigen');
});

it('Overrides Password Reset Mail text in german', function () {
    expect(Lang::get('passwords.sent'))->toBe('Wir haben wir eine E-Mail für den Passwort-Reset geschickt')
        ->and(Lang::get('passwords.reset'))->toBe('Dein Passwort wurde zurück gesetzt')
        ->and(Lang::get('signup.update-password'))->toBe('Passwort aktualisieren')
        ->and(Lang::get('signup.new-password'))->toBe('Neues Passwort')
        ->and(Lang::get('signup.new-password-confirmation'))->toBe('Neues Passwort wiederholen')
        ->and(Lang::get('You are receiving this email because we received a password reset request for your account.'))
        ->toBe('Du erhältst diese E-Mail weil ein Passwort-Reset für deinen Account angefragt wurde.')
        ->and(Lang::get('Reset Password'))
        ->toBe('Passwort zurücksetzen')
        ->and(Lang::get('If you did not request a password reset, no further action is required.'))
        ->toBe('Wenn du keinen Reset angefordert hast, musst du nichts weiter tun.')
        ->and(Lang::get('This password reset link will expire in :count minutes.'))
        ->toBe('Dieser Reset Link wird in :count Minuten ablaufen.');
});

it('Overrides validation messages in german', function () {
    expect(Lang::get('validation.numeric'))->toBe('Der :attribute muss eine Zahl sein.');
});
