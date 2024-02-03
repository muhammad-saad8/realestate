var G5ELEMENT_MAP_BOX = G5ELEMENT_MAP_BOX || {};
(function ($) {
	"use strict";
	G5ELEMENT_MAP_BOX = {
		options: {
			locations: [],
			zoom: 12,
			minZoom: 0,
			skin: 'skin1',
			gestureHandling: 'cooperative',// "greedy",
			//cluster_markers: g5ere_map_config.cluster_markers,
			draggable: true,
			scrollwheel: true,
			navigationControl: true,
			mapTypeControl: false,
			streetViewControl: false,
		},
		skins: [],
		instances: [],
		getSkin: function (skin) {
			return G5ELEMENT_MAP_BOX.skins[skin] ? G5ELEMENT_MAP_BOX.skins[skin] : G5ELEMENT_MAP_BOX.skins.skin1
		},
		getInstance: function (id) {
			for (var i = 0; i < this.instances.length; i++) {
				if (this.instances[i].id == id) {
					return this.instances[i];
				}
			}
			return false;
		},
		addListener: function (el, e, t) {
			el.on(e, function (e) {
				t(e);
			});
		}
	};

	G5ELEMENT_MAP_BOX.skins = {
		skin1: "mapbox://styles/mapbox/streets-v10",
		skin2: "mapbox://styles/mapbox/outdoors-v10",
		skin3: "mapbox://styles/mapbox/light-v9",
		skin4: "mapbox://styles/mapbox/dark-v9",
		skin6: "mapbox://styles/mapbox/satellite-streets-v10",
		skin7: "mapbox://styles/mapbox/navigation-preview-day-v4",
		skin8: "mapbox://styles/mapbox/navigation-preview-night-v4",
		skin9: "mapbox://styles/mapbox/navigation-guidance-day-v4",
		skin10: "mapbox://styles/mapbox/navigation-guidance-night-v4",
		skin12: ""
	};


	G5ELEMENT_MAP_BOX.LatLng = function (latitude, longitude) {
		this.init(latitude, longitude);
	};

	G5ELEMENT_MAP_BOX.LatLng.prototype.init = function (latitude, longitude) {
		this.latitude = latitude;
		this.longitude = longitude;
		this.latlng = new mapboxgl.LngLat(longitude, latitude);
	};

	G5ELEMENT_MAP_BOX.LatLng.prototype.getLatitude = function () {
		return this.latlng.lat;
	};


	G5ELEMENT_MAP_BOX.LatLng.prototype.getLongitude = function () {
		return this.latlng.lng;
	};

	G5ELEMENT_MAP_BOX.LatLng.prototype.toGeocoderFormat = function () {
		return [this.getLongitude(), this.getLatitude()].join(",");
	};

	G5ELEMENT_MAP_BOX.LatLng.prototype.getSourceObject = function () {
		return this.latlng;
	};


	G5ELEMENT_MAP_BOX.LatLngBounds = function (southwest, northeast) {
		this.init(southwest, northeast)
	};

	G5ELEMENT_MAP_BOX.LatLngBounds.prototype.init = function (southwest, northeast) {
		this.southwest = southwest;
		this.northeast = northeast;
		this.bounds = new mapboxgl.LngLatBounds(southwest, northeast);
	};

	G5ELEMENT_MAP_BOX.LatLngBounds.prototype.extend = function (e) {
		this.bounds.extend(e.getSourceObject());
	};

	G5ELEMENT_MAP_BOX.LatLngBounds.prototype.getSourceObject = function () {
		return this.bounds;
	};


	G5ELEMENT_MAP_BOX.Marker = function (e) {
		this.options = $.extend(true, {
				position: false,
				map: false,
				popup: false,
				animation: false, // 'Drop' | 'Bounce' | 'Wobble'
				draggable: false,
				marker_image : '',
			}
			, e);
		this.init(e);
	};

	G5ELEMENT_MAP_BOX.Marker.prototype.init = function () {
		var marker_height = 70;
		if (this.options.marker_image !== '') {
			var el = document.createElement('div');
			el.className = "gel-map-box-marker-container";
			$(el).append(this.options.marker_image);
			this.marker = new mapboxgl.Marker({
				element: el,
				draggable: this.options.draggable
			});
			var $image = $(el).find('img');
				marker_height = $image.attr('height');
		} else {
			this.marker = new mapboxgl.Marker({
				draggable: this.options.draggable
			});

		}

		if (this.options.position) {
			this.setPosition(this.options.position);
		}

		if (this.options.map) {
			this.setMap(this.options.map);
		}

		if (this.options.popup) {
			var popup = new mapboxgl.Popup({ offset: [0,-(marker_height / 2)]}).setHTML(
				this.options.popup
			);
			this.marker.setPopup(popup);
		}
	};

	G5ELEMENT_MAP_BOX.Marker.prototype.getPosition = function () {
		return this.options.position;
	};

	G5ELEMENT_MAP_BOX.Marker.prototype.setPosition = function (e) {
		this.marker.setLngLat(e.getSourceObject());
		return  this;
	};

	G5ELEMENT_MAP_BOX.Marker.prototype.setMap = function (e) {
		this.marker.addTo(e.getSourceObject());
		return this;
	};

	G5ELEMENT_MAP_BOX.Marker.prototype.remove = function () {
		if (this.options.popup) {
			this.options.popup.remove();
		}
		this.marker.remove();
		return this;
	};

	G5ELEMENT_MAP_BOX.Marker.prototype.getSourceObject = function () {
		return this.marker;
	};



	G5ELEMENT_MAP_BOX.MAP = function (element) {
		this.$element = $(element);
		this.element = element;
		this.init();
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.init = function () {
		this.options = $.extend({}, G5ELEMENT_MAP_BOX.options, this.$element.data('options'));
		this.markers = [];
		this.bounds = new G5ELEMENT_MAP_BOX.LatLngBounds;
		this.id = typeof (this.$element.attr('id')) !== 'undefined' ? this.$element.attr('id') : Date.now();
		this.$element.attr('id',this.id);
		this.events = {
			zoom_changed: "zoomstart",
			bounds_changed: "moveend"
		};
		this.map = new mapboxgl.Map({
			container: this.element,
			zoom: parseInt(this.options.zoom, 10),
			minZoom: this.options.minZoom,
			interactive: this.options.draggable,
			style: G5ELEMENT_MAP_BOX.getSkin(this.options.skin),
			scrollZoom: this.options.scrollwheel
		});

		if (this.options.navigationControl) {
			this.map.addControl(new mapboxgl.NavigationControl({
				showCompass: false
			}));
			this.map.addControl(new mapboxgl.FullscreenControl);
		}

		this.setCenter(new G5ELEMENT_MAP_BOX.LatLng(0, 0));
		this.maybeAddMarkers();
		this.addListener("refresh", this.refresh.bind(this));

		G5ELEMENT_MAP_BOX.instances.push({
			id: this.id,
			map: this.map,
			instance: this
		});
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.setZoom = function (e) {
		this.map.setZoom(e);
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.resetZoom = function (e) {
		this.setZoom(this.options.zoom);
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.getZoom = function () {
		return Math.floor(this.map.getZoom());
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.setCenter = function (e) {
		this.map.setCenter(e.getSourceObject());
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.getSourceObject = function () {
		return this.map;
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.fitBounds = function (e) {
		if (!e.getSourceObject().isEmpty()) {
			this.map.fitBounds(e.getSourceObject(), {
				padding: 85,
				animate: !1
			});
		}
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.getBounds = function () {
		return this.map.getBounds();
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.getSourceObject = function () {
		return this.map;
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.addListener = function (e, t) {
		this.map.on(this.getSourceEvent(e), function (e) {
			t(e);
		});
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.getSourceEvent = function (e) {
		return void 0 !== this.events[e] ? this.events[e] : e;
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.trigger = function (e) {
		this.map.fire(this.getSourceEvent(e));
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.refresh = function () {
		this.map.resize();
	};

	G5ELEMENT_MAP_BOX.MAP.prototype.maybeAddMarkers = function() {
		var markers = this.$element.data('markers'),
			self = this;
		if (markers) {
			$.each(markers, function (index, item) {
				if (item.position) {
					var position = new G5ELEMENT_MAP_BOX.LatLng(item.position.lat, item.position.lng);
					var marker_option = {
						position: position,
						map: self,
						marker_image: item.marker
					};

					if (item.popup !== '') {
						marker_option.popup = item.popup;
					}


					var marker = new G5ELEMENT_MAP_BOX.Marker(marker_option);
					self.markers.push(marker);
					self.bounds.extend(marker.getPosition());
				}
			});

			if (self.markers.length < 1) {
				self.setZoom(2);
				self.setCenter(new G5ELEMENT_MAP_BOX.LatLng(33.9, 27.8));
			}

			if (self.markers.length === 1) {
				self.setCenter(self.markers[0].getPosition());
			}

			if (self.markers.length > 1) {
				self.fitBounds(self.bounds);
			}
		}
	};
	$(document).ready(function () {
		if (typeof (g5element_map_box_config) !== 'undefined' && g5element_map_box_config.accessToken !== '') {
			mapboxgl.accessToken = g5element_map_box_config.accessToken;
			$(".gel-map-box").each(function () {
				new G5ELEMENT_MAP_BOX.MAP(this);
			});

			$('[data-g5element-full-width="true"]').on('g5element_after_stretch_content',function () {
				var $maps = $(this).find('.gel-map-box');
				$maps.each(function () {
					var $this = $(this);
					setTimeout(function () {
						var id = $this.attr('id');
						var mapObj = G5ELEMENT_MAP_BOX.getInstance(id);
						if (mapObj) {
							mapObj.instance.refresh();
						}
					}, 50);

				});

			});

		}
	});
})(jQuery);