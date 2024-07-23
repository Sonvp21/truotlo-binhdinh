import 'ol/ol.css';
import GeoJSON from 'ol/format/GeoJSON.js';
import VectorSource from 'ol/source/Vector';
import {Style, Fill, Text, Stroke, Icon} from 'ol/style';
import { VectorImage as VectorImageLayer, Vector as VectorLayer } from 'ol/layer';

const APP_URL = document.querySelector('meta[name="app-url"]').content;

const API_URL = {
    landslide: APP_URL + '/api/map/layers/landslides',
}

const LAYER_STYLE = {
    landslide: new Style({
        image: new Icon({
            anchor: [0.5, 0.96],
            crossOrigin: 'anonymous',
            src: `${APP_URL}/files/images/map/landslide.png`,
            scale: 0.07
        })
    })

}

const LAYER_SOURCE = {
    landslide: new VectorSource({
        url: API_URL.landslide,
        format: new GeoJSON(),
    }),
}

export const LANDSLIDE_LAYER = {
    landslide: new VectorLayer({
        visible: true,
        title: 'landslide',
        source: LAYER_SOURCE.landslide,
        style: LAYER_STYLE.landslide
    }),

}

export const LANDSLIDE_UI = {
    landslide: document.getElementById('landslide-checkbox'),
};

LANDSLIDE_UI.landslide.addEventListener('click', function () {
    LANDSLIDE_LAYER.landslide.setVisible(this.checked);
});

export function LANDSLIDE_INFOBOX(map) {
    map.on('singleclick', function (event) {
        const features = map.getFeaturesAtPixel(event.pixel);

        if (features.length === 0)
            return;

        let prop = features[0].getProperties();

        if (prop.layer === 'landslides') {
            Livewire.dispatchTo('map.info.landslide', 'get-landslide-info', {
                id: prop.id
            });
        }
    });
}
