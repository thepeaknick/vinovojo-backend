webpackJsonp(["winery.module"],{

/***/ "./src/app/services/winery.datasource.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return WineryDataSource; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__ = __webpack_require__("./node_modules/rxjs/_esm5/BehaviorSubject.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_rxjs_operators__ = __webpack_require__("./node_modules/rxjs/_esm5/operators.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_rxjs_observable_of__ = __webpack_require__("./node_modules/rxjs/_esm5/observable/of.js");



var WineryDataSource = /** @class */ (function () {
    function WineryDataSource(httpService) {
        this.httpService = httpService;
        this.winerySubject = new __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__["a" /* BehaviorSubject */]([]);
        this.loadingSubject = new __WEBPACK_IMPORTED_MODULE_0_rxjs_BehaviorSubject__["a" /* BehaviorSubject */](false);
        this.loading$ = this.loadingSubject.asObservable();
    }
    WineryDataSource.prototype.loadWineries = function (pageIndex, lang) {
        var _this = this;
        this.loadingSubject.next(true);
        this.httpService.findWineries('get/winery', lang, pageIndex).pipe(Object(__WEBPACK_IMPORTED_MODULE_1_rxjs_operators__["catchError"])(function () { return Object(__WEBPACK_IMPORTED_MODULE_2_rxjs_observable_of__["a" /* of */])([]); }), Object(__WEBPACK_IMPORTED_MODULE_1_rxjs_operators__["finalize"])(function () { return _this.loadingSubject.next(false); }))
            .subscribe(function (wineries) { return _this.winerySubject.next(wineries); });
    };
    WineryDataSource.prototype.connect = function (collectionViewer) {
        return this.winerySubject.asObservable();
    };
    WineryDataSource.prototype.disconnect = function (collectionViewer) {
        this.winerySubject.complete();
        this.loadingSubject.complete();
    };
    return WineryDataSource;
}());



/***/ }),

/***/ "./src/app/winery/add/add.component.css":
/***/ (function(module, exports) {

module.exports = "ul.dropdown-menu.dropdown-menu-left {\r\n    cursor: pointer;\r\n}\r\n\r\n#langDropdown {\r\n    margin-top: -10px;\r\n    position: absolute;\r\n    width: 100%;\r\n}\r\n\r\ni.fcancel.material-icons {\r\n    cursor: pointer;\r\n    z-index: 999;\r\n}\r\n\r\n.form-full-width {\r\n    width: 100%;\r\n}\r\n\r\ndiv#card-winery {\r\n    margin-top: 45px;\r\n}"

/***/ }),

/***/ "./src/app/winery/add/add.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <form [formGroup]=\"wineryForm\" novalidate #f=\"ngForm\" (ngSubmit)=\"onSubmit()\">\r\n                <div class=\"col-md-offset-1 col-md-10\">\r\n                    <div class=\"dropdown\" *ngIf=\"wineryForm.get('items').controls.length == 0\">\r\n                        <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">Dodaj jezik<b class=\"caret\"></b></button>\r\n                        <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                            <li class=\"dropdown-header\">izaberite jezik</li>\r\n                            <li *ngFor=\"let lang of langs\">\r\n                                <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                            </li>\r\n                        </ul>\r\n                    </div>\r\n                </div>\r\n                <div formArrayName=\"items\" *ngFor=\"let item of wineryForm.get('items').controls; let i = index;\">\r\n                    <div [formGroupName]=\"i\">\r\n                        <div class=\"col-md-offset-1 col-md-10\">\r\n                            <div class=\"card\">\r\n                                <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                                    <i class=\"material-icons\">language</i>\r\n                                </div>\r\n                                <div class=\"pull-right remove-btn\">\r\n                                    <h4 class=\"card-title\"><i (click)=\"onRemoveLangs(item.controls.language_name.value , item.controls.language.value ,  i)\" class=\"fcancel material-icons\">cancel</i></h4>\r\n                                </div>\r\n                                <div class=\"card-content\">\r\n                                    <h4 class=\"card-title\">{{item.controls['language_name'].value}}</h4>\r\n                                    <div class=\"col-md-offset-1 col-md-10\">\r\n                                        <div class=\"row\">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Ime vinarije</mat-label>\r\n                                                <input type=\"text\" matInput placeholder=\"Ime\" formControlName=\"wineryName\">\r\n                                                <mat-error>\r\n                                                    <span *ngIf=\"item.controls['wineryName'].touched && item.controls['wineryName'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                </mat-error>\r\n                                            </mat-form-field>\r\n                                        </div>\r\n                                        <div class=\"row \">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Opis vinarije</mat-label>\r\n                                                <textarea matInput type=\"text\" placeholder=\"Opis...\" formControlName=\"wineryDesc\"></textarea>\r\n                                                <mat-error>\r\n                                                    <span *ngIf=\"item.controls['wineryDesc'].touched && item.controls['wineryDesc'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                </mat-error>\r\n                                            </mat-form-field>\r\n                                            <div id=\"langDropdown\" class=\"dropdown\" *ngIf=\"wineryForm.get('items').controls.length == i+1 && langs.length !== 0\">\r\n                                                <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">Dodaj jezik<b class=\"caret\"></b></button>\r\n                                                <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                                                    <li class=\"dropdown-header\">izaberite jezik</li>\r\n                                                    <li *ngFor=\"let lang of langs\">\r\n                                                        <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                                                    </li>\r\n                                                </ul>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-md-offset-1 col-md-10\">\r\n                    <div id=\"card-winery\" class=\"card\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                            <i class=\"material-icons\">assignment</i>\r\n                        </div>\r\n                        <div class=\"card-content\">\r\n                            <h4 class=\"card-title\">Forma za dodavanje vinarija</h4>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-12\">\r\n                                    <div class=\"col-md-4 col-sm-6\">\r\n                                        <div class=\"pull-left\">\r\n                                            <legend>Slika za logo</legend>\r\n                                        </div>\r\n                                        <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                            <div class=\"fileinput-new thumbnail\">\r\n                                                <img src=\"./assets/img/image_placeholder.jpg\" alt=\"...\">\r\n                                            </div>\r\n                                            <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                            <div>\r\n                                                <span class=\"btn btn-rose btn-block btn-file\">\r\n                                            <span class=\"fileinput-new\">Izaberi sliku</span>\r\n                                                <span class=\"fileinput-exists\">Promeni</span>\r\n                                                <input (change)=\"onUploadLogo($event)\" type=\"file\" name=\"logo_image\" />\r\n                                                </span>\r\n                                                <a href=\"#\" #logoPath class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-md-4 col-sm-6\">\r\n                                        <div class=\"pull-left\">\r\n                                            <legend>Slika za naslovnu</legend>\r\n                                        </div>\r\n                                        <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                            <div class=\"fileinput-new thumbnail\">\r\n                                                <img src=\"./assets/img/image_placeholder.jpg\" alt=\"...\">\r\n                                            </div>\r\n                                            <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                            <div>\r\n                                                <span class=\"btn btn-rose btn-block btn-file\">\r\n                                            <span class=\"fileinput-new\">Izaberi naslovnu</span>\r\n                                                <span class=\"fileinput-exists\">Promeni</span>\r\n                                                <input (change)=\"onUploadCover($event)\" type=\"file\" name=\"cover_image\" />\r\n                                                </span>\r\n                                                <a href=\"#\" #coverPath class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-md-4 col-sm-6\">\r\n                                        <div class=\"pull-left\">\r\n                                            <legend>Video snimak *MP4</legend>\r\n                                        </div>\r\n                                        <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                            <div class=\"fileinput-new thumbnail\">\r\n                                                <img src=\"./assets/img/image_placeholder.jpg\" alt=\"...\">\r\n                                            </div>\r\n                                            <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                            <div>\r\n                                                <span class=\"btn btn-rose btn-block btn-file\">\r\n                                            <span class=\"fileinput-new\">Izaberi Video</span>\r\n                                                <span class=\"fileinput-exists\">Promeni</span>\r\n                                                <input (change)=\"onUploadVideo($event)\" type=\"file\" name=\"video\" />\r\n                                                </span>\r\n                                                <a href=\"#\" #videoPath class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"col-md-6\">\r\n                                    <div class=\"row\">\r\n                                        <div class=\"pull-left\">\r\n                                            <legend>Radno vreme</legend>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"row\">\r\n                                        <div class=\"togglebutton\">\r\n                                            <label><input name=\"mondayFriday\" formControlName=\"mondayFriday\" type=\"checkbox\" checked>Ponedeljak - Petak</label>\r\n                                            <div class=\"row\">\r\n                                                <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['mondayFriday'].value == '' || wineryForm.controls['mondayFriday'].value == false\">\r\n                                                    <div class=\"form-group label-floating column-sizing\">\r\n                                                        <input name=\"mondayFridayTimeStart\" placeholder=\"Početak\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                    </div>\r\n                                                </div>\r\n                                                <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['mondayFriday'].value == '' || wineryForm.controls['mondayFriday'].value == false\">\r\n                                                    <div class=\"form-group label-floating column-sizing\">\r\n                                                        <input name=\"mondayFridayTimeEnd\" placeholder=\"Kraj\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"togglebutton\">\r\n                                            <label><input name=\"saturday\" formControlName=\"saturday\" type=\"checkbox\">Subota</label>\r\n                                            <div class=\"row\">\r\n                                                <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['saturday'].value === '' || wineryForm.controls['saturday'].value === false\">\r\n                                                    <div class=\"form-group label-floating column-sizing\">\r\n                                                        <input name=\"saturdayTimeStart\" type=\"text\" placeholder=\"Početak\" class=\"form-control timepicker\" />\r\n                                                    </div>\r\n                                                </div>\r\n                                                <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['saturday'].value === '' || wineryForm.controls['saturday'].value === false\">\r\n                                                    <div class=\"form-group label-floating column-sizing\">\r\n                                                        <input name=\"saturdayTimeEnd\" type=\"text\" placeholder=\"Kraj\" class=\"form-control timepicker\" />\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                        <div class=\"togglebutton\">\r\n                                            <label><input name=\"sunday\" formControlName=\"sunday\" type=\"checkbox\">Nedelja</label>\r\n                                            <div class=\"row\">\r\n                                                <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['sunday'].value === '' || wineryForm.controls['sunday'].value === false\">\r\n                                                    <div class=\"form-group label-floating column-sizing\">\r\n                                                        <input matInput name=\"sundayTimeStart\" placeholder=\"Početak\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                    </div>\r\n                                                </div>\r\n                                                <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['sunday'].value === '' || wineryForm.controls['sunday'].value === false\">\r\n                                                    <div class=\"form-group label-floating column-sizing\">\r\n                                                        <input name=\"sundayTimeEnd\" placeholder=\"Kraj\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                    </div>\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <div class=\"col-lg-6 col-md-6 col-sm-3\">\r\n                                        <mat-form-field class=\"form-full-width\">\r\n                                            <mat-label>Regija</mat-label>\r\n                                            <mat-select formControlName=\"area_id\" [value]=\"wineryForm.controls['area_id'].value\" placeholder=\"odaberite regiju\">\r\n                                                <mat-option *ngFor=\"let area of areas\" [value]=\"area.id\">{{area.name}}</mat-option>\r\n                                            </mat-select>\r\n                                            <mat-error>\r\n                                                <span *ngIf=\"wineryForm.controls['area_id'].touched && wineryForm.controls['area_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                            </mat-error>\r\n                                        </mat-form-field>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <div class=\"col-md-6 col-lg-6\">\r\n                                        <div class=\"form-group label-floating\">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Telefon</mat-label>\r\n                                                <input matInput type=\"text\" placeholder=\"Broj telefona | primer: 12345678\" formControlName=\"contact\" pattern=\"^[0-9]+\">\r\n                                                <mat-error>\r\n                                                    <span *ngIf=\"wineryForm.controls['contact'].touched && wineryForm.controls['contact'].hasError('pattern')\">broj telefona nije ispravno unet <strong>molimo proverite format</strong></span>\r\n                                                </mat-error>\r\n                                            </mat-form-field>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-md-6 col-lg-6\">\r\n                                        <div class=\"form-group label-floating\">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Kontakt</mat-label>\r\n                                                <input matInput type=\"text\" placeholder=\"Ime osobe za kontakt\" formControlName=\"contact_person\">\r\n                                            </mat-form-field>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <div class=\"col-md-12 col-lg-12\">\r\n                                        <mat-form-field class=\"form-full-width\">\r\n                                            <mat-label>Web sajt</mat-label>\r\n                                            <input matInput type=\"text\" placeholder=\"http://... ili https://...\" formControlName=\"webpage\">\r\n                                            <mat-error>\r\n                                                <span *ngIf=\"wineryForm.controls['webpage'].touched && wineryForm.controls['webpage'].hasError('pattern')\">URL nije ispravan <strong>molimo proverite format http://www.primer.rs</strong></span>\r\n                                            </mat-error>\r\n                                        </mat-form-field>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <div class=\"text-center\">\r\n                                        <button type=\"submit\" class=\"btn btn-rose btn-fill btn-wd\" [disabled]=\"!wineryForm.valid\">DODAJ VINARIJU\r\n                                        </button>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                    <div class=\"row\">\r\n                        <div class=\"col-md-12\">\r\n                            <div class=\"card\">\r\n                                <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                                    <i class=\"material-icons\">location_on</i>\r\n                                </div>\r\n                                <div class=\"card-content\">\r\n                                    <h4 class=\"card-title\">Lokacija vinarije</h4>\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Adresa</mat-label>\r\n                                        <input matInput type=\"text\" placeholder=\"ulica\" formControlName=\"address\" #address>\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineryForm.controls['address'].touched && wineryForm.controls['address'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                    <agm-map (mapClick)=\"onChoseLocation($event)\" [latitude]=\"lat\" [longitude]=\"lng\">\r\n                                        <agm-marker [latitude]=\"lat\" [longitude]=\"lng\"></agm-marker>\r\n                                    </agm-map>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/winery/add/add.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return AddComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__agm_core__ = __webpack_require__("./node_modules/@agm/core/index.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var datepicker = {
    // datepickerArray:[],
    monFri: [],
    saturday: [],
    sunday: []
};
var AddComponent = /** @class */ (function () {
    function AddComponent(fb, http, alert, mapsAPILoader, ngZone) {
        this.fb = fb;
        this.http = http;
        this.alert = alert;
        this.mapsAPILoader = mapsAPILoader;
        this.ngZone = ngZone;
        this.langs = [];
        this.areas = [];
        this.languages = [];
        this.contactNo = "^[0-9]+"; // pattern for contact number
        this.websiteUrl = "https?://.+"; // pattern for web site url
        this.fileValidator = [];
    }
    AddComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.lat = 43.3176108;
        this.lng = 21.9079216;
        this.subscriptionarea = this.http
            .get("dropdown/area", 1)
            .subscribe(function (httpresponse) {
            _this.areas = httpresponse.json();
            console.log(_this.areas);
        });
        this.subscriptionlang = this.http
            .get("dropdown/language", 1)
            .subscribe(function (httpresponse) {
            _this.langs = httpresponse.json();
            // this.langs.splice(0, 1);
        });
        this.wineryForm = this.fb.group({
            address: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            // cardTitle: ["srb"],
            contact: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].pattern(this.contactNo)],
            contact_person: [""],
            webpage: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].pattern(this.websiteUrl)],
            mondayFriday: [""],
            saturday: [""],
            sunday: [""],
            ponpet: [""],
            sub: [""],
            ned: [""],
            area_id: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            items: this.fb.array([]),
            languages: [""]
        });
        //  Init Bootstrap Select Picker
        if ($(".selectpicker").length !== 0) {
            $(".selectpicker").selectpicker();
        }
        $(".timepicker").datetimepicker({
            format: "H:mm",
            // format: 'h:mm A',    //use this format if you want the 12hours timpiecker with AM/PM toggle
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-screenshot",
                clear: "fa fa-trash",
                close: "fa fa-remove",
                inline: true,
                sideBySide: true
            }
        });
        //set current position
        this.setCurrentPosition();
        //get lng and lat for map
        this.mapsAPILoader.load().then(function () {
            var autocomplete = new google.maps.places.Autocomplete(_this.searchElementRef.nativeElement, { types: ["address"] });
            autocomplete.addListener("place_changed", function () {
                _this.ngZone.run(function () {
                    //get the place result
                    var place = autocomplete.getPlace();
                    //verify result
                    if (place.geometry === undefined || place.geometry === null) {
                        return;
                    }
                    //set latitude, longitude and zoom
                    _this.lat = place.geometry.location.lat();
                    _this.lng = place.geometry.location.lng();
                });
            });
        });
    };
    AddComponent.prototype.setCurrentPosition = function () {
        var _this = this;
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                _this.lat = position.coords.latitude;
                _this.lng = position.coords.longitude;
            });
        }
    };
    AddComponent.prototype.onRemoveLangs = function (language_name, language_id, index) {
        var _this = this;
        var selected = this.wineryForm.get("items");
        swal({
            title: "Da li ste sigurni da \u017Eelite da uklonite " + language_name + " jezik",
            text: "Vrednosti polja biće trajno obrisane!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: 'ne',
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: "DA, Obriši!",
            buttonsStyling: false
        }).then(function () {
            swal({
                title: "Obrisano!",
                text: "Jezik " + language_name + " je uspesno obrisan!",
                type: "success",
                confirmButtonClass: "btn btn-success",
                buttonsStyling: false
            });
            selected.removeAt(index);
            _this.alert.showNotification("uspesno ste izbirsali jezik", "success", "notification");
            var renewLang = {
                name: language_name,
                id: language_id
            };
            _this.langs.push(renewLang);
        }, function (dismiss) {
        });
    };
    AddComponent.prototype.onChoseLocation = function (event) {
        this.lat = event.coords.lat;
        this.lng = event.coords.lng;
        console.log(event);
    };
    AddComponent.prototype.createLanguage = function (languageId, languageName) {
        return this.fb.group({
            wineryName: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            wineryDesc: ["", __WEBPACK_IMPORTED_MODULE_1__angular_forms__["l" /* Validators */].required],
            language: languageId,
            language_name: [languageName]
        });
    };
    AddComponent.prototype.addItem = function (value) {
        console.log("value", value);
        this.items = this.wineryForm.get("items");
        this.items.push(this.createLanguage(value.id, value.name));
        var index = this.langs.indexOf(value, 0);
        this.langs.splice(index, 1);
        console.log(value);
        console.log(value.name);
    };
    AddComponent.prototype.onUploadLogo = function (event) {
        var file = event.target.files[0];
        var logoValid = {};
        logoValid.name = 'logo';
        if (file.type.indexOf('image') == -1) {
            this.alert.showNotification('Fajl nije slika! molimo ubacite sliku', 'danger', '');
            logoValid.isValid = false;
            this.fileValidator[0] = logoValid;
            return false;
        }
        if (!this.validateImage(file.name)) {
            this.alert.showNotification('Format slike nije podrzan! podrzani formati: *jpg *jpeg *png', 'danger', '');
            logoValid.isValid = false;
            this.fileValidator[0] = logoValid;
            return false;
        }
        else {
            logoValid.isValid = true;
            this.fileValidator[0] = logoValid;
            this.logoFile = event.target.files[0];
        }
    };
    AddComponent.prototype.onUploadCover = function (event) {
        var coverValid = {};
        coverValid.name = 'cover';
        var file = event.target.files[0];
        if (file.type.indexOf('image') == -1) {
            this.alert.showNotification('Fajl nije slika! molimo ubacite sliku', 'danger', '');
            coverValid.isValid = false;
            this.fileValidator[1] = coverValid;
            return false;
        }
        if (!this.validateImage(file.name)) {
            this.alert.showNotification('Format slike nije podrzan! podrzani formati: *jpg *jpeg *png', 'danger', '');
            coverValid.isValid = false;
            this.fileValidator[1] = coverValid;
            return false;
        }
        else {
            coverValid.isValid = true;
            this.fileValidator[1] = coverValid;
            this.coverFile = event.target.files[0];
        }
    };
    AddComponent.prototype.onUploadVideo = function (event) {
        var videoValid = {};
        videoValid.name = 'video';
        var file = event.target.files[0];
        if (file.type.indexOf('video') == -1) {
            this.alert.showNotification('Fajl nije video! molimo ubacite video', 'danger', '');
            videoValid.isValid = false;
            this.fileValidator[2] = videoValid;
            return false;
        }
        if (!this.validateVideo(file.name)) {
            this.alert.showNotification('Format video snimka nije podrzan! podrzani format: *MP4', 'danger', '');
            videoValid.isValid = false;
            this.fileValidator[2] = videoValid;
            return false;
        }
        else {
            videoValid.isValid = true;
            this.fileValidator[2] = videoValid;
            this.videoFile = event.target.files[0];
        }
    };
    AddComponent.prototype.validateVideo = function (name) {
        var ext = name.substring(name.lastIndexOf('.') + 1);
        if (ext.toLowerCase() == 'mp4') {
            return true;
        }
        return false;
    };
    AddComponent.prototype.validateImage = function (name) {
        var ext = name.substring(name.lastIndexOf('.') + 1);
        if (ext.toLowerCase() == 'png') {
            return true;
        }
        if (ext.toLowerCase() == 'jpg') {
            return true;
        }
        if (ext.toLowerCase() == 'jpeg') {
            return true;
        }
        return false;
    };
    AddComponent.prototype.resetForm = function () {
        this.myNgForm.resetForm({ mondayFriday: "", saturday: "", sunday: "" });
    };
    AddComponent.prototype.onSubmit = function () {
        var _this = this;
        console.log(this.wineryForm);
        var fd = new FormData();
        var langForm = this.wineryForm.get("items"); // vrednosti FormArray 'items'
        console.log("items: ", langForm);
        datepicker.monFri = [];
        datepicker.saturday = [];
        datepicker.sunday = [];
        $("input.timepicker").each(function (index, value) {
            var d = $(value).data("date");
            if ($(value).attr("name") === "mondayFridayTimeStart") {
                datepicker.monFri.push(d);
            }
            if ($(value).attr("name") === "mondayFridayTimeEnd") {
                datepicker.monFri.push(d);
            }
            /**
             *
             */
            if ($(value).attr("name") === "saturdayTimeStart") {
                datepicker.saturday.push(d);
            }
            if ($(value).attr("name") === "saturdayTimeEnd") {
                datepicker.saturday.push(d);
            }
            /**
             *
             */
            if ($(value).attr("name") === "sundayTimeStart") {
                datepicker.sunday.push(d);
            }
            if ($(value).attr("name") === "sundayTimeEnd") {
                datepicker.sunday.push(d);
            }
        });
        //TODO
        var checking = this.wineryForm.controls;
        if (checking.mondayFriday.value === true) {
            if (datepicker.monFri[0] === undefined) {
                //TODO poruka lose upisan datum
                this.alert.showNotification("niste ispravno uneli datum za ponedeljak", "danger", "notifications");
                return false;
            }
            else if (datepicker.monFri[1] === undefined) {
                //TODO poruka lose upisan datum
                this.alert.showNotification("niste ispravno uneli datum za ponedeljak", "danger", "notifications");
                return false;
            }
            else {
                this.wineryForm.controls["ponpet"].setValue(datepicker.monFri);
            }
        }
        if (checking.saturday.value === true) {
            if (datepicker.saturday[0] === undefined) {
                //TODO poruka lose upisan datum
                this.alert.showNotification("niste ispravno uneli datum za subotu", "danger", "notifications");
                return false;
            }
            else if (datepicker.saturday[1] === undefined) {
                //TODO poruka lose upisan datum
                this.alert.showNotification("niste ispravno uneli datum za subotu", "danger", "notifications");
                return false;
            }
            else {
                this.wineryForm.controls["sub"].setValue(datepicker.saturday);
            }
        }
        if (checking.sunday.value === true) {
            if (datepicker.sunday[0] === undefined) {
                //TODO poruka lose upisan datum
                this.alert.showNotification("niste ispravno uneli datum za nedelju", "danger", "notifications");
                return false;
            }
            else if (datepicker.sunday[1] === undefined) {
                //TODO poruka lose upisan datum
                this.alert.showNotification("niste ispravno uneli datum za nedelju", "danger", "notifications");
                return false;
            }
            else {
                this.wineryForm.controls["ned"].setValue(datepicker.sunday);
            }
        }
        var languages = [];
        langForm.controls.forEach(function (element) {
            var formGroup = element;
            languages.push({
                language_id: formGroup.controls.language.value,
                name: "description",
                value: formGroup.controls["wineryDesc"].value
            });
            languages.push({
                language_id: formGroup.controls.language.value,
                name: "name",
                value: formGroup.controls["wineryName"].value
            });
        });
        this.wineryForm.controls.languages.setValue(languages);
        this.wineryForm.controls.address.setValue(this.searchElementRef.nativeElement.value);
        var formInput = this.wineryForm.value;
        delete formInput.items;
        delete formInput.mondayFriday;
        delete formInput.sunday;
        delete formInput.saturday;
        if (this.logoFile !== undefined) {
            fd.append("logo", this.logoFile);
        }
        if (this.coverFile) {
            fd.append("cover", this.coverFile);
        }
        if (this.videoFile) {
            fd.append("video", this.videoFile);
        }
        var marker = {
            lat: this.lat,
            lng: this.lng
        };
        formInput.point = marker;
        console.log(formInput);
        fd.append("json", JSON.stringify(formInput));
        var isFormValid = true;
        this.fileValidator.forEach(function (element) {
            console.log(element);
            if (element.isValid === false) {
                isFormValid = false;
                _this.alert.showNotification('Greska promenite ' + element.name, 'danger', 'notifications');
                return false;
            }
        });
        if (isFormValid) {
            this.http.postFormData("create/winery/", fd).subscribe(function (httpResponse) {
                //   if (event.type === HttpEventType.UploadProgress) {
                //     console.log(
                //       "Upload progress:" +
                //         Math.round(event.loaded / event.total * 100) +
                //         "%"
                //     )
                //     console.log(event);
                //   }
                if (httpResponse.status === 201) {
                    var controls = _this.wineryForm.get('items');
                    while (controls.length !== 0) {
                        controls.removeAt(0);
                        console.log(controls);
                    }
                    _this.http.get('dropdown/language', 1).subscribe(function (httpResponse) {
                        _this.langs = httpResponse.json();
                    });
                    // this.wineryForm.reset({mondayFriday: "", saturday: "", sunday: ""});
                    // clear image tumbnails 
                    _this.logoPath.nativeElement.click();
                    _this.coverPath.nativeElement.click();
                    _this.videoPath.nativeElement.click();
                    _this.coverFile = null;
                    _this.logoFile = null;
                    _this.videoFile = null;
                    // reseting form 
                    _this.resetForm();
                    $("input.timepicker").each(function (index, value) {
                        $($(value).data("date", '')).val("");
                    });
                    _this.alert.showNotification("Uspesno ste kreirali novu vinariju!", "success", "notification");
                }
            }, function (error) {
                _this.alert.showNotification("Greska , niste uspesno sacuvali podatke!", "danger", "error");
            });
        }
        else {
            this.alert.showNotification('Pogresno uneti podaci molimo proverite!', 'danger', '');
        }
        console.log(fd);
    };
    AddComponent.prototype.ngOnDestroy = function () {
        this.subscriptionarea.unsubscribe();
        this.subscriptionlang.unsubscribe();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])("logoPath"),
        __metadata("design:type", Object)
    ], AddComponent.prototype, "logoPath", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])("coverPath"),
        __metadata("design:type", Object)
    ], AddComponent.prototype, "coverPath", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])("videoPath"),
        __metadata("design:type", Object)
    ], AddComponent.prototype, "videoPath", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])("address"),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["ElementRef"])
    ], AddComponent.prototype, "searchElementRef", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])("f"),
        __metadata("design:type", Object)
    ], AddComponent.prototype, "myNgForm", void 0);
    AddComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: "app-add",
            template: __webpack_require__("./src/app/winery/add/add.component.html"),
            styles: [__webpack_require__("./src/app/winery/add/add.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_forms__["b" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_2__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_3__notifications_notifications_service__["a" /* NotificationsService */],
            __WEBPACK_IMPORTED_MODULE_4__agm_core__["b" /* MapsAPILoader */],
            __WEBPACK_IMPORTED_MODULE_0__angular_core__["NgZone"]])
    ], AddComponent);
    return AddComponent;
}());



