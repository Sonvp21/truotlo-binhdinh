<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CommuneLayerController extends Controller
{
    public function __invoke()
    {
        $geoJson =
            Cache::rememberForever('map_communes', function () {
                return DB::select("SELECT
                                        row_to_json(fc) AS data
                                    FROM (
                                        SELECT
                                            'FeatureCollection' AS TYPE,
                                            array_to_json(array_agg(f)) AS features
                                        FROM (
                                            SELECT
                                                'Feature' AS TYPE,
                                                ST_AsGeoJSON(c.geom)::json AS geometry,
                                                row_to_json((
                                                    SELECT
                                                        p FROM (
                                                            SELECT
                                                                c.id, c.district_id, c.name AS commune, d.name AS district, 'communes' layer) AS p)) AS properties
                                            FROM
                                                map_communes c
                                                JOIN map_districts d ON d.id = c.district_id::INTEGER
                                            GROUP BY
                                                c.id,
                                                d.id) AS f) AS fc");
            });

        $geoJson = collect($geoJson)->first();

        return json_decode($geoJson->data);
    }
}
