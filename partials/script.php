<script>
	var ImageLocation = '../assets/img/icons/';
	var customLabel = {
		user: {
			icon: ImageLocation + 'man.png'
		},
		jeep: {
			icon: ImageLocation + 'jeep2.png'
		}
	};
var map;


	function initMap() {
		if(!map){
		fetch("../controller/user_location_endpoint.php").then( response => response.json() ).then( response => {
			map = new google.maps.Map(document.getElementById('map'), { center: new google.maps.LatLng(response.latitude, response.longitude), zoom: 18,
				styles: [
				{elementType: 'geometry', stylers: [{color: '#242f3e'}]},
				{elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
				{elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
				{
					featureType: 'administrative.locality',
					elementType: 'labels.text.fill',
					stylers: [{color: '#d59563'}]
				},
				{
					featureType: 'poi',
					elementType: 'labels.text.fill',
					stylers: [{color: '#d59563'}]
				},
				{
					featureType: 'poi.park',
					elementType: 'geometry',
					stylers: [{color: '#263c3f'}]
				},
				{
					featureType: 'poi.park',
					elementType: 'labels.text.fill',
					stylers: [{color: '#6b9a76'}]
				},
				{
					featureType: 'road',
					elementType: 'geometry',
					stylers: [{color: '#38414e'}]
				},
				{
					featureType: 'road',
					elementType: 'geometry.stroke',
					stylers: [{color: '#212a37'}]
				},
				{
					featureType: 'road',
					elementType: 'labels.text.fill',
					stylers: [{color: '#9ca5b3'}]
				},
				{
					featureType: 'road.highway',
					elementType: 'geometry',
					stylers: [{color: '#746855'}]
				},
				{
					featureType: 'road.highway',
					elementType: 'geometry.stroke',
					stylers: [{color: '#1f2835'}]
				},
				{
					featureType: 'road.highway',
					elementType: 'labels.text.fill',
					stylers: [{color: '#f3d19c'}]
				},
				{
					featureType: 'transit',
					elementType: 'geometry',
					stylers: [{color: '#2f3948'}]
				},
				{
					featureType: 'transit.station',
					elementType: 'labels.text.fill',
					stylers: [{color: '#d59563'}]
				},
				{
					featureType: 'water',
					elementType: 'geometry',
					stylers: [{color: '#17263c'}]
				},
				{
					featureType: 'water',
					elementType: 'labels.text.fill',
					stylers: [{color: '#515c6d'}]
				},
				{
					featureType: 'water',
					elementType: 'labels.text.stroke',
					stylers: [{color: '#17263c'}]
				}
				]
			});
		});
		}

		var infoWindow = new google.maps.InfoWindow;

		downloadUrl('http://localhost:3000/views/xml.php', function(data) {
			var xml = data.responseXML;
			var markers = xml.documentElement.getElementsByTagName('marker');
			console.log(markers);
			Array.prototype.forEach.call(markers, function(markerElem) {
				var id = markerElem.getAttribute('id');
				var name = markerElem.getAttribute('name');
				var address = markerElem.getAttribute('address');
				var destination = markerElem.getAttribute('dstn');
				var type = markerElem.getAttribute('type');
				var point = new google.maps.LatLng(
					parseFloat(markerElem.getAttribute('lat')),
					parseFloat(markerElem.getAttribute('lng')));

				var infowincontent = document.createElement('div');
				var strong = document.createElement('strong');
				strong.textContent = name
				infowincontent.appendChild(strong);
				infowincontent.appendChild(document.createElement('br'));

				var text = document.createElement('text');
				text.textContent = "Destination: " + destination
				infowincontent.appendChild(text);
				var icon = customLabel[type] || {};
				var marker = new google.maps.Marker({
					map: map,
					position: point,
					icon: icon.icon
				});
				marker.addListener('click', function() {
					infoWindow.setContent(infowincontent);
					infoWindow.open(map, marker);
				});
			});
		});
	}



	function downloadUrl(url, callback) {
		var request = window.ActiveXObject ?
		new ActiveXObject('Microsoft.XMLHTTP') :
		new XMLHttpRequest;

		request.onreadystatechange = function() {
			if (request.readyState == 4) {
				request.onreadystatechange = doNothing;
				callback(request, request.status);
			}
		};

		request.open('GET', url, true);
		request.send(null);
	}

	function doNothing() {}
</script>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpoAVASdnR7F0Pv3USKf6IKbS17bJ0S54&callback=initMap">

</script>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		setInterval(function(){ initMap(); }, 3000);
	});
</script>