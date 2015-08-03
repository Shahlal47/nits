var map = null;
var xmlHttp = null;
var tblDeviceID = '';
var userType = '';
var gMarkerArray = [0];
var gMarkerPre = null;
var gOdometerArray = [];
var gVehicleSpeedArray = [];
var gTotalMarker = 0;
var gTotalSpeed = 0;
var gVehicleAddress = 'Bangladesh';
var gIgnitionStatus = 0;
var gVehicleSpeed = 0;
var gMarkerIconImage = '';
var gPolyLine = new GPolyline([], '#f33f00', 3, 1);
var gLocationCurrent = null;
var gLocationPre = null;
var gVehicleLatPre = 0;
var gVehicleLngPre = 0;
var gIgnitionStatusPre = 5;
var gVehicleSpeedPre = 0;
var gStatus = 0;
var gStatusPre = 1;
var gFirstTime = true;
var gLineColor = '#ff0000';
var gRecordTimePre = 0;
var gEarlierDate = 0;
var gWait = 0;
var gStop = 0;
var gDataInitialized = false;
var gSmallIcon = true;
var gTimeDiff = '';
var gRowIndex = 0;
var gSelectedRowIndex = 0;
var baseIcon = new GIcon();
baseIcon['iconSize'] = new GSize(20, 20);
baseIcon['shadowSize'] = new GSize(20, 20);
baseIcon['iconAnchor'] = new GPoint(8, 8);
baseIcon['infoWindowAnchor'] = new GPoint(8, 8);
var liveIcon = new GIcon(baseIcon, '../images/icon15.png', null, null);
var blinkIcon = new GIcon(baseIcon, '../images/icon7.png', null, null);
var gPolygon = null;
var gPreGeofenceStatus = true;
var gDirection = 'North';

function init() {
    gWait = 0;
    gStop = 0;
    if (GBrowserIsCompatible()) {
        var _0x5d06x2a = document['body']['clientWidth'] - 305;
        _0x5d06x2a = _0x5d06x2a + 'px';
        document['getElementById']('mapArea')['style']['width'] = _0x5d06x2a;
        document['getElementById']('userTabViewArea')['style']['width'] = _0x5d06x2a;
        var _0x5d06x2b = document['body']['clientHeight'] - 180;
        _0x5d06x2b = _0x5d06x2b + 'px';
        document['getElementById']('mapArea')['style']['height'] = _0x5d06x2b;
        map = new GMap2(document['getElementById']('mapArea'));
        map['setCenter'](new GLatLng(23.806868, 90.419013), 12);
        map['addControl'](new GScaleControl());
        map['addControl'](new GSmallZoomControl());
        map['addControl'](new GMapTypeControl());
        map['addMapType'](G_SATELLITE_3D_MAP);
        map['enableScrollWheelZoom']();
    };
};

function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        xmlHttp = new XMLHttpRequest();
    } catch (e) {
        try {
            xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
        } catch (e) {
            xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
        };
    };
    return xmlHttp;
};

function getFlashMovie(_0x5d06x2e) {
    var _0x5d06x2f = navigator['appName']['indexOf']('Microsoft') != -1;
    return (_0x5d06x2f) ? window[_0x5d06x2e] : document[_0x5d06x2e];
};

function passUserInfo(_0x5d06x31, userType, _0x5d06x32) {
    tblDeviceID = _0x5d06x31;
    userType = userType;
    setTimeout('checkStatus("' + tblDeviceID + '")', 3000);
    setTimeout('updateIconStatus()', 20000);
    if (_0x5d06x32 != '') {
        setTimeout('loadFence("' + _0x5d06x32 + '")', 60000);
    };
};

function loadFence(_0x5d06x32) {
    var _0x5d06x34 = 'fencedatafromdb.php?fencename=' + _0x5d06x32;
    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert('Browser does not support HTTP Request');
        return;
    };
    xmlHttp['open']('POST', _0x5d06x34, true);
    xmlHttp['onreadystatechange'] = getFence;
    xmlHttp['send'](null);
};

