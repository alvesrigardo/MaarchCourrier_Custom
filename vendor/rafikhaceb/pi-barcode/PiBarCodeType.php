<?php
declare(strict_types=1);

namespace PiBarCode;

/**
 * Classe .
 */
class PiBarCodeType
{
    public const C25 = [
        0 => "11331",
        1 => "31113",
        2 => "13113",
        3 => "33111",
        4 => "11313",
        5 => "31311",
        6 => "13311",
        7 => "11133",
        8 => "31131",
        9 => "13131",
        'D' => "111011101",
        'F' => "111010111", // Code 2 parmi 5
        'd' => "1010",
        'f' => "11101"   // Code 2/5 entrelacé
    ];

    public const C128 = [
        0 => "11011001100",
        1 => "11001101100",
        2 => "11001100110",
        3 => "10010011000",
        4 => "10010001100",
        5 => "10001001100",
        6 => "10011001000",
        7 => "10011000100",
        8 => "10001100100",
        9 => "11001001000",
        10 => "11001000100",
        11 => "11000100100",
        12 => "10110011100",
        13 => "10011011100",
        14 => "10011001110",
        15 => "10111001100",
        16 => "10011101100",
        17 => "10011100110",
        18 => "11001110010",
        19 => "11001011100",
        20 => "11001001110",
        21 => "11011100100",
        22 => "11001110100",
        23 => "11101101110",
        24 => "11101001100",
        25 => "11100101100",
        26 => "11100100110",
        27 => "11101100100",
        28 => "11100110100",
        29 => "11100110010",
        30 => "11011011000",
        31 => "11011000110",
        32 => "11000110110",
        33 => "10100011000",
        34 => "10001011000",
        35 => "10001000110",
        36 => "10110001000",
        37 => "10001101000",
        38 => "10001100010",
        39 => "11010001000",
        40 => "11000101000",
        41 => "11000100010",
        42 => "10110111000",
        43 => "10110001110",
        44 => "10001101110",
        45 => "10111011000",
        46 => "10111000110",
        47 => "10001110110",
        48 => "11101110110",
        49 => "11010001110",
        50 => "11000101110",
        51 => "11011101000",
        52 => "11011100010",
        53 => "11011101110",
        54 => "11101011000",
        55 => "11101000110",
        56 => "11100010110",
        57 => "11101101000",
        58 => "11101100010",
        59 => "11100011010",
        60 => "11101111010",
        61 => "11001000010",
        62 => "11110001010",
        63 => "10100110000",
        64 => "10100001100",
        65 => "10010110000",
        66 => "10010000110",
        67 => "10000101100",
        68 => "10000100110",
        69 => "10110010000",
        70 => "10110000100",
        71 => "10011010000",
        72 => "10011000010",
        73 => "10000110100",
        74 => "10000110010",
        75 => "11000010010",
        76 => "11001010000",
        77 => "11110111010",
        78 => "11000010100",
        79 => "10001111010",
        80 => "10100111100",
        81 => "10010111100",
        82 => "10010011110",
        83 => "10111100100",
        84 => "10011110100",
        85 => "10011110010",
        86 => "11110100100",
        87 => "11110010100",
        88 => "11110010010",
        89 => "11011011110",
        90 => "11011110110",
        91 => "11110110110",
        92 => "10101111000",
        93 => "10100011110",
        94 => "10001011110",
        95 => "10111101000",
        96 => "10111100010",
        97 => "11110101000",
        98 => "11110100010",
        99 => "10111011110",    // 99 et 'c' sont identiques ne nous sert que pour le checksum
        100 => "10111101110",    // 100 et 'b' sont identiques ne nous sert que pour le checksum
        101 => "11101011110",    // 101 et 'a' sont identiques ne nous sert que pour le checksum
        102 => "11110101110",    // 102 correspond à FNC1 ne nous sert que pour le checksum
        'c' => "10111011110",
        'b' => "10111101110",
        'a' => "11101011110",
        'A' => "11010000100",
        'B' => "11010010000",
        'C' => "11010011100",
        'S' => "1100011101011"
    ];

