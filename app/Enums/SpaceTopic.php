<?php

namespace App\Enums;

enum SpaceTopic: string
{
    use CasesAsOptions;
    case Ai = 'Ai';
    case Memecoin = 'Memecoin';
    case Defi = 'Defi';
    case RWA = 'RWA';
    case Gaming = 'Gaming';
    case NFT = 'NFT';
    case Web3 = 'Web3';
    case SocialFi = 'SocialFi';
    case Countdown = 'Countdown';
}