/***/ }),

/***/ "./src/app/winery/edit/edit.component.css":
/***/ (function(module, exports) {

module.exports = "ul.dropdown-menu.dropdown-menu-left {\r\n    cursor: pointer;\r\n}\r\n\r\n.form-full-width {\r\n    width: 100%;\r\n}\r\n\r\n#langDropdown {\r\n    margin-top: -10px;\r\n    position: absolute;\r\n    width: 100%;\r\n}\r\n\r\n.progress {\r\n    margin: 0px;\r\n}\r\n\r\nagm-map {\r\n    height: 300px;\r\n}\r\n\r\ni.fcancel.material-icons {\r\n    cursor: pointer;\r\n    z-index: 999;\r\n}\r\n\r\ndiv#card-winery {\r\n    margin-top: 45px;\r\n}\r\n\r\na.material-icons.cancel-time {\r\n    vertical-align: middle;\r\n    margin-top: -5px;\r\n    margin-left: 5px;\r\n}"

/***/ }),

/***/ "./src/app/winery/edit/edit.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <form [formGroup]=\"wineryForm\" novalidate (ngSubmit)=\"onSubmit()\">\r\n                <div class=\"col-md-offset-1 col-md-10\">\r\n                    <div class=\"dropdown\" *ngIf=\"wineryForm.get('items').controls.length == 0\">\r\n                        <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">Add new lang<b class=\"caret\"></b></button>\r\n                        <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                            <li class=\"dropdown-header\">select language</li>\r\n                            <li *ngFor=\"let lang of langs\">\r\n                                <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                            </li>\r\n                        </ul>\r\n                    </div>\r\n                </div>\r\n                <div formArrayName=\"items\" *ngFor=\"let item of wineryForm.get('items').controls; let i = index;\">\r\n                    <div [formGroupName]=\"i\">\r\n                        <div class=\"col-md-offset-1 col-md-10\">\r\n                            <div class=\"card\">\r\n                                <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                                    <i class=\"material-icons\">language</i>\r\n                                </div>\r\n                                <div class=\"pull-right remove-btn\">\r\n                                    <h4 class=\"card-title\"><i (click)=\"onRemoveLangs(item.controls['language_id'].value, item.controls['language_name'].value  , i)\" class=\"fcancel material-icons\">cancel</i></h4>\r\n                                </div>\r\n                                <div class=\"card-content\">\r\n                                    <h4 class=\"card-title\">{{item.controls['language_name'].value}}</h4>\r\n\r\n                                    <div class=\"col-md-offset-1 col-md-10\">\r\n                                        <div class=\"row\">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Ime vinarije</mat-label>\r\n                                                <input type=\"text\" matInput placeholder=\"Ime\" formControlName=\"wineryName\">\r\n                                                <mat-error>\r\n                                                    <span *ngIf=\"item.controls['wineryName'].touched && item.controls['wineryName'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                </mat-error>\r\n                                            </mat-form-field>\r\n                                        </div>\r\n                                        <div class=\"row \">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Opis vinarije</mat-label>\r\n                                                <textarea matInput type=\"text\" placeholder=\"Opis...\" formControlName=\"wineryDesc\"></textarea>\r\n                                                <mat-error>\r\n                                                    <span *ngIf=\"item.controls['wineryDesc'].touched && item.controls['wineryDesc'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                                </mat-error>\r\n                                            </mat-form-field>\r\n                                            <div class=\"row\">\r\n                                                <button type=\"button\" *ngIf=\"item.controls['flag'].value == 1\" (click)=\"onSaveLanguage(item)\" class=\"btn btn-rose btn-fill btn-wd pull-right\" [disabled]=\"!item.valid\">sačuvaj jezik</button>\r\n                                            </div>\r\n                                            <div id=\"langDropdown\" class=\"dropdown\" *ngIf=\"wineryForm.get('items').controls.length == i+1 && langs.length !== 0\">\r\n                                                <button class=\"dropdown-toggle btn btn-rose btn-block\" data-toggle=\"dropdown\">Dodaj jezik<b class=\"caret\"></b></button>\r\n                                                <ul class=\"dropdown-menu dropdown-menu-left\">\r\n                                                    <li class=\"dropdown-header\">izaberi jezik</li>\r\n                                                    <li *ngFor=\"let lang of langs\">\r\n                                                        <a (click)=\"addItem(lang)\">{{ lang.name }}</a>\r\n                                                    </li>\r\n                                                </ul>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-md-offset-1 col-md-10\">\r\n                    <div id=\"card-winery\" class=\"card\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                            <i class=\"material-icons\">assignment</i>\r\n                        </div>\r\n                        <div class=\"card-content\">\r\n                            <h4 class=\"card-title\">Uređivanje vinarije</h4>\r\n                            <div class=\"row\">\r\n                                <div class=\"col-md-12\">\r\n                                    <div class=\"col-md-4 col-sm-6\">\r\n                                        <div class=\"pull-left\">\r\n                                            <legend>Slika za logo</legend>\r\n                                        </div>\r\n                                        <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                            <div class=\"fileinput-new thumbnail\">\r\n                                                <img *ngIf=\"logo_image !== null\" [src]=\"logo_image\" alt=\"...\">\r\n                                            </div>\r\n                                            <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                            <div>\r\n                                                <span class=\"btn btn-rose btn-block btn-file\">\r\n                                              <span class=\"fileinput-new\">Izaberi logo</span>\r\n                                                <span class=\"fileinput-exists\">Promeni</span>\r\n                                                <input (change)=\"onUploadLogo($event)\" type=\"file\" name=\"logo_image\" />\r\n                                                </span>\r\n                                                <a href=\"#\" class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-md-4 col-sm-6\">\r\n                                        <div class=\"pull-left\">\r\n                                            <legend>Slika za naslovnu</legend>\r\n                                        </div>\r\n                                        <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                            <div class=\"fileinput-new thumbnail\">\r\n                                                <img *ngIf=\"cover_image !== null\" [src]=\"cover_image\" alt=\"...\">\r\n\r\n                                            </div>\r\n\r\n                                            <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                            <div>\r\n                                                <span class=\"btn btn-rose btn-block btn-file\">\r\n                                            <span class=\"fileinput-new\">Izaberi naslovnu</span>\r\n                                                <span class=\"fileinput-exists\">Promeni</span>\r\n                                                <input type=\"file\" (change)=\"onUploadCover($event)\" name=\"cover_image\" />\r\n                                                </span>\r\n                                                <a href=\"#\" class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-md-4 col-sm-6\">\r\n                                        <div class=\"pull-left\">\r\n                                            <legend>Video snimak *MP4</legend>\r\n                                        </div>\r\n                                        <div class=\"fileinput fileinput-new text-center\" data-provides=\"fileinput\">\r\n                                            <div class=\"fileinput-new thumbnail\">\r\n                                                <img src=\"https://p6.zdassets.com/hc/theme_assets/840341/200176068/video_placeholder.png\" alt=\"...\">\r\n                                            </div>\r\n                                            <div class=\"fileinput-preview fileinput-exists thumbnail\"></div>\r\n                                            <div>\r\n                                                <span class=\"btn btn-rose btn-block btn-file\">\r\n                                            <span class=\"fileinput-new\">Izaberi video</span>\r\n                                                <span class=\"fileinput-exists\">Promeni</span>\r\n                                                <input type=\"file\" (change)=\"onUploadVideo($event)\" name=\"...\" />\r\n                                                </span>\r\n                                                <a href=\"#\" class=\"btn btn-danger btn-round fileinput-exists\" data-dismiss=\"fileinput\"><i class=\"fa fa-times\"></i>Ukloni</a>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"row\">\r\n                                    <div class=\"pull-left\">\r\n                                        <legend>Radno vreme</legend>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <div class=\"togglebutton\">\r\n                                        <label><input name=\"mondayFriday\" formControlName=\"mondayFriday\" type=\"checkbox\" checked> \r\n                                                Ponedeljak - Petak - Radno vreme:  {{ponpetTime}} \r\n                                            </label>\r\n                                        <a (click)=\"onRemoveTime('ponpet')\"><i class=\"material-icons cancel-time\">close</i></a>\r\n                                        <div class=\"row\">\r\n                                            <div class=\"col-sm-6 col-md-6\" [hidden]=\"submitted || wineryForm.controls['mondayFriday'].value === '' || wineryForm.controls['mondayFriday'].value === false\">\r\n                                                <div class=\"form-group label-floating column-sizing\">\r\n                                                    <input name=\"mondayFridayTimeStart\" value=\"{{ ponedeljak }}\" placeholder=\"Početak\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                </div>\r\n                                            </div>\r\n                                            <div class=\"col-sm-6 col-md-6\" [hidden]=\"submitted || wineryForm.controls['mondayFriday'].value === '' || wineryForm.controls['mondayFriday'].value === false\">\r\n                                                <div class=\"form-group label-floating column-sizing\">\r\n                                                    <input name=\"mondayFridayTimeEnd\" placeholder=\"Kraj\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"togglebutton\">\r\n                                        <label><input name=\"saturday\" formControlName=\"saturday\" type=\"checkbox\">\r\n                                                Subota - Radno vreme: {{subTime}}\r\n                                            </label>\r\n                                        <a (click)=\"onRemoveTime('sub')\"><i class=\"material-icons cancel-time\">close</i></a>\r\n                                        <div class=\"row\">\r\n                                            <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['saturday'].value === '' || wineryForm.controls['saturday'].value === false\">\r\n                                                <div class=\"form-group label-floating column-sizing\">\r\n                                                    <input name=\"saturdayTimeStart\" type=\"text\" placeholder=\"Početak\" class=\"form-control timepicker\" />\r\n                                                </div>\r\n                                            </div>\r\n                                            <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['saturday'].value === '' || wineryForm.controls['saturday'].value === false\">\r\n                                                <div class=\"form-group label-floating column-sizing\">\r\n                                                    <input name=\"saturdayTimeEnd\" type=\"text\" placeholder=\"Kraj\" class=\"form-control timepicker\" />\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"togglebutton\">\r\n                                        <label><input name=\"sunday\" formControlName=\"sunday\" type=\"checkbox\">\r\n                                                Nedelja - Radno vreme: {{nedTime}}\r\n                                            </label>\r\n                                        <a (click)=\"onRemoveTime('ned')\"><i class=\"material-icons cancel-time\">close</i></a>\r\n                                        <div class=\"row\">\r\n                                            <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['sunday'].value === '' || wineryForm.controls['sunday'].value === false\">\r\n                                                <div class=\"form-group label-floating column-sizing\">\r\n                                                    <input name=\"sundayTimeStart\" placeholder=\"Početak\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                </div>\r\n                                            </div>\r\n                                            <div class=\"col-sm-6 col-md-6\" [hidden]=\"wineryForm.controls['sunday'].value === '' || wineryForm.controls['sunday'].value === false\">\r\n                                                <div class=\"form-group label-floating column-sizing\">\r\n                                                    <input name=\"sundayTimeEnd\" placeholder=\"Kraj\" type=\"text\" class=\"form-control timepicker\" />\r\n                                                </div>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <div class=\"col-lg-6 col-md-6 col-sm-3\">\r\n                                        <mat-form-field class=\"form-full-width\">\r\n                                            <mat-label>Region</mat-label>\r\n                                            <mat-select formControlName=\"area_id\" [value]=\"wineryForm.controls['area_id'].value\" placeholder=\"Region\">\r\n                                                <mat-option *ngFor=\"let area of areas\" [value]=\"area.id\">{{area.name}}</mat-option>\r\n                                            </mat-select>\r\n                                            <mat-error>\r\n                                                <span *ngIf=\"wineryForm.controls['area_id'].touched && wineryForm.controls['area_id'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                            </mat-error>\r\n                                        </mat-form-field>\r\n                                    </div>\r\n                                </div>\r\n\r\n                                <div class=\"row\">\r\n                                    <div class=\"col-md-6 col-lg-6\">\r\n                                        <div class=\"form-group\">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Telefon</mat-label>\r\n                                                <input matInput type=\"text\" placeholder=\"Broj telefona  primer: 12345678\" formControlName=\"contact\">\r\n                                                <mat-error>\r\n                                                    <span *ngIf=\"wineryForm.controls['contact'].touched && wineryForm.controls['contact'].hasError('pattern')\">broj telefona nije ispravno unet <strong>molimo proverite format</strong></span>\r\n                                                </mat-error>\r\n                                            </mat-form-field>\r\n                                        </div>\r\n                                    </div>\r\n                                    <div class=\"col-md-6 col-lg-6\">\r\n                                        <div class=\"form-group\">\r\n                                            <mat-form-field class=\"form-full-width\">\r\n                                                <mat-label>Kontakt</mat-label>\r\n                                                <input matInput type=\"text\" placeholder=\"Osoba za kontakt\" formControlName=\"contact_person\">\r\n                                            </mat-form-field>\r\n                                        </div>\r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"row\">\r\n                                    <mat-form-field class=\"form-full-width\">\r\n                                        <mat-label>Web sajt</mat-label>\r\n                                        <input matInput type=\"text\" placeholder=\"http://... ili https://...\" formControlName=\"webpage\">\r\n                                        <mat-error>\r\n                                            <span *ngIf=\"wineryForm.controls['webpage'].touched && wineryForm.controls['webpage'].hasError('pattern')\">URL nije ispravan <strong>molimo proverite format http://www.primer.rs</strong></span>\r\n                                        </mat-error>\r\n                                    </mat-form-field>\r\n                                </div>\r\n                            </div>\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"row\">\r\n                                    <div class=\"text-center\">\r\n                                        <button type=\"submit\" class=\"btn btn-rose btn-fill btn-wd\" [disabled]=\"!wineryForm.valid\">SAČUVAJ</button>\r\n                                    </div>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"col-md-offset-1 col-md-10\">\r\n                    <div class=\"card\">\r\n                        <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                            <i class=\"material-icons\">location_on</i>\r\n                        </div>\r\n                        <div class=\"card-content\">\r\n                            <h4 class=\"card-title\">Lokacija vinarije</h4>\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Adresa</mat-label>\r\n                                <input matInput type=\"text\" placeholder=\"Ulica\" name=\"address\" formControlName=\"address\" #address>\r\n                                <mat-error>\r\n                                    <span *ngIf=\"wineryForm.controls['address'].touched && wineryForm.controls['address'].hasError('required')\">Ovo polje je <strong>obavezno!</strong></span>\r\n                                </mat-error>\r\n                            </mat-form-field>\r\n                            <agm-map (mapClick)=\"onChoseLocation($event)\" [latitude]=\"lat\" [longitude]=\"lng\">\r\n                                <agm-marker [latitude]=\"lat\" [longitude]=\"lng\"></agm-marker>\r\n                            </agm-map>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/winery/edit/edit.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return EditComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_common_http__ = __webpack_require__("./node_modules/@angular/common/esm5/http.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__agm_core__ = __webpack_require__("./node_modules/@agm/core/index.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};







var datepicker = {
    monFri: [],
    saturday: [],
    sunday: []
};
// value of checked field
var dateValue = {
    mondayFridayCheck: false,
    saturdayCheck: false,
    sundayCheck: false
};
var EditComponent = /** @class */ (function () {
    function EditComponent(fb, http, alert, route, httpc, router, mapsAPILoader, ngZone) {
        this.fb = fb;
        this.http = http;
        this.alert = alert;
        this.route = route;
        this.httpc = httpc;
        this.router = router;
        this.mapsAPILoader = mapsAPILoader;
        this.ngZone = ngZone;
        this.langs = [];
        this.areas = [];
        this.logo_image = null;
        this.cover_image = null;
        this.contactNo = "^[0-9]+"; // pattern for contact number
        this.websiteUrl = "https?://.+"; // pattern for web site url
        this.fileValidator = []; // array contain objects for file validation
    }
    EditComponent.prototype.ngOnInit = function () {
        var _this = this;
        this.subscriptionparams = this.route.params.subscribe(function (params) { return (_this.id = params.id); });
        this.subscriptionlang = this.http
            .get("dropdown/language", 1)
            .subscribe(function (httpresponse) {
            _this.langs = httpresponse.json();
            // this.langs.splice(0, 1);
        });
        this.subscriptionarea = this.http
            .get("dropdown/area", 1)
            .subscribe(function (httpresponse) {
            _this.areas = httpresponse.json();
        });
        this.initLoadingData();
        this.wineryForm = this.fb.group({
            address: ["", __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].required],
            contact: ["", __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].pattern(this.contactNo)],
            contact_person: [""],
            webpage: ["", __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].pattern(this.websiteUrl)],
            mondayFriday: [""],
            saturday: [""],
            sunday: [""],
            ponpet: [""],
            sub: [""],
            ned: [""],
            area_id: ["", __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].required],
            items: this.fb.array([]),
            languages: [''],
            point: {
                lat: this.lat,
                lng: this.lng
            }
        });
        //init data for address
        // this.getLatLan(this.wineryForm.controls['address'].value);
        var addressControl = this.wineryForm.controls['address'].value;
        //  Init Bootstrap Select Picker
        if ($(".selectpicker").length !== 0) {
            $(".selectpicker").selectpicker();
        }
        $(".timepicker").datetimepicker({
            format: "H:mm",
            // format: 'h:mm A',    //use this format if you want the 12hours timpiecker with AM/PM toggle
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: "fa fa-chevron-left",
                next: "fa fa-chevron-right",
                today: "fa fa-screenshot",
                clear: "fa fa-trash",
                close: "fa fa-remove",
                inline: true,
                sideBySide: true
            }
        });
        //set current position
        this.setCurrentPosition();
        //get lng and lat for map
        this.mapsAPILoader.load().then(function () {
            var autocomplete = new google.maps.places.Autocomplete(_this.searchElementRef.nativeElement, {
                types: ["address"]
            });
            autocomplete.addListener("place_changed", function () {
                _this.ngZone.run(function () {
                    //get the place result
                    var place = autocomplete.getPlace();
                    //verify result
                    if (place.geometry === undefined || place.geometry === null) {
                        return;
                    }
                    //set latitude, longitude and zoom
                    _this.lat = place.geometry.location.lat();
                    _this.lng = place.geometry.location.lng();
                });
            });
        });
    };
    EditComponent.prototype.initLoadingData = function (onSave) {
        var _this = this;
        if (onSave === void 0) { onSave = false; }
        this.subscriptiondata = this.http
            .get("patch/initialize/winery/" + this.id, 1)
            .subscribe(function (httpResponse) {
            var serverData = _this.serverData = httpResponse.json();
            _this.wineryForm.controls["address"].setValue(_this.serverData.address);
            _this.wineryForm.controls["webpage"].setValue(_this.serverData.webpage);
            _this.wineryForm.controls["contact"].setValue(_this.serverData.contact);
            _this.wineryForm.controls["contact_person"].setValue(_this.serverData.contact_person);
            _this.lat = serverData.pin.lat;
            _this.lng = serverData.pin.lng;
            _this.ponpetTime = serverData.ponpet;
            _this.subTime = serverData.sub;
            _this.nedTime = serverData.ned;
            // let dropValue: HTMLElement = document.getElementById("areaDropdown");
            // dropValue.innerText = this.serverData.area.name;
            _this.wineryForm.controls["area_id"].setValue(_this.serverData.area.id);
            _this.logo_image = _this.serverData.logo_image;
            _this.cover_image = _this.serverData.cover_image;
            _this.video = _this.serverData.video;
            // console.log(this.logo_image);
            serverData.languages.forEach(function (lang, langIndex) {
                var name = "", desc = "";
                var fieldsindex;
                var name_id;
                var desc_id;
                lang.fields.forEach(function (field, fieldIndex) {
                    fieldsindex = fieldIndex;
                    if (field.name === "name") {
                        name = field.value;
                        name_id = field.id;
                    }
                    if (field.name === "description") {
                        desc = field.value;
                        desc_id = field.id;
                    }
                });
                if (!onSave) {
                    var index = _this.langs.findIndex(function (item) { return item.name === lang.language; }); // SELECTING INDEX OF OBJECT IN ARRAY BY PROPERTY *(etc. name)
                    _this.langs.splice(index, 1);
                }
                var language_name = lang.language;
                var language_id = lang.language_id;
                _this.createItem(name_id, desc_id, name, desc, language_name, language_id, false);
            });
        }, function (error) {
            // console.log(error);
        });
    };
    EditComponent.prototype.setCurrentPosition = function () {
        var _this = this;
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                _this.lat = position.coords.latitude;
                _this.lng = position.coords.longitude;
            });
        }
    };
    EditComponent.prototype.onRemoveTime = function (day) {
        console.log('remove time');
        if (day === 'ponpet') {
            this.ponpetTime = '/';
            this.wineryForm.controls["mondayFriday"].setValue(false);
        }
        if (day === 'sub') {
            this.subTime = '/';
            this.wineryForm.controls["saturday"].setValue(false);
        }
        if (day === 'ned') {
            this.nedTime = '/';
            this.wineryForm.controls["sunday"].setValue(false);
        }
    };
    EditComponent.prototype.onSaveLanguage = function (value) {
        var _this = this;
        var languageFormFields = [];
        languageFormFields.push({
            language_id: value.controls.name_id.value,
            name: "description",
            value: value.controls.wineryDesc.value
        });
        languageFormFields.push({
            language_id: value.controls.name_id.value,
            name: "name",
            value: value.controls.wineryName.value
        });
        var postData = {
            languages: languageFormFields
        };
        this.http
            .post("add/language/winery/" + this.id, postData)
            .subscribe(function (httpResponse) {
            if (httpResponse.status === 204) {
                var itemArray = _this.wineryForm.controls['items'];
                itemArray.controls.forEach(function (element) {
                    element.markAsUntouched;
                });
                _this.alert.showNotification("uspesno ste sacuvali jezik", "success", "notifications");
                _this.removeItem();
                _this.initLoadingData(true);
            }
        }, function (error) {
            if (error.status === 500) {
                _this.alert.showNotification('Greska na serveru! molimo pokušajte kasnije', 'danger', 'notifications');
            }
        });
    };
    EditComponent.prototype.onRemoveLangs = function (language_id, language_name, index) {
        var _this = this;
        var selected = this.wineryForm.get("items");
        swal({
            title: "Da li ste sigurni da \u017Eelite da uklonite " + language_name + " jezik",
            text: "Vrednosti polja biće trajno obrisane!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "NE",
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: "Da, Obriši",
            buttonsStyling: false
        }).then(function () {
            _this.http
                .delete("delete/language/winery/" + _this.id + "/" + language_id)
                .subscribe(function (httpResponse) {
                if (httpResponse.status === 204) {
                    swal({
                        title: "Obrisano!",
                        text: language_name + " jezik je uspesno obrisan!",
                        type: "success",
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    });
                    selected.removeAt(index);
                    var renewLang = {
                        name: language_name,
                        id: language_id
                    };
                    _this.langs.push(renewLang);
                }
                else if (httpResponse.status !== 204) {
                }
            }, function (error) {
                if (error.status === 500) {
                    _this.alert.showNotification('Greska na serveru! molimo pokušajte kasnije', 'danger', 'notifications');
                }
                _this.alert.showNotification("Greska! jezik nije obrisan ", "danger", "error");
            });
        }, function (dismiss) {
        });
    };
    EditComponent.prototype.onChoseLocation = function (event) {
        this.lat = event.coords.lat;
        this.lng = event.coords.lng;
    };
    EditComponent.prototype.onUploadLogo = function (event) {
        var file = event.target.files[0];
        var logoValid = {};
        logoValid.name = 'logo';
        if (file.type.indexOf('image') == -1) {
            this.alert.showNotification('Fajl nije slika! molimo ubacite sliku', 'danger', '');
            logoValid.isValid = false;
            this.fileValidator[0] = logoValid;
            return false;
        }
        if (!this.validateImage(file.name)) {
            this.alert.showNotification('Format slike nije podrzan! podrzani formati: *jpg *jpeg *png', 'danger', '');
            logoValid.isValid = false;
            this.fileValidator[0] = logoValid;
            return false;
        }
        else {
            logoValid.isValid = true;
            this.fileValidator[0] = logoValid;
            this.logoFile = event.target.files[0];
        }
    };
    EditComponent.prototype.onUploadCover = function (event) {
        var coverValid = {};
        coverValid.name = 'cover';
        var file = event.target.files[0];
        if (file.type.indexOf('image') == -1) {
            this.alert.showNotification('Fajl nije slika! molimo ubacite sliku', 'danger', '');
            coverValid.isValid = false;
            this.fileValidator[1] = coverValid;
            return false;
        }
        if (!this.validateImage(file.name)) {
            this.alert.showNotification('Format slike nije podrzan! podrzani formati: *jpg *jpeg *png', 'danger', '');
            coverValid.isValid = false;
            this.fileValidator[1] = coverValid;
            return false;
        }
        else {
            coverValid.isValid = true;
            this.fileValidator[1] = coverValid;
            this.coverFile = event.target.files[0];
        }
    };
    EditComponent.prototype.onUploadVideo = function (event) {
        var videoValid = {};
        videoValid.name = 'video';
        var file = event.target.files[0];
        if (file.type.indexOf('video') == -1) {
            this.alert.showNotification('Fajl nije video! molimo ubacite video', 'danger', '');
            videoValid.isValid = false;
            this.fileValidator[2] = videoValid;
            return false;
        }
        if (!this.validateVideo(file.name)) {
            this.alert.showNotification('Format video snimka nije podrzan! podrzani format: *MP4', 'danger', '');
            videoValid.isValid = false;
            this.fileValidator[2] = videoValid;
            return false;
        }
        else {
            videoValid.isValid = true;
            this.fileValidator[2] = videoValid;
            this.videoFile = event.target.files[0];
        }
    };
    EditComponent.prototype.validateVideo = function (name) {
        var ext = name.substring(name.lastIndexOf('.') + 1);
        if (ext.toLowerCase() == 'mp4') {
            return true;
        }
        else {
            return false;
        }
    };
    EditComponent.prototype.validateImage = function (name) {
        var ext = name.substring(name.lastIndexOf('.') + 1);
        if (ext.toLowerCase() == 'png') {
            return true;
        }
        if (ext.toLowerCase() == 'jpg') {
            return true;
        }
        if (ext.toLowerCase() == 'jpeg') {
            return true;
        }
        else {
            return false;
        }
    };
    EditComponent.prototype.createLanguage = function (nameId, descId, wName, wDesc, lName, lId, isNew) {
        if (isNew === void 0) { isNew = true; }
        var fg = this.fb.group({
            wineryName: [wName, __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].required],
            wineryDesc: [wDesc, __WEBPACK_IMPORTED_MODULE_2__angular_forms__["l" /* Validators */].required],
            name_id: nameId,
            desc_id: descId,
            language_name: [lName],
            language_id: [lId],
            flag: ['']
        });
        if (isNew)
            fg.controls['flag'].setValue(1);
        return fg;
    };
    // adding new item to FormArray items and splice item from langsArray
    EditComponent.prototype.addItem = function (value) {
        var isSaved;
        this.items = this.wineryForm.get("items");
        this.items.controls.forEach(function (item) {
            var items = item;
            if (items.controls.flag.value === 1) {
                isSaved = true;
                swal({
                    title: "Upozorenje! Molimo Vas da sačuvate predhodni jezik!",
                    buttonsStyling: false,
                    confirmButtonClass: "btn btn-success"
                });
                return;
            }
            isSaved = false;
        });
        if (!isSaved) {
            this.items.push(this.createLanguage(value.id, null, "", "", value.name, value.id));
            var index = this.langs.indexOf(value, 0);
            this.langs.splice(index, 1);
        }
    };
    EditComponent.prototype.removeItem = function () {
        var controls = this.wineryForm.get('items');
        while (controls.length !== 0) {
            controls.removeAt(0);
        }
    };
    EditComponent.prototype.createItem = function (nameId, descId, wName, wDesc, lname, lid, isNew) {
        if (isNew === void 0) { isNew = true; }
        this.items = this.wineryForm.get("items");
        this.items.push(this.createLanguage(nameId, descId, wName, wDesc, lname, lid, isNew));
    };
    // setting name of selected item from list on button
    // onSelectDropdown(id: number, name: string) {
    //   let dropValue: HTMLElement = document.getElementById("areaDropdown");
    //   dropValue.innerText = name;
    //   this.wineryForm.controls["area_id"].setValue(id);
    // }
    EditComponent.prototype.onSubmit = function () {
        var _this = this;
        var fd = new FormData();
        var langForm = this.wineryForm.get("items"); // vrednosti FormArray 'items'
        datepicker.monFri = [];
        datepicker.saturday = [];
        datepicker.sunday = [];
        dateValue.mondayFridayCheck = this.wineryForm.controls["mondayFriday"].value;
        dateValue.saturdayCheck = this.wineryForm.controls["saturday"].value;
        dateValue.sundayCheck = this.wineryForm.controls["sunday"].value;
        // loop for checked field and push time to Obj
        $("input.timepicker").each(function (index, value) {
            var d = $(value).data("date"); // init - empty : undefined
            if (dateValue.mondayFridayCheck === true) {
                if ($(value).attr("name") === "mondayFridayTimeStart") {
                    datepicker.monFri.push(d);
                }
                if ($(value).attr("name") === "mondayFridayTimeEnd") {
                    datepicker.monFri.push(d);
                }
            }
            if (dateValue.saturdayCheck === true) {
                if ($(value).attr("name") === "saturdayTimeStart") {
                    datepicker.saturday.push(d);
                }
                if ($(value).attr("name") === "saturdayTimeEnd") {
                    datepicker.saturday.push(d);
                }
            }
            if (dateValue.sundayCheck === true) {
                if ($(value).attr("name") === "sundayTimeStart") {
                    datepicker.sunday.push(d);
                }
                if ($(value).attr("name") === "sundayTimeEnd") {
                    datepicker.sunday.push(d);
                }
            }
        });
        // checking datepicker and set value to FormControler for time (ponpet, sub, ned)
        if (datepicker.monFri.length !== 0) {
            if (datepicker.monFri[0] !== undefined &&
                datepicker.monFri[1] !== undefined) {
                this.wineryForm.controls["ponpet"].setValue(datepicker.monFri);
            }
            else {
                this.alert.showNotification('unesite vreme za ponedeljak', 'danger', 'notifications');
            }
        }
        else {
            if (this.ponpetTime !== '/') {
                var formattingTime = this.serverData.ponpet;
                var timeArray = [];
                timeArray[0] = formattingTime.substring(0, 5);
                timeArray[1] = formattingTime.substring(8);
                this.wineryForm.controls["ponpet"].setValue(timeArray);
            }
            else {
                this.wineryForm.controls["ponpet"].setValue("");
            }
            // ponpet empty
        }
        if (datepicker.saturday.length !== 0) {
            if (datepicker.saturday[0] !== undefined &&
                datepicker.saturday[1] !== undefined) {
                this.wineryForm.controls["sub"].setValue(datepicker.saturday);
            }
        }
        else {
            if (this.subTime !== '/') {
                var formattingTime = this.serverData.sub;
                var timeArray = [];
                timeArray[0] = formattingTime.substring(0, 5);
                timeArray[1] = formattingTime.substring(8);
                this.wineryForm.controls["sub"].setValue(timeArray);
            }
            else {
                this.wineryForm.controls["sub"].setValue("");
            }
        }
        if (datepicker.sunday.length !== 0) {
            if (datepicker.sunday[0] !== undefined &&
                datepicker.sunday[1] !== undefined) {
                this.wineryForm.controls["ned"].setValue(datepicker.sunday);
            }
        }
        else {
            if (this.nedTime !== '/') {
                var formattingTime = this.serverData.ned;
                var timeArray = [];
                timeArray[0] = formattingTime.substring(0, 5);
                timeArray[1] = formattingTime.substring(8);
                this.wineryForm.controls["ned"].setValue(timeArray);
            }
            else {
                this.wineryForm.controls["ned"].setValue("");
            }
        }
        var languages = [];
        // parse data from FormArray items to this.language array
        langForm.controls.forEach(function (element) {
            var formGroup = element;
            languages.push({
                id: formGroup.controls.desc_id.value,
                name: "description",
                value: formGroup.controls["wineryDesc"].value
            });
            languages.push({
                id: formGroup.controls.name_id.value,
                name: "name",
                value: formGroup.controls["wineryName"].value
            });
        });
        this.wineryForm.controls.languages.setValue(languages);
        this.wineryForm.controls.address.setValue(this.searchElementRef.nativeElement.value);
        var formInput = this.wineryForm.value;
        delete formInput.items;
        delete formInput.mondayFriday;
        delete formInput.sunday;
        delete formInput.saturday;
        if (this.logoFile !== undefined) {
            fd.append("logo", this.logoFile);
        }
        if (this.coverFile !== undefined) {
            fd.append("cover", this.coverFile);
        }
        if (this.videoFile !== undefined) {
            fd.append("video", this.videoFile);
        }
        var marker = {
            lat: this.lat,
            lng: this.lng
        };
        formInput.point = marker;
        fd.append("json", JSON.stringify(formInput));
        var isFormValid = true;
        this.fileValidator.forEach(function (element) {
            console.log(element);
            if (element.isValid === false) {
                isFormValid = false;
                _this.alert.showNotification('Greska promenite ' + element.name, 'danger', 'notifications');
                return false;
            }
        });
        if (isFormValid) {
            this.http.postFormData("patch/winery/" + this.id, fd).subscribe(function (httpResponse) {
                //   if (event.type === HttpEventType.UploadProgress) {
                //     console.log(
                //       "Upload progress:" +
                //         Math.round(event.loaded / event.total * 100) +
                //         "%"
                //     )
                //     console.log(event);
                //   }
                if (httpResponse.status === 204) {
                    _this.alert.showNotification("Uspesno ste izmenili podatke!", "success", "notification");
                    _this.removeItem();
                    _this.initLoadingData(true);
                }
            }, function (error) {
                if (error.status === 500) {
                    _this.alert.showNotification('Greska na serveru! molimo pokušajte kasnije', 'danger', 'notifications');
                }
                _this.alert.showNotification("Greska , niste uspesno sacuvali podatke!", "danger", "error");
            });
        }
        else {
            this.alert.showNotification('Podaci nisu ispravno uneti molimo proverite!', 'danger', '');
        }
    };
    // destroying subscripions
    EditComponent.prototype.ngOnDestroy = function () {
        this.subscriptionlang.unsubscribe();
        this.subscriptionarea.unsubscribe();
        this.subscriptionparams.unsubscribe();
        this.subscriptiondata.unsubscribe();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])("address"),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["ElementRef"])
    ], EditComponent.prototype, "searchElementRef", void 0);
    EditComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: "app-edit",
            template: __webpack_require__("./src/app/winery/edit/edit.component.html"),
            styles: [__webpack_require__("./src/app/winery/edit/edit.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2__angular_forms__["b" /* FormBuilder */],
            __WEBPACK_IMPORTED_MODULE_3__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_4__notifications_notifications_service__["a" /* NotificationsService */],
            __WEBPACK_IMPORTED_MODULE_5__angular_router__["a" /* ActivatedRoute */],
            __WEBPACK_IMPORTED_MODULE_1__angular_common_http__["a" /* HttpClient */],
            __WEBPACK_IMPORTED_MODULE_5__angular_router__["b" /* Router */],
            __WEBPACK_IMPORTED_MODULE_6__agm_core__["b" /* MapsAPILoader */],
            __WEBPACK_IMPORTED_MODULE_0__angular_core__["NgZone"]])
    ], EditComponent);
    return EditComponent;
}());



