<?php

namespace ColorzExporter\Controller;

use ColorzExporter\Service\Export\MembersCsvExporter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExportMembersCsv extends AbstractController
{
    private MembersCsvExporter $exporter;

    public function __construct(MembersCsvExporter $exporter)
    {
        $this->exporter = $exporter;
    }

    #[Route('/members/csv', name: 'export_team_members', methods: 'GET')]
    public function index(): Response
    {
        $jsonSample = '{
                    "teams" : [
                    {
                        "squadName": "Super hero squad",
                        "homeTown": "Metro City",
                        "formed": 2016,
                        "secretBase": "Super tower",
                        "active": true,
                        "members": [
                            {
                                "name": "Molecule Man",
                                "age": 29,
                                "secretIdentity": "Dan Jukes",
                                "powers": [
                                    "Radiation resistance",
                                    "Turning tiny",
                                    "Radiation blast"
                                ]
                            },
                            {
                                "name": "Madame Uppercut",
                                "age": 39,
                                "secretIdentity": "Jane Wilson",
                                "powers": [
                                    "Million tonne punch",
                                    "Damage resistance",
                                    "Superhuman reflexes"
                                ]
                            },
                            {
                                "name": "Eternal Flame",
                                "age": 1000000,
                                "secretIdentity": "Unknown",
                                "powers": [
                                    "Immortality",
                                    "Heat Immunity",
                                    "Inferno",
                                    "Teleportation",
                                    "Interdimensional travel"
                                ]
                            }
                        ]
                    },
                    {
                        "squadName": "Super Vilain squad",
                        "homeTown": "Meudon City",
                        "formed": 2019,
                        "secretBase": "Under Town",
                        "active": true,
                        "members": []
                    },
                    {
                        "squadName": "Useless Team",
                        "homeTown": "Bar",
                        "formed": 2021,
                        "secretBase": "Le Debonnaire",
                        "active": true,
                        "members": [
                            {
                                "name": "Slowy",
                                "age": 29,
                                "secretIdentity": "Speedy No Gonzales",
                                "powers": [
                                    "Hyper slowing writer",
                                    "Always late"
                                ]
                            },
                            {
                                "name": "Jumpy",
                                "age": 39,
                                "secretIdentity": "Bugs D.Bunny ",
                                "powers": [
                                    "Jump 2 feet up",
                                    "Never stop jumping"
                                ]
                            },
                            {
                                "name": "Cuty Baby",
                                "age": 1,
                                "secretIdentity": "Unknown",
                                "powers": [
                                    "Cry a lot"
                                ]
                            }
                        ]
                    },
                    {
                        "squadName": "The Oldest",
                        "homeTown": "Dust",
                        "formed": 184,
                        "secretBase": "Under Dust",
                        "active": false,
                        "members": [
                            {
                                "name": "Daddy Cool",
                                "age": 93822,
                                "secretIdentity": "Bobby Farrell",
                                    "powers": [
                                    "Sing to charm"
                                ]
                            },
                            {
                                "name": "Missy Elliot",
                                "age": 45342,
                                "secretIdentity": "Melissa Arnette",
                                "powers": [
                                    "Infernal groove",
                                    "Burn all dancefloors"
                                ]
                            },
                            {
                                "name": "Liz Mitchell",
                                "age": 3245342,
                                "secretIdentity": "Unknown",
                                "powers": [
                                    "Mortality",
                                    "Invisibility"
                                ]
                            }
                        ]
                    }
                ]
            }';

        $this->exporter->export($jsonSample);

        return new Response('it worked ! check the latest CSV file in public/');
    }
}
