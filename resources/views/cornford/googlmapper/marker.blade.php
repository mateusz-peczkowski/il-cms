@if ($options['user'] && $options['place'])

	var service = new google.maps.places.PlacesService({!! $options['map'] !!});
	var request = {
		placeId: '{!! $options['place'] !!}'
	};

	service.getDetails(request, function(placeResult, status) {
		if (status != google.maps.places.PlacesServiceStatus.OK) {
			alert('Unable to find the Place details.');
			return;
		}

@endif

var markerPosition_{!! $id !!} = new google.maps.LatLng({!! $options['latitude'] !!}, {!! $options['longitude'] !!});

var marker_{!! $id !!} = new google.maps.Marker({
	position: markerPosition_{!! $id !!},
	@if ($options['user'] && $options['place'])
		place: {
			placeId: '{!! $options['place'] !!}',
			location: { lat: {!! $options['latitude'] !!}, lng: {!! $options['longitude'] !!} }
		},
		attribution: {
			source: document.title,
			webUrl: document.URL
		},
	@endif
		
	@if (isset($options['draggable']) && $options['draggable'] == true)
		draggable:true,
	@endif
	
	title: {!! json_encode((string) $options['title']) !!},
	label: {!! json_encode((string) $options['label']) !!},
	animation: @if (empty($options['animation']) || $options['animation'] == 'NONE') '' @else google.maps.Animation.{!! $options['animation'] !!} @endif,
	@if ($options['symbol'])
		icon: {
			path: google.maps.SymbolPath.{!! $options['symbol'] !!},
			scale: {!! $options['scale'] !!}
		}
	@else
		icon: {!! json_encode((is_array($options['icon']) ? (array) $options['icon'] : (string) $options['icon'])) !!}
	@endif
});

bounds.extend(marker_{!! $id !!}.position);

marker_{!! $id !!}.setMap({!! $options['map'] !!});
markers.push(marker_{!! $id !!});

bounds.extend(marker_{!! $id !!}.position);

marker_{!! $id !!}.setMap({!! $options['map'] !!});
markers.push(marker_{!! $id !!});

autocomplete.addListener('place_changed', function() {
	marker_{!! $id !!}.setVisible(false);
	var place = autocomplete.getPlace();
	if (!place.geometry) {
		window.alert("Autocomplete's returned place contains no geometry");
		return;
	}

	// If the place has a geometry, then present it on a map.
	if (place.geometry.viewport) {
		map_{!! $id !!}.fitBounds(place.geometry.viewport);
	} else {
		map_{!! $id !!}.setCenter(place.geometry.location);
		map_{!! $id !!}.setZoom(12);  // Why 17? Because it looks good.
	}

	marker_{!! $id !!}.setPosition(place.geometry.location);
	marker_{!! $id !!}.setVisible(true);

	var address = '';
	if (place.address_components) {
		address = [
			(place.address_components[0] && place.address_components[0].short_name || ''),
			(place.address_components[1] && place.address_components[1].short_name || ''),
			(place.address_components[2] && place.address_components[2].short_name || '')
		].join(' ');
	}

	infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
	infowindow.open(map_{!! $id !!}, marker_{!! $id !!});
});

@if ($options['user'] && $options['place'])

		marker_{!! $id !!}.addListener('click', function() {
			infowindow.setContent('<a href="' + placeResult.website + '">' + placeResult.name + '</a>');
			infowindow.open({!! $options['map'] !!}, this);
		});
	});

@else

	@if (!empty($options['content']))

		var infowindow_{!! $id !!} = new google.maps.InfoWindow({
			content: {!! json_encode((string) $options['content']) !!}
		});

		@if (isset($options['maxWidth']))

			infowindow_{!! $id !!}.setOptions({ maxWidth: {!! $options['maxWidth'] !!} });

		@endif

		@if (isset($options['open']) && $options['open'])

			infowindow_{!! $id !!}.open({!! $options['map'] !!}, marker_{!! $id !!});

		@endif

		google.maps.event.addListener(marker_{!! $id !!}, 'click', function() {

			@if (isset($options['autoClose']) && $options['autoClose'])

				for (var i = 0; i < infowindows.length; i++) {
					infowindows[i].close();
				}

			@endif

			infowindow_{!! $id !!}.open({!! $options['map'] !!}, marker_{!! $id !!});
		});

		infowindows.push(infowindow_{!! $id !!});

	@endif

@endif

@foreach (['eventClick', 'eventRightClick', 'eventMouseOver', 'eventMouseDown', 'eventMouseUp', 'eventMouseOut', 'eventDrag', 'eventDragStart', 'eventDragEnd', 'eventDomReady'] as $event)

	@if (isset($options[$event]))

		google.maps.event.addListener(marker_{!! $id !!}, '{!! str_replace('event', '', strtolower($event)) !!}', function (event) {
			{!! $options[$event] !!}
		});

	@endif

@endforeach
