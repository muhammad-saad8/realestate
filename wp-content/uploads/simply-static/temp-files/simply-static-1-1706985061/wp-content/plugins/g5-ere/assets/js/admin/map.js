var G5ERE_ADMIN_MAP = G5ERE_ADMIN_MAP || {};
(function ($) {
	G5ERE_ADMIN_MAP = {
		map: null,
		lat: '',
		lng: '',
		id: 'g5ere__admin_property_map',
		init: function () {
			var that = this;
			this.setupMap();
			this.updateMap();
			$(document).on('click', '.g5ere__enter-coordinates-toggle label', function () {
				$('.g5ere__location-coords').toggleClass('hide');
			});
			$('[data-id="section_real_estate_location_tab"]').on('click', function () {
				if (that.map) {
					setTimeout(function () {
						that.map.refresh();
					}, 50);
				}
			});
		},
		setupMap: function () {
			var t = G5ERE_MAP.getInstance(this.id);
			this.map = t.instance;
		},
		updateMap: function () {
			var self = this;
			if (self.map) {
				var $address = $('.g5ere__property_address'),
					$lockPin = $('.g5ere__map-lock-pin'),
					$currentLocation = $('.g5ere__current-location');
				this.lat = self.map.options.position.lat ? self.map.options.position.lat : g5ere_admin_map_vars.coordinate_default.lat;
				this.lng = self.map.options.position.lng ? self.map.options.position.lng : g5ere_admin_map_vars.coordinate_default.lng;

				var position = new G5ERE_MAP.LatLng(this.lat, this.lng),
					autoComplete = new G5ERE_MAP.Autocomplete($address[0]),
					marker = new G5ERE_MAP.Marker({
						position: position,
						map: self.map,
						template: {
							type: 'simple'
						},
						draggable: true
					});
				self.setPosition();
				if (self.map.markers.length < 1) {
					self.map.markers.push(marker);
				}
				self.map.setCenter(position);


				autoComplete.change(function (e) {
					if (e) {
						self.map.setCenter(e.location);
						marker.setPosition(e.location);
						self.lat = e.latitude;
						self.lng = e.longitude;
						self.setPosition();
					}
				});

				// Map click
				G5ERE_MAP.addListener(self.map.getSourceObject(), 'click', function (e) {
					if (!$lockPin.is(':checked')) {
						var latLng = self.map.getClickPosition(e);
						marker.setPosition(latLng);
						self.lat = latLng.getLatitude();
						self.lng = latLng.getLongitude();
						self.setPosition();
						autoComplete.geocoder.geocode(latLng.toGeocoderFormat(), function (results) {
							if (results) {
								$address.val(results.address);
							}
						});
					}
				});

				G5ERE_MAP.addListener(self.map.getSourceObject(), 'resize', function (e) {
					self.map.panTo(new G5ERE_MAP.LatLng(self.lat, self.lng));
				});

				// Marker drag
				G5ERE_MAP.addListener(marker.getSourceObject(), 'dragend', function (e) {
					var latLng = self.map.getDragPosition(e);
					self.lat = latLng.getLatitude();
					self.lng = latLng.getLongitude();
					self.setPosition();
					autoComplete.geocoder.geocode(latLng.toGeocoderFormat(), function (results) {
						if (results) {
							$address.val(results.address);
						}
					});
				});

				$currentLocation.on('click', function (e) {
					e.preventDefault();
					if (navigator.geolocation) {
						navigator.geolocation.getCurrentPosition(function (position) {
							var latLng = new G5ERE_MAP.LatLng(position.coords.latitude, position.coords.longitude);
							autoComplete.geocoder.geocode(latLng.toGeocoderFormat(), function (results) {
								if (results) {
									$address.val(results.address);
								}
							});
							self.map.setCenter(latLng);
							marker.setPosition(latLng);
							self.lat = latLng.getLatitude();
							self.lng = latLng.getLongitude();
							self.setPosition();
						}, function (e) {
						});
					}
				});

				$('[name="real_estate_map_lat"],[name="real_estate_map_lng"]').on('change', function () {
					var latLng = self.getPosition();
					if (latLng) {
						autoComplete.geocoder.geocode(latLng.toGeocoderFormat(), function (results) {
							if (results) {
								$address.val(results.address);
							}
						});
						self.map.setCenter(latLng);
						marker.setPosition(latLng);
						self.map.resetZoom();
						$('[name="real_estate_property_location[location]"]').val(self.lat + ',' + self.lng);
					} else {
						self.setPosition();
					}
				});

			}
		},
		setPosition: function () {
			$('[name="real_estate_map_lat"]').val(this.lat);
			$('[name="lat"]').val(this.lat);
			$('[name="real_estate_map_lng"]').val(this.lng);
			$('[name="lng"]').val(this.lng);
			$('[name="real_estate_property_location[location]"]').val(this.lat + ',' + this.lng);
		},
		getPosition: function () {
			var $lat = $('[name="real_estate_map_lat"]'),
				$lng = $('[name="real_estate_map_lng"]'),
				lat = $lat.val(),
				lng = $lng.val(),
				latPattern = new RegExp($lat.attr('pattern')),
				lngPattern = new RegExp($lng.attr('pattern'));
			if (!latPattern.test(lat) || !lngPattern.test(lng)) {
				return false;
			}
			this.lat = lat;
			this.lng = lng;
			return new G5ERE_MAP.LatLng(lat, lng);
		}
	};

	$(document).on('maps:loaded', function () {
		G5ERE_ADMIN_MAP.init();
	});

})(jQuery);