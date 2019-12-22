var googlemap = {};

function googlemaps_init(field, params) {
  if (!document.getElementById('mapa' + field.attr("name"))) {
    return;
  }
  googlemap[field.attr("name")] = new GOOGLEMAP(field, params), {
    zoom: 3,
    center: new google.maps.LatLng(-42, -63),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
}

function googlemaps_totext(field, params) {
  var urlGoogleMap = "http://maps.google.com/?q=" + field.val();
  return "<a href='" + urlGoogleMap + "' title='Link a Mapa' target='_blank'><img src='/img/geolocation/lugar_referencia.gif' alt='Lugar Referencia' /></a>";
}

function GOOGLEMAP(field, params, myOptions) {
  var self = this;
  this.field = field;
  this.params = params; //this.params = $.parseJSON(params);
  this.options = myOptions;
  this.id = this.field.attr("name");
  this.table = (this.field.parents(".asociada_add").length > 0);
  this.markersArray = new Array();
  this.geocoder = null;
  this.map = null;
  this.results = null;
  this.initialize = function() {
    this.geocoder = new google.maps.Geocoder();
    this.map = new google.maps.Map(document.getElementById("mapa" + this.id), this.options);
    google.maps.event.trigger(this.map, 'resize');
    $("#gmap_geolocate_" + this.id).show();
    $("#gmap_restart_" + this.id).hide();
  };
  this.geolocate = function() {
    var address = this.generateAddress();
    this.results = null;
    this.geocoder.geocode({
      'address': address
    }, this.checkResult);
  };
  this.checkGeo = function() {
    if (!empty(this.field.val())) {
      var geo = this.field.val().split(",");
      var latlng = new google.maps.LatLng(geo[0], geo[1]);
      this.geocoder.geocode({
        'latLng': latlng
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          self.map.setCenter(results[0].geometry.location);
          var marker = new google.maps.Marker({
            map: this.self.map,
            position: results[0].geometry.location,
            animation: google.maps.Animation.DROP
          });
          $("[name='" + googlemap.id + "']").val(results[0].geometry.location);
          setTimeout('$("[id=\'' + self.id + '\']").change()', 200);
          self.markersArray.push(marker);
          self.disableFields(self.parseGoogleAddressComponents(results[0].address_components));
          self.map.setZoom(16);
          $("#gmap_geolocate_" + self.id).hide();
          $("#gmap_restart_" + self.id).show();
        } else {
          swal('Error', 'Error al geolocalizar (' + status + ')', 'error');
        }
      });
    }
  };
  this.checkResult = function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results.length == 0) {
        swal('Alerta', 'La geolocalización no trajo resultados.', 'info');
      } else if (results.length == 1) {
        self.markResult(results[0]);
      } else {
        self.results = results;
        self.displayResults();
      }
    } else {
      swal('Error', 'Error al geolocalizar (' + status + ')', 'error');
    }
  };
  this.displayResults = function() {
    var html = "";
    html += '<div id="googlemap-select-result">';
    for (var index in this.results) {
      html += '<div><input value="' + index + '" name="' + this.id + 'Result" type="radio" /> ' + this.results[index].formatted_address + '</div>';
    }
    html += '</div>';
    $("#googlemap-select-result").remove();
    var self = this;
    bootbox.dialog({
      message: html,
      title: "Seleccione un Resultado",
      buttons: {
        main: {
          label: "Continuar",
          className: "btn-primary",
          callback: function() {
            googlemap[self.id].selectStoredResult();
          }
        }
      }
    });
  };
  this.selectStoredResult = function() {
    if ($("[name=" + this.id + "Result]:checked").length == 0) {
      swal('Error', 'Seleccione uno de los resultados de la georeferenciación', 'error');
      return;
    }
    var index = $("[name=" + this.id + "Result]:checked").val();
    this.markResult(this.results[index]);
  };
  this.markResult = function(result) {
    self.map.setCenter(result.geometry.location);
    var marker = new google.maps.Marker({
      map: self.map,
      position: result.geometry.location,
      animation: google.maps.Animation.DROP
    });
    var latLng = result.geometry.location.lat() + "," + result.geometry.location.lng();
    $("[name='" + self.id + "']").val(latLng);
    setTimeout('$("[name=\'' + self.id + '\']").change()', 200);
    self.markersArray.push(marker);
    self.disableFields(self.parseGoogleAddressComponents(result.address_components));
    self.map.setZoom(16);
    $("#gmap_geolocate_" + self.id).hide();
    $("#gmap_restart_" + self.id).show();
  };
  this.generateAddress = function() {
    var string = "";
    if (!empty(this.params.calle_altura) && !empty($("[name='" + this.params.calle_altura + "']").val())) {
      string += " " + $("[name='" + this.params.calle_altura + "']").val() + ", ";
    } else {
      if (!empty(this.params.calle) && !empty($("[name='" + this.params.calle + "']").val())) {
        string += " " + $("[name='" + this.params.calle + "']").val() + " ";
      }
      if (!empty(this.params.altura) && !empty($("[name='" + this.params.altura + "']").val())) {
        string += " " + $("[name='" + this.params.altura + "']").val() + ", ";
      }
    }
    if (!empty(this.params.ciudad) && !empty($("[name='" + this.params.ciudad + "']").val())) {
      string += " " + $("[name='" + this.params.ciudad + "']").val() + ", ";
    }
    if (!empty(this.params.provincia) && !empty($("[name='" + this.params.provincia + "']").val())) {
      string += " " + $("[name='" + this.params.provincia + "']").val() + ", ";
    }
    if (!empty(this.params.pais) && !empty($("[name='" + this.params.pais + "']").val())) {
      string += " " + $("[name='" + this.params.pais + "']").val() + " ";
    }
    if (!empty(this.params.codigo_postal) && !empty($("[name='" + this.params.codigo_postal + "']").val())) {
      string += " " + $("[name='" + this.params.codigo_postal + "']").val() + " ";
    }
    return $.trim(string);
  };
  this.disableFields = function(valores_localizados) {
    if (!empty(valores_localizados)) {
      for (var i in this.params) {
        if ($("[name='" + this.params[i] + "']").length) {
          switch (i) {
            case "pais":
              if (!empty(valores_localizados.pais)) {
                if (this.params.usar_iso === 'SI') {
                  $("[name='" + this.params[i] + "']").val(valores_localizados.pais_iso).siblings('span').text(valores_localizados.pais_iso);
                } else {
                  $("[name='" + this.params[i] + "']").val(valores_localizados.pais).siblings('span').text(valores_localizados.pais);
                }
              }
              break;
            case "provincia":
              if (!empty(valores_localizados.provincia)) {
                $("[name='" + this.params[i] + "']").val(valores_localizados.provincia).siblings('span').text(valores_localizados.provincia);
              }
              break;
            case "ciudad":
              if (!empty(valores_localizados.ciudad)) {
                $("[name='" + this.params[i] + "']").val(valores_localizados.ciudad).siblings('span').text(valores_localizados.ciudad);
              }
              break;
            case "barrio":
              if (!empty(valores_localizados.barrio)) {
                $("[name='" + this.params[i] + "']").val(valores_localizados.barrio).siblings('span').text(valores_localizados.barrio);
              }
              break;
            case "comuna":
              if (!empty(valores_localizados.comuna)) {
                $("[name='" + this.params[i] + "']").val(valores_localizados.comuna).siblings('span').text(valores_localizados.comuna);
              }
              break;
            case "calle":
              if (!empty(valores_localizados.calle)) {
                $("[name='" + this.params[i] + "']").val(valores_localizados.calle).siblings('span').text(valores_localizados.calle);
              }
              break;
            case "codigo_postal":
              if (!empty(valores_localizados.codigo_postal)) {
                $("[name='" + this.params[i] + "']").val(valores_localizados.codigo_postal).siblings('span').text(valores_localizados.codigo_postal);
              }
              break;
            case "altura":
              if (!empty(valores_localizados.altura) && empty($("[name='" + this.params[i] + "']").val())) {
                $("[name='" + this.params[i] + "']").val(valores_localizados.altura).siblings('span').text(valores_localizados.altura);
              }
              break;
            default:
              break;
          }
        }
        input2readonly($("[name='" + this.params[i] + "']").filter(':visible'));
      }
    }
  };
  this.restart = function() {
    this.map.setCenter(this.options.center);
    this.map.setZoom(this.options.zoom);
    this.deleteOverlays();
    for (var i in this.params) {
      var field = $("[name='" + this.params[i] + "']");
      if (field.is('[type=hidden]') && field.siblings(".val").length == 1) {
        field.val("").siblings(".val").html("");
      } else {
        readonly2input(field);
      }
    }
    $("[name='" + this.id + "']").val('').change();
    $("#gmap_restart_" + this.id).hide();
    $("#gmap_geolocate_" + this.id).show();
  };
  this.deleteOverlays = function() {
    if (this.markersArray) {
      for (var i in this.markersArray) {
        this.markersArray[i].setMap(null);
      }
      this.markersArray.length = 0;
    }
  };
  this.parseGoogleAddressComponents = function(address_components) {
    var datos_dir_google = {
      "pais": "",
      "pais_iso": "",
      "provincia": "",
      "ciudad": "",
      "barrio": "",
      "comuna": "",
      "calle": "",
      "altura": "",
      "codigo_postal": ""
    };
    $.each(address_components, function(k, v) {
      if ($.inArray("route", v.types) != -1) {
        datos_dir_google["calle"] = v.long_name;
        return true;
      }
      if ($.inArray("street_number", v.types) != -1) {
        datos_dir_google["altura"] = v.long_name;
        return true;
      }
      if ($.inArray("locality", v.types) != -1) {
        datos_dir_google["ciudad"] = v.long_name;
        return true;
      }
      if ($.inArray("administrative_area_level_1", v.types) != -1) {
        datos_dir_google["provincia"] = v.long_name;
        return true;
      }
      if ($.inArray("administrative_area_level_2", v.types) != -1 && v.long_name.substr(0, 6) === "Comuna") {
        datos_dir_google["comuna"] = v.long_name.substr(7);
        return true;
      }
      if ($.inArray("sublocality_level_1", v.types) != -1) {
        datos_dir_google["barrio"] = v.long_name;
        return true;
      }
      if ($.inArray("country", v.types) != -1) {
        datos_dir_google["pais"] = v.long_name;
        datos_dir_google["pais_iso"] = v.short_name;
        return true;
      }
      if ($.inArray("postal_code", v.types) != -1) {
        datos_dir_google["codigo_postal"] = v.long_name;
        return true;
      }
    });
    return datos_dir_google;
  };

  this.initialize();
  this.checkGeo();
}
