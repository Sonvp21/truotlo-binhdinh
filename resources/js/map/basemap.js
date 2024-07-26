import XYZ from 'ol/source/XYZ';
import TileLayer from 'ol/layer/Tile';

const BASEMAP_LAYERSOURCE = new XYZ({
	attributionsCollapsible: false,
	tilePixelRatio: 2,
	url: 'https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}'
})

export const BASEMAP_LAYER = new TileLayer({
	visible: true,
	source: BASEMAP_LAYERSOURCE
});

document.querySelectorAll('input[type=radio][name="basemap"]').forEach(radio => radio.addEventListener('change', function () {
	BASEMAP_LAYERSOURCE.setUrl(`https://mt0.google.com/vt/lyrs=${this.value}&hl=en&x={x}&y={y}&z={z}`);
}));
