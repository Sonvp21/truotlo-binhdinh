import Overlay from 'ol/Overlay';
import Draw from 'ol/interaction/Draw';
import { unByKey } from 'ol/Observable';
import VectorSource from 'ol/source/Vector';
import { Vector as VectorLayer } from 'ol/layer';
import { Polygon, Circle, LineString } from 'ol/geom';
import { getLength, getArea, getDistance } from 'ol/sphere';
import { Style, Stroke, Fill, Circle as CircleStyle } from 'ol/style';

export function DEFAULT_CONTROLS(map, borderSource) {

	const LAYER_SOURCE = {
		measure: new VectorSource(),
	}

	var LAYER_STYLE = {
		measure: function () {
			return new Style({
				fill: new Fill({
					color: 'rgba(255, 255, 255, 0.2)'
				}),
				stroke: new Stroke({
					color: '#ef4444',
					width: 2
				}),
				image: new CircleStyle({
					radius: 7,
					fill: new Fill({
						color: '#ef4444'
					})
				})
			})
		},
	}

	let vectorMeasure = new VectorLayer({
		source: LAYER_SOURCE.measure,
		style: LAYER_STYLE.measure
	});

	let activeState = {
		measure: false,
	}

	let draw;
	let sketch;
	let helpTooltip;
	let measureTooltip;
	let helpTooltipElement;
	let measureTooltipElement;
	let continueLineMsg = 'Kích chọn để vẽ đường';
	let continuePolygonMsg = 'Kích chọn để vẽ vùng';
	let continueRadiusMsg = 'Drag the mouse to create radius';

	let pointerMoveHandler = function (evt) {
		if (evt.dragging) {
			return;
		}

		let helpMsg = 'Kích chọn để bắt đầu';

		if (sketch) {
			let geom = sketch.getGeometry();

			if (geom instanceof Polygon) {
				helpMsg = continuePolygonMsg;
			} else if (geom instanceof LineString) {
				helpMsg = continueLineMsg;
			}
			else if (geom instanceof Circle) {
				helpMsg = continueRadiusMsg;
			}
		}

		helpTooltipElement.innerHTML = helpMsg;
		helpTooltip.setPosition(evt.coordinate);

		helpTooltipElement.classList.remove('hidden');
	};

	let selectedTool;
	let formatLength = function (line) {
		let length = getLength(line, { projection: 'EPSG:4326' });
		let output;
		if (length > 100) {
			output = (Math.round(length / 1000 * 100) / 100) +
				' ' + 'km';
		} else {
			output = (Math.round(length * 100) / 100) +
				' ' + 'm';
		}
		return output;
	};

	let formatArea = function (polygon) {
		let area = getArea(polygon, { projection: 'EPSG:4326' });
		let output;
		if (area > 10000) {
			output = (Math.round(area / 1000000 * 100) / 100) +
				' ' + 'km<sup>2</sup>';
		} else {
			output = (Math.round(area * 100) / 100) +
				' ' + 'm<sup>2</sup>';
		}
		return output;
	};

	let formatCircle = function (geometry) {
		var center = geometry.getCenter()
		var edgeCoordinate = geometry.getLastCoordinate()

		let length = getDistance(center, edgeCoordinate);

		let output;

		if (length > 100) {
			output = (Math.round(length / 1000 * 100) / 100) +
				' ' + 'km';
		} else {
			output = (Math.round(length * 100) / 100) +
				' ' + 'm';
		}

		return output;
	};

	function addInteraction() {
		if (!activeState.measure) { return; }

		draw = new Draw({
			source: LAYER_SOURCE.measure,
			type: selectedTool,
			style: new Style({
				fill: new Fill({
					color: 'rgba(255, 255, 255, 0.2)'
				}),
				stroke: new Stroke({
					color: 'rgba(0, 0, 0, 0.5)',
					lineDash: [10, 10],
					width: 2
				}),
				image: new CircleStyle({
					radius: 5,
					stroke: new Stroke({
						color: 'rgba(0, 0, 0, 0.7)'
					}),
					fill: new Fill({
						color: 'rgba(255, 255, 255, 0.2)'
					})
				})
			})
		});

		map.addInteraction(draw);

		createMeasureTooltip();
		createHelpTooltip();

		let listener;
		draw.on('drawstart',
			function (evt) {
				// set sketch
				sketch = evt.feature;

				/** @type {import("../src/ol/coordinate.js").Coordinate|undefined} */
				let tooltipCoord = evt.coordinate;

				listener = sketch.getGeometry().on('change', function (evt) {
					let geom = evt.target;
					let output;
					if (geom instanceof Polygon) {
						output = formatArea(geom);
						tooltipCoord = geom.getInteriorPoint().getCoordinates();
					} else if (geom instanceof LineString) {
						output = formatLength(geom);
						tooltipCoord = geom.getLastCoordinate();
					}
					else if (geom instanceof Circle) {
						output = formatCircle(geom);
						tooltipCoord = geom.getCenter();
					}
					measureTooltipElement.innerHTML = output;
					measureTooltip.setPosition(tooltipCoord);
				});
			}
		);

		draw.on('drawend',
			function () {
				measureTooltipElement.className = 'px-3 text-sm text-white bg-red-500 border border-red-400 rounded-md redTooltip';
				measureTooltip.setOffset([0, -7]);
				// unset sketch
				sketch = null;
				// unset tooltip so that a new one can be created
				measureTooltipElement = null;
				createMeasureTooltip();
				unByKey(listener);
			}
		);
	}

	function removeInteraction() {
		LAYER_SOURCE.measure.clear()
		map.removeInteraction(draw);
		map.removeOverlay(helpTooltip);
		document.querySelectorAll(".redTooltip")
			.forEach(function (el, i) {
				el.parentNode.removeChild(el);
			})
	}

	function createHelpTooltip() {
		if (helpTooltipElement) {
			helpTooltipElement.parentNode.removeChild(helpTooltipElement);
		}
		helpTooltipElement = document.createElement('div');
		helpTooltipElement.className = 'hidden px-3 py-1 text-sm text-white bg-black rounded-md bg-opacity-30';
		helpTooltip = new Overlay({
			element: helpTooltipElement,
			offset: [15, 0],
			positioning: 'center-left'
		});

		map.addOverlay(helpTooltip);
	}

	function createMeasureTooltip() {
		if (measureTooltipElement) {
			measureTooltipElement.parentNode.removeChild(measureTooltipElement);
		}
		measureTooltipElement = document.createElement('div');
		measureTooltipElement.className = 'px-3 py-1 text-sm text-white bg-black bg-opacity-50 rounded-md';
		measureTooltip = new Overlay({
			element: measureTooltipElement,
			offset: [0, -15],
			positioning: 'bottom-center'
		});

		map.addOverlay(measureTooltip);
	}

	const UI_TOOLS = {
		in: document.getElementById('zoom-in'),
		out: document.getElementById('zoom-out'),
		reset: document.getElementById('reset-center'),

		mesureTool: document.querySelectorAll('.measure-tool'),
	}

	const ZOOM_STEPS = 0.2;

	UI_TOOLS.in.addEventListener('click', function () {
		map.getView().setZoom(map.getView().getZoom() + ZOOM_STEPS);
	});

	UI_TOOLS.out.addEventListener('click', function () {
		map.getView().setZoom(map.getView().getZoom() - ZOOM_STEPS);
	});

	/* Reset center */
	UI_TOOLS.reset.addEventListener('click', function () {
		map.getView().fit(borderSource.getExtent());
	});

	UI_TOOLS.mesureTool.forEach(function (el, i) {
		el.addEventListener('click', function () {
			map.removeInteraction(draw);

			if (selectedTool === el.dataset.tool) {
				activeState.measure = false;
				selectedTool = null;
				map.removeLayer(vectorMeasure);
			} else {
				activeState.measure = true;
				selectedTool = el.dataset.tool;
				map.removeLayer(vectorMeasure);
				map.addLayer(vectorMeasure);
			}

			if (activeState.measure) {
				map.on('pointermove', pointerMoveHandler);
				map.getViewport().addEventListener('mouseout', function () {
					helpTooltipElement.classList.add('hidden');
				});
				addInteraction();
			} else {
				removeInteraction();
			}
		});
	});
}