/***/ }),

/***/ "./src/app/winery/winery.component.css":
/***/ (function(module, exports) {

module.exports = ".example-container {\r\n    display: -webkit-box;\r\n    display: -ms-flexbox;\r\n    display: flex;\r\n    -webkit-box-orient: vertical;\r\n    -webkit-box-direction: normal;\r\n        -ms-flex-direction: column;\r\n            flex-direction: column;\r\n    min-width: 300px;\r\n}\r\n\r\n.mat-table {\r\n    overflow: auto;\r\n    max-height: 500px;\r\n}\r\n\r\nmat-table.winery-table.mat-elevation-z8.mat-table {\r\n    max-height: 800px;\r\n}\r\n\r\n.loading_spinner {\r\n    position: absolute;\r\n    margin-left: 50%;\r\n    margin-top: 70px;\r\n}\r\n\r\nmat-cell,\r\nmat-header-cell {\r\n    padding-left: 20px;\r\n}"

/***/ }),

/***/ "./src/app/winery/winery.component.html":
/***/ (function(module, exports) {

module.exports = "<div class=\"main-content\">\r\n    <div class=\"container-fluid\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"col-md-1 col-md-offset-11\">\r\n                    <button (click)=\"OnAddWinery()\" mat-raised-button class=\"btn btn-rose btn-lg\">DODAJ</button>\r\n                </div>\r\n                <div class=\"card\">\r\n                    <div class=\"card-header card-header-icon\" data-background-color=\"darkred\">\r\n                        <i class=\"material-icons\">assignment</i>\r\n                    </div>\r\n                    <div class=\"card-content\">\r\n                        <h4 class=\"card-title\">Vinarije</h4>\r\n                        <div class=\"toolbar\">\r\n                            <!--        Here you can write extra buttons/actions for the toolbar              -->\r\n                            <mat-form-field class=\"form-full-width\">\r\n                                <mat-label>Izaberi jezik:</mat-label>\r\n                                <mat-select [value]=\"selectedLanguage\" placeholder=\"jezici\">\r\n                                    <mat-option *ngFor=\"let language of languages\" [value]=\"language.id\" (click)=\"onChangeLanguage(language.id, language.name)\">{{language.name}}</mat-option>\r\n                                </mat-select>\r\n                            </mat-form-field>\r\n                        </div>\r\n                        <div class=\"material-datatables table-responsive\">\r\n                            <div class=\"loading_spinner\" *ngIf=\"dataSource.loading$ | async\">\r\n\r\n                                <mat-spinner [diameter]=\"40\"></mat-spinner>\r\n\r\n                            </div>\r\n                            <mat-table class=\"winery-table mat-elevation-z8\" [dataSource]=\"dataSource\" matSort matSortDisableClear>\r\n\r\n                                <ng-container matColumnDef=\"name\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef mat-sort-header>Ime</mat-header-cell>\r\n\r\n                                    <mat-cell *matCellDef=\"let element\">{{element.name}}</mat-cell>\r\n\r\n                                </ng-container>\r\n\r\n                                <ng-container matColumnDef=\"address\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>Adresa</mat-header-cell>\r\n\r\n                                    <mat-cell class=\"description-cell\" *matCellDef=\"let element\">{{element.address}}</mat-cell>\r\n\r\n                                </ng-container>\r\n                                <ng-container matColumnDef=\"actions\">\r\n\r\n                                    <mat-header-cell *matHeaderCellDef>Akcije</mat-header-cell>\r\n\r\n                                    <mat-cell class=\"actions-cell\" *matCellDef=\"let element\">\r\n                                        <button (click)=\"OnEditWinery(element.id)\" type=\"button\" rel=\"tooltip\" class=\"btn btn-just-icon btn-success rounded\"><i class=\"material-icons\">edit</i></button>\r\n                                        <button (click)=\"OnDeleteWinery(element.id, element.name)\" type=\"button\" rel=\"tooltip\" class=\"btn btn-just-icon btn-danger rounded\"><i class=\"material-icons\">close</i></button>\r\n                                    </mat-cell>\r\n\r\n                                </ng-container>\r\n\r\n                                <mat-header-row *matHeaderRowDef=\"displayedColumns\"></mat-header-row>\r\n\r\n                                <mat-row *matRowDef=\"let row; columns: displayedColumns\"></mat-row>\r\n\r\n                            </mat-table>\r\n\r\n                            <mat-paginator [length]=\"total\" [pageSize]=\"pageSize\"></mat-paginator>\r\n                        </div>\r\n                    </div>\r\n                    <!-- end content-->\r\n                </div>\r\n                <!--  end card  -->\r\n            </div>\r\n            <!-- end col-md-12 -->\r\n        </div>\r\n        <!-- end row -->\r\n    </div>\r\n</div>"

/***/ }),

