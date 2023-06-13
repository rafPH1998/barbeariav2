<?php

namespace App\Enums;

enum AvailableTimeEnum: string
{
    case NOVE_HORAS   = '09:00';
    case DEZ_HORAS    = '10:00';
    case ONZE_HORAS   = '11:00';
    case MEIO_DIA     = '12:00';
    case UMA_HORA     = '13:00';
    case DUAS_HORAS   = '14:00';
    case TRES_HORAS   = '15:00';
    case QUATRO_HORAS = '16:00';
    case CINCO_HORAS  = '17:00';
    case SEIS_HORAS   = '18:00';
    case SETE_HORAS   = '19:00';
    case OITO_HORAS   = '20:00';
}