// angular.bootstrap( document.getElementById("TailTargetApp") , ['SettingsApp']);

var appPlugin = angular.module('SettingsApp', []);

appPlugin.factory('ConnectService', ['$http', function ($http) {

    "use strict";

    var Connect = function (data) {
          angular.extend(this, data);
        },
        Header = {
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        };
    
    var ResponseModel = function (response) {
      if (response.data.statusCode === 201 || response.data.statusCode === 200) {
        return new Connect({data: response.data.data, statusCode: response.data.statusCode, statusMessage: response.data.statusMessage});
      } else {
        return new Connect({data: [], statusCode: response.data.statusCode, statusMessage: response.data.statusMessage});
      }
    };

    Connect.saveOption = function (trackingId) {

      if (!trackingId) {
        return ResponseModel(null);
      }

      return $http({
        method  : 'POST',
        url     : ajaxurl,
        data    : jQuery.param({trackingId: trackingId, action: 'save_trackingid_data'}),
        headers : Header
      }).then(function (response) {
        return ResponseModel(response);
      });

    };

    Connect.getOption = function () {

      return $http({
        method  : 'POST',
        url     : ajaxurl,
        data    : jQuery.param({action: 'get_trackingid_data'}),
        headers : Header
      }).then(function (response) {
        return ResponseModel(response);
      });

    };

    return Connect;

}]);

appPlugin.controller('SettingsCtrl', ['ConnectService', function (ConnectService) {

    var self = this;

    self.trackingId = null;

    self.message = {
      info: null
      , type: null
    };

    self.showRegister = false;

    self.init = function () {
      self.getOption();
    };

    self.getOption = function () {
      var option = ConnectService.getOption();

      option.then(function (response) {
        console.log(response);
        if (response.statusCode === 201) {

          self.message.info = null;
          self.message.type = null;
          self.trackingId   = response.data;

        } else {

          if (response.statusCode === 500) {
            self.showRegister = true;
          }

        }
      }, function () {
      });
    };

    self.saveOption = function () {
      var option = ConnectService.saveOption(self.trackingId);

      option.then(function (response) {
        console.log(response);
        if (response.statusCode === 201) {
          self.message.info = response.statusMessage;
          self.message.type = "SUCCESS";
          self.trackingId   = response.data;
        } else {

          if (response.statusCode === 500) {
            self.message.info = response.statusMessage;
            self.message.type = "ERROR";
          }

        }
      }, function () {
      });
    };

    self.save = function () {
      if (!self.trackingId) {
        self.message.info = _tailtarget.messageRequired;
        self.message.type = "ERROR";
        return false;
      }
      self.saveOption();
    };

    self.init();

}]);