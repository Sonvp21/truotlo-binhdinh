import "ol/ol.css";
import GeoJSON from "ol/format/GeoJSON.js";
import VectorSource from "ol/source/Vector";
import { Style, Fill, Text, Stroke, Icon } from "ol/style";
import {
    VectorImage as VectorImageLayer,
    Vector as VectorLayer,
} from "ol/layer";
// import { TILE_LAYER } from "./tilelayer.js";

const APP_URL = document.querySelector('meta[name="app-url"]').content;

const API_URL = {
    border: APP_URL + "/ban-do/borders.geojson",
    communes: APP_URL + "/ban-do/communes.geojson",
    districts: APP_URL + "/ban-do/districts.geojson",
};

const LAYER_STYLE = {
    border: new Style({
        stroke: new Stroke({
            color: "#FF00C5",
            width: 2,
        }),
    }),
    districts: function (feature) {
        return new Style({
            stroke: new Stroke({
                color: "#00000024",
                width: 2,
                lineDash: [2, 4],
            }),
            // fill: new Fill({
            //     color: feature.get('color')
            // }),

            text: new Text({
                text: feature.get("name"),
                font: "bold 14px Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif",
                fill: new Fill({
                    color: "#000",
                }),
                stroke: new Stroke({
                    color: "#fff",
                    width: 3,
                }),
            }),
        });
    },
    communes: function (feature) {
        return new Style({
            stroke: new Stroke({
                color: "#00000024",
                width: 1,
            }),
            fill: new Fill({
                color: "rgba(0,0,0,0)",
            }),
            text: new Text({
                text: feature.get("commune"),
                fill: new Fill({
                    color: "#000",
                }),
                stroke: new Stroke({
                    color: "#eee",
                    width: 2,
                }),
            }),
        });
    },
};

// this is only for small data ok
const LAYER_SOURCE = {
    border: new VectorSource({
        url: API_URL.border,
        format: new GeoJSON(),
    }),
    districts: new VectorSource({
        format: new GeoJSON(),
        url: API_URL.districts,
    }),
    communes: new VectorSource({
        format: new GeoJSON(),
        url: API_URL.communes,
    }),
};

export const ADMINISTRATIVE_LAYER = {
    border: new VectorLayer({
        visible: true,
        title: "border",
        source: LAYER_SOURCE.border,
        style: LAYER_STYLE.border,
    }),

    communes: new VectorImageLayer({
        visible: true,
        title: "communes",
        source: LAYER_SOURCE.communes,
        style: LAYER_STYLE.communes,
    }),

    districts: new VectorImageLayer({
        visible: true,
        title: "districts",
        source: LAYER_SOURCE.districts,
        style: LAYER_STYLE.districts,
    }),
};

export const ADMINISTRATIVE_UI = {
    border: document.getElementById("border-checkbox"),
    communes: document.getElementById("communes-checkbox"),
    districts: document.getElementById("districts-checkbox"),
};

ADMINISTRATIVE_UI.border.addEventListener("click", function () {
    ADMINISTRATIVE_LAYER.border.setVisible(this.checked);
});

ADMINISTRATIVE_UI.communes.addEventListener("click", function () {
    ADMINISTRATIVE_LAYER.communes.setVisible(this.checked);
});

ADMINISTRATIVE_UI.districts.addEventListener("click", function () {
    ADMINISTRATIVE_LAYER.districts.setVisible(this.checked);
});

export function ADMINISTRATIVE_INFOBOX(map) {
    
    map.on("singleclick", function (event) {
        const features = map.getFeaturesAtPixel(event.pixel);
        // let prop = features[0].getProperties();
        // console.log(prop.layer)

        if (features.length === 0) return;

        let prop = features[0].getProperties();

        // if (prop.layer === 'communes') {
        //     Livewire.dispatchTo('website.map.info.communes', 'getCommuneInfo', {
        //         'id': prop.id
        //     });
        // }

        if (prop.layer === "districts") {
            Livewire.dispatchTo(
                "website.map.info.districts",
                "getDistrictInfo",
                {
                    id: prop.id,
                }
            );
        }

        if (prop.layer === "xa") {
            Livewire.dispatchTo("website.map.info.xa", "getXaInfo", {
                id: prop.id,
            });
        }
    });
}
