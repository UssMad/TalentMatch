<?php

namespace App\Enums;

enum Recommendation: string
{
    case StronglyRecommend = 'Strongly Recommend';
    case Recommend = 'Recommend';
    case Consider = 'Consider';
    case NotRecommended = 'Not Recommended';
    case NoDecision = 'No Decision';
}