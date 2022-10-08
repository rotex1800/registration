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
