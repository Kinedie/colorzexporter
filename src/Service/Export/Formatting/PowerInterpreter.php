<?php

namespace ColorzExporter\Service\Export\Formatting;

use ColorzExporter\Exception\NonExistingPowerException;
use ColorzExporter\Model\PowerCode;

final class PowerInterpreter
{
    /**
     * @throws NonExistingPowerException
     */
    public function getPowerCode(string $name): PowerCode|string
    {
        return match (mb_strtolower($name))
        {
            'always late' => PowerCode::AlwaysLate->value,
            'burn all dancefloors' => PowerCode::BurnAllDanceFloors->value,
            'cheese control' => PowerCode::CheeseControl->value,
            'cry a lot' => PowerCode::CryALot->value,
            'damage resistance' => PowerCode::DamageResistance->value,
            'drink really fast' => PowerCode::DrinkReallyFast->value,
            'heat immunity' => PowerCode::HeatImmunity->value,
            'hyper slowing writer' => PowerCode::HyperSlowingWriter->value,
            'immortality' => PowerCode::Immortality->value,
            'infernal groove' => PowerCode::InfernalGroove->value,
            'inferno' => PowerCode::Inferno->value,
            'interdimensional travel' => PowerCode::InterdimensionalTravel->value,
            'invisibility' => PowerCode::Invisibility->value,
            'jump 2 feet up' => PowerCode::Jump2FeetUp->value,
            'million tonne punch' => PowerCode::MillionTonnePunch->value,
            'mortality' => PowerCode::Mortality->value,
            'never stop jumping' => PowerCode::NeverStopJumping->value,
            'radiation blast' => PowerCode::RadiationBlast->value,
            'radiation resistance' => PowerCode::RadiationResistance->value,
            'sing to charm' => PowerCode::SingToCharm->value,
            'superhuman reflexes' => PowerCode::SuperhumanReflexes->value,
            'teleportation' => PowerCode::Teleportation->value,
            'turning tiny' => PowerCode::TurningTiny->value,
            default => throw new NonExistingPowerException('This power does not exist : ' . $name, 400)
        };
    }
}