/***/ "./src/app/winery/winery.component.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return WineryComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_material__ = __webpack_require__("./node_modules/@angular/material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_rxjs_operators__ = __webpack_require__("./node_modules/rxjs/_esm5/operators.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__services_http_service__ = __webpack_require__("./src/app/services/http.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__notifications_notifications_service__ = __webpack_require__("./src/app/notifications/notifications.service.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__services_winery_datasource__ = __webpack_require__("./src/app/services/winery.datasource.ts");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};







var WineryComponent = /** @class */ (function () {
    function WineryComponent(router, http, alert) {
        this.router = router;
        this.http = http;
        this.alert = alert;
        this.languages = []; // storage list of all languages
        this.defaultLanguage = 1; // default language srpski = 1
        this.displayedColumns = ['name', 'address', 'actions'];
    }
    WineryComponent.prototype.ngOnInit = function () {
        var _this = this;
        // dataSource init
        this.dataSource = new __WEBPACK_IMPORTED_MODULE_6__services_winery_datasource__["a" /* WineryDataSource */](this.http);
        this.dataSource.loadWineries(1, this.defaultLanguage);
        this.selectedLanguage = this.defaultLanguage;
        // get all languages
        this.subscriptionLang = this.http.get("dropdown/language", 1).subscribe(function (httpResponse) {
            _this.languages = httpResponse.json();
        });
        // fetch data for table
        this.subscription = this.http
            .get("get/winery/", this.selectedLanguage)
            .subscribe(function (httpResponse) {
            if (httpResponse.status === 200) {
                _this.total = httpResponse.json().total;
                _this.pageSize = httpResponse.json().per_page;
            }
        }, function (error) {
            _this.alert.showNotification('Greska na serveru, molimo pokusajte kasnije!', 'danger', '');
        });
    };
    WineryComponent.prototype.ngAfterViewInit = function () {
        var _this = this;
        this.paginator.page.pipe(Object(__WEBPACK_IMPORTED_MODULE_3_rxjs_operators__["tap"])(function () { return _this.loadWineryPage(); })).subscribe();
    };
    WineryComponent.prototype.loadWineryPage = function () {
        this.dataSource.loadWineries(this.paginator.pageIndex + 1, this.selectedLanguage);
        console.log('loadWineryPage triggered!: ', this.paginator.pageIndex);
    };
    WineryComponent.prototype.onChangeLanguage = function (id, name) {
        var _this = this;
        console.log(id, name);
        this.selectedLanguage = id;
        this.dataSource = new __WEBPACK_IMPORTED_MODULE_6__services_winery_datasource__["a" /* WineryDataSource */](this.http);
        this.dataSource.loadWineries(this.paginator.pageIndex, this.selectedLanguage);
        this.paginator.firstPage();
        this.subscription = this.http
            .get("get/winery/", this.selectedLanguage)
            .subscribe(function (httpResponse) {
            console.log(httpResponse.json());
            if (httpResponse.status === 200) {
                _this.total = httpResponse.json().total;
                _this.pageSize = httpResponse.json().per_page;
            }
        });
    };
    WineryComponent.prototype.OnAddWinery = function () {
        this.router.navigate(["winery/add"]);
    };
    WineryComponent.prototype.OnEditWinery = function (id) {
        this.router.navigate(["winery/edit", id]);
    };
    WineryComponent.prototype.OnDeleteWinery = function (id, name) {
        var _this = this;
        console.log(id);
        console.log(name);
        swal({
            title: "Da li ste sigurni da \u017Eelite da obri\u0161ete " + name + " ?",
            text: "Podatke nije moguće povratiti nakon brisanja!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: 'ne',
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger",
            confirmButtonText: "Da, obriši!",
            buttonsStyling: false
        }).then(function () {
            _this.http.delete("delete/winery/" + id).subscribe(function (httpResponse) {
                if (httpResponse.status === 204) {
                    swal({
                        title: "Obrisano!",
                        text: "Vinarija " + name + " je uspesno obrisana!",
                        type: "success",
                        confirmButtonClass: "btn btn-success",
                        buttonsStyling: false
                    });
                    _this.http.get('get/winery', _this.selectedLanguage).subscribe(function (data) {
                        _this.paginator.length = data.json().total;
                    });
                    _this.dataSource = new __WEBPACK_IMPORTED_MODULE_6__services_winery_datasource__["a" /* WineryDataSource */](_this.http);
                    _this.dataSource.loadWineries(_this.paginator.pageIndex, _this.selectedLanguage);
                    _this.paginator.firstPage();
                }
            }, function (error) {
                _this.alert.showNotification("Greska!" + name + "nije obrisana", "danger", "error");
            });
        }, function (dismiss) {
        });
    };
    WineryComponent.prototype.ngOnDestroy = function () {
        this.subscription.unsubscribe();
        this.subscriptionLang.unsubscribe();
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_2__angular_material__["s" /* MatPaginator */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_2__angular_material__["s" /* MatPaginator */])
    ], WineryComponent.prototype, "paginator", void 0);
    WineryComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: "app-winery",
            template: __webpack_require__("./src/app/winery/winery.component.html"),
            styles: [__webpack_require__("./src/app/winery/winery.component.css")]
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1__angular_router__["b" /* Router */],
            __WEBPACK_IMPORTED_MODULE_4__services_http_service__["a" /* HttpService */],
            __WEBPACK_IMPORTED_MODULE_5__notifications_notifications_service__["a" /* NotificationsService */]])
    ], WineryComponent);
    return WineryComponent;
}());



