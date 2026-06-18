<?php

use App\DTOs\AnalysisData;

test('can create AnalysisData from array', function () {
    $data = AnalysisData::fromArray([
        'extracted_skills' => ['PHP', 'Laravel', 'MySQL'],
        'years_of_experience' => 5,
        'education_level' => "Master's",
        'languages' => ['English', 'French'],
        'matching_score' => 85,
        'strengths' => ['Strong backend skills'],
        'weaknesses' => ['No frontend experience'],
        'missing_skills' => ['Docker'],
        'recommendation' => 'convoquer',
        'justification' => 'Strong match for the role',
    ]);

    expect($data)->toBeInstanceOf(AnalysisData::class);
    expect($data->extractedSkills)->toBe(['PHP', 'Laravel', 'MySQL']);
    expect($data->yearsOfExperience)->toBe(5);
    expect($data->educationLevel)->toBe("Master's");
    expect($data->languages)->toBe(['English', 'French']);
    expect($data->matchingScore)->toBe(85);
    expect($data->strengths)->toBe(['Strong backend skills']);
    expect($data->weaknesses)->toBe(['No frontend experience']);
    expect($data->missingSkills)->toBe(['Docker']);
    expect($data->recommendation)->toBe('convoquer');
    expect($data->justification)->toBe('Strong match for the role');
});

test('AnalysisData toArray returns correct keys', function () {
    $data = AnalysisData::fromArray([
        'extracted_skills' => ['PHP'],
        'years_of_experience' => 3,
        'education_level' => "Bachelor's",
        'languages' => ['English'],
        'matching_score' => 70,
        'strengths' => ['Fast learner'],
        'weaknesses' => ['Junior'],
        'missing_skills' => ['AWS'],
        'recommendation' => 'attente',
        'justification' => 'Needs more experience',
    ]);

    $array = $data->toArray();

    expect($array)->toHaveKeys([
        'extracted_skills', 'years_of_experience', 'education_level',
        'languages', 'matching_score', 'strengths', 'weaknesses',
        'missing_skills', 'recommendation', 'justification',
    ]);
    expect($array['matching_score'])->toBe(70);
    expect($array['recommendation'])->toBe('attente');
});

test('AnalysisData defaults for missing fields', function () {
    $data = AnalysisData::fromArray([]);

    expect($data->extractedSkills)->toBe([]);
    expect($data->yearsOfExperience)->toBe(0);
    expect($data->educationLevel)->toBe('');
    expect($data->languages)->toBe([]);
    expect($data->matchingScore)->toBe(0);
    expect($data->strengths)->toBe([]);
    expect($data->weaknesses)->toBe([]);
    expect($data->missingSkills)->toBe([]);
    expect($data->recommendation)->toBe('');
    expect($data->justification)->toBe('');
});
