<?php

namespace App\Enums;

enum SpaceType : string
{
    use CasesAsOptions;
    case SS_on_M = 'SS on M';
    case Video_on_M = 'Video on M';
    case SS_on_RT = 'SS on RT';
    case Video_on_RT = 'Video on RT';
}