/***/ }),

/***/ "./src/app/winery/winery.module.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "WineryModule", function() { return WineryModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__("./node_modules/@angular/core/esm5/core.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_router__ = __webpack_require__("./node_modules/@angular/router/esm5/router.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__angular_common__ = __webpack_require__("./node_modules/@angular/common/esm5/common.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__angular_forms__ = __webpack_require__("./node_modules/@angular/forms/esm5/forms.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__winery_routing__ = __webpack_require__("./src/app/winery/winery.routing.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__winery_component__ = __webpack_require__("./src/app/winery/winery.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6__add_add_component__ = __webpack_require__("./src/app/winery/add/add.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__edit_edit_component__ = __webpack_require__("./src/app/winery/edit/edit.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__angular_material__ = __webpack_require__("./node_modules/@angular/material/esm5/material.es5.js");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__agm_core__ = __webpack_require__("./node_modules/@agm/core/index.js");
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};










// import { DataTablesModule } from 'angular-datatables';
var WineryModule = /** @class */ (function () {
    function WineryModule() {
    }
    WineryModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            imports: [
                __WEBPACK_IMPORTED_MODULE_2__angular_common__["b" /* CommonModule */],
                __WEBPACK_IMPORTED_MODULE_1__angular_router__["c" /* RouterModule */].forChild(__WEBPACK_IMPORTED_MODULE_4__winery_routing__["a" /* WineryTable */]),
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["e" /* FormsModule */],
                __WEBPACK_IMPORTED_MODULE_3__angular_forms__["k" /* ReactiveFormsModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["h" /* MatDatepickerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["r" /* MatNativeDateModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["l" /* MatFormFieldModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["o" /* MatInputModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["y" /* MatSelectModule */],
                __WEBPACK_IMPORTED_MODULE_9__agm_core__["a" /* AgmCoreModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["F" /* MatTableModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["D" /* MatSortModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["t" /* MatPaginatorModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["v" /* MatProgressSpinnerModule */]
                // DataTablesModule
            ],
            declarations: [
                __WEBPACK_IMPORTED_MODULE_5__winery_component__["a" /* WineryComponent */],
                __WEBPACK_IMPORTED_MODULE_7__edit_edit_component__["a" /* EditComponent */],
                __WEBPACK_IMPORTED_MODULE_6__add_add_component__["a" /* AddComponent */]
            ],
            exports: [
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["h" /* MatDatepickerModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["r" /* MatNativeDateModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["l" /* MatFormFieldModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["o" /* MatInputModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["y" /* MatSelectModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["F" /* MatTableModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["D" /* MatSortModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["t" /* MatPaginatorModule */],
                __WEBPACK_IMPORTED_MODULE_8__angular_material__["v" /* MatProgressSpinnerModule */]
            ]
        })
    ], WineryModule);
    return WineryModule;
}());



/***/ }),

/***/ "./src/app/winery/winery.routing.ts":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return WineryTable; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__winery_component__ = __webpack_require__("./src/app/winery/winery.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__edit_edit_component__ = __webpack_require__("./src/app/winery/edit/edit.component.ts");
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__add_add_component__ = __webpack_require__("./src/app/winery/add/add.component.ts");



var WineryTable = [
    {
        path: '',
        children: [{
                path: '',
                component: __WEBPACK_IMPORTED_MODULE_0__winery_component__["a" /* WineryComponent */]
            }]
    }, {
        path: '',
        children: [{
                path: 'edit/:id',
                component: __WEBPACK_IMPORTED_MODULE_1__edit_edit_component__["a" /* EditComponent */],
                pathMatch: 'full'
            }]
    }, {
        path: '',
        children: [{
                path: 'add',
                component: __WEBPACK_IMPORTED_MODULE_2__add_add_component__["a" /* AddComponent */],
                pathMatch: 'full'
            }]
    }
];


/***/ })

});
//# sourceMappingURL=winery.module.chunk.js.map