    public const CMC7 = [
        0 => "0,3-0,22|2,1-2,24|4,0-4,8|4,18-4,25|8,0-8,8|8,18-8,25|12,0-12,8|12,18-12,25|14,1-14,24|16,3-16,22",
        1 => "0,5-0,12|0,17-0,25|4,3-4,10|4,17-4,25|6,2-6,9|6,17-6,25|8,1-8,25|10,0-10,25|14,14-14,25|16,14-16,25",
        2 => "0,2-0,9|0,17-0,25|2,0-2,9|2,16-2,25|6,0-6,6|6,13-6,25|10,0-10,6|10,11-10,17|10,20-10,25|12,0-12,6|12,10-12,16|12,20-12,25|14,0-14,14|14,20-14,25|16,2-16,13|16,20-16,25",
        3 => "0,2-0,9|0,17-0,23|4,0-4,9|4,17-4,25|6,0-6,8|6,18-6,25|10,0-10,7|10,10-10,16|10,19-10,25|12,0-12,7|12,10-12,16|12,19-12,25|14,0-14,25|16,2-16,12|16,14-16,23",
        4 => "0,6-0,21|4,4-4,21|6,3-6,11|6,16-6,21|8,2-8,10|8,16-8,21|12,0-12,8|12,15-12,25|14,0-14,8|14,15-14,25|16,0-16,8|16,15-16,25",
        5 => "0,0-0,14|0,19-0,25|2,0-2,14|2,19-2,25|4,0-4,6|4,9-4,14|4,19-4,25|6,0-6,6|6,9-6,14|6,19-6,25|10,0-10,6|10,9-10,14|10,19-10,25|14,0-14,6|14,9-14,25|16,0-16,6|16,11-16,23",
        6 => "0,2-0,23|2,0-2,25|4,0-4,6|4,10-4,15|4,19-4,25|8,0-8,6|8,10-8,15|8,19-8,25|10,0-10,6|10,10-10,15|10,19-10,25|14,0-14,7|14,10-14,25|16,2-16,7|16,12-16,23",
        7 => "0,0-0,9|0,19-0,25|4,0-4,6|4,16-4,25|8,0-8,6|8,12-8,21|10,0-10,6|10,9-10,19|12,0-12,17|14,0-14,15|16,0-16,13",
        8 => "0,2-0,10|0,15-0,23|2,0-2,11|2,14-2,25|6,0-6,6|6,10-6,15|6,19-6,25|8,0-8,6|8,10-8,15|8,19-8,25|10,0-10,6|10,10-10,15|10,19-10,25|14,0-14,11|14,14-14,25|16,2-16,10|16,15-16,23",
        9 => "0,2-0,13|0,18-0,23|2,0-2,15|2,18-2,25|6,0-6,6|6,10-6,15|6,19-6,25|8,0-8,6|8,10-8,15|8,19-8,25|12,0-12,6|12,10-12,15|12,19-12,25|14,0-14,25|16,2-16,23",
        'A' => "0,4-0,15|0,19-0,24|2,4-2,15|2,19-2,24|4,4-4,15|4,19-4,24|8,4-8,15|8,19-8,24|10,4-10,15|10,19-10,24|12,4-12,15|12,19-12,24|16,4-16,15|16,19-16,24",
        'B' => "0,9-0,24|4,7-4,22|6,6-6,21|8,5-8,20|10,4-10,19|12,3-12,18|16,1-16,16",
        'C' => "0,4-0,12|0,16-0,24|2,4-2,12|2,16-2,24|4,4-4,12|4,16-4,24|6,4-6,12|6,16-6,24|10,7-10,21|12,7-12,21|16,7-16,21",
        'D' => "0,10-0,24|2,10-2,24|6,10-6,24|8,10-8,24|10,4-10,24|12,4-12,24|16,4-16,24",
        'E' => "0,7-0,12|0,16-0,25|2,5-2,23|4,3-4,21|6,1-6,19|8,0-8,18|12,3-12,21|16,7-16,12|16,16-16,25",
    ];

    public const MSI = [
        0 => "100100100100",
        1 => "100100100110",
        2 => "100100110100",
        3 => "100100110110",
        4 => "100110100100",
        5 => "100110100110",
        6 => "100110110100",
        7 => "100110110110",
        8 => "110100100100",
        9 => "110100100110",
        'D' => "110",
        'F' => "1001"
    ];

    public const C11 = [
        '0' => "101011",
        '1' => "1101011",
        '2' => "1001011",
        '3' => "1100101",
        '4' => "1011011",
        '5' => "1101101",
        '6' => "1001101",
        '7' => "1010011",
        '8' => "1101001",
        '9' => "110101",
        '-' => "101101",
        'S' => "1011001"
    ];

    public const POSTNET = [
        '0' => "11000",
        '1' => "00011",
        '2' => "00101",
        '3' => "00110",
        '4' => "01001",
        '5' => "01010",
        '6' => "01100",
        '7' => "10001",
        '8' => "10010",
        '9' => "10100"
    ];