function getFence() {
    if (xmlHttp['readyState'] == 4) {
        if (map == null) {
            setTimeout('loadFence("' + _0x5d06x32 + '")', 10000);
            return;
        };
        var _0x5d06x36 = xmlHttp['responseXML'];
        var _0x5d06x37 = _0x5d06x36['documentElement']['getElementsByTagName']('populateDataDetails');
        var _0x5d06x32 = _0x5d06x37[0]['getAttribute']('fencename_xml');
        var _0x5d06x38 = _0x5d06x37[0]['getAttribute']('fencetype_xml');
        var _0x5d06x39 = _0x5d06x37[0]['getAttribute']('fencepoints_xml');
        var _0x5d06x3a = [];
        if ((_0x5d06x39 == '') || (_0x5d06x39 == null)) {
            return;
        } else {
            if (_0x5d06x39['indexOf']('),') == -1) {
                alert('There is only one record which is ' + _0x5d06x39);
            } else {
                _0x5d06x39 = _0x5d06x39['replace'](/\(/g, '');
                var _0x5d06x3b = _0x5d06x39['length'];
                _0x5d06x39 = _0x5d06x39['slice'](0, _0x5d06x3b - 1);
                var _0x5d06x3c = _0x5d06x39['split']('),');
                var _0x5d06x3d = [];
                for (var _0x5d06x3e = 0; _0x5d06x3e < _0x5d06x3c['length']; _0x5d06x3e++) {
                    _0x5d06x3d = _0x5d06x3c[_0x5d06x3e]['split'](',', 2);
                    _0x5d06x3a['push'](new GLatLng(parseFloat(_0x5d06x3d[0]), parseFloat(_0x5d06x3d[1])));
                };
            };
        };
        gPolygon = new GPolygon(_0x5d06x3a, '#f33f00', 1, 1, '#00ff00', 0.2);
        map['addOverlay'](gPolygon);
        gPolygon['hide']();
    };
};

function checkStatus(_0x5d06x31) {
    tblDeviceID = _0x5d06x31;
    url = 'queryvehicledata.php?tbldeviceid=' + tblDeviceID;
    loadXMLDoc(url);
};

function loadXMLDoc(_0x5d06x34) {
    if (window['XMLHttpRequest']) {
        xmlHttp = new XMLHttpRequest();
    } else {
        if (window['ActiveXObject']) {
            xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
        };
    };
    if (xmlHttp != null) {
        xmlHttp['onreadystatechange'] = state_Change;
        xmlHttp['open']('POST', _0x5d06x34, true);
        xmlHttp['send'](null);
    } else {
        alert('Your browser does not support XMLHTTP.');
    };
};

function state_Change() {
    var _0x5d06x42 = 15000;
    if (xmlHttp['readyState'] == 4) {
        var _0x5d06x36 = xmlHttp['responseXML'];
        if (_0x5d06x36['documentElement'] != null && map != null) {
            var _0x5d06x37 = _0x5d06x36['documentElement']['getElementsByTagName']('populateDataDetails');
        } else {
            setTimeout('checkStatus("' + tblDeviceID + '")', _0x5d06x42);
            return;
        };
        var _0x5d06x43 = _0x5d06x37[0]['getAttribute']('recordDate_xml');
        if (_0x5d06x43 == 'NA') {
            document['getElementById']('tdStatus')['innerHTML'] = 'Device not activated yet!!';
            return;
        };
        var _0x5d06x44 = _0x5d06x37[0]['getAttribute']('serverDateTime_xml');
        var _0x5d06x45 = _0x5d06x37[0]['getAttribute']('recordTime_xml');
        var _0x5d06x46 = _0x5d06x37[0]['getAttribute']('vehicleLat_xml');
        var _0x5d06x47 = _0x5d06x37[0]['getAttribute']('vehicleLng_xml');
        var _0x5d06x48 = _0x5d06x37[0]['getAttribute']('addressLat_xml');
        var _0x5d06x49 = _0x5d06x37[0]['getAttribute']('addressLng_xml');
        var _0x5d06x4a = _0x5d06x37[0]['getAttribute']('nearaddress_xml');
        var _0x5d06x4b = _0x5d06x37[0]['getAttribute']('vehicleAltitude_xml');
        gVehicleSpeed = _0x5d06x37[0]['getAttribute']('vehicleSpeed_xml');
        gVehicleSpeedArray[gRowIndex] = gVehicleSpeed;
        gIgnitionStatus = _0x5d06x37[0]['getAttribute']('ignitionStatus_xml');
        var _0x5d06x4c = _0x5d06x37[0]['getAttribute']('vehicleOdometer_xml');
        gOdometerArray[gRowIndex] = _0x5d06x4c;
        var _0x5d06x4d = (_0x5d06x4c - gOdometerArray[gRowIndex - 1]) / 1000;
        var _0x5d06x4e = _0x5d06x37[0]['getAttribute']('timeDiff_xml');
        gTimeDiff = ReturnTimeDiff(_0x5d06x4e);
        var _0x5d06x4f = new GLatLng(_0x5d06x46, _0x5d06x47);
        var _0x5d06x50 = new GLatLng(_0x5d06x48, _0x5d06x49);
        var _0x5d06x51 = bearing(_0x5d06x4f, _0x5d06x50);
        if (_0x5d06x51 >= 0 && _0x5d06x51 < 5) {
            gDirection = 'South';
        } else {
            if (_0x5d06x51 >= 5 && _0x5d06x51 < 85) {
                gDirection = 'South West';
            } else {
                if (_0x5d06x51 >= 85 && _0x5d06x51 < 95) {
                    gDirection = 'West';
                } else {
                    if (_0x5d06x51 >= 95 && _0x5d06x51 < 175) {
                        gDirection = 'North West';
                    } else {
                        if (_0x5d06x51 >= 175 && _0x5d06x51 < 185) {
                            gDirection = 'North';
                        } else {
                            if (_0x5d06x51 >= 185 && _0x5d06x51 < 265) {
                                gDirection = 'North East';
                            } else {
                                if (_0x5d06x51 >= 265 && _0x5d06x51 < 275) {
                                    gDirection = 'East';
                                } else {
                                    if (_0x5d06x51 >= 275 && _0x5d06x51 < 355) {
                                        gDirection = 'South East';
                                    } else {
                                        if (_0x5d06x51 >= 355 && _0x5d06x51 <= 360) {
                                            gDirection = 'South';
                                        } else {
                                            gDirection = 'South';
                                        };
                                    };
                                };
                            };
                        };
                    };
                };
            };
        };
        _0x5d06x4a = gDirection + ' ' + _0x5d06x4a;
        updateTrackerStatus(_0x5d06x46, _0x5d06x47, _0x5d06x4a, gIgnitionStatus, gVehicleSpeed);
        if (_0x5d06x46 == '' || _0x5d06x47 == '' || map == null) {
            setTimeout('checkStatus("' + tblDeviceID + '")', _0x5d06x42);
            return;
        };
        if (gRecordTimePre == _0x5d06x45 && _0x5d06x46 != '' && _0x5d06x47 != '' && map != null) {
            updateMarker(_0x5d06x44, gIgnitionStatus, gVehicleSpeed);
            setTimeout('checkStatus("' + tblDeviceID + '")', _0x5d06x42);
            return;
        };
        gRecordTimePre = _0x5d06x45;
        if (gStatus == 3) {
            gWait = 0;
            gStop = 0;
            gStatusPre = gStatus;
            populateRecentTracking(_0x5d06x44, gVehicleSpeed);
            showFirstRowStatus(_0x5d06x44, _0x5d06x4c, gVehicleSpeed);
            addMarker(_0x5d06x46, _0x5d06x47, _0x5d06x44, gIgnitionStatus, gVehicleSpeed);
            gRowIndex++;
            setTimeout('checkStatus("' + tblDeviceID + '")', _0x5d06x42);
        };
        //if (gStatus == 1 && gStop == 0) {  added by me masud
        if (gStatus == 1 && gStop == 1) {
            gStop = 1;
            gWait = 0;
            gStatusPre = gStatus;
            populateRecentTracking(_0x5d06x44, gVehicleSpeed);
            showFirstRowStatus(_0x5d06x44, _0x5d06x4c, gVehicleSpeed);
            addMarker(_0x5d06x46, _0x5d06x47, _0x5d06x44, gIgnitionStatus, gVehicleSpeed);
            gRowIndex++;
            setTimeout('checkStatus("' + tblDeviceID + '")', _0x5d06x42);
            return;
        };
        if (gStatus == 2 && gWait == 0) {
            gWait = 1;
            gStop = 0;
            gStatusPre = gStatus;
            populateRecentTracking(_0x5d06x44, gVehicleSpeed);
            showFirstRowStatus(_0x5d06x44, _0x5d06x4c, gVehicleSpeed);
            addMarker(_0x5d06x46, _0x5d06x47, _0x5d06x44, gIgnitionStatus, gVehicleSpeed);
            gRowIndex++;
            setTimeout('checkStatus("' + tblDeviceID + '")', _0x5d06x42);
            return;
        };
        if ((gStatus == 2 && gWait == 1) || (gStatus == 1 && gStop == 1)) {
			//addMarker(_0x5d06x46, _0x5d06x47, _0x5d06x44, gIgnitionStatus, gVehicleSpeed);
            updateMarker(_0x5d06x44, gIgnitionStatus, gVehicleSpeed);
            setTimeout('checkStatus("' + tblDeviceID + '")', _0x5d06x42);
            return;
        };
        getFlashMovie('ExternalInterface1')['sendToActionScript'](gVehicleSpeed);
        if (gRowIndex > 0 && _0x5d06x4d > 0) {
            getFlashMovie('ExternalInterface2')['sendToActionScript'](_0x5d06x4d);
        };
    };
};

function bearing(_0x5d06x53, _0x5d06x54) {
    var _0x5d06x55 = _0x5d06x53['latRadians']();
    var _0x5d06x56 = _0x5d06x53['lngRadians']();
    var _0x5d06x57 = _0x5d06x54['latRadians']();
    var _0x5d06x58 = _0x5d06x54['lngRadians']();
    var _0x5d06x59 = -Math['atan2'](Math['sin'](_0x5d06x56 - _0x5d06x58) * Math['cos'](_0x5d06x57), Math['cos'](_0x5d06x55) * Math['sin'](_0x5d06x57) - Math['sin'](_0x5d06x55) * Math['cos'](_0x5d06x57) * Math['cos'](_0x5d06x56 - _0x5d06x58));
    if (_0x5d06x59 < 0.0) {
        _0x5d06x59 += Math['PI'] * 2.0;
    };
    _0x5d06x59 = _0x5d06x59 * degreesPerRadian;
    _0x5d06x59 = _0x5d06x59['toFixed'](1);
    return _0x5d06x59;
};
var degreesPerRadian = 180.0 / Math['PI'];

function speedCalculation(_0x5d06x5c, _0x5d06x5d, _0x5d06x5e) {
    var _0x5d06x5f = _0x5d06x5e['split'](':');
    var _0x5d06x60 = _0x5d06x5d['split'](':');
    var _0x5d06x61 = (_0x5d06x60[0] - _0x5d06x5f[0]) + (_0x5d06x60[1] - _0x5d06x5f[1]) / 60 + (_0x5d06x60[2] - _0x5d06x5f[2]) / 3600;
    return _0x5d06x5c / _0x5d06x61;
    var _0x5d06x62 = new Date(1, 1, 1, _0x5d06x5f[0], _0x5d06x5f[1], 0);
    var _0x5d06x63 = new Date(1, 1, 1, _0x5d06x60[0], _0x5d06x60[1], 0);
    var _0x5d06x64 = _0x5d06x63['getHours']() - _0x5d06x62['getHours']();
    var _0x5d06x65 = _0x5d06x63['getMinutes']() - _0x5d06x62['getMinutes']();
    if (_0x5d06x65 < 0) {
        _0x5d06x65 += 60;
        _0x5d06x64--;
    };
    return (new Array(_0x5d06x64, _0x5d06x65));
};

function getAltitude(_0x5d06x67, _0x5d06x68) {
    var _0x5d06x34 = 'http://ws.geonames.org/srtm3?lat=' + _0x5d06x67 + 'lng=' + _0x5d06x68;
    fp = fopen(_0x5d06x34, 'r');
    alert('Ok');
    if (fp) {
        contents = stream_get_contents(fp);
        fclose(fp);
        return contents;
    };
};

function highlight_row(_0x5d06x6a) {
    var _0x5d06x6b = _0x5d06x6a['sectionRowIndex'];
    document['getElementById']('tr' + _0x5d06x6b)['style']['backgroundColor'] = 'gray';
    oldHighlight_RowIndex = _0x5d06x6b;
    var _0x5d06x6c = locations[_0x5d06x6b]['getAttribute']('lng');
    var _0x5d06x6d = locations[_0x5d06x6b]['getAttribute']('lat');
    var _0x5d06x6e = document['getElementById']('statsTable')['getElementsByTagName']('tr');
    iRowCount = _0x5d06x6e['length'];
    if (_0x5d06x6b < iRowCount - 1) {
        var _0x5d06x6f = 0;
        var _0x5d06x70 = 0;
        if (_0x5d06x6b == iRowCount - 2) {
            _0x5d06x6f = 0;
            _0x5d06x70 = 0;
        } else {
            _0x5d06x6f = normalMarkers[_0x5d06x6b]['getPoint']()['distanceFrom'](normalMarkers[_0x5d06x6b + 1]['getPoint']()) / 1000;
            _0x5d06x70 = speedCalculation(_0x5d06x6f, document['getElementById']('TimeTD' + _0x5d06x6b)['innerHTML'], document['getElementById']('TimeTD' + [_0x5d06x6b + 1])['innerHTML']);
        };
        var _0x5d06x34 = 'altitude.php?lat=' + _0x5d06x6c + '&lng=' + _0x5d06x6d;
        GDownloadUrl(_0x5d06x34, function (_0x5d06x71) {
            var _0x5d06x72 = GXml['parse'](_0x5d06x71);
            var _0x5d06x73 = parseInt(GXml['value'](_0x5d06x72));
            map['openInfoWindow'](point, 'The altitude here is ' + _0x5d06x73 + ' metres');
        });
        var _0x5d06x34 = 'get_altitude.php?alt_lat=' + _0x5d06x6c + '&alt_lng=' + _0x5d06x6d;
        GDownloadUrl(_0x5d06x34, function (_0x5d06x71, _0x5d06x74) {
            retval = _0x5d06x71;
            var _0x5d06x72 = GXml['parse'](_0x5d06x71);
            var _0x5d06x75 = parseInt(GXml['value'](_0x5d06x72));
        });
        GDownloadUrl(_0x5d06x34, function (_0x5d06x71, _0x5d06x74) {
            if (_0x5d06x71 == '-32768') {
                retval = 'N/A';
            } else {
                retval = _0x5d06x71;
            };
        });
        document['getElementById']('time')['innerHTML'] = ' : ' + document['getElementById']('TimeTD' + _0x5d06x6b)['innerHTML'];
        document['getElementById']('speed')['innerHTML'] = ' : ' + _0x5d06x70['toFixed'](0) + ' km/h ';;;
        document['getElementById']('distance')['innerHTML'] = ' : ' + _0x5d06x6f['toFixed'](2) + ' km ';
        var _0x5d06x76 = '';
        if (document['getElementById']('LocationTD' + _0x5d06x6b)['innerHTML'] == '') {
            _0x5d06x76 = 'Bangladesh';
        } else {
            _0x5d06x76 = document['getElementById']('LocationTD' + _0x5d06x6b)['innerHTML'];
        };
        document['getElementById']('loc')['innerHTML'] = ' : ' + _0x5d06x76;
    };
    var _0x5d06x77 = new GLatLng(_0x5d06x6c, _0x5d06x6d);
    var _0x5d06x78 = new GMarker(_0x5d06x77, liveIcon);
    map['addOverlay'](_0x5d06x78);
    var _0x5d06x79 = map['getBounds']();
    var _0x5d06x7a = _0x5d06x79['containsLatLng'](_0x5d06x77);
    if (_0x5d06x7a == false) {
        map['panTo'](_0x5d06x77);
    };
    MarkersArray[0] = _0x5d06x78;
};

function populateRecentTracking(_0x5d06x44, _0x5d06x7c) {
    var _0x5d06x7d = document['getElementById']('statsTable')['insertRow'](0);
    _0x5d06x7d['setAttribute']('id', 'tr' + gRowIndex);
    if (gRowIndex % 2) {
        _0x5d06x7d['setAttribute']('bgColor', '#6BA118');
    } else {
        _0x5d06x7d['setAttribute']('bgColor', '#79B71B');
    };
    _0x5d06x7d['onmouseover'] = function () {
        highlightRow(this);
    };
    _0x5d06x7d['onmouseout'] = function () {
        if (gSelectedRowIndex % 2) {
            document['getElementById']('tr' + gSelectedRowIndex)['style']['backgroundColor'] = '#6BA118';
        } else {
            document['getElementById']('tr' + gSelectedRowIndex)['style']['backgroundColor'] = '#79B71B';
        };
    };
    var _0x5d06x7e = _0x5d06x7d['insertCell'](0);
    _0x5d06x7e['setAttribute']('id', 'timeTD' + gRowIndex);
    _0x5d06x7e['setAttribute']('width', '25%');
    _0x5d06x7e['innerHTML'] = _0x5d06x44;
    var _0x5d06x7f = _0x5d06x7d['insertCell'](1);
    _0x5d06x7f['setAttribute']('id', 'statusTD' + gRowIndex);
    _0x5d06x7f['setAttribute']('width', '15%');
    if (gStatus == 1) {
        _0x5d06x7f['innerHTML'] = 'OFF';
    } else {
        _0x5d06x7f['innerHTML'] = 'ON';
    };
    var _0x5d06x80 = _0x5d06x7d['insertCell'](2);
    _0x5d06x80['setAttribute']('id', 'locationTD' + gRowIndex);
    _0x5d06x80['setAttribute']('width', '60%');
    _0x5d06x80['innerHTML'] = gVehicleAddress;
};

function populateRecentTrackingOld(_0x5d06x82, _0x5d06x83, _0x5d06x7c) {
    var _0x5d06x6e = document['getElementById']('statsTable')['getElementsByTagName']('tr');
    var _0x5d06x84 = _0x5d06x6e['length'];
    tableRef = document['getElementById']('statsTable')['getElementsByTagName']('tbody')[0];
    newRow = tableRef['insertRow'](0);
    newRow['setAttribute']('id', 'tr' + gRowIndex);
    if (gRowIndex % 2) {
        newRow['setAttribute']('bgColor', '#6BA118');
    } else {
        newRow['setAttribute']('bgColor', '#79B71B');
    };
    newRow['onmouseover'] = function () {
        highlightRow(this);
    };
    newRow['onmouseout'] = function () {
        if (gSelectedRowIndex % 2) {
            document['getElementById']('tr' + gSelectedRowIndex)['style']['backgroundColor'] = '#6BA118';
        } else {
            document['getElementById']('tr' + gSelectedRowIndex)['style']['backgroundColor'] = '#79B71B';
        };
    };
    tName = document['createElement']('td');
    tName['setAttribute']('id', 'timeTD' + gRowIndex);
    tName['setAttribute']('width', '40%');
    tName['innerHTML'] = _0x5d06x82 + ' ' + _0x5d06x83;
    sName = document['createElement']('td');
    sName['setAttribute']('id', 'statusTD' + gRowIndex);
    sName['setAttribute']('width', '20%');
    sName['innerHTML'] = gStatus;
    lName = document['createElement']('td');
    lName['setAttribute']('id', 'locationTD' + gRowIndex);
    lName['setAttribute']('width', '40%');
    lName['innerHTML'] = gVehicleAddress;
    newRow['appendChild'](tName);
    newRow['appendChild'](sName);
    newRow['appendChild'](lName);
    tableRef['appendChild'](newRow);
};

function showNormalMarkers(_0x5d06x86) {
    var _0x5d06x78;
    for (var _0x5d06x3e = 0; _0x5d06x3e < _0x5d06x86; _0x5d06x3e++) {
        map['addOverlay'](normalMarkers[_0x5d06x3e]);
    };
};

function showArrowMarkersWithLine(_0x5d06x86) {
    for (var _0x5d06x3e = 0; _0x5d06x3e < _0x5d06x86 - 1; _0x5d06x3e++) {
        map['addOverlay'](lineArray[_0x5d06x3e]);
        lineArray[_0x5d06x3e]['show']();
    };
    for (var _0x5d06x3e = 0; _0x5d06x3e < _0x5d06x86; _0x5d06x3e++) {
        map['addOverlay'](arrowMarkers[_0x5d06x3e]);
    };
};

function reDrawAnimatedMarkers() {
    for (var _0x5d06x3e = 0; _0x5d06x3e < animatedMarkers['length']; _0x5d06x3e++) {
        var _0x5d06x78 = animatedMarkers[_0x5d06x3e];
        map['addOverlay'](_0x5d06x78);
        _0x5d06x78['hide']();
    };
};

function removeAnimatedMarkers() {
    for (var _0x5d06x3e = 0; _0x5d06x3e < animatedMarkers['length']; _0x5d06x3e++) {
        var _0x5d06x78 = animatedMarkers[_0x5d06x3e];
        map['removeOverlay'](_0x5d06x78);
    };
};

function removeMarkers() {
    for (var _0x5d06x3e = 0; _0x5d06x3e < normalMarkers['length']; _0x5d06x3e++) {
        var _0x5d06x78 = normalMarkers[_0x5d06x3e];
        map['removeOverlay'](_0x5d06x78);
    };
    for (var _0x5d06x3e = 0; _0x5d06x3e < arrowMarkers['length']; _0x5d06x3e++) {
        var _0x5d06x78 = arrowMarkers[_0x5d06x3e];
        map['removeOverlay'](_0x5d06x78);
    };
};

function removeAllLines() {
    for (var _0x5d06x3e = 0; _0x5d06x3e < lineArray['length']; _0x5d06x3e++) {
        var _0x5d06x8c = lineArray[_0x5d06x3e];
        map['removeOverlay'](_0x5d06x8c);
    };
};

function hideAnimatedMarkers() {
    for (var _0x5d06x3e = 0; _0x5d06x3e < animatedMarkers['length']; _0x5d06x3e++) {
        animatedMarkers[_0x5d06x3e]['hide']();
    };
};

function onTimer() {
    hideAnimatedMarkers();
    animatedMarkers[lastIndex--]['show']();
    if (lastIndex < 0) {
        clearInterval(timerId);
        removeAnimatedMarkers();
        isRunningAnimation = false;
        document['f1']['btnShowRoute']['value'] = 'Show Route';
        return;
    };
    var _0x5d06x8f = animatedMarkers[lastIndex]['getLatLng']();
    var _0x5d06x79 = map['getBounds']();
    var _0x5d06x7a = _0x5d06x79['containsLatLng'](_0x5d06x8f);
    if (_0x5d06x7a == false) {
        map['panTo'](_0x5d06x8f);
    };
};

function liveTracking() {
    if (false == isLiveTrackingStart) {
        isLiveTrackingStart = true;
        getLiveTrackingData();
        alert('test1');
        hideMessage();
        document['f1']['btnLiveTracking']['value'] = 'Stop Tracking';
    } else {
        resetTracking();
    };
};

function startAnimation() {
    if (false == isRunningAnimation) {
        if (animatedMarkers['length'] == 0) {
            return;
        };
        isRunningAnimation = true;
        removeAnimatedMarkers();
        reDrawAnimatedMarkers();
        if (true == isLiveTrackingStart) {
            resetTracking();
            showMarkersByType(gIconType);
        };
        document['f1']['btnShowRoute']['value'] = 'Stop Animation';
        lastIndex = animatedMarkers['length'] - 1;
        var _0x5d06x92 = document['f1']['speedOption']['value'];
        switch (_0x5d06x92) {
        case 'slow':
            setTimeInterval = 1000;
            break;;
        case 'normal':
            setTimeInterval = 500;
            break;;
        case 'fast':
            setTimeInterval = 250;
            break;;
        default:
            setTimeInterval = 500;;
        };
        timerId = setInterval('onTimer()', setTimeInterval, '');
    } else {
        isRunningAnimation = false;
        document['f1']['btnShowRoute']['value'] = 'Show Route';
        clearInterval(timerId);
        removeAnimatedMarkers();
    };
};

function rsSetAnimation() {
    isRunningAnimation = false;
    document['f1']['btnShowRoute']['value'] = 'Show Route';
    clearInterval(timerId);
    removeAnimatedMarkers();
};

function resetTracking() {
    isLiveTrackingStart = false;
    if (lvTrackingMarker != null) {
        map['removeOverlay'](lvTrackingMarker);
    };
    clearInterval(idTimerTracking);
    document['f1']['btnLiveTracking']['value'] = 'Live Tracking';
};

function updateTrackerStatus(_0x5d06x46, _0x5d06x47, _0x5d06x4a, _0x5d06x96, _0x5d06x97) {
    if (map != null) {
        var _0x5d06x98 = new GLatLng(_0x5d06x46, _0x5d06x47);
        if (_0x5d06x4a == '') {
            var _0x5d06x99 = new GClientGeocoder();
            _0x5d06x99['getLocations'](_0x5d06x98, getAddressFromGoogle);
        } else {
            gVehicleAddress = _0x5d06x4a;
        };
    } else {
        gVehicleAddress = _0x5d06x4a;
    };
    var _0x5d06x9a = '';
    if (_0x5d06x96 == 0) {
        gStatus = 1;
        var _0x5d06x9b = 'Ignition off';
        _0x5d06x9b = _0x5d06x9b['fontsize'](2);
        _0x5d06x9b = _0x5d06x9b['fontcolor']('red');
        if (gTimeDiff != '') {
            _0x5d06x9a = _0x5d06x9b + '<br> For last ' + gTimeDiff + '<br> ' + gVehicleAddress;
        } else {
            _0x5d06x9a = _0x5d06x9b + '<br>' + gVehicleAddress;
        };
        document['getElementById']('tdStatus')['innerHTML'] = _0x5d06x9a;
        document['getElementById']('tdIcon')['style']['backgroundImage'] = 'url(../images/bgicon7.png)';
        if (map != null) {
            liveIcon['image'] = '../images/icon15.png';
            blinkIcon['image'] = '../images/icon7.png';
        };
    } else {
        if (_0x5d06x97 > 0) {
            gStatus = 3;
            var _0x5d06x9b = 'Ignition on ( Moving )';
            _0x5d06x9b = _0x5d06x9b['fontsize'](2);
            document['getElementById']('tdStatus')['innerHTML'] = _0x5d06x9b + '<br> ' + gVehicleAddress;
            document['getElementById']('tdIcon')['style']['backgroundImage'] = 'url(../images/bgicon54.png)';
            if (map != null) {
                liveIcon['image'] = '../images/icon62.png';
                blinkIcon['image'] = '../images/icon54.png';
            };
        } else {
            gStatus = 2;
            var _0x5d06x9b = 'Ignition on ( Idle)';
            _0x5d06x9b = _0x5d06x9b['fontsize'](2);
            _0x5d06x9b = _0x5d06x9b['fontcolor']('yellow');
            if (gTimeDiff != '') {
                _0x5d06x9a = _0x5d06x9b + '<br>' + gVehicleAddress;
            } else {
                _0x5d06x9a = _0x5d06x9b + '<br> ' + gVehicleAddress;
            };
            document['getElementById']('tdStatus')['innerHTML'] = _0x5d06x9a;
            document['getElementById']('tdIcon')['style']['backgroundImage'] = 'url(../images/bgicon23.png)';
            if (map != null) {
                liveIcon['image'] = '../images/icon31.png';
                blinkIcon['image'] = '../images/icon23.png';
            };
        };
    };
};
GPolygon['prototype']['Contains'] = function (_0x5d06x9c) {
    var _0x5d06x9d = 0;
    var _0x5d06x9e = false;
    var _0x5d06x9f = _0x5d06x9c['lng']();
    var _0x5d06xa0 = _0x5d06x9c['lat']();
    for (var _0x5d06x3e = 0; _0x5d06x3e < this['getVertexCount'](); _0x5d06x3e++) {
        _0x5d06x9d++;
        if (_0x5d06x9d == this['getVertexCount']()) {
            _0x5d06x9d = 0;
        };
        if (((this['getVertex'](_0x5d06x3e)['lat']() < _0x5d06xa0) && (this['getVertex'](_0x5d06x9d)['lat']() >= _0x5d06xa0)) || ((this['getVertex'](_0x5d06x9d)['lat']() < _0x5d06xa0) && (this['getVertex'](_0x5d06x3e)['lat']() >= _0x5d06xa0))) {
            if (this['getVertex'](_0x5d06x3e)['lng']() + (_0x5d06xa0 - this['getVertex'](_0x5d06x3e)['lat']()) / (this['getVertex'](_0x5d06x9d)['lat']() - this['getVertex'](_0x5d06x3e)['lat']()) * (this['getVertex'](_0x5d06x9d)['lng']() - this['getVertex'](_0x5d06x3e)['lng']()) < _0x5d06x9f) {
                _0x5d06x9e = !_0x5d06x9e;
            };
        };
    };
    return _0x5d06x9e;
};

function playSound(_0x5d06xa2) {
    alert(_0x5d06xa2);
};

function addMarker(_0x5d06x46, _0x5d06x47, _0x5d06x44, _0x5d06x96, _0x5d06x97) {
    if (map == null) {
        return;
    };
    if (_0x5d06x46 == gVehicleLatPre && gIgnitionStatusPre == _0x5d06x96 && gVehicleSpeed == _0x5d06x97) {
        return;
    };
    gVehicleLatPre = _0x5d06x46;
    gIgnitionStatusPre = _0x5d06x96;
    gVehicleSpeedPre = _0x5d06x97;
    gLocationCurrent = new GLatLng(_0x5d06x46, _0x5d06x47);
    var _0x5d06x79 = map['getBounds']();
    var _0x5d06x7a = _0x5d06x79['containsLatLng'](gLocationCurrent);
    if (_0x5d06x7a == false) {
        map['panTo'](gLocationCurrent);
    };
    if (gPolygon != null) {
        if (gPolygon.Contains(gLocationCurrent)) {
            if (gPreGeofenceStatus == true) {
                alert('The Tracker is Inside the Geofence.');
                gPreGeofenceStatus = false;
            };
        } else {
            if (gPreGeofenceStatus == false) {
                playSound('The Tracker is Outside the Geofence.');
                gPreGeofenceStatus = true;
            };
        };
    };
    var _0x5d06x78 = new GMarker(gLocationCurrent, liveIcon);
    var _0x5d06xa4 = new GMarker(gLocationCurrent, blinkIcon);
    map['addOverlay'](_0x5d06x78);
    map['removeOverlay'](gMarkerArray[0]);
    map['addOverlay'](_0x5d06xa4);
    if (gLocationPre != null && gLocationCurrent != null) {
        var _0x5d06x3a = [gLocationPre, gLocationCurrent];
        gPolyLine = new XPolyline(_0x5d06x3a, gLineColor, 2, 1, null, 30, 5, gLineColor, 2, 1);
        map['addOverlay'](gPolyLine);
        if (gStatus == 1 && gLineColor == '#ff0000') {
            gLineColor = '#0000ff';
        } else {
            if (gStatus == 1 && gLineColor == '#0000ff') {
                gLineColor = '#ff0000';
            };
        };
    };
    gVehicleLatPre = _0x5d06x46;
    gVehicleLngPre = _0x5d06x47;
    gLocationPre = new GLatLng(gVehicleLatPre, gVehicleLngPre);
    var _0x5d06x9b = '';
    if (gStatus == 1) {
        _0x5d06x9b = 'Ignition off';
    } else {
        if (gStatus == 2) {
            _0x5d06x9b = 'Ignition on ( Idle)';
        } else {
            _0x5d06x9b = 'Ignition on ( Moving )';
        };
    };
    var _0x5d06xa5 = '<div style="background-color:#0077ff; align=left; "><table width=\'200px\' height=\'60px\'   border=\'0\' style=\'font-family:  Arial; font-size: 11px; color=white; font-weight:bold;\'>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\' >' + '<b>Status:</b></font></td><td height=\'15px\'> ' + _0x5d06x9b + ' </td></tr>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\'>' + '<b>Time:</b></font></td><td height=\'15px\'> ' + _0x5d06x44 + '</td></tr>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\'> ' + '<b>Lat/Lng:</b></font></td><td height=\'15px\'> ' + _0x5d06x46 + ' / ' + _0x5d06x47 + '</td></tr>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\'>' + '<b>Speed:</b></font></td><td height=\'15px\'> ' + _0x5d06x97 + ' km/h</td></tr>';
    _0x5d06xa5 += '<tr><td colspan=\'2\' width=\'150px\' height=\'15px\'><textarea name=\'add\' cols=\'48\' rows=\'2\'  style=\'font-family:  Arial; font-size: 10px; color=black; \'>' + gVehicleAddress + '</textarea></td></tr></table></div>';
    _0x5d06x78['openInfoWindowHtml'](_0x5d06xa5);
    GEvent['addListener'](_0x5d06x78, 'click', function () {
        _0x5d06x78['openInfoWindowHtml'](_0x5d06xa5);
    });
    GEvent['addListener'](_0x5d06xa4, 'click', function () {
        _0x5d06xa4['openInfoWindowHtml'](_0x5d06xa5);
    });
    gMarkerArray[0] = _0x5d06xa4;
    gMarkerPre = _0x5d06x78;
    gDataInitialized = true;
};

function updateMarker(_0x5d06x44, _0x5d06x96, _0x5d06x97) {
    if (map == null) {
        return;
    };
    var _0x5d06xa7 = new GLatLng(gVehicleLatPre, gVehicleLngPre);
    var _0x5d06x78 = new GMarker(_0x5d06xa7, liveIcon);
    if (gMarkerPre != null) {
        map['removeOverlay'](gMarkerPre);
        map['addOverlay'](_0x5d06x78);
    } else {
        return;
    };
    var _0x5d06xa4 = new GMarker(_0x5d06xa7, blinkIcon);
    if (gMarkerArray[0] != null) {
        map['removeOverlay'](gMarkerArray[0]);
        map['addOverlay'](_0x5d06xa4);
    };
    document['getElementById']('timeTD' + (gRowIndex - 1))['innerHTML'] = _0x5d06x44;
    document['getElementById']('tabDetailsTime')['innerHTML'] = _0x5d06x44;
    var _0x5d06x9b = '';
    if (gStatus == 1) {
        _0x5d06x9b = 'Ignition off';
    } else {
        if (gStatus == 2) {
            _0x5d06x9b = 'Ignition on ( Idle)';
        } else {
            _0x5d06x9b = 'Ignition on ( Moving )';
        };
    };
    var _0x5d06xa5 = '<div style="background-color:#0077ff; align=left; "><table width=\'200px\' height=\'60px\'   border=\'0\' style=\'font-family:  Arial; font-size: 11px; color=white; font-weight:bold;\'>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\' >' + '<b>Status:</b></font></td><td height=\'15px\'> ' + _0x5d06x9b + ' </td></tr>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\'>' + '<b>Time:</b></font></td><td height=\'15px\'> ' + _0x5d06x44 + '</td></tr>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\'> ' + '<b>Lat/Lng:</b></font></td><td height=\'15px\'> ' + gVehicleLatPre + ' / ' + gVehicleLngPre + '</td></tr>';
    _0x5d06xa5 += '<tr><td width=\'50px\' height=\'15px\'>' + '<b>Speed:</b></font></td><td height=\'15px\'> ' + _0x5d06x97 + ' km/h</td></tr>';
    _0x5d06xa5 += '<tr><td colspan=\'2\' width=\'150px\' height=\'15px\'><textarea name=\'add\' cols=\'48\' rows=\'2\'  style=\'font-family:  Arial; font-size: 10px; color=black; \'>' + gVehicleAddress + '</textarea></td></tr></table></div>';
    _0x5d06x78['openInfoWindowHtml'](_0x5d06xa5);
    GEvent['addListener'](_0x5d06x78, 'click', function () {
        _0x5d06x78['openInfoWindowHtml'](_0x5d06xa5);
    });
    GEvent['addListener'](_0x5d06xa4, 'click', function () {
        _0x5d06xa4['openInfoWindowHtml'](_0x5d06xa5);
    });
    gMarkerPre = _0x5d06x78;
    gMarkerArray[0] = _0x5d06xa4;
};

function getAddressFromGoogle(_0x5d06xa9) {
    try {
        if (!_0x5d06xa9 || _0x5d06xa9['Status']['code'] != 200) {
            gVehicleAddress = 'Unknown';
        } else {
            place = _0x5d06xa9['Placemark'][1];
            gVehicleAddress = place['address'];
        };
    } catch (e) {};
};

function highlightRow(_0x5d06x6a) {
    rowIndex = _0x5d06x6a['sectionRowIndex'];
    var _0x5d06xab = document['getElementById']('statsTable')['rows']['length'];
    rowIndex = _0x5d06xab - rowIndex - 1;
    gSelectedRowIndex = rowIndex;
    document['getElementById']('tr' + rowIndex)['style']['backgroundColor'] = '#CCFFCC';
    document['getElementById']('tabDetailsTime')['innerHTML'] = document['getElementById']('timeTD' + rowIndex)['innerHTML'];
    document['getElementById']('tabDetailsSpeed')['innerHTML'] = gVehicleSpeedArray[rowIndex] + ' km/h';
    document['getElementById']('tabDetailsLocation')['innerHTML'] = document['getElementById']('locationTD' + rowIndex)['innerHTML'];
    document['getElementById']('tabDetailsTotalMileage')['innerHTML'] = gOdometerArray[rowIndex] / 1000 + ' km';
};

function deselectRow(_0x5d06x6a) {
    rowIndex = _0x5d06x6a['sectionRowIndex'];
    document['getElementById']('tr' + rowIndex)['style']['backgroundColor'] = '#103344';
    document['getElementById']('tr' + rowIndex)['style']['color'] = '#CCFF00';
};

function showFirstRowStatus(_0x5d06x44, _0x5d06x4c, _0x5d06x97) {
    document['getElementById']('tabDetailsTime')['innerHTML'] = _0x5d06x44;
    document['getElementById']('tabDetailsSpeed')['innerHTML'] = _0x5d06x97 + ' km/h';
    document['getElementById']('tabDetailsLocation')['innerHTML'] = document['getElementById']('locationTD' + gRowIndex)['innerHTML'];
    document['getElementById']('tabDetailsTotalMileage')['innerHTML'] = _0x5d06x4c / 1000 + ' km';
};

function updateIconStatus() {
    setTimeout('updateIconStatus()', 250);
    if (map == null) {
        return;
    };
    if (gDataInitialized == false) {
        return;
    };
    if (gSmallIcon == true) {
        gSmallIcon = false;
        gMarkerArray[0]['show']();
    } else {
        gSmallIcon = true;
        gMarkerArray[0]['hide']();
    };
};

function ReturnTimeDiff(_0x5d06x4e) {
    var _0x5d06xb0 = Math['floor'](_0x5d06x4e / (60 * 60 * 24));
    var _0x5d06xb1 = Math['floor']((_0x5d06x4e - (_0x5d06xb0 * 60 * 60 * 24)) / (60 * 60));
    var _0x5d06xb2 = Math['floor']((_0x5d06x4e - (_0x5d06xb0 * 60 * 60 * 24) - (_0x5d06xb1 * 60 * 60)) / 60);
    if (_0x5d06xb0 < 1) {
        if (_0x5d06xb1 < 1) {
            if (_0x5d06xb2 < 2) {
                _0x5d06x4e = '';
                return _0x5d06x4e;
            } else {
                _0x5d06x4e = _0x5d06xb2 + ' min';
                return _0x5d06x4e;
            };
        } else {
            _0x5d06x4e = _0x5d06xb1 + ' hrs';
            _0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb2 + ' min';
            return _0x5d06x4e;
        };
    } else {
        _0x5d06x4e = _0x5d06xb0 + ' days';
        _0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb1 + ' hrs';
        _0x5d06x4e = _0x5d06x4e + ' ' + _0x5d06xb2 + ' min';
        return _0x5d06x4e;
    };
};

function convertHrAndMin(_0x5d06x4e) {
    var _0x5d06xb4 = Math['floor'](_0x5d06x4e);
    var _0x5d06xb5 = Math['floor']((_0x5d06x4e - _0x5d06xb4) * 60);
    return _0x5d06xb4 + ' hr ' + _0x5d06xb5 + ' min';
};

function getSystemTime() {
    var _0x5d06xb7 = new Date();
    var _0x5d06xb8 = _0x5d06xb7['getHours']();
    var _0x5d06xb9 = _0x5d06xb7['getMinutes']();
    var _0x5d06xba = _0x5d06xb7['getSeconds']();
    var _0x5d06xbb = ' AM';
    var _0x5d06xbc = '';
    if (_0x5d06xb8 >= 12) {
        _0x5d06xb8 -= 12;
        _0x5d06xbb = ' PM';
    };
    if (_0x5d06xb8 == 0) {
        _0x5d06xb8 = 12;
    };
    _0x5d06xbc = _0x5d06xb8 + ':' + ((_0x5d06xb9 < 10) ? '0' : '') + _0x5d06xb9 + ':' + ((_0x5d06xba < 10) ? '0' : '') + _0x5d06xba + _0x5d06xbb;
    return _0x5d06xbc;
};

function getSystemDate() {
    var _0x5d06xbe = new Date();
    var _0x5d06xbf = _0x5d06xbe['getMonth']() + 1;
    var _0x5d06xc0 = _0x5d06xbe['getYear']();
    var _0x5d06xc1 = _0x5d06xbe['getDate']();
    if (_0x5d06xc1 < 10) {
        _0x5d06xc1 = '0' + _0x5d06xc1;
    };
    if (_0x5d06xbf < 10) {
        _0x5d06xbf = '0' + _0x5d06xbf;
    };
    if (_0x5d06xc0 < 1000) {
        _0x5d06xc0 += 1900;
    };
    var _0x5d06xc2 = _0x5d06xc0 + '-' + _0x5d06xbf + '-' + _0x5d06xc1;
    return _0x5d06xc2;
};