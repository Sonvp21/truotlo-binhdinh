<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DistrictLayerController extends Controller
{
    public function __invoke()
    {
        $geoJson =
            Cache::rememberForever('map_districts', function () {
                return DB::select("SELECT
                                        row_to_json(fc) AS data
                                    FROM (
                                        SELECT
                                            'FeatureCollection' AS TYPE,
                                            array_to_json(array_agg(f)) AS features
                                        FROM (
                                            SELECT
                                                'Feature' AS TYPE,
                                                ST_AsGeoJSON(d.geom)::json AS geometry,
                                                row_to_json((
                                                    SELECT
                                                        p FROM (
                                                            SELECT
                                                                d.id, d.name, 'district' layer) AS p)) AS properties
                                            FROM
                                                map_districts d
                                            GROUP BY
                                                d.id) AS f) AS fc");
            });

        $geoJson = collect($geoJson)->first();

        return json_decode($geoJson->data);
    }
}
