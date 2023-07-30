<div class="content">
  <div id="map" style="width: 100%; height: 530px; color:black;"></div>
</div>
<script> 
var prov = new L.LayerGroup();
var titikpt = new L.LayerGroup();

  var map = L.map('map', {
    center: [-1.7912605, 116.42311],
    zoom: 5,
    zoomControl: false,
    layers:[]
  }); 

  var Esri_NatGeoWorldMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
	attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
	maxZoom: 16
  });

  var GoogleSatelliteHybrid= L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
    maxZoom: 22,
    attribution: 'Praktikum SIP by kelompok 1'
  }).addTo(map);

  var baseLayers = {
      'Google Satellite Hybrid': GoogleSatelliteHybrid,
      'Esri National Geography' :Esri_NatGeoWorldMap
  };
  var groupedOverlays = {
      "Peta Dasar":{'Ibu Kota Kab/Kota' :prov},
      "Peta Tematik":{'Titik Perguruan Tinggi' :titikpt}
  };


  L.control. groupedLayers(baseLayers, groupedOverlays, {collapsed: false}).addTo(map);
  var osmUrl='https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}';
var osmAttrib='Map data &copy; OpenStreetMap contributors';
var osm2 = new L.TileLayer(osmUrl, {minZoom: 0, maxZoom: 13, attribution: osmAttrib });
var rect1 = {color: "#ff1100", weight: 3};
var rect2 = {color: "#0000AA", weight: 1, opacity:0, fillOpacity:0};
var miniMap = new L.Control.MiniMap(osm2, {toggleDisplay: true, position : "bottomright", aimingRectOptions
: rect1, shadowRectOptions: rect2}).addTo(map);
L.Control.geocoder({position :"topleft", collapsed:true}).addTo(map);
var north = L.control({position: "bottomleft"}); 
north.onAdd = function(map) { 
        var div = L.DomUtil.create("div", "info legend"); 
        div.innerHTML = '<img src="<?=base_url()?>assets/kompas.png"style=width:100px;>'; 
        return div; } 
        north.addTo(map)
        var zoom_bar = new L.Control.ZoomBar({position: 'topleft'}).addTo(map);
L.control.coordinates({
 position:"bottomleft",
 decimals:2,
 decimalSeperator:",",
 labelTemplateLat:"Latitude: {y}",
 labelTemplateLng:"Longitude: {x}"
 }).addTo(map);

 $.getJSON("<?=base_url()?>assets/ibukota.geojson",function(data){
   var ratIcon = L.icon({
    iconUrl: '<?=base_url()?>assets/Marker3.png',
    iconSize: [20,17]
   });
   L.geoJson(data,{
    pointToLayer: function(feature,latlng){
     var marker = L.marker(latlng,{icon: ratIcon});
     marker.bindPopup(feature.properties.KAB);
     return marker;
   }
  }).addTo(prov);
 });

 $.getJSON("<?=base_url()?>assets/TitikPT.geojson",function(data){
   var ratIcon = L.icon({
    iconUrl: '<?=base_url()?>assets/Marker2.png',
    iconSize: [15,13]
   });
   L.geoJson(data,{
    pointToLayer: function(feature,latlng){
     var marker = L.marker(latlng,{icon: ratIcon});
     marker.bindPopup(feature.properties.Nama);
     return marker;
   }
  }).addTo(titikpt);
 });

 const legend = L.control.Legend({
       position: "bottomright",
       collapsed: true,
       symbolWidth: 15,
       opacity: 0.8,
       column: 2,
       legends: [{
           label: "Ibu Kota Kab/Kota",
           type: "image",
           url: "<?=base_url()?>/assets/Marker3.png",
       },{
           label: "Titik Perguruan Tinggi",
           type: "image",
           url: "<?=base_url()?>/assets/Marker2.png"
       },{
 },]
})
.addTo(map);

</script>