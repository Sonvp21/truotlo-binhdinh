<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LandslideLayerController extends Controller
{
    public function __invoke()
    {
        $geoJson =
            Cache::rememberForever('map_landslides', function () {
                return DB::select("SELECT
                                        row_to_json(fc) AS data
                                    FROM (
                                        SELECT
                                            'FeatureCollection' AS TYPE,
                                            array_to_json(array_agg(f)) AS features
                                        FROM (
                                            SELECT
                                                'Feature' AS TYPE,
                                                ST_AsGeoJSON(l.geom)::json AS geometry,
                                                row_to_json((
                                                    SELECT
                                                        p FROM (
                                                            SELECT
                                                                l.id, l.commune_id, c.name AS commune, d.name AS district, 'landslides' layer) AS p)) AS properties
                                            FROM
                                                map_landslides l
                                                JOIN map_communes c ON c.id = l.commune_id::INTEGER
                                                JOIN map_districts d ON d.id = c.district_id::INTEGER
                                            GROUP BY
                                                l.id,
                                                c.id,
                                                d.id) AS f) AS fc");
            });

        $geoJson = collect($geoJson)->first();

        return json_decode($geoJson->data);
    }
}
