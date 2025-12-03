<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RankedController extends Controller
{
    /**
     * Display the Ranked System page with MMR ranges for all game modes
     */
    public function index()
    {
        // MMR ranges per gamemode with all divisions
        // Data sources: Rocket League Tracker Network (2024-2025 Season)

        $gamemodes = [
            'doubles' => [
                'name' => 'Ranked Doubles 2v2',
                'ranks' => [
                    [
                        'rank' => 'Supersonic Legend',
                        'image' => 'SSL.png',
                        'divisions' => [
                            'I' => '1861 — 2108',
                            'II' => '—',
                            'III' => '—',
                            'IV' => '—'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion III',
                        'image' => 'GC3.png',
                        'divisions' => [
                            'I' => '1715 — 1737',
                            'II' => '1744 — 1775',
                            'III' => '1788 — 1815',
                            'IV' => '1832 — 1859'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion II',
                        'image' => 'GC2.png',
                        'divisions' => [
                            'I' => '1575 — 1597',
                            'II' => '1600 — 1636',
                            'III' => '1638 — 1660',
                            'IV' => '1677 — 1700'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion I',
                        'image' => 'GC1.png',
                        'divisions' => [
                            'I' => '1435 — 1458',
                            'II' => '1462 — 1495',
                            'III' => '1498 — 1534',
                            'IV' => '1537 — 1559'
                        ]
                    ],
                    [
                        'rank' => 'Champion III',
                        'image' => 'C3.png',
                        'divisions' => [
                            'I' => '1314 — 1333',
                            'II' => '1334 — 1367',
                            'III' => '1368 — 1397',
                            'IV' => '1402 — 1419'
                        ]
                    ],
                    [
                        'rank' => 'Champion II',
                        'image' => 'C2.png',
                        'divisions' => [
                            'I' => '1195 — 1213',
                            'II' => '1214 — 1247',
                            'III' => '1248 — 1280',
                            'IV' => '1282 — 1299'
                        ]
                    ],
                    [
                        'rank' => 'Champion I',
                        'image' => 'C1.png',
                        'divisions' => [
                            'I' => '1075 — 1093',
                            'II' => '1094 — 1127',
                            'III' => '1128 — 1160',
                            'IV' => '1162 — 1180'
                        ]
                    ],
                    [
                        'rank' => 'Diamond III',
                        'image' => 'D3.png',
                        'divisions' => [
                            'I' => '935 — 1003',
                            'II' => '1004 — 1027',
                            'III' => '1028 — 1051',
                            'IV' => '1052 — 1065'
                        ]
                    ],
                    [
                        'rank' => 'Diamond II',
                        'image' => 'D2.png',
                        'divisions' => [
                            'I' => '915 — 923',
                            'II' => '924 — 947',
                            'III' => '900 — 971',
                            'IV' => '972 — 988'
                        ]
                    ],
                    [
                        'rank' => 'Diamond I',
                        'image' => 'D1.png',
                        'divisions' => [
                            'I' => '827 — 843',
                            'II' => '844 — 867',
                            'III' => '868 — 891',
                            'IV' => '892 — 900'
                        ]
                    ],
                    [
                        'rank' => 'Platinum III',
                        'image' => 'P3.png',
                        'divisions' => [
                            'I' => '767 — 778',
                            'II' => '779 — 797',
                            'III' => '798 — 816',
                            'IV' => '817 — 829'
                        ]
                    ],
                    [
                        'rank' => 'Platinum II',
                        'image' => 'P2.png',
                        'divisions' => [
                            'I' => '710 — 718',
                            'II' => '719 — 737',
                            'III' => '738 — 756',
                            'IV' => '757 — 774'
                        ]
                    ],
                    [
                        'rank' => 'Platinum I',
                        'image' => 'P1.png',
                        'divisions' => [
                            'I' => '641 — 658',
                            'II' => '659 — 677',
                            'III' => '678 — 696',
                            'IV' => '697 — 705'
                        ]
                    ],
                    [
                        'rank' => 'Gold III',
                        'image' => 'G3.png',
                        'divisions' => [
                            'I' => '593 — 598',
                            'II' => '599 — 617',
                            'III' => '618 — 636',
                            'IV' => '637 — 648'
                        ]
                    ],
                    [
                        'rank' => 'Gold II',
                        'image' => 'G2.png',
                        'divisions' => [
                            'I' => '532 — 538',
                            'II' => '539 — 557',
                            'III' => '558 — 576',
                            'IV' => '577 — 588'
                        ]
                    ],
                    [
                        'rank' => 'Gold I',
                        'image' => 'G1.png',
                        'divisions' => [
                            'I' => '472 — 478',
                            'II' => '479 — 497',
                            'III' => '498 — 516',
                            'IV' => '517 — 526'
                        ]
                    ],
                    [
                        'rank' => 'Silver III',
                        'image' => 'Z3.png',
                        'divisions' => [
                            'I' => '414 — 418',
                            'II' => '419 — 437',
                            'III' => '438 — 456',
                            'IV' => '457 — 467'
                        ]
                    ],
                    [
                        'rank' => 'Silver II',
                        'image' => 'Z2.png',
                        'divisions' => [
                            'I' => '353 — 358',
                            'II' => '359 — 377',
                            'III' => '378 — 396',
                            'IV' => '397 — 406'
                        ]
                    ],
                    [
                        'rank' => 'Silver I',
                        'image' => 'Z1.png',
                        'divisions' => [
                            'I' => '293 — 298',
                            'II' => '299 — 317',
                            'III' => '318 — 336',
                            'IV' => '337 — 345'
                        ]
                    ],
                    [
                        'rank' => 'Bronze III',
                        'image' => 'Brons3.png',
                        'divisions' => [
                            'I' => '228 — 238',
                            'II' => '233 — 257',
                            'III' => '258 — 276',
                            'IV' => '277 — 284'
                        ]
                    ],
                    [
                        'rank' => 'Bronze II',
                        'image' => 'Brons2.png',
                        'divisions' => [
                            'I' => '172 — 178',
                            'II' => '173 — 197',
                            'III' => '198 — 216',
                            'IV' => '217 — 220'
                        ]
                    ],
                    [
                        'rank' => 'Bronze I',
                        'image' => 'Brons1.png',
                        'divisions' => [
                            'I' => '< 172',
                            'II' => '—',
                            'III' => '—',
                            'IV' => '—'
                        ]
                    ],
                ]
            ],
            'duel' => [
                'name' => 'Ranked Duel 1v1',
                'ranks' => [
                    [
                        'rank' => 'Supersonic Legend',
                        'image' => 'SSL.png',
                        'divisions' => [
                            'I' => '1355+',
                            'II' => '—',
                            'III' => '—',
                            'IV' => '—'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion III',
                        'image' => 'GC3.png',
                        'divisions' => [
                            'I' => '1286 — 1303',
                            'II' => '1304 — 1320',
                            'III' => '1321 — 1337',
                            'IV' => '1338 — 1354'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion II',
                        'image' => 'GC2.png',
                        'divisions' => [
                            'I' => '1225 — 1240',
                            'II' => '1241 — 1255',
                            'III' => '1256 — 1270',
                            'IV' => '1271 — 1285'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion I',
                        'image' => 'GC1.png',
                        'divisions' => [
                            'I' => '1175 — 1187',
                            'II' => '1188 — 1199',
                            'III' => '1200 — 1212',
                            'IV' => '1213 — 1224'
                        ]
                    ],
                    [
                        'rank' => 'Champion III',
                        'image' => 'C3.png',
                        'divisions' => [
                            'I' => '1106 — 1123',
                            'II' => '1124 — 1140',
                            'III' => '1141 — 1157',
                            'IV' => '1158 — 1174'
                        ]
                    ],
                    [
                        'rank' => 'Champion II',
                        'image' => 'C2.png',
                        'divisions' => [
                            'I' => '1045 — 1060',
                            'II' => '1061 — 1075',
                            'III' => '1076 — 1090',
                            'IV' => '1091 — 1105'
                        ]
                    ],
                    [
                        'rank' => 'Champion I',
                        'image' => 'C1.png',
                        'divisions' => [
                            'I' => '995 — 1007',
                            'II' => '1008 — 1019',
                            'III' => '1020 — 1032',
                            'IV' => '1033 — 1044'
                        ]
                    ],
                    [
                        'rank' => 'Diamond III',
                        'image' => 'D3.png',
                        'divisions' => [
                            'I' => '926 — 943',
                            'II' => '944 — 960',
                            'III' => '961 — 977',
                            'IV' => '978 — 994'
                        ]
                    ],
                    [
                        'rank' => 'Diamond II',
                        'image' => 'D2.png',
                        'divisions' => [
                            'I' => '866 — 881',
                            'II' => '882 — 896',
                            'III' => '897 — 910',
                            'IV' => '911 — 925'
                        ]
                    ],
                    [
                        'rank' => 'Diamond I',
                        'image' => 'D1.png',
                        'divisions' => [
                            'I' => '806 — 821',
                            'II' => '822 — 836',
                            'III' => '837 — 850',
                            'IV' => '851 — 865'
                        ]
                    ],
                    [
                        'rank' => 'Platinum III',
                        'image' => 'P3.png',
                        'divisions' => [
                            'I' => '746 — 761',
                            'II' => '762 — 776',
                            'III' => '777 — 790',
                            'IV' => '791 — 805'
                        ]
                    ],
                    [
                        'rank' => 'Platinum II',
                        'image' => 'P2.png',
                        'divisions' => [
                            'I' => '692 — 705',
                            'II' => '706 — 719',
                            'III' => '720 — 732',
                            'IV' => '733 — 745'
                        ]
                    ],
                    [
                        'rank' => 'Platinum I',
                        'image' => 'P1.png',
                        'divisions' => [
                            'I' => '634 — 648',
                            'II' => '649 — 662',
                            'III' => '663 — 677',
                            'IV' => '678 — 691'
                        ]
                    ],
                    [
                        'rank' => 'Gold III',
                        'image' => 'G3.png',
                        'divisions' => [
                            'I' => '566 — 583',
                            'II' => '584 — 600',
                            'III' => '601 — 617',
                            'IV' => '618 — 633'
                        ]
                    ],
                    [
                        'rank' => 'Gold II',
                        'image' => 'G2.png',
                        'divisions' => [
                            'I' => '508 — 522',
                            'II' => '523 — 537',
                            'III' => '538 — 551',
                            'IV' => '552 — 565'
                        ]
                    ],
                    [
                        'rank' => 'Gold I',
                        'image' => 'G1.png',
                        'divisions' => [
                            'I' => '453 — 467',
                            'II' => '468 — 481',
                            'III' => '482 — 495',
                            'IV' => '496 — 507'
                        ]
                    ],
                    [
                        'rank' => 'Silver III',
                        'image' => 'Z3.png',
                        'divisions' => [
                            'I' => '387 — 403',
                            'II' => '404 — 420',
                            'III' => '421 — 436',
                            'IV' => '437 — 452'
                        ]
                    ],
                    [
                        'rank' => 'Silver II',
                        'image' => 'Z2.png',
                        'divisions' => [
                            'I' => '335 — 348',
                            'II' => '349 — 361',
                            'III' => '362 — 374',
                            'IV' => '375 — 386'
                        ]
                    ],
                    [
                        'rank' => 'Silver I',
                        'image' => 'Z1.png',
                        'divisions' => [
                            'I' => '278 — 292',
                            'II' => '293 — 306',
                            'III' => '307 — 320',
                            'IV' => '321 — 334'
                        ]
                    ],
                    [
                        'rank' => 'Bronze III',
                        'image' => 'Brons3.png',
                        'divisions' => [
                            'I' => '217 — 232',
                            'II' => '233 — 247',
                            'III' => '248 — 262',
                            'IV' => '263 — 277'
                        ]
                    ],
                    [
                        'rank' => 'Bronze II',
                        'image' => 'Brons2.png',
                        'divisions' => [
                            'I' => '149 — 166',
                            'II' => '167 — 183',
                            'III' => '184 — 200',
                            'IV' => '201 — 216'
                        ]
                    ],
                    [
                        'rank' => 'Bronze I',
                        'image' => 'Brons1.png',
                        'divisions' => [
                            'I' => '0 — 37',
                            'II' => '38 — 74',
                            'III' => '75 — 111',
                            'IV' => '112 — 148'
                        ]
                    ],
                ]
            ],
            'standard' => [
                'name' => 'Ranked Standard 3v3',
                'ranks' => [
                    [
                        'rank' => 'Supersonic Legend',
                        'image' => 'SSL.png',
                        'divisions' => [
                            'I' => '1871+',
                            'II' => '—',
                            'III' => '—',
                            'IV' => '—'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion III',
                        'image' => 'GC3.png',
                        'divisions' => [
                            'I' => '1721 — 1758',
                            'II' => '1759 — 1795',
                            'III' => '1796 — 1833',
                            'IV' => '1834 — 1870'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion II',
                        'image' => 'GC2.png',
                        'divisions' => [
                            'I' => '1582 — 1616',
                            'II' => '1617 — 1651',
                            'III' => '1652 — 1686',
                            'IV' => '1687 — 1720'
                        ]
                    ],
                    [
                        'rank' => 'Grand Champion I',
                        'image' => 'GC1.png',
                        'divisions' => [
                            'I' => '1442 — 1477',
                            'II' => '1478 — 1512',
                            'III' => '1513 — 1547',
                            'IV' => '1548 — 1581'
                        ]
                    ],
                    [
                        'rank' => 'Champion III',
                        'image' => 'C3.png',
                        'divisions' => [
                            'I' => '1321 — 1351',
                            'II' => '1352 — 1381',
                            'III' => '1382 — 1411',
                            'IV' => '1412 — 1441'
                        ]
                    ],
                    [
                        'rank' => 'Champion II',
                        'image' => 'C2.png',
                        'divisions' => [
                            'I' => '1202 — 1231',
                            'II' => '1232 — 1261',
                            'III' => '1262 — 1291',
                            'IV' => '1292 — 1320'
                        ]
                    ],
                    [
                        'rank' => 'Champion I',
                        'image' => 'C1.png',
                        'divisions' => [
                            'I' => '1082 — 1112',
                            'II' => '1113 — 1142',
                            'III' => '1143 — 1172',
                            'IV' => '1173 — 1201'
                        ]
                    ],
                    [
                        'rank' => 'Diamond III',
                        'image' => 'D3.png',
                        'divisions' => [
                            'I' => '942 — 977',
                            'II' => '978 — 1012',
                            'III' => '1013 — 1047',
                            'IV' => '1048 — 1081'
                        ]
                    ],
                    [
                        'rank' => 'Diamond II',
                        'image' => 'D2.png',
                        'divisions' => [
                            'I' => '862 — 882',
                            'II' => '883 — 902',
                            'III' => '903 — 922',
                            'IV' => '923 — 941'
                        ]
                    ],
                    [
                        'rank' => 'Diamond I',
                        'image' => 'D1.png',
                        'divisions' => [
                            'I' => '782 — 802',
                            'II' => '803 — 822',
                            'III' => '823 — 842',
                            'IV' => '843 — 861'
                        ]
                    ],
                    [
                        'rank' => 'Platinum III',
                        'image' => 'P3.png',
                        'divisions' => [
                            'I' => '722 — 737',
                            'II' => '738 — 752',
                            'III' => '753 — 767',
                            'IV' => '768 — 781'
                        ]
                    ],
                    [
                        'rank' => 'Platinum II',
                        'image' => 'P2.png',
                        'divisions' => [
                            'I' => '662 — 677',
                            'II' => '678 — 692',
                            'III' => '693 — 707',
                            'IV' => '708 — 721'
                        ]
                    ],
                    [
                        'rank' => 'Platinum I',
                        'image' => 'P1.png',
                        'divisions' => [
                            'I' => '602 — 617',
                            'II' => '618 — 632',
                            'III' => '633 — 647',
                            'IV' => '648 — 661'
                        ]
                    ],
                    [
                        'rank' => 'Gold III',
                        'image' => 'G3.png',
                        'divisions' => [
                            'I' => '542 — 557',
                            'II' => '558 — 572',
                            'III' => '573 — 587',
                            'IV' => '588 — 601'
                        ]
                    ],
                    [
                        'rank' => 'Gold II',
                        'image' => 'G2.png',
                        'divisions' => [
                            'I' => '482 — 497',
                            'II' => '498 — 512',
                            'III' => '513 — 527',
                            'IV' => '528 — 541'
                        ]
                    ],
                    [
                        'rank' => 'Gold I',
                        'image' => 'G1.png',
                        'divisions' => [
                            'I' => '422 — 437',
                            'II' => '438 — 452',
                            'III' => '453 — 467',
                            'IV' => '468 — 481'
                        ]
                    ],
                    [
                        'rank' => 'Silver III',
                        'image' => 'Z3.png',
                        'divisions' => [
                            'I' => '362 — 377',
                            'II' => '378 — 392',
                            'III' => '393 — 407',
                            'IV' => '408 — 421'
                        ]
                    ],
                    [
                        'rank' => 'Silver II',
                        'image' => 'Z2.png',
                        'divisions' => [
                            'I' => '302 — 317',
                            'II' => '318 — 332',
                            'III' => '333 — 347',
                            'IV' => '348 — 361'
                        ]
                    ],
                    [
                        'rank' => 'Silver I',
                        'image' => 'Z1.png',
                        'divisions' => [
                            'I' => '242 — 257',
                            'II' => '258 — 272',
                            'III' => '273 — 287',
                            'IV' => '288 — 301'
                        ]
                    ],
                    [
                        'rank' => 'Bronze III',
                        'image' => 'Brons3.png',
                        'divisions' => [
                            'I' => '182 — 197',
                            'II' => '198 — 212',
                            'III' => '213 — 227',
                            'IV' => '228 — 241'
                        ]
                    ],
                    [
                        'rank' => 'Bronze II',
                        'image' => 'Brons2.png',
                        'divisions' => [
                            'I' => '122 — 137',
                            'II' => '138 — 152',
                            'III' => '153 — 167',
                            'IV' => '168 — 181'
                        ]
                    ],
                    [
                        'rank' => 'Bronze I',
                        'image' => 'Brons1.png',
                        'divisions' => [
                            'I' => '0 — 30',
                            'II' => '31 — 61',
                            'III' => '62 — 91',
                            'IV' => '92 — 121'
                        ]
                    ],
                ]
            ],
        ];

        // Reorder to: duel, doubles, standard
        $orderedGamemodes = [
            'duel' => $gamemodes['duel'],
            'doubles' => $gamemodes['doubles'],
            'standard' => $gamemodes['standard'],
        ];

        return view('ranked.index', compact('orderedGamemodes'));
    }
}
