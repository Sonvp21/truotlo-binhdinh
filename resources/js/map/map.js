import 'ol/ol.css';
import Map from 'ol/Map';
import View from 'ol/View';
import { BASEMAP_LAYER } from './basemap.js';
import { DEFAULT_CONTROLS } from './control';
import { defaults as defaultControls } from 'ol/control';
// import { COMPANY_LAYER, COMPANY_INFOBOX } from './company.js';
import { ADMINISTRATIVE_LAYER, ADMINISTRATIVE_INFOBOX } from './baselayer';
import { LANDSLIDE_LAYER, LANDSLIDE_INFOBOX }     from "./Layers/landslide.js";

/** End of extended functionalities **/

const VIEW = new View({
    projection: 'EPSG:4326',
    center: [108.97, 14.18],
    minZoom: 7,
    maxZoom: 20,
    zoom: 9
})

const borderSource = ADMINISTRATIVE_LAYER.border.getSource();
borderSource.on('addfeature', function () {
    VIEW.fit(borderSource.getExtent());
});

const map = new Map({
    controls: defaultControls({ zoom: false }),
    layers: [
        BASEMAP_LAYER,
        ADMINISTRATIVE_LAYER.border,
        ADMINISTRATIVE_LAYER.districts,
        ADMINISTRATIVE_LAYER.communes,
        LANDSLIDE_LAYER.landslide,
    ],
    target: 'map',
    view: VIEW
});

/**  Measurementsm, Zoom, Reset **/
DEFAULT_CONTROLS(map, borderSource/* borderSource is use to get the extent for the reset function */);

/** Enable info for administrative map **/
// ADMINISTRATIVE_INFOBOX(map)
LANDSLIDE_INFOBOX(map)
