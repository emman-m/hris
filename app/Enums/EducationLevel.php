<?php

namespace App\Enums;

enum EducationLevel: string
{
    case ELEMENTARY = 'Elementary';
    case HIGHSCHOOL = 'High School';
    case UNDERGRADUATE = 'Under Graduate';
    case GRADUATE = 'Graduate';
    case POSTGRADUATE = 'Post Graduate';
}