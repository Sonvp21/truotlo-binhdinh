<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MapController extends Controller
{
    public function index()
    {
        $total_orders_landslide = DB::table('landslide')->get()->count();
        return view('web.map.index', compact('total_orders_landslide'));
    }
    public function layer($layer)
    {
        if ($layer === 'borders') {
            $geoJson =
                Cache::rememberForever('border', function () {
                    return DB::select("SELECT
                        row_to_json(fc) AS data
                    FROM (
                        SELECT
                            'FeatureCollection' AS TYPE,
                            array_to_json(array_agg(f)) AS features
                        FROM (
                            SELECT
                                'Feature' AS TYPE,
                                ST_AsGeoJSON(b.geom)::json AS geometry,
                                row_to_json((
                                    SELECT
                                        p FROM (
                                            SELECT
                                               b.id, 'border' layer ) AS p)) AS properties
                            FROM
                                borders b

                            GROUP BY
                                b.id) AS f) AS fc");
                });

            $geoJson = collect($geoJson)->first();

            return json_decode($geoJson->data);
        }

        if ($layer === 'districts') {
            $geoJson = DB::select("SELECT
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
                                            d.id, d.ten_huyen AS district, 'districts' layer) AS p)) AS properties
                        FROM
                            districts d
                        GROUP BY
                            d.id) AS f) AS fc");

            $geoJson = collect($geoJson)->first();

            return json_decode($geoJson->data);
        }

        if ($layer === 'communes') { // this is xa
            $geoJson =
                Cache::rememberForever('communes', function () {
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
                                                                    c.id, c.district_id, c.ten_xa AS commune, c.ten_tinh, c.ten_huyen, 'communes' layer) AS p)) AS properties
                                                FROM
                                                    xa c
                                                GROUP BY
                                                    c.id) AS f) AS fc");
                });

            $geoJson = collect($geoJson)->first();

            return json_decode($geoJson->data);
        }

        if ($layer === 'landslide') {
            $geoJson = Cache::rememberForever('landslide', function () {
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
                                                l.id AS id, 
                                                l.commune_id AS commune_id, 
                                                l.ten_xa AS ten_xa, 
                                                l.vi_tri AS vi_tri, 
                                                l.mo_ta AS mo_ta, 
                                                l.object_id AS object_id,
                                                'landslide' AS layer
                                        ) AS p
                                )) AS properties
                            FROM
                                landslide l
                            GROUP BY
                                l.id
                        ) AS f
                    ) AS fc
                ");
            });

            $geoJson = collect($geoJson)->first();

            return json_decode($geoJson->data);
        }
    }
}
