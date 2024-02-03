var G5ERE_MAP = G5ERE_MAP || {};
(function ($) {
	'use strict';

	G5ERE_MAP = {
		options: {
			locations: [],
			zoom: !isNaN(parseInt(g5ere_map_config.zoom, 10)) ? parseInt(g5ere_map_config.zoom, 10) : 12,
			minZoom: 0,
			skin: g5ere_map_config.skin,
			gestureHandling: 'cooperative',// "greedy",
			cluster_markers: g5ere_map_config.cluster_markers,
			draggable: true,
			navigationControl: true,
			mapTypeControl: false,
			streetViewControl: false,
		},
		instances: [],
		skins: [],
		getInstance: function (id) {
			for (var i = 0; i < this.instances.length; i++) {
				if (this.instances[i].id === id) {
					return this.instances[i];
				}
			}
			return false;
		},
		getSkin: function (skin) {
			return G5ERE_MAP.skins[skin] ? G5ERE_MAP.skins[skin] : G5ERE_MAP.skins.skin1
		},
		addListener: function (el, e, t) {
			google.maps.event.addListener(el, e, function (e) {
					t(e);
				}
			)
		}
	};

	/*
    * G5ERE_MAP.skins
    */
	G5ERE_MAP.skins = {
		skin1: [{
			featureType: "all",
			elementType: "labels.icon",
			stylers: [{
				visibility: "off"
			}
			]
		}
			,
			{
				featureType: "administrative",
				elementType: "geometry.fill",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "administrative.country",
				elementType: "geometry",
				stylers: [{
					lightness: "100"
				}
				]
			}
			,
			{
				featureType: "administrative.country",
				elementType: "geometry.stroke",
				stylers: [{
					lightness: "0"
				}
					,
					{
						color: "#d0ecff"
					}
				]
			}
			,
			{
				featureType: "administrative.country",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.province",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative.locality",
				elementType: "labels.text",
				stylers: [{
					visibility: "simplified"
				}
					,
					{
						color: "#777777"
					}
				]
			}
			,
			{
				featureType: "administrative.locality",
				elementType: "labels.icon",
				stylers: [{
					visibility: "simplified"
				}
					,
					{
						lightness: 60
					}
				]
			}
			,
			{
				featureType: "administrative.neighborhood",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative.land_parcel",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "landscape.man_made",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
					,
					{
						color: "#f5f5f5"
					}
				]
			}
			,
			{
				featureType: "landscape.natural",
				elementType: "geometry",
				stylers: [{
					color: "#fafafa"
				}
				]
			}
			,
			{
				featureType: "landscape.natural",
				elementType: "labels",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "geometry",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.attraction",
				elementType: "geometry",
				stylers: [{
					color: "#e2e8cf"
				}
				]
			}
			,
			{
				featureType: "poi.business",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "poi.business",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.medical",
				elementType: "all",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "poi.park",
				elementType: "geometry",
				stylers: [{
					color: "#ecf4d7"
				}
				]
			}
			,
			{
				featureType: "poi.park",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.place_of_worship",
				elementType: "geometry",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "poi.school",
				elementType: "geometry",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "poi.sports_complex",
				elementType: "geometry",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry",
				stylers: [{
					color: "#e5e5e5"
				}
					,
					{
						visibility: "simplified"
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "geometry.fill",
				stylers: [{
					color: "#ffffff"
				}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "geometry.stroke",
				stylers: [{
					visibility: "on"
				}
					,
					{
						color: "#eeeeee"
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "labels",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "labels.text",
				stylers: [{
					color: "#777777"
				}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit.line",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit.station",
				elementType: "geometry.fill",
				stylers: [{
					color: "#eeeeee"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "geometry.fill",
				stylers: [{
					color: "#d0ecff"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
		],
		skin2: [{
			featureType: "all",
			elementType: "labels.text.fill",
			stylers: [{
				saturation: "0"
			}
				,
				{
					color: "#f3f3f3"
				}
				,
				{
					lightness: "-40"
				}
				,
				{
					gamma: "1"
				}
			]
		}
			,
			{
				featureType: "all",
				elementType: "labels.text.stroke",
				stylers: [{
					visibility: "on"
				}
					,
					{
						color: "#000000"
					}
					,
					{
						lightness: "12"
					}
				]
			}
			,
			{
				featureType: "all",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative",
				elementType: "geometry.fill",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: "4"
					}
				]
			}
			,
			{
				featureType: "administrative",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: 17
					}
					,
					{
						weight: 1.2
					}
				]
			}
			,
			{
				featureType: "landscape",
				elementType: "geometry",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: "25"
					}
					,
					{
						gamma: "0.60"
					}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "geometry",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: "26"
					}
					,
					{
						gamma: "0.49"
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.fill",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: 17
					}
					,
					{
						gamma: "0.60"
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: 29
					}
					,
					{
						weight: .2
					}
					,
					{
						gamma: "0.60"
					}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "geometry",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: 18
					}
					,
					{
						gamma: "0.60"
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "geometry",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: 16
					}
					,
					{
						gamma: "0.60"
					}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "geometry",
				stylers: [{
					color: "#2c2d37"
				}
					,
					{
						lightness: "29"
					}
					,
					{
						gamma: "0.60"
					}
				]
			}
			,
			{
				featureType: "water",
				elementType: "geometry",
				stylers: [{
					color: "#3c3d47"
				}
					,
					{
						lightness: "16"
					}
					,
					{
						gamma: "0.50"
					}
				]
			}
		],
		skin3: [{
			featureType: "water",
			elementType: "geometry",
			stylers: [{
				color: "#e9e9e9"
			}
				,
				{
					lightness: 17
				}
			]
		}
			,
			{
				featureType: "landscape",
				elementType: "geometry",
				stylers: [{
					color: "#f5f5f5"
				}
					,
					{
						lightness: 20
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.fill",
				stylers: [{
					color: "#ffffff"
				}
					,
					{
						lightness: 17
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#ffffff"
				}
					,
					{
						lightness: 29
					}
					,
					{
						weight: .2
					}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "geometry",
				stylers: [{
					color: "#ffffff"
				}
					,
					{
						lightness: 18
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "geometry",
				stylers: [{
					color: "#ffffff"
				}
					,
					{
						lightness: 16
					}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "geometry",
				stylers: [{
					color: "#f5f5f5"
				}
					,
					{
						lightness: 21
					}
				]
			}
			,
			{
				featureType: "poi.park",
				elementType: "geometry",
				stylers: [{
					color: "#dedede"
				}
					,
					{
						lightness: 21
					}
				]
			}
			,
			{
				elementType: "labels.text.stroke",
				stylers: [{
					visibility: "on"
				}
					,
					{
						color: "#ffffff"
					}
					,
					{
						lightness: 16
					}
				]
			}
			,
			{
				elementType: "labels.text.fill",
				stylers: [{
					saturation: 36
				}
					,
					{
						color: "#333333"
					}
					,
					{
						lightness: 40
					}
				]
			}
			,
			{
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "geometry",
				stylers: [{
					color: "#f2f2f2"
				}
					,
					{
						lightness: 19
					}
				]
			}
			,
			{
				featureType: "administrative",
				elementType: "geometry.fill",
				stylers: [{
					color: "#fefefe"
				}
					,
					{
						lightness: 20
					}
				]
			}
			,
			{
				featureType: "administrative",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#fefefe"
				}
					,
					{
						lightness: 17
					}
					,
					{
						weight: 1.2
					}
				]
			}
		],
		skin4: [{
			featureType: "administrative",
			elementType: "labels.text.fill",
			stylers: [{
				color: "#444444"
			}
			]
		}
			,
			{
				featureType: "landscape",
				elementType: "all",
				stylers: [{
					color: "#f2f2f2"
				}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "all",
				stylers: [{
					saturation: -100
				}
					,
					{
						lightness: 45
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "all",
				stylers: [{
					color: "#46bcec"
				}
					,
					{
						visibility: "on"
					}
				]
			}
		],
		skin5: [{
			featureType: "landscape.man_made",
			elementType: "geometry",
			stylers: [{
				color: "#f7f1df"
			}
			]
		}
			,
			{
				featureType: "landscape.natural",
				elementType: "geometry",
				stylers: [{
					color: "#d0e3b4"
				}
				]
			}
			,
			{
				featureType: "landscape.natural.terrain",
				elementType: "geometry",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.business",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.medical",
				elementType: "geometry",
				stylers: [{
					color: "#fbd3da"
				}
				]
			}
			,
			{
				featureType: "poi.park",
				elementType: "geometry",
				stylers: [{
					color: "#bde6ab"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "geometry.stroke",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.fill",
				stylers: [{
					color: "#ffe15f"
				}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#efd151"
				}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "geometry.fill",
				stylers: [{
					color: "#ffffff"
				}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "geometry.fill",
				stylers: [{
					color: "black"
				}
				]
			}
			,
			{
				featureType: "transit.station.airport",
				elementType: "geometry.fill",
				stylers: [{
					color: "#cfb2db"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "geometry",
				stylers: [{
					color: "#a2daf2"
				}
				]
			}
		],
		skin6: [{
			featureType: "administrative",
			elementType: "all",
			stylers: [{
				visibility: "off"
			}
			]
		}
			,
			{
				featureType: "landscape",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
					,
					{
						hue: "#0066ff"
					}
					,
					{
						saturation: 74
					}
					,
					{
						lightness: 100
					}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
					,
					{
						weight: .6
					}
					,
					{
						saturation: -85
					}
					,
					{
						lightness: 61
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "all",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
					,
					{
						color: "#5f94ff"
					}
					,
					{
						lightness: 26
					}
					,
					{
						gamma: 5.86
					}
				]
			}
		],
		skin7: [{
			featureType: "water",
			elementType: "geometry",
			stylers: [{
				color: "#a0d6d1"
			}
				,
				{
					lightness: 17
				}
			]
		}
			,
			{
				featureType: "landscape",
				elementType: "geometry",
				stylers: [{
					color: "#ffffff"
				}
					,
					{
						lightness: 20
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.fill",
				stylers: [{
					color: "#dedede"
				}
					,
					{
						lightness: 17
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#dedede"
				}
					,
					{
						lightness: 29
					}
					,
					{
						weight: .2
					}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "geometry",
				stylers: [{
					color: "#dedede"
				}
					,
					{
						lightness: 18
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "geometry",
				stylers: [{
					color: "#ffffff"
				}
					,
					{
						lightness: 16
					}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "geometry",
				stylers: [{
					color: "#f1f1f1"
				}
					,
					{
						lightness: 21
					}
				]
			}
			,
			{
				elementType: "labels.text.stroke",
				stylers: [{
					visibility: "on"
				}
					,
					{
						color: "#ffffff"
					}
					,
					{
						lightness: 16
					}
				]
			}
			,
			{
				elementType: "labels.text.fill",
				stylers: [{
					saturation: 36
				}
					,
					{
						color: "#333333"
					}
					,
					{
						lightness: 40
					}
				]
			}
			,
			{
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "geometry",
				stylers: [{
					color: "#f2f2f2"
				}
					,
					{
						lightness: 19
					}
				]
			}
			,
			{
				featureType: "administrative",
				elementType: "geometry.fill",
				stylers: [{
					color: "#fefefe"
				}
					,
					{
						lightness: 20
					}
				]
			}
			,
			{
				featureType: "administrative",
				elementType: "geometry.stroke",
				stylers: [{
					color: "#fefefe"
				}
					,
					{
						lightness: 17
					}
					,
					{
						weight: 1.2
					}
				]
			}
		],
		skin8: [{
			featureType: "all",
			stylers: [{
				saturation: 0
			}
				,
				{
					hue: "#e7ecf0"
				}
			]
		}
			,
			{
				featureType: "road",
				stylers: [{
					saturation: -70
				}
				]
			}
			,
			{
				featureType: "transit",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "water",
				stylers: [{
					visibility: "simplified"
				}
					,
					{
						saturation: -60
					}
				]
			}
		],
		skin9: [{
			featureType: "all",
			elementType: "labels",
			stylers: [{
				visibility: "off"
			}
			]
		}
			,
			{
				featureType: "all",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.country",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.country",
				elementType: "labels.text",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.province",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.province",
				elementType: "labels.text",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.locality",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.neighborhood",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.land_parcel",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "landscape",
				elementType: "all",
				stylers: [{
					hue: "#FFBB00"
				}
					,
					{
						saturation: 43.400000000000006
					}
					,
					{
						lightness: 37.599999999999994
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "landscape",
				elementType: "geometry.fill",
				stylers: [{
					saturation: "-40"
				}
					,
					{
						lightness: "36"
					}
				]
			}
			,
			{
				featureType: "landscape.man_made",
				elementType: "geometry",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "landscape.natural",
				elementType: "geometry.fill",
				stylers: [{
					saturation: "-77"
				}
					,
					{
						lightness: "28"
					}
				]
			}
			,
			{
				featureType: "landscape.natural",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "all",
				stylers: [{
					hue: "#ff0091"
				}
					,
					{
						saturation: -44
					}
					,
					{
						lightness: 11.200000000000017
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
					,
					{
						saturation: -81
					}
				]
			}
			,
			{
				featureType: "poi.attraction",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.park",
				elementType: "geometry.fill",
				stylers: [{
					saturation: "-24"
				}
					,
					{
						lightness: "61"
					}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels.text.fill",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "all",
				stylers: [{
					hue: "#ff0048"
				}
					,
					{
						saturation: -78
					}
					,
					{
						lightness: 45.599999999999994
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.highway.controlled_access",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "all",
				stylers: [{
					hue: "#FF0300"
				}
					,
					{
						saturation: -100
					}
					,
					{
						lightness: 51.19999999999999
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "all",
				stylers: [{
					hue: "#ff0300"
				}
					,
					{
						saturation: -100
					}
					,
					{
						lightness: 52
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "geometry",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "geometry.stroke",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit.line",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit.station",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "all",
				stylers: [{
					hue: "#789cdb"
				}
					,
					{
						saturation: -66
					}
					,
					{
						lightness: 2.4000000000000057
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "water",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
		],
		skin10: [{
			featureType: "all",
			elementType: "labels",
			stylers: [{
				visibility: "on"
			}
			]
		}
			,
			{
				featureType: "administrative.country",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.country",
				elementType: "labels.text",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.province",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.province",
				elementType: "labels.text",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.locality",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.neighborhood",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative.land_parcel",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "landscape",
				elementType: "all",
				stylers: [{
					hue: "#FFBB00"
				}
					,
					{
						saturation: 43.400000000000006
					}
					,
					{
						lightness: 37.599999999999994
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "landscape",
				elementType: "geometry.fill",
				stylers: [{
					saturation: "-40"
				}
					,
					{
						lightness: "36"
					}
				]
			}
			,
			{
				featureType: "landscape.man_made",
				elementType: "geometry",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "landscape.natural",
				elementType: "geometry.fill",
				stylers: [{
					saturation: "-77"
				}
					,
					{
						lightness: "28"
					}
				]
			}
			,
			{
				featureType: "landscape.natural",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "all",
				stylers: [{
					hue: "#00FF6A"
				}
					,
					{
						saturation: -1.0989010989011234
					}
					,
					{
						lightness: 11.200000000000017
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.attraction",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "poi.park",
				elementType: "geometry.fill",
				stylers: [{
					saturation: "-24"
				}
					,
					{
						lightness: "61"
					}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels.text.fill",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "all",
				stylers: [{
					hue: "#FFC200"
				}
					,
					{
						saturation: -61.8
					}
					,
					{
						lightness: 45.599999999999994
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.highway.controlled_access",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.arterial",
				elementType: "all",
				stylers: [{
					hue: "#FF0300"
				}
					,
					{
						saturation: -100
					}
					,
					{
						lightness: 51.19999999999999
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "all",
				stylers: [{
					hue: "#ff0300"
				}
					,
					{
						saturation: -100
					}
					,
					{
						lightness: 52
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "road.local",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "geometry",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "geometry.stroke",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit.line",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit.station",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "all",
				stylers: [{
					hue: "#0078FF"
				}
					,
					{
						saturation: -13.200000000000003
					}
					,
					{
						lightness: 2.4000000000000057
					}
					,
					{
						gamma: 1
					}
				]
			}
			,
			{
				featureType: "water",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}
				]
			}
		],
		skin11: [{
			featureType: "all",
			elementType: "labels",
			stylers: [{
				visibility: "on"
			}
			]
		}
			,
			{
				featureType: "administrative.country",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "administrative.country",
				elementType: "labels.text",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "all",
				elementType: "geometry",
				stylers: [{
					color: "#262c33"
				}
				]
			}
			,
			{
				featureType: "all",
				elementType: "labels.text.fill",
				stylers: [{
					gamma: .01
				}
					,
					{
						lightness: 20
					}
					,
					{
						color: "#949aa6"
					}
				]
			}
			,
			{
				featureType: "all",
				elementType: "labels.text.stroke",
				stylers: [{
					saturation: -31
				}
					,
					{
						lightness: -33
					}
					,
					{
						weight: 2
					}
					,
					{
						gamma: "0.00"
					}
					,
					{
						visibility: "off"
					}
				]
			}
			,
			{
				featureType: "all",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative.province",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative.locality",
				elementType: "all",
				stylers: [{
					visibility: "simplified"
				}
				]
			}
			,
			{
				featureType: "administrative.locality",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative.neighborhood",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "administrative.land_parcel",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "landscape",
				elementType: "geometry",
				stylers: [{
					lightness: 30
				}
					,
					{
						saturation: 30
					}
					,
					{
						color: "#353c44"
					}
					,
					{
						visibility: "on"
					}
				]
			}
			,
			{
				featureType: "poi",
				elementType: "geometry",
				stylers: [{
					saturation: "0"
				}
					,
					{
						lightness: "0"
					}
					,
					{
						gamma: "0.30"
					}
					,
					{
						weight: "0.01"
					}
					,
					{
						visibility: "off"
					}
				]
			}
			,
			{
				featureType: "poi.park",
				elementType: "geometry",
				stylers: [{
					lightness: "100"
				}
					,
					{
						saturation: -20
					}
					,
					{
						visibility: "simplified"
					}
					,
					{
						color: "#31383f"
					}
				]
			}
			,
			{
				featureType: "road",
				elementType: "geometry",
				stylers: [{
					lightness: 10
				}
					,
					{
						saturation: -30
					}
					,
					{
						color: "#2a3037"
					}
				]
			}
			,
			{
				featureType: "road",
				elementType: "geometry.stroke",
				stylers: [{
					saturation: "-100"
				}
					,
					{
						lightness: "-100"
					}
					,
					{
						gamma: "0.00"
					}
					,
					{
						color: "#2a3037"
					}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels",
				stylers: [{
					visibility: "on"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels.text",
				stylers: [{
					visibility: "on"
				}
					,
					{
						color: "#575e6b"
					}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels.text.stroke",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road",
				elementType: "labels.icon",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.fill",
				stylers: [{
					color: "#4c5561"
				}
					,
					{
						visibility: "on"
					}
				]
			}
			,
			{
				featureType: "road.highway",
				elementType: "geometry.stroke",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "transit.station.airport",
				elementType: "all",
				stylers: [{
					visibility: "off"
				}
				]
			}
			,
			{
				featureType: "water",
				elementType: "all",
				stylers: [{
					lightness: -20
				}
					,
					{
						color: "#2a3037"
					}
				]
			}
		],
		skin12: []
	};


	/**
	 * G5ERE_MAP.LatLng
	 * @param latitude
	 * @param longitude
	 * @constructor
	 */
	G5ERE_MAP.LatLng = function (latitude, longitude) {
		this.init(latitude, longitude);
	};

	G5ERE_MAP.LatLng.prototype.init = function (latitude, longitude) {
		this.latitude = latitude;
		this.longitude = longitude;
		this.latlng = new google.maps.LatLng(latitude, longitude)
	};

	G5ERE_MAP.LatLng.prototype.getLatitude = function () {
		return this.latlng.lat();
	};

	G5ERE_MAP.LatLng.prototype.getLongitude = function () {
		return this.latlng.lng()
	};

	G5ERE_MAP.LatLng.prototype.toGeocoderFormat = function () {
		return this.latlng;
	};

	G5ERE_MAP.LatLng.prototype.getSourceObject = function () {
		return this.latlng;
	};


	/**
	 * G5ERE_MAP.LatLngBounds
	 * @param southwest
	 * @param northeast
	 * @constructor
	 */
	G5ERE_MAP.LatLngBounds = function (southwest, northeast) {
		this.init(southwest, northeast)
	};

	G5ERE_MAP.LatLngBounds.prototype.init = function (southwest, northeast) {
		this.southwest = southwest;
		this.northeast = northeast;
		this.bounds = new google.maps.LatLngBounds(southwest, northeast);
	};

	G5ERE_MAP.LatLngBounds.prototype.extend = function (e) {
		this.bounds.extend(e.getSourceObject());
	};

	G5ERE_MAP.LatLngBounds.prototype.getSourceObject = function () {
		return this.bounds;
	};


	/**
	 * G5ERE_MAP.Clusterer
	 * @param e
	 * @constructor
	 */
	G5ERE_MAP.Clusterer = function (e) {
		this.init(e);
	};

	G5ERE_MAP.Clusterer.prototype.init = function (e) {
		this.map = e;
		var options = {
			clusterClass: 'g5ere__cluster',
			styles: [
				{
					textColor: "#fff",
					height: 35,
					width: 35
				}
			]
		};
		this.clusterer = new MarkerClusterer(this.map.getSourceObject(), this.getMarkers(), options);
	};

	G5ERE_MAP.Clusterer.prototype.getMarkers = function () {
		return this.map.markers.map(function (e) {
				return e.getSourceObject();
			}
		)
	};

	G5ERE_MAP.Clusterer.prototype.update = function () {
		this.clusterer.clearMarkers();
		this.clusterer.addMarkers(this.getMarkers());
	};

	G5ERE_MAP.Clusterer.prototype.setMaxZoom = function(e) {
		this.clusterer.setMaxZoom(e);
	};

	G5ERE_MAP.Clusterer.prototype.repaint = function() {
		this.clusterer.repaint();
	};


	/**
	 * G5ERE_MAP.Marker
	 * @param e
	 * @constructor
	 */
	G5ERE_MAP.Marker = function (e) {
		var newConfigMarker = $.parseJSON(JSON.stringify(g5ere_map_config.marker));
		this.options = $.extend(true, {
				position: false,
				map: false,
				popup: false,
				animation: false,
				draggable: false,
				template: {
					type: 'basic', // 'simple'| 'basic'
					marker: newConfigMarker,
					id: ''
				}
			}
			, e);
		this.init(e);
	};

	G5ERE_MAP.Marker.prototype.init = function (e) {
		if (this.options.template.type === 'basic') {
			this.marker = new G5ERE_MAP.MarkerOverLay(this);
		} else {
			this.marker = new google.maps.Marker({
				position: this.options.position.latlng,
				map: this.options.map.map,
				draggable: this.options.draggable,
				animation: this.options.animation
			});
		}
		this.options.position && this.setPosition(this.options.position);
		this.options.map && this.setMap(this.options.map);
	};

	G5ERE_MAP.Marker.prototype.setPosition = function (e) {
		this.marker.setPosition(e.getSourceObject());
		return this;
	};

	G5ERE_MAP.Marker.prototype.getPosition = function () {
		return this.options.position;
	};

	G5ERE_MAP.Marker.prototype.setMap = function (e) {
		this.marker.setMap(e.getSourceObject());
		return this;
	};


	G5ERE_MAP.Marker.prototype.remove = function () {
		if (this.options.popup) {
			this.options.popup.remove();
		}
		this.marker.setMap(null);
		this.marker.remove();
		return this;
	};

	G5ERE_MAP.Marker.prototype.getSourceObject = function () {
		return this.marker;
	};

	G5ERE_MAP.Marker.prototype.getTemplate = function () {
		var e = document.createElement("div");
		e.className = "g5ere__marker-container";
		e.style.position = "absolute";
		e.style.cursor = "pointer";
		e.style.zIndex = 10;
		e.id = this.options.template.id;
		var t = $("#g5ere__marker_template").html().replace("{{icon}}", this.options.template.marker.html).replace("{{type}}", this.options.template.marker.type);
		$(e).append(t);
		return e;
	};


	G5ERE_MAP.Marker.prototype.active = function(){
		var self = this;
		if ("object" === typeof (self.options.map)) {
			var $markerElement =  self.options.map.$element.find('#' + self.options.template.id);
			if ($markerElement.length > 0) {
				$markerElement.addClass('active');
			}
		}
		$(self.marker.args.template).trigger('click');
	};

	/**
	 * G5ERE_MAP.MarkerOverLay
	 * @param e
	 * @constructor
	 */
	G5ERE_MAP.MarkerOverLay = function (e) {
		this.args = {
			marker: e,
			template: null,
			latlng: e.getPosition().getSourceObject(),
			map: e.options.map,
			animation: e.options.animation,
			popup: e.options.popup,
			draggable: e.options.draggable
		};
		if (this.args.map && this.args.popup) {
			this.args.popup.setMap(this.args.map);
		}
	};

	"undefined" != typeof google && (G5ERE_MAP.MarkerOverLay.prototype = new google.maps.OverlayView);

	G5ERE_MAP.MarkerOverLay.prototype.onAdd = function () {
		var self = this;
		if (!this.args.template) {
			this.args.template = this.args.marker.getTemplate();
			if (this.args.map && this.args.popup) {
				google.maps.event.addDomListener(this.args.template, 'click', function (e) {
					e.preventDefault();
					e.stopPropagation();
					self.args.map.closePopups();
					self.args.popup.setPosition(self.args.marker.getPosition());

					var $marker = $(this).find('.g5ere__pin-wrap'),
						marker_bottom = parseInt($marker.css('bottom').replace('px', '')),
						marker_height = $marker.height() + marker_bottom;
					self.args.popup.popup.setOptions({
						boxStyle: {
							width: self.args.popup.options.width ? self.args.popup.options.width : "300px",
							zIndex: 5e6,
							margin: '0 0 ' + marker_height + 'px 0'
						}
					});
					self.args.popup.show();
				});
			}
			this.getPanes().overlayImage.appendChild(this.args.template);
		}
	};

	G5ERE_MAP.MarkerOverLay.prototype.draw = function () {
		this.setPosition(this.args.latlng);
	};

	G5ERE_MAP.MarkerOverLay.prototype.remove = function () {
		if (this.args.template) {
			this.args.template.parentNode.removeChild(this.args.template);
			this.args.template = null;
		}
	};

	G5ERE_MAP.MarkerOverLay.prototype.getPosition = function () {
		return this.args.latlng;
	};

	G5ERE_MAP.MarkerOverLay.prototype.setPosition = function (e) {
		this.args.latlng = e;
		if (this.args.template && !(!this.args.latlng instanceof google.maps.LatLng)) {
			var t = this.getProjection().fromLatLngToDivPixel(this.args.latlng);
			this.args.template.style.left = t.x + "px";
			this.args.template.style.top = t.y + "px";
		}
	};

	G5ERE_MAP.MarkerOverLay.prototype.getDraggable = function () {
		return this.args.draggable;
	};


	/**
	 * G5ERE_MAP.Geocoder
	 * @constructor
	 */
	G5ERE_MAP.Geocoder = function () {
		this.init();
	};

	G5ERE_MAP.Geocoder.prototype.init = function () {
		this.geocoder = new google.maps.Geocoder();
	};

	G5ERE_MAP.Geocoder.prototype.setMap = function (e) {
		this.map = e;
	};

	G5ERE_MAP.Geocoder.prototype.geocode = function (e, t, i) {
		var self = this,
			r = {},
			o = false;


		if (typeof t === 'function') {
			i = t;
			t = {};
		}


		if (e instanceof google.maps.LatLng) {
			r.location = e;
		} else if (e instanceof G5ERE_MAP.LatLng) {
			r.location = e.getSourceObject();
		} else {
			if ("string" != typeof e || !e.length) return i(o);
			r.address = e;
		}

		t = $.extend({
			limit: 1
		}, t);

		this.geocoder.geocode(r, function (results, status) {
			if (status === 'OK' && results && results.length) {
				o = t.limit === 1 ? self.formatFeature(results[0]) : results.map(self.formatFeature);
			}
			return i(o);
		});
	};

	G5ERE_MAP.Geocoder.prototype.formatFeature = function (e) {
		return {
			location: new G5ERE_MAP.LatLng(e.geometry.location.lat(), e.geometry.location.lng()),
			latitude: e.geometry.location.lat(),
			longitude: e.geometry.location.lng(),
			address: e.formatted_address
		}
	};

	/**
	 * G5ERE_MAP.Autocomplete
	 * */
	G5ERE_MAP.Autocomplete = function (e) {
		$(e).data('autocomplete', this);
		this.init(e);
	};

	G5ERE_MAP.Autocomplete.prototype.init = function (e) {
		if (!(e instanceof Element)) return false;
		this.element = e;
		this.$element = $(e);
		this.options = {};

		if (g5ere_map_config.types.length) {
			this.options.types = [g5ere_map_config.types];
		}

		if (g5ere_map_config.countries.length) {
			this.options.componentRestrictions = {
				country: g5ere_map_config.countries
			};
		}

		this.geocoder = new G5ERE_MAP.Geocoder();
		this.autocomplete = new google.maps.places.Autocomplete(this.element, this.options);
		this.$element.on('keydown', function (e) {
			if (e.which === 13) {
				e.preventDefault();
			}
		});
	};

	G5ERE_MAP.Autocomplete.prototype.change = function (t) {
		var self = this;
		this.autocomplete.addListener('place_changed', function () {
			var place = self.autocomplete.getPlace();
			var e = false;
			if (typeof place.geometry !== "undefined") {
				e = self.geocoder.formatFeature(self.autocomplete.getPlace());
			} else if (typeof place.name !== 'undefined') {
				self.geocoder.geocode(place.name, function (e) {
					if (e) {
						self.$element.val(e.address);
						t(e);
					}
				});
			}
			t(e);
		});
	};

	/**
	 * G5ERE_MAP.Popup
	 * @param e
	 * @constructor
	 */
	G5ERE_MAP.Popup = function (e) {
		this.options = $.extend(true, {
			content: "",
			classes: "g5ere__map-popup-wrap g5ere__map-popup-google",
			position: false,
			map: false,
			width: false
		}, e);
		this.init(e);
	};

	G5ERE_MAP.Popup.prototype.init = function (e) {
		this.template_name = "default";
		this.popup = new InfoBox({
				content: "",
				disableAutoPan: false,
				maxWidth: 0,
				zIndex: 5e8,
				boxClass: this._getBoxClass(),
				boxStyle: {
					width: this.options.width ? this.options.width : "300px",
					zIndex: 5e6
				},
				//closeBoxURL: "",
				infoBoxClearance: new google.maps.Size(1, 1),
				isHidden: false,
				pane: "floatPane",
				enableEventPropagation: false,
				alignBottom: true
			}
		);

		if (this.options.position) {
			this.setPosition(this.options.position);
		}

		if (this.options.content) {
			this.setContent(this.options.content);
		}

		if (this.options.map) {
			this.setMap(this.options.map);
		}
	};

	G5ERE_MAP.Popup.prototype.setContent = function (e) {
		this.popup.setContent(e);
		return this;
	};

	G5ERE_MAP.Popup.prototype.setPosition = function (e) {
		this.popup.setPosition(e.getSourceObject());
		return this;
	};

	G5ERE_MAP.Popup.prototype.setMap = function (e) {
		this.map = e;
		return this;
	};

	G5ERE_MAP.Popup.prototype.remove = function () {
		this.popup.close();
		return this;

	};

	G5ERE_MAP.Popup.prototype.show = function () {
		return this.popup.getVisible() ? this : (this.popup.open(this.map.getSourceObject()), setTimeout(function () {
			this.popup.setOptions({
					boxClass: this._getBoxClass() + " show"
				}
			)
		}
			.bind(this), 5), this)
	};

	G5ERE_MAP.Popup.prototype.hide = function () {
		return this.popup.getVisible() ? (this.remove(), this.popup.setOptions({
				boxClass: this._getBoxClass()
			}
		), this) : this
	};

	G5ERE_MAP.Popup.prototype._getBoxClass = function () {
		return [this.options.classes ? this.options.classes : "", "tpl-" + this.template_name].join(" ");
	};


	/**
	 * G5ERE_MAP.MAP
	 * @param element
	 * @constructor
	 */
	G5ERE_MAP.MAP = function (element) {
		this.$element = $(element);
		this.element = element;
		this.init();
	};

	G5ERE_MAP.MAP.prototype.init = function () {
		this.options = $.extend({}, G5ERE_MAP.options, this.$element.data('options'));
		this.markers = [];
		this.bounds = new G5ERE_MAP.LatLngBounds;
		this.id = typeof (this.$element.attr('id')) !== 'undefined' ? this.$element.attr('id') : false;
		this.events = {};
		this.map = new google.maps.Map(this.element, {
			zoom: parseInt(this.options.zoom, 10),
			minZoom: this.options.minZoom,
			styles: G5ERE_MAP.getSkin(this.options.skin),
			gestureHandling: this.options.gestureHandling,
			draggable: this.options.draggable,
			navigationControl: this.options.navigationControl,
			mapTypeControl: this.options.mapTypeControl,
			streetViewControl: this.options.streetViewControl,
		});

		this.setCenter(new G5ERE_MAP.LatLng(0, 0));
		this.maybeAddMarkers();

		if (this.options.cluster_markers) {
			this.clusterer = new G5ERE_MAP.Clusterer(this);
			this.addListener('updated_markers', this._updateCluster.bind(this));
		}

		this.addListener("zoom_changed", this.closePopups.bind(this));
		this.addListener("click", this.closePopups.bind(this));

		G5ERE_MAP.instances.push({
			id: this.id,
			map: this.map,
			instance: this
		});
	};

	G5ERE_MAP.MAP.prototype.maybeAddMarkers = function() {
		if (this.options._type === 'single-location') {
			var location = this.$element.data('location');
			if (location && location.position) {
				this.trigger('updating_markers');
				var position = new G5ERE_MAP.LatLng(location.position.lat, location.position.lng);
				var marker_option = {
					position: position,
					map: this,
					template: {
					}
				};

				if (location.marker) {
					marker_option.template.marker = location.marker;
					marker_option.template.id = location.id;
				}
				if (location.popup) {
					var template = wp.template('g5ere__map_popup_template');
					var content_popup = template(location);
					marker_option.popup = new G5ERE_MAP.Popup({
						content: content_popup
					});
				}

				var marker = new G5ERE_MAP.Marker(marker_option);
				this.markers.push(marker);
				this.setCenter(position);
				this.trigger("updated_markers");
			}
		}
	};


	G5ERE_MAP.MAP.prototype.setZoom = function (e) {
		this.map.setZoom(e);
	};

	G5ERE_MAP.MAP.prototype.resetZoom = function (e) {
		this.setZoom(this.options.zoom);
	};

	G5ERE_MAP.MAP.prototype.getZoom = function () {
		return this.map.getZoom();
	};


	G5ERE_MAP.MAP.prototype.setCenter = function (e) {
		this.map.setCenter(e.getSourceObject());
	};

	G5ERE_MAP.MAP.prototype.fitBounds = function (e) {
		this.map.fitBounds(e.getSourceObject());
	};

	G5ERE_MAP.MAP.prototype.panTo = function (e) {
		this.map.panTo(e.getSourceObject());
	};

	G5ERE_MAP.MAP.prototype.getClickPosition = function (e) {
		return new G5ERE_MAP.LatLng(e.latLng.lat(), e.latLng.lng());
	};

	G5ERE_MAP.MAP.prototype.getDragPosition = function (e) {
		return new G5ERE_MAP.LatLng(e.latLng.lat(), e.latLng.lng());
	};

	G5ERE_MAP.MAP.prototype.addListener = function (e, t) {
		google.maps.event.addListener(this.map, this.getSourceEvent(e), function (e) {
				t(e);
			}
		)
	};

	G5ERE_MAP.MAP.prototype.addListenerOnce = function (e, t) {
		google.maps.event.addListenerOnce(this.map, this.getSourceEvent(e), function (e) {
				t(e);
			}
		);
	};

	G5ERE_MAP.MAP.prototype.trigger = function (e) {
		google.maps.event.trigger(this.map, this.getSourceEvent(e));
	};

	G5ERE_MAP.MAP.prototype.getSourceObject = function () {
		return this.map;
	};


	G5ERE_MAP.MAP.prototype.getSourceEvent = function (e) {
		return void 0 !== this.events[e] ? this.events[e] : e;
	};

	G5ERE_MAP.MAP.prototype.closePopups = function () {
		for (var i = 0; i < this.markers.length; i++) {
			if ("object" === typeof (this.markers[i].options.popup)) {
				this.markers[i].options.popup.hide();
			}
		}
	};

	G5ERE_MAP.MAP.prototype.removeMarkers = function () {
		for (var i = 0; i < this.markers.length; i++) {
			this.markers[i].remove();
		}
		this.markers.length = 0;
		this.markers = [];
	};

	G5ERE_MAP.MAP.prototype._updateCluster = function () {
		this.clusterer || (this.clusterer = new G5ERE_MAP.Clusterer(this));
		setTimeout(function () {
			this.clusterer.update();
		}.bind(this), 5);
	};

	G5ERE_MAP.MAP.prototype.refresh = function () {
	};


	G5ERE_MAP.MAP.prototype.activeMarker = function(id) {
		if (this.options.cluster_markers) {
			this.clusterer.setMaxZoom(1);
			this.clusterer.repaint();
		}

		var self = this;
		clearTimeout(this.timeOutActive);
		this.timeOutActive = setTimeout(function () {
			for (var i = 0; i < self.markers.length; i++) {
				if (self.markers[i].options.template.id == id) {
					self.markers[i].active();
					break;
				}
			}
		},10);
	};

	G5ERE_MAP.MAP.prototype.deactiveMarker = function() {
		var self = this;
		if (self.options.cluster_markers) {
			self.clusterer.setMaxZoom(13);
			self.clusterer.repaint();
		}
		self.$element.find('.g5ere__marker-container').removeClass('active');
		self.closePopups();
	};




	typeof (google) !== 'undefined' && typeof (g5ere_map_config) !== 'undefined' && google.maps.event.addDomListener(window, 'load', function () {
		if (typeof g5ere_map_config.skin_custom === 'object' && g5ere_map_config.skin === 'custom') {
			try {
				G5ERE_MAP.skins.custom = JSON.parse(g5ere_map_config.skin_custom);
			} catch (e) {
				G5ERE_MAP.skins.custom = [];
			}
		}

		$('.g5ere__map-canvas:not(.manual)').each(function () {
			new G5ERE_MAP.MAP(this);
		});
		$(document).trigger("maps:loaded");
	});

})(jQuery);