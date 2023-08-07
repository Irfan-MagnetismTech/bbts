<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Modules\Admin\Entities\User;
use Spatie\Permission\Models\Role;
use Modules\Networking\Entities\CoreNoColor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoreNoColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coreNoColors = [
            ["core_number" => 1, "colour" => "White (WH)"],
            ["core_number" => 2, "colour" => "Brown (BR)"],
            ["core_number" => 3, "colour" => "Green (GN)"],
            ["core_number" => 4, "colour" => "Yellow (YW)"],
            ["core_number" => 5, "colour" => "Grey (GR)"],
            ["core_number" => 6, "colour" => "Pink (PK)"],
            ["core_number" => 7, "colour" => "Blue (BL)"],
            ["core_number" => 8, "colour" => "Red (RD)"],
            ["core_number" => 9, "colour" => "Black (BK)"],
            ["core_number" => 10, "colour" => "Grey-Pink (GRPK)"],
            ["core_number" => 11, "colour" => "Red-Blue (RDBL)"],
            ["core_number" => 12, "colour" => "White-Green (WHGN)"],
            ["core_number" => 13, "colour" => "Brown-Green (BRGN)"],
            ["core_number" => 14, "colour" => "White-Yellow (WHYW)"],
            ["core_number" => 15, "colour" => "Yellow-Brown (YWBN)"],
            ["core_number" => 16, "colour" => "White-Grey (WHGR)"],
            ["core_number" => 17, "colour" => "Grey-Brown (GRBN)"],
            ["core_number" => 18, "colour" => "White-Pink (WHPK)"],
            ["core_number" => 19, "colour" => "Pink-Brown (PKBN)"],
            ["core_number" => 20, "colour" => "White-Blue (WHBL)"],
            ["core_number" => 21, "colour" => "Brown-Blue (BNBL)"],
            ["core_number" => 22, "colour" => "White-Red (WHRD)"],
            ["core_number" => 23, "colour" => "Brown-Red (BNRD)"],
            ["core_number" => 24, "colour" => "White-Black (WHBK)"],
            ["core_number" => 25, "colour" => "Brown-Black (BNBK)"],
            ["core_number" => 27, "colour" => "Grey-Green (GRGN)"],
            ["core_number" => 28, "colour" => "Yellow-Grey (YWGR)"],
            ["core_number" => 29, "colour" => "Pink-Green (PKGN)"],
            ["core_number" => 30, "colour" => "Yellow-Pink (YWPK)"],
            ["core_number" => 31, "colour" => "Green-Blue (GNBL)"],
            ["core_number" => 32, "colour" => "Yellow-Blue (YWBL)"],
            ["core_number" => 33, "colour" => "Green-Red (GNRD)"],
            ["core_number" => 34, "colour" => "Yellow-Red (YWRD)"],
            ["core_number" => 35, "colour" => "Green-Black (GNBK)"],
            ["core_number" => 36, "colour" => "Yellow-Black (YWBK)"],
            ["core_number" => 37, "colour" => "Grey-Blue (GRBL)"],
            ["core_number" => 38, "colour" => "Pink-Blue (PKBL)"],
            ["core_number" => 39, "colour" => "Grey-Red (GRRD)"],
            ["core_number" => 40, "colour" => "Pink-Red (PKRD)"],
            ["core_number" => 41, "colour" => "Grey-Black (GRBK)"],
            ["core_number" => 42, "colour" => "Pink-Black (PKBK)"],
            ["core_number" => 43, "colour" => "Blue-Black (BLBK)"],
            ["core_number" => 44, "colour" => "Red-Black (RDBK)"],
            ["core_number" => 45, "colour" => "White-Brown-Black (WHBNBK)"],
            ["core_number" => 46, "colour" => "Yellow-Green-Black (YWGNBK)"],
            ["core_number" => 47, "colour" => "Grey-Pink-Black (GRPKBK)"],
            ["core_number" => 48, "colour" => "Red-Blue-Black (RDBLBK)"],
            ["core_number" => 49, "colour" => "White-Green-Black (WHGNBK)"],
            ["core_number" => 50, "colour" => "Brown-Green-Black (BNGNBK)"],
            ["core_number" => 51, "colour" => "White-Yellow-Black (WHYWBK)"],
            ["core_number" => 52, "colour" => "Yellow-Brown-Black (YWBNBK)"],
            ["core_number" => 53, "colour" => "White-Grey-Black (WHGRBK)"],
            ["core_number" => 54, "colour" => "Grey-Brown-Black (GRBNBK)"],
            ["core_number" => 55, "colour" => "White-Pink-Black (WHPKBK)"],
            ["core_number" => 56, "colour" => "Pink-Brown-Black (PKBNBK)"],
            ["core_number" => 57, "colour" => "White-Blue-Black (WHBLBK)"],
            ["core_number" => 58, "colour" => "Brown-Blue-Black (BNBLBK)"],
            ["core_number" => 59, "colour" => "White-Red-Black (WHRDBK)"],
            ["core_number" => 60, "colour" => "Brown-Red-Black (BNRDBK)"]
        ];
        foreach ($coreNoColors as $coreNoColor) {
            CoreNoColor::create($coreNoColor);
        }
    }
}
