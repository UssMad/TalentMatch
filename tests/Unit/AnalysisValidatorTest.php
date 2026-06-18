<?php

use App\Services\AnalysisValidator;

beforeEach(function () {
    $this->validator = new AnalysisValidator;
    $this->validData = [
        'extracted_skills' => ['PHP', 'Laravel'],
        'years_of_experience' => 5,
        'education_level' => "Master's",
        'languages' => ['English', 'French'],
        'matching_score' => 85,
        'strengths' => ['Strong backend skills'],
        'weaknesses' => ['No frontend experience'],
        'missing_skills' => ['Docker'],
        'recommendation' => 'convoquer',
        'justification' => 'Strong match for the role',
    ];
});

test('passes with valid data', function () {
    $result = $this->validator->validate($this->validData);

    expect($result)->toBeTrue();
    expect($this->validator->getErrors())->toBe([]);
});

test('fails when required fields are missing', function () {
    $result = $this->validator->validate([]);

    expect($result)->toBeFalse();
    expect($this->validator->getErrors())->not->toBeEmpty();
});

test('fails with missing extracted_skills', function () {
    unset($this->validData['extracted_skills']);
    $result = $this->validator->validate($this->validData);

    expect($result)->toBeFalse();
});

test('fails with invalid matching_score', function () {
    $this->validData['matching_score'] = 150;
    expect($this->validator->validate($this->validData))->toBeFalse();

    $this->validData['matching_score'] = -1;
    expect($this->validator->validate($this->validData))->toBeFalse();

    $this->validData['matching_score'] = 'not-int';
    expect($this->validator->validate($this->validData))->toBeFalse();
});

test('fails with invalid recommendation', function () {
    $this->validData['recommendation'] = 'invalid';
    expect($this->validator->validate($this->validData))->toBeFalse();
});

test('accepts all valid recommendation values', function () {
    foreach (['convoquer', 'attente', 'rejeter'] as $rec) {
        $this->validData['recommendation'] = $rec;
        expect($this->validator->validate($this->validData))->toBeTrue();
    }
});

test('fails with invalid years_of_experience', function () {
    $this->validData['years_of_experience'] = -1;
    expect($this->validator->validate($this->validData))->toBeFalse();

    $this->validData['years_of_experience'] = 'not-int';
    expect($this->validator->validate($this->validData))->toBeFalse();
});

test('fails with empty education_level', function () {
    $this->validData['education_level'] = '';
    expect($this->validator->validate($this->validData))->toBeFalse();
});

test('fails with empty justification', function () {
    $this->validData['justification'] = '';
    expect($this->validator->validate($this->validData))->toBeFalse();
});

test('fails when arrays are not arrays', function () {
    $this->validData['extracted_skills'] = 'not-an-array';
    expect($this->validator->validate($this->validData))->toBeFalse();

    $this->validData['languages'] = 'not-an-array';
    expect($this->validator->validate($this->validData))->toBeFalse();
});
