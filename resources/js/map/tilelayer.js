import "ol/ol.css";
import TileWMS from "ol/source/TileWMS";
import TileLayer from "ol/layer/Tile";

const GEOSERVER_BASE_URL = "https://geoserver.tuaf.edu.vn";

// Đường dẫn đến dịch vụ WMS của Geoserver và các lớp bản đồ
const GEOSERVER_WMS = GEOSERVER_BASE_URL + "/babe_ddsh/wms";

const layerSource = {
    vegetation: new TileWMS({
        url: GEOSERVER_WMS,
        params: {
            LAYERS: "babe_ddsh:thamtv",
        },
    }),
    sinhcanh: new TileWMS({
        url: GEOSERVER_WMS,
        params: {
            LAYERS: "babe_ddsh:sinh_canh_ba_be",
        },
    }),
};

export const TILE_LAYER = {
    vegetation: new TileLayer({
        visible: false,
        tile: "vegetation",
        source: layerSource.vegetation,
    }),
    sinhcanh: new TileLayer({
        visible: false,
        tile: "sinhcanh",
        source: layerSource.sinhcanh,
    }),
};

export const TILE_LAYER_UI = {
    toggle: {
        vegetation: document.getElementById("thamtv-checkbox"),
        sinhcanh: document.getElementById("sinhcanh-checkbox"),
    },
};

TILE_LAYER_UI.toggle.vegetation.addEventListener("click", function () {
    TILE_LAYER.vegetation.setVisible(this.checked);
});
TILE_LAYER_UI.toggle.sinhcanh.addEventListener("click", function () {
    TILE_LAYER.sinhcanh.setVisible(this.checked);
});

export function TILE_LAYER_INFOBOX(map) {
    map.on("singleclick", function (evt) {
        var viewResolution = map.getView().getResolution();

        const features = map.getFeaturesAtPixel(evt.pixel);
        let prop = features[0].getProperties();
        
        let arrayOrder = [
            "bosat",
            "ca",
            "contrung",
            "chim",
            "dongvatday",
            "dongvatnoi",
            "thuysinh",
            "thu",
        ];

        if (arrayOrder.includes(prop.layer)) return;
        
        // console.log(prop.layer);

        if (TILE_LAYER.vegetation.getVisible()) {
            var vegetationUrl = TILE_LAYER.vegetation
                .getSource()
                .getFeatureInfoUrl(
                    evt.coordinate,
                    viewResolution,
                    map.getView().getProjection(),
                    { INFO_FORMAT: "application/json" }
                );
            fetchInfoAndDispatchEvent(vegetationUrl, "vegetation");
        }
        else if (TILE_LAYER.sinhcanh.getVisible()) {
            var sinhcanhUrl = TILE_LAYER.sinhcanh
                .getSource()
                .getFeatureInfoUrl(
                    evt.coordinate,
                    viewResolution,
                    map.getView().getProjection(),
                    { INFO_FORMAT: "application/json" }
                );

            fetchInfoAndDispatchEvent(sinhcanhUrl, "sinhcanhs");
        } else {}
    });
}

function fetchInfoAndDispatchEvent(url, layer) {
    if (url) {
        fetch(url)
            .then(function (response) {
                return response.json();
            })
            .then(function (json) {
                if (json.features.length === 0) return;

                let id = json.features[0].properties.id;

                console.log(
                    "get" +
                        layer.charAt(0).toUpperCase() +
                        layer.slice(1) +
                        "Info"
                );
                // Dispatch a Livewire event to show the info for the corresponding layer
                Livewire.dispatchTo(
                    "website.map.info." + layer,
                    "get" +
                        layer.charAt(0).toUpperCase() +
                        layer.slice(1) +
                        "Info",
                    { id: id }
                );
            });
    }
}
