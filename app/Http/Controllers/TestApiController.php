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
}