    public const C39 = [
        '0' => "101001101101",
        '1' => "110100101011",
        '2' => "101100101011",
        '3' => "110110010101",
        '4' => "101001101011",
        '5' => "110100110101",
        '6' => "101100110101",
        '7' => "101001011011",
        '8' => "110100101101",
        '9' => "101100101101",
        'A' => "110101001011",
        'B' => "101101001011",
        'C' => "110110100101",
        'D' => "101011001011",
        'E' => "110101100101",
        'F' => "101101100101",
        'G' => "101010011011",
        'H' => "110101001101",
        'I' => "101101001101",
        'J' => "101011001101",
        'K' => "110101010011",
        'L' => "101101010011",
        'M' => "110110101001",
        'N' => "101011010011",
        'O' => "110101101001",
        'P' => "101101101001",
        'Q' => "101010110011",
        'R' => "110101011001",
        'S' => "101101011001",
        'T' => "101011011001",
        'U' => "110010101011",
        'V' => "100110101011",
        'W' => "110011010101",
        'X' => "100101101011",
        'Y' => "110010110101",
        'Z' => "100110110101",
        '-' => "100101011011",
        '.' => "110010101101",
        ' ' => "100110101101",
        '$' => "100100100101",
        '/' => "100100101001",
        '+' => "100101001001",
        '%' => "101001001001",
        '*' => "100101101101"
    ];

    public const EAN_PARITY = [
        0 => ['A', 'A', 'A', 'A', 'A', 'A'],
        1 => ['A', 'A', 'B', 'A', 'B', 'B'],
        2 => ['A', 'A', 'B', 'B', 'A', 'B'],
        3 => ['A', 'A', 'B', 'B', 'B', 'A'],
        4 => ['A', 'B', 'A', 'A', 'B', 'B'],
        5 => ['A', 'B', 'B', 'A', 'A', 'B'],
        6 => ['A', 'B', 'B', 'B', 'A', 'A'],
        7 => ['A', 'B', 'A', 'B', 'A', 'B'],
        8 => ['A', 'B', 'A', 'B', 'B', 'A'],
        9 => ['A', 'B', 'B', 'A', 'B', 'A']
    ];

    public const CODE_A_BAR = [
        '0' => "101010011",
        '1' => "101011001",
        '2' => "101001011",
        '3' => "110010101",
        '4' => "101101001",
        '5' => "110101001",
        '6' => "100101011",
        '7' => "100101101",
        '8' => "100110101",
        '9' => "110100101",
        '-' => "101001101",
        '$' => "101100101",
        ':' => "1101011011",
        '/' => "1101101011",
        '.' => "1101101101",
        '+' => "1011011011",
        'A' => "1011001001",
        'B' => "1010010011",
        'C' => "1001001011",
        'D' => "1010011001"
    ];

    public const EAN_BARS = [
        'A' => [
            0 => "0001101",
            1 => "0011001",
            2 => "0010011",
            3 => "0111101",
            4 => "0100011",
            5 => "0110001",
            6 => "0101111",
            7 => "0111011",
            8 => "0110111",
            9 => "0001011"
        ],
        'B' => [
            0 => "0100111",
            1 => "0110011",
            2 => "0011011",
            3 => "0100001",
            4 => "0011101",
            5 => "0111001",
            6 => "0000101",
            7 => "0010001",
            8 => "0001001",
            9 => "0010111"
        ],
        'C' => [
            0 => "1110010",
            1 => "1100110",
            2 => "1101100",
            3 => "1000010",
            4 => "1011100",
            5 => "1001110",
            6 => "1010000",
            7 => "1000100",
            8 => "1001000",
            9 => "1110100"
        ]
    ];

    /**
     * 0=haut, 1=bas, 2=milieu, 3=toute la hauteur
     */
    public const KIX = [
        '0' => '2233',
        '1' => '2103',
        '2' => '2130',
        '3' => '1203',
        '4' => '1230',
        '5' => '1100',
        '6' => '2013',
        '7' => '2323',
        '8' => '2310',
        '9' => '1023',
        'A' => '1010',
        'B' => '1320',
        'C' => '2031',
        'D' => '2301',
        'E' => '2332',
        'F' => '1001',
        'G' => '1032',
        'H' => '1302',
        'I' => '0213',
        'J' => '0123',
        'K' => '0110',
        'L' => '3223',
        'M' => '3210',
        'N' => '3120',
        'O' => '0231',
        'P' => '0101',
        'Q' => '0132',
        'R' => '3201',
        'S' => '3232',
        'T' => '3102',
        'U' => '0011',
        'V' => '0321',
        'W' => '0312',
        'X' => '3021',
        'Y' => '3021',
        'Z' => '3322'
    ];
}
