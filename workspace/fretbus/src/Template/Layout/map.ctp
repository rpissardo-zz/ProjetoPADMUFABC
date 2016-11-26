<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <?= $this->Html->css('main.css') ?>
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 90%;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?sensor=true&&signed_in=true&key=AIzaSyAu48Gy-zw-DN1BZ0pDcz-bor27gCpwchA">
    </script>
    <script type="text/javascript"
      src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js">
  </script>
  
  <script>
  /* DECLARAÇÃO DE VARIÁVEIS */
    var map;//Variável de Mapa
    window.latuser=0;
    window.lonuser=0;
    window.lat=0;//Latitude atual
    window.latant=0;//Longitude atual
    window.lonant=0;//Latitude anterior
    window.lon=0;//Longitude anterior
    window.vel=0;
    window.attroute = 0;
    window.modified;//Última modificação
    window.posBus;//Posição do veículo
    window.busMarker = [];//Marcador do veículo
    window.userMarker = [];//Marcador do usuário
    window.posUser;
    window.busIcon = '/fretbus/webroot/img/bus-side-view.png';//Imagem do marcador no mapa
    window.userIcon = '/fretbus/webroot/img/user-dot.png';//Imagem do marcador no mapa
    
    /* Ajax utilizado para pegar os elementos antes de inicializar o mapa */
    
    $.ajax({
      url: "/fretbus/data/map/1",
      context: document.body,
      dataType: 'json'
    }).done(function(posAtual) {
      posAtual = posAtual['retorno'];
      window.lat = Number(posAtual['lat']);
      window.lon = Number(posAtual['lon']);
      window.modified = posAtual['modified'];
      window.posBus = new google.maps.LatLng(window.lat, window.lon);
    });
  
    /** FUNÇÃO INITIALIZE
     * Essa função é executada uma vez, sempre que o mapa é inicializado
     * Função simples:
     *        Inicia os parâmetros e opções do mapa
     */
      
    function initialize() {
      directionsService = new google.maps.DirectionsService;
      directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});
      var mapOptions = {
        zoom: 14,
        center: window.posBus
      }
      map = new google.maps.Map(document.getElementById('map'), mapOptions);
      var trafficLayer = new google.maps.TrafficLayer();
      trafficLayer.setMap(map);
      directionsDisplay.setMap(map);
      }
    
    /** FUNÇÃO LOADUSER
     * Essa função tem como dever carregar as novas posições do usuário,
     * bem como tratar se o marker deve ser excluído ou não.
     * Ela é chamada, cada vez que a posição do veículo é verificada.
     */
    
    function loadUser(){
      if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function(position){
          window.posUser = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
          if (position.coords.latitude!=window.latuser || position.coords.longitude!=window.lonuser) {
            window.latuser=position.coords.latitude;
            window.lonuser=position.coords.longitude;
            deleteUserMarker();
            window.userMarker[0] = new google.maps.Marker({
              position: window.posUser,
              map: map,
              title: "Você",
              icon: window.userIcon
            });
          }
        });
      }
    }
    
    
    /** FUNÇÃO LOADBUS
     * Essa função tem como dever carregar as novas posições do veículo,
     * bem como tratar se o marker deve ser excluído ou não.
     */
     
    function loadBus() {
      //Ajax busca as posições sem atualizar o mapa
      loadUser();
      $.ajax({
        url: "/fretbus/data/map/1",
        context: document.body,
        dataType: 'json'
      }).done(function(posAtual) {
        posAtual = posAtual['retorno'];
        window.lat = Number(posAtual['lat']);
        window.lon = Number(posAtual['lon']);
        window.modified = posAtual['modified'];
        window.vel = posAtual['vel'];
        window.posBus = new google.maps.LatLng(window.lat, window.lon);
        $(".modified").text(window.modified);
        $(".vel").text(window.vel+"km/h");
      });
      //Tratamento para determinar necessidade de atualização da posição do veículo
      if ((window.lat!=window.latant || window.lon!=window.lonant) && (window.lat!="0.0" && window.lon!="0.0")) {
        window.latant = window.lat;
        window.lonant = window.lon;
        deleteBusMarker();//Deleta o marker antes de criar um novo
        //Cria marker
        window.busMarker[1] = new google.maps.Marker({
          position: window.posBus, 
          map: map, 
          title: "Fretado",
          icon: window.busIcon
        });
        window.attroute = 0;
      }
        if(window.attroute == 0){
        calculateAndDisplayRoute(directionsService, directionsDisplay);
        directionsDisplay.setPanel(document.getElementById('directionsPanel'));
        google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
        computeTotalDistance(directionsDisplay.directions);
      });
      window.attroute=1;
        }
    }
    
    
    /** FUNCAO DELETEBUSMARKER
     * Essa função é chamada dento da função LOADBUS
     */
    function deleteBusMarker(){
      for (var i = 1; i < window.busMarker.length; i++) {
        window.busMarker[i].setMap(null);
      }
      window.busMarker = [];
    }
    
    /** FUNCAO DELETEUSERMARKER
     * Essa função é chamada dento da função
     */
    function deleteUserMarker(){
      for (var i = 0; i < window.userMarker.length; i++) {
        window.userMarker[i].setMap(null);
      }
      window.userMarker = [];
    }
    
    // FUNÇÃO PARA CENTRALIZAR O MAPA
    
    function centerOnMarker(){
      map.panTo(window.posBus);
    }
    
    // FUNÇÃO PARA DETERMINAR A ROTA DO VEÍCULO
    
    function calculateAndDisplayRoute(directionsService, directionsDisplay) {
      directionsService.route({
        origin: window.posBus,
        destination: window.posUser,
        travelMode: google.maps.TravelMode.DRIVING
      }, function(response, status) {
        if (status === google.maps.DirectionsStatus.OK) {
           directionsDisplay.setDirections(response);
        }
      });
    }
    /** FUNÇÃO QUE CALCULA AS VARIAVEIS DA ROTA DE ONDE O VEÍCULO ESTÁ ATÉ O USUÁRIO
     */
    function computeTotalDistance(result) {
      window.totalToArriveKm = 0;
      window.totalToArriveTime= 0;
      var myroute = result.routes[0];
      for (var i = 0; i < myroute.legs.length; i++) {
        window.totalToArriveKm += myroute.legs[i].distance.value;
        window.totalToArriveTime +=myroute.legs[i].duration.text;
        }
    window.totalToArriveTime = totalToArriveTime.replace('hours','H');
    window.totalToArriveTime = totalToArriveTime.replace('mins','M');
    window.totalToArriveKm = totalToArriveKm / 1000;
    console.log(window.totalToArriveTime) ;
    console.log((window.totalToArriveKm)+"KM") ;
    $(".totalToArriveTime").text(window.totalToArriveTime);
    $(".totalToArriveKm").text(totalToArriveKm+"Km");
  }
  
  
    
  google.maps.event.addDomListener(window, 'load', initialize);//Inicializa a função INITIALIZE quando a página é carregada
  setInterval(function(){ loadBus(); }, 1000);//A cada um segundo verifica a posição do veículo
  setInterval(function(){ centerOnMarker(); }, 5000);
    </script>
    <div class="barra">
      <b>Vel:</b>
      <span class='vel'></span> 
      <b>Última atualização:</b>
      <span class='modified'></span>
      </br>
      <b>Tempo:</b>
      <span class='totalToArriveTime'></span> 
      <b>Distancia:</b>
      <span class='totalToArriveKm'></span>
      </br>
    </div>
  </body>