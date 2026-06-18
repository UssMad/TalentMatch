<?php

use App\Enums\Recommendation;

test('enum has three cases', function () {
    $cases = Recommendation::cases();

    expect($cases)->toHaveCount(3);
});

test('enum values are correct', function () {
    expect(Recommendation::Convoquer->value)->toBe('convoquer');
    expect(Recommendation::Attente->value)->toBe('attente');
    expect(Recommendation::Rejeter->value)->toBe('rejeter');
});

test('enum can be backed from string', function () {
    $convoquer = Recommendation::from('convoquer');
    $attente = Recommendation::from('attente');
    $rejeter = Recommendation::from('rejeter');

    expect($convoquer)->toBe(Recommendation::Convoquer);
    expect($attente)->toBe(Recommendation::Attente);
    expect($rejeter)->toBe(Recommendation::Rejeter);
});

test('enum tryFrom returns null for invalid value', function () {
    $result = Recommendation::tryFrom('invalid');

    expect($result)->toBeNull();
});
