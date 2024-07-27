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
    landslide: APP_URL + "/ban-do/landslide.geojson",
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

    landslide: new Style({
        image: new Icon({
            anchor: [0.5, 0.96],
            crossOrigin: "anonymous",
            src: `${APP_URL}/files/images/map/landslide.png`,
            scale: 0.07,
        }),
    }),
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

    landslide: new VectorSource({
        url: API_URL.landslide,
        format: new GeoJSON(),
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

    landslide: new VectorLayer({
        visible: true,
        title: "landslide",
        source: LAYER_SOURCE.landslide,
        style: LAYER_STYLE.landslide,
        declutter: true,
    }),
};

export const ADMINISTRATIVE_UI = {
    border: document.getElementById("border-checkbox"),
    communes: document.getElementById("communes-checkbox"),
    districts: document.getElementById("districts-checkbox"),

    landslide: document.getElementById("landslide-checkbox"),
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

ADMINISTRATIVE_UI.landslide.addEventListener("click", function () {
    ADMINISTRATIVE_LAYER.landslide.setVisible(this.checked);
});

document.addEventListener("DOMContentLoaded", function () {
    const districtSelect = document.getElementById("districtSelect");
    if (districtSelect) {
        // Kích hoạt sự kiện change của districtSelect ngay khi trang được tải
        districtSelect.dispatchEvent(new Event("change"));
    }
});

document.getElementById("districtSelect").addEventListener("change", function () {
    const districtId = this.value;
    const url = districtId 
        ? `${APP_URL}/ban-do/landslide.geojson?district_id=${districtId}`
        : `${APP_URL}/ban-do/landslide.geojson`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log("Received GeoJSON data:", data); // Kiểm tra dữ liệu nhận được

            try {
                // Nếu dữ liệu trả về là một mảng, bọc nó vào một đối tượng FeatureCollection
                if (Array.isArray(data)) {
                    data = {
                        type: "FeatureCollection",
                        features: data
                    };
                }

                // Kiểm tra và xử lý dữ liệu
                if (typeof data.features === "string") {
                    try {
                        data.features = JSON.parse(data.features);
                    } catch (error) {
                        console.error("Failed to parse features JSON string:", error);
                        throw new Error("Failed to parse features JSON string");
                    }
                }

                if (data.type !== "FeatureCollection" || !Array.isArray(data.features)) {
                    console.error("Invalid GeoJSON structure:", data);
                    throw new Error("Invalid GeoJSON structure");
                }

                // Kiểm tra và lọc dữ liệu
                const filteredFeatures = data.features.filter(feature => {
                    return feature.geometry && ["Point", "Polygon", "LineString", "MultiPoint"].includes(feature.geometry.type);
                });

                // Tạo nguồn dữ liệu cho layer
                const landslideSource = new VectorSource({
                    features: new GeoJSON().readFeatures({
                        type: "FeatureCollection",
                        features: filteredFeatures
                    }),
                });

                // Cập nhật layer với nguồn dữ liệu mới
                ADMINISTRATIVE_LAYER.landslide.setSource(landslideSource);
            } catch (error) {
                console.error('Error processing GeoJSON:', error);
            }
        })
        .catch(error => console.error('Error fetching GeoJSON:', error));
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

        if (prop.layer === 'landslide') {
            Livewire.dispatchTo('map.info.landslide', 'get-landslide-info', {
                id: prop.id
            });
        }
    });
}
