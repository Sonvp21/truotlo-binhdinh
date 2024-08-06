<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestApiController extends Controller
{
    public function duBao5Ngay()
    {
        $data = [
            [
                "Nam" => 2024,
                "Thang" => 5,
                "Cac_diem" => [
                    [
                        "ten_diem" => "100001",
                        "vi_tri" => "Đá Cạnh",
                        "kinh_do" => "108.87",
                        "vi_do" => "14.47",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "cac_ngay" => [
                            ["ngay" => 1, "nguy_co" => "Thấp"],
                            ["ngay" => 2, "nguy_co" => "Thấp"],
                            ["ngay" => 3, "nguy_co" => "Trung bình"],
                            ["ngay" => 4, "nguy_co" => "Trung bình"],
                            ["ngay" => 5, "nguy_co" => "Cao"],
                        ]
                    ]
                ]
            ],

            [
                "Nam" => 2024,
                "Thang" => 6,
                "Cac_diem" => [
                    [
                        "ten_diem" => "100001",
                        "vi_tri" => "Đá Cạnh",
                        "kinh_do" => "108.87",
                        "vi_do" => "14.47",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "cac_ngay" => [
                            ["ngay" => 1, "nguy_co" => "Thấp"],
                            ["ngay" => 2, "nguy_co" => "Thấp"],
                            ["ngay" => 3, "nguy_co" => "Trung bình"],
                            ["ngay" => 4, "nguy_co" => "Trung bình"],
                            ["ngay" => 5, "nguy_co" => "Cao"],
                        ]
                    ]
                ]
            ],
            // Tiếp tục tạo dữ liệu cho các tháng và năm khác
        ];

        return response()->json($data);
    }

    public function canhBaoGio()
    {
        $data = [
            [
                "Nam" => 2024,
                "Thang" => 3,
                "Ngay" => 7,
                "Gio" => 15,
                "Cac_diem" => [
                    [
                        "ten_diem" => "100001",
                        "vi_tri" => "Đá Cạnh",
                        "kinh_do" => "108.87",
                        "vi_do" => "14.47",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "Rất cao"
                    ],
                    [
                        "ten_diem" => "113002",
                        "vi_tri" => "Cổng Chào",
                        "kinh_do" => "108.91",
                        "vi_do" => "14.52",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "Trung bình"
                    ]
                ]
            ],
            [
                "Nam" => 2024,
                "Thang" => 3,
                "Ngay" => 8,
                "Gio" => 15,
                "Cac_diem" => [
                    [
                        "ten_diem" => "100001",
                        "vi_tri" => "Đá Cạnh",
                        "kinh_do" => "108.87",
                        "vi_do" => "14.47",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "Rất cao"
                    ],
                    [
                        "ten_diem" => "113002",
                        "vi_tri" => "Cổng Chào",
                        "kinh_do" => "108.91",
                        "vi_do" => "14.52",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "Trung bình"
                    ]
                ]
            ],
            [
                "Nam" => 2024,
                "Thang" => 3,
                "Ngay" => 9,
                "Gio" => 15,
                "Cac_diem" => [
                    [
                        "ten_diem" => "100001",
                        "vi_tri" => "Đá Cạnh",
                        "kinh_do" => "108.87",
                        "vi_do" => "14.47",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "Rất cao"
                    ],
                    [
                        "ten_diem" => "113002",
                        "vi_tri" => "Cổng Chào",
                        "kinh_do" => "108.91",
                        "vi_do" => "14.52",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "Trung bình"
                    ]
                ]
            ],
            [
                "Nam" => 2024,
                "Thang" => 2,
                "Ngay" => 10,
                "Gio" => 15,
                "Cac_diem" => [
                    [
                        "ten_diem" => "113002",
                        "vi_tri" => "Cổng Chào",
                        "kinh_do" => "108.91",
                        "vi_do" => "14.52",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "Trung bình"
                    ],
                    [
                        "ten_diem" => "100001",
                        "vi_tri" => "Đá Cạnh",
                        "kinh_do" => "108.87",
                        "vi_do" => "14.47",
                        "tinh" => "Bình Định",
                        "huyen" => "An Lão",
                        "xa" => "TT. An Lão",
                        "nguy_co" => "cao"
                    ]
                ]
            ],
            [
                "Nam" => 2029,
                "Thang" => 9,
                "Ngay" => 9,
                "Gio" => 9,
                "Cac_diem" => [
                    [
                        "ten_diem" => "100008",
                        "vi_tri" => "Đá Cạnh8",
                        "kinh_do" => "108.88",
                        "vi_do" => "14.48",
                        "tinh" => "Bình Định8",
                        "huyen" => "An Lão8",
                        "xa" => "TT. An Lão8",
                        "nguy_co" => "Cao"
                    ],
                    [
                        "ten_diem" => "113009",
                        "vi_tri" => "Cổng Chào9",
                        "kinh_do" => "108.92",
                        "vi_do" => "14.53",
                        "tinh" => "Bình Định9",
                        "huyen" => "An Lão9",
                        "xa" => "TT. An Lão9",
                        "nguy_co" => "Trung bình"
                    ]
                ]
            ]
        ];

        return response()->json($data);
    }
}
