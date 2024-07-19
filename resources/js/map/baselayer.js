import 'ol/ol.css';
import GeoJSON from 'ol/format/GeoJSON.js';
import VectorSource from 'ol/source/Vector';
import { Style, Fill, Text, Stroke } from 'ol/style';
import { VectorImage as VectorImageLayer, Vector as VectorLayer } from 'ol/layer';

const APP_URL = document.querySelector('meta[name="app-url"]').content;

const API_URL = {
    border: APP_URL + '/api/map/layers/borders',
    communes: APP_URL + '/api/map/layers/communes',
    districts: APP_URL + '/api/map/layers/districts',
}

const LAYER_STYLE = {
    border: new Style({
        stroke: new Stroke({
            color: '#FF00C5',
            width: 8
        }),
    }),
    districts: function (feature) {
        const districtColors = [
            '',
            '#008080',
            '#FF7F50',
            '#6A5ACD',
            '#808000',
            '#4682B4',
            '#D2691E',
            '#68b788',
            '#9932CC',
            '#CD5C5C',
            '#DAA520',
            '#40E0D0',
        ];
        return new Style({
            stroke: new Stroke({
                color: '#00000024',
                width: 2,
                lineDash: [2, 4]
            }),
            fill: new Fill({ color: districtColors[feature.get('id')] }),

            text: new Text({
                text: feature.get('name'),
                font: 'bold 14px Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif',
                fill: new Fill({ color: '#000' }),
                stroke: new Stroke({
                    color: '#fff', width: 3
                }),
            })
        })
    },
    communes: function (feature) {
        return new Style({
            stroke: new Stroke({
                color: '#00000024',
                width: 1
            }),
            fill: new Fill({ color: 'rgba(0,0,0,0)' }),
            text: new Text({
                text: feature.get('commune'),
                fill: new Fill({ color: '#000' }),
                stroke: new Stroke({
                    color: '#eee', width: 2
                })
            })
        })
    },
}

const LAYER_SOURCE = {
    border: new VectorSource({
        url: API_URL.border,
        format: new GeoJSON(),
    }),
    districts: new VectorSource({
        format: new GeoJSON(),
        url: API_URL.districts
    }),
    communes: new VectorSource({
        format: new GeoJSON(),
        url: API_URL.communes
    }),
}

export const ADMINISTRATIVE_LAYER = {
    border: new VectorLayer({
        visible: true,
        title: 'border',
        source: LAYER_SOURCE.border,
        style: LAYER_STYLE.border
    }),

    communes: new VectorImageLayer({
        visible: true,
        title: 'communes',
        source: LAYER_SOURCE.communes,
        style: LAYER_STYLE.communes
    }),

    districts: new VectorImageLayer({
        visible: true,
        title: 'districts',
        source: LAYER_SOURCE.districts,
        style: LAYER_STYLE.districts
    }),
}

export const ADMINISTRATIVE_UI = {
    border: document.getElementById('border-checkbox'),
    communes: document.getElementById('communes-checkbox'),
    districts: document.getElementById('districts-checkbox'),
};

ADMINISTRATIVE_UI.border.addEventListener('click', function () {
    ADMINISTRATIVE_LAYER.border.setVisible(this.checked);
});

ADMINISTRATIVE_UI.communes.addEventListener('click', function () {
    ADMINISTRATIVE_LAYER.communes.setVisible(this.checked)
});

ADMINISTRATIVE_UI.districts.addEventListener('click', function () {
    ADMINISTRATIVE_LAYER.districts.setVisible(this.checked)
});


export function ADMINISTRATIVE_INFOBOX(map) {
    map.on('singleclick', function (event) {
        const features = map.getFeaturesAtPixel(event.pixel);

        if (features.length === 0)
            return;

        let prop = features[0].getProperties();

        if (prop.layer === 'communes') {
            Livewire.emitTo('website.map.info.communes', 'getCommuneInfo', prop.id);
        }

        if (prop.layer === 'districts') {
            Livewire.emitTo('website.map.info.districts', 'getDistrictInfo', prop.id);
        }
    });
}
