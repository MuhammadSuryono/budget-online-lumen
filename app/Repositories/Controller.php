<?php

namespace App\Repositories;

use Illuminate\Http\Request;

class Controller
{
    /**
     * @var Request
     */
    protected Request $request;

    /**
     * @var string[]
     */
    public array $convAnswer = [
        1 => 'a',
        2 => 'b',
        3 => 'c',
        4 => 'd',
        5 => 'e',
    ];

    public array $convNumberToRomanNumber = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII',
    ];

    public array $convMonthIntlToIndonesian = [
        "Jan" => "Januari",
        "Feb" => "Februari",
        "Mar" => "Maret",
        "Apr" => "April",
        "May" => "Mei",
        "Jun" => "Juni",
        "Jul" => "Juli",
        "Aug" => "Agustus",
        "Sep" => "September",
        "Oct" => "Oktober",
        "Nov" => "November",
        "Dec" => "Desember",
    ];

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /***
     * @param bool $isSuccess
     * @param string $message
     * @param null $data
     * @return object
     */
    public function callback(bool $isSuccess, string $message = "", $data = null): object
    {
        return (object)[
            "is_success" => $isSuccess,
            "message" => $message,
            "data" => $data
        ];
    }

    /**
     * @return string[]
     */
    public function dict_day_local(): array
    {
        return [
            "Minggu" => "Sunday",
            "Senin" => "Monday",
            "Selasa" => "Tuesday",
            "Rabu" => "Wednesday",
            "Kamis" => "Thursday",
            "Jumat" => "Friday",
            "Sabtu" => "Saturday",
        ];
    }

    /**
     * @param $key
     * @return string
     */
    public function upload_listening($key = 'file'): string
    {
        if ($this->request->hasFile('file')) {
            $file = $this->request->file($key);
            $file->move(storage_path('/uploads/listening'), $file->getClientOriginalName());
            return $file->getClientOriginalName();
        }
        return "-";
    }

    /**
     * @return Request
     */
    public function request_data(): Request
    {
        return $this->request;
    }

    public array $dictRewardExam = [
        1 => [
            0 => 24,
            1 => 25,
            2 => 26,
            3 => 27,
            4 => 28,
            5 => 29,
            6 => 30,
            7 => 31,
            8 => 32,
            9 => 32,
            10 => 33,
            11 => 35,
            12 => 37,
            13 => 38,
            14 => 39,
            15 => 41,
            16 => 41,
            17 => 42,
            18 => 43,
            19 => 44,
            20 => 45,
            21 => 45,
            22 => 46,
            23 => 47,
            24 => 47,
            25 => 48,
            26 => 48,
            27 => 49,
            28 => 49,
            29 => 50,
            30 => 51,
            31 => 51,
            32 => 52,
            33 => 52,
            34 => 53,
            35 => 54,
            36 => 54,
            37 => 55,
            38 => 56,
            39 => 57,
            40 => 57,
            41 => 58,
            42 => 59,
            43 => 60,
            44 => 61,
            45 => 62,
            46 => 63,
            47 => 65,
            48 => 66,
            49 => 67,
            50 => 68,
        ],
        2 => [
            0 => 20,
            1 => 20,
            2 => 21,
            3 => 22,
            4 => 23,
            5 => 25,
            6 => 26,
            7 => 27,
            8 => 29,
            9 => 31,
            10 => 33,
            11 => 35,
            12 => 36,
            13 => 37,
            14 => 38,
            15 => 40,
            16 => 40,
            17 => 41,
            18 => 43,
            19 => 43,
            20 => 44,
            21 => 45,
            22 => 46,
            23 => 47,
            24 => 48,
            25 => 49,
            26 => 50,
            27 => 51,
            28 => 52,
            29 => 53,
            30 => 54,
            31 => 55,
            32 => 56,
            33 => 57,
            34 => 58,
            35 => 60,
            36 => 61,
            37 => 63,
            38 => 65,
            39 => 67,
            40 => 68,
        ],
        3 => [
            0 => 21,
            1 => 22,
            2 => 23,
            3 => 24,
            4 => 24,
            5 => 25,
            6 => 26,
            7 => 27,
            8 => 28,
            9 => 28,
            10 => 29,
            11 => 30,
            12 => 31,
            13 => 32,
            14 => 34,
            15 => 35,
            16 => 36,
            17 => 37,
            18 => 38,
            19 => 39,
            20 => 40,
            21 => 41,
            22 => 42,
            23 => 43,
            24 => 43,
            25 => 44,
            26 => 45,
            27 => 46,
            28 => 46,
            29 => 47,
            30 => 48,
            31 => 48,
            32 => 49,
            33 => 50,
            34 => 51,
            35 => 52,
            36 => 52,
            37 => 53,
            38 => 54,
            39 => 54,
            40 => 55,
            41 => 56,
            42 => 57,
            43 => 58,
            44 => 59,
            45 => 60,
            46 => 61,
            47 => 63,
            48 => 65,
            49 => 66,
            50 => 67,
        ]
    ];

    /**
     * @param $totalCount
     * @param $totalType
     * @return false|float
     */
    public function count_total_score($totalCount, $totalType)
    {
        return ceil(($totalCount / $totalType) * 10);
    }

    /**
     * @param $date
     * @return string
     */
    public function conv_date_to_indonesia_format($date): string
    {
        $dayNumber = date('d', strtotime($date));
        $month = date('M', strtotime($date));
        $year = date('Y', strtotime($date));

        return sprintf('%s %s %s', $dayNumber, $this->convMonthIntlToIndonesian[$month], $year);
    }
}